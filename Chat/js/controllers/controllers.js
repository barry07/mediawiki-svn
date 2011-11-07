//
//Controllers
//
if($.getUrlVar('nosockets', false) == 1) {
	var globalTransports = [ 'htmlfile', 'xhr-polling', 'jsonp-polling'  ];
} else {
	var globalTransports = [ 'htmlfile', 'xhr-polling', 'jsonp-polling'  ];	
}

//hack
$.msg = function(msg) {
	return msg;
}

var NodeChatSocketWrapper = $.createClass(Observable,{
	proxy: $.proxy,
	connected: false,
	announceConnection: true,
	autoReconnect: true,
	isInitialized: false,
	comingBackFromAway: false,	
	roomId: false,
	socket: false,
	reConnectCount: 0,
	constructor: function( roomId ) {
		NodeChatSocketWrapper.superclass.constructor.apply(this,arguments);
		NodeChatSocketWrapper.sessionData = null;		
		this.roomId = roomId;
	},
	
	send: function($msg) {
		$().log( $msg, 'message');
		this.socket.emit('message', $msg);
	},

	baseconnect: function() {
		io.transports = globalTransports ;
		this.socket = io.connect('http://' + WIKIA_NODE_HOST + ':' + WIKIA_NODE_PORT, { 
			'force new connection' : true,	
			'try multiple transports': true,
			'connect timeout': false
		});
		
		this.socket.on('connect', this.proxy( this.onConnect, this ) );
		this.socket.on('message', this.proxy( this.onMsgReceived, this ) );
	    this.socket.on('disconnect', this.proxy( this.onDisconnect, this ) );
	},
	
	connect: function() {
		if(!this.socket) {
			this.baseconnect();
			this.connectTimeoutTimer = setTimeout($.proxy(function() {
				$().log("timeout try without socket connection");
				globalTransports = [ 'htmlfile', 'xhr-polling', 'jsonp-polling'  ];
				if(this.connected == false) {
					this.baseconnect();		
				}
			}, this), 6000 );
		}
	},
	
	onConnect: function() {
		clearTimeout(this.connectTimeoutTimer);
        if(this.announceConnection){
			$().log("Reconnected.");
			this.announceConnection = false;
		}
        this.connected = true;    	
    },
    
	onDisconnect: function(){
		$().log("Node-server connection needs to be refreshed...");
		
        this.connected = false;
		this.announceConnection = true;
		
		// Sometimes the view is in a state where it shouldn't reconnected (eg: user has entered the same room from another computer and wants to kick this instance off w/o it reconnecting).
		if(this.autoReconnect){
			trying = setTimeout(this.proxy(this.tryconnect, this),500);
		}
    },
	
    onAuthRequestWithMW: function() {
		// We can't access the second-level-domain cookies from Javascript, so we make a request to wikia's
		// servers (which we trust) to echo back the session info which we then send to node via socket.io
		// (which doesn't reliably get cookies directly from clients since they may be on flash, etc. and
		// there isn't good support for getting cookies anyway).
		$().log("Getting full session info from Apache.");
		
		
		this.checkSession = function(data) {
			NodeChatSocketWrapper.sessionData = data;
			$().log("Got full session info from Apache: ");

			var authData = {
					'name': wgUserName, // for debugging only
					'key': data.key,
					'roomId': this.roomId // this is set in the js by Chat_Index.php
			};
			
			var authInfo = new models.AuthInfo(authData);
			$().log(authInfo)
			this.send(authInfo.xport());

			$().log("Sent auth info");
		};
		
		if(NodeChatSocketWrapper.sessionData == null) {
			$.post(wgScript + '?action=ajax&rs=ChatAjax&method=echoCookies&time=' + (new Date().getTime()) + "&name=" + wgUserName , {}, this.proxy(this.checkSession, this) );
		} else {
			this.checkSession(NodeChatSocketWrapper.sessionData);
		}
		
    },
    
    forceReconnect: function() {
		NodeChatSocketWrapper.sessionData = null;
		this.socket.disconnect();
		this.socket = null;
		this.connect();
    },
    
    onMsgReceived: function(message) {
    	$().log(message);
    	switch(message.event) {
			case 'auth':
					// Server has requested that the client send its authentication data (Wikia session cookies).
					this.onAuthRequestWithMW(message);
				break;
			case 'disableReconnect':
				this.autoReconnect = false;
				break;
			case 'forceReconnect':
				this.forceReconnect();
				break;
			case 'initial':
				this.reConnectCount = 0;
			default:
				this.fire( message.event, message );
			break;
    	}
    },
    
    getAllowedEvents: function() {
    	return ['updateUser', 'initial', 'chat:add', 'join', 'part'];
    },
    
	tryconnect: function (){
        if(!this.connected) {
			$().log("Trying to re-connect to node-server:" + this.reConnectCount);
            this.connect();
            clearTimeout(trying);
            this.reConnectCount++;
            
            if(this.reConnectCount == 15) {
            	this.fire( "reConnectFail", {} );
            } else {
            	trying = setTimeout(this.proxy(this.tryconnect, this), 5000);	
            }
        }
    }
});	

var NodeRoomController = $.createClass(Observable,{
	active: false,
	unreadMessage: 0,
	roomId: null,
	mainController: null,
	afterInitQueue: [],
	constructor: function(roomId) {
		
		NodeRoomController.superclass.constructor.apply(this,arguments);

		this.afterInitQueue = [];
		$().log(this.afterInitQueue);
		this.socket = new NodeChatSocketWrapper( roomId );
		this.roomId = roomId;

		this.model = new models.NodeChatModelCS();
	
		this.model.room.set({  
			'roomId': roomId, 
			'unreadMessage': 0, 
			'isActive': this.active 
		}); 
			
		this.model.chats.bind('add', $.proxy(function(current) {
			
			if(current.get('isInlineAlert') !== true && current.get('msgType') == 'chat' && current.get('name') != wgUserName) {
				this.unreadMessage ++;	
			}
			
			if(this.active == true) {
				this.unreadMessage = 0
			}
			
			var data = {
				'unreadMessage': this.unreadMessage, 
				'isActive': this.active 
			};
			
			this.model.room.set(data);
		}, this));
		
		this.socket.bind('join',  $.proxy(this.onJoin, this));
		this.socket.bind('initial',  $.proxy(this.onInitial, this));
		this.socket.bind('chat:add',  $.proxy(this.onChatAdd, this));
		
		this.socket.bind('reConnectFail',  $.proxy(this.onReConnectFail, this));
		this.socket.bind('part',  $.proxy(this.onPart, this));
		
		this.viewDiscussion = new NodeChatDiscussion({model: this.model, el: $('body'), roomId: roomId});
		this.viewDiscussion.bind('clickAnchor', $.proxy(this.clickAnchor, this) );
		this.viewDiscussion.bind('sendMessage', $.proxy(this.sendMessage, this) );
		
		//TODO: move to view ??
		$(window).focus($.proxy(function() {
			// set focus on the text input
			this.viewDiscussion.getTextInput().focus();
		},this));

		this.viewDiscussion.getTextInput().focus();
	}, 	
	
	onReConnectFail: function(message) {
		var chatEntry = new models.InlineAlert({text: $.msg( 'chat-user-permanently-disconnected' ) });
		this.model.chats.add(chatEntry);	
	},
	
	onInitial: function(message) {
		if(!this.isInitialized){
			
			_.each(this.model.chats.models, $.proxy(function(data) {
				this.model.chats.remove(data);
			},this)); 
			
			this.model.chats.trigger('clear');
			// On first connection, just update the entire model.
			this.model.mport(message.data);
			this.isInitialized = true;
			$().log(this.isInitialized, "isInitialized");
		} else {
			// If this is a reconnect... go through the model that was given and selectively, only add ChatEntries that were not already in the collection of chats.
			var jsonObj = JSON.parse(message.data);
			var chatEntries = this.model.chats;
			_.each(jsonObj.collections.chats.models, function(item, index){
				var match = chatEntries.get(item.id);
				if(typeof match == "undefined"){
					$().log("Found a ChatEntry that must have occurred during reconnection. Adding it to the model...");
					var additionalEntry = new models.ChatEntry();
					additionalEntry.mport( $.toJSON(item) );
					chatEntries.add(additionalEntry);
				}
			});
			
			// TODO: update the entire userlist (if the server went down or something, you're not going to get "part" messages for the users who are gone).
			// See BugzId 6107 for more info & partially completed code.
		}
		
		for(var i in this.afterInitQueue) {
			this.socket.send(this.afterInitQueue[i]);	
		} 

		this.afterInitQueue = [];
	},
	
	setActive: function(status) {
		this.active = status;
		if(status) {
			this.unreadMessage = 0;			
			this.model.room.set({ 
				'unreadMessage': 0,
				'isActive': true
			});
		} else {
			this.model.room.set({ 
				'isActive': false
			});
		}
		//TODO: move it to view ???
		this.viewDiscussion.getTextInput().focus();
	},
	
	sendMessage: function(event){
		if(!this.active) {
			return true;
		}
		
		if (event.which == 13 && !event.shiftKey) {
			event.preventDefault();
			var inputField = this.viewDiscussion.getTextInput();

			if (inputField.val()) {
				var chatEntry = new models.ChatEntry({roomId: this.roomId, name: wgUserName, text: inputField.val()});
				if( this.mainController != null ) { //is prive
					if( this.afterInitQueue.length < 1 || this.model.users.length < 2 ){
						this.mainController.socket.send( this.model.privateRoom.xport() );		
					}
					if( !this.isInitialized  ) {
						this.afterInitQueue.push(chatEntry.xport());
						//temp chat entry in case of slow connection time
						chatEntry.set({temp : true, avatarSrc: wgAvatarUrl });  
						this.model.chats.add(chatEntry);
					} else {
						this.socket.send(chatEntry.xport());
					}
				} else {
					this.socket.send(chatEntry.xport());
				}
				
				inputField.val('');
				event.preventDefault();
			}
			$().log('submitting form');
			inputField.focus();
		}
	},
	
	onChatAdd: function(message) {
		var newChatEntry;
		var dataObj = JSON.parse(message.data);

		if(dataObj.attrs.isInlineAlert){
			newChatEntry = new models.InlineAlert();
		} else {
			newChatEntry = new models.ChatEntry();
		}
		newChatEntry.mport(message.data);
		
		this.model.chats.add(newChatEntry); 
	},
	
	onJoin: function(message) {
		var joinedUser = new models.User();
		joinedUser.mport(message.joinData);

		var connectedUser = this.model.users.findByName(joinedUser.get('name'));
		
		if(typeof connectedUser == "undefined"){
			this.model.users.add(joinedUser);
			this.fire('afterJoin', joinedUser);
			
			//TODO: move it to other class
			if(this.mainController == null) {
				// Create the inline-alert (on client side so that we only display it if the user actually IS new to the room and not just disconnecting/reconnecting).
				var newChatEntry = new models.InlineAlert({text: $.msg('chat-user-joined', [joinedUser.get('name')] ) });
				this.model.chats.add(newChatEntry);				
			}
			
			this.disableRoom(joinedUser, false);
		} else {
			// The user is already in the room... just update them (in case they have changed).
			this.model.users.remove(connectedUser);
			this.model.users.add(joinedUser);
		}		
	},

	onPart: function(message) {
		var partedUser = new models.User();
		partedUser.mport(message.data);
		
		var connectedUser = this.model.users.findByName(partedUser.get('name'));

		if(typeof connectedUser != "undefined"){

			//TODO: move it to other class
			if(this.mainController == null) {
				var newChatEntry = new models.InlineAlert({text: $.msg('chat-user-parted', [connectedUser.get('name')] ) });
				this.model.chats.add(newChatEntry);
			}
			
			this.model.users.remove(connectedUser);
			this.disableRoom(connectedUser, true);
		}		
	},

	//TODO: this is wrong place for this
	disableRoom: function(user, flag) {
		if( this.mainController == null ) {	
			//TODO: fix it for multiuser priv chat
			var privateUser =  this.model.privateUsers.findByName(user.get('name'));
			
			if(typeof privateUser != "undefined"){
				var roomId = privateUser.get('roomId');
				if( typeof( this.chats.privates[roomId] ) != "undefined" ){
					this.chats.privates[roomId].model.room.set({ 
						'blockedMessageInput': flag
					});
				}
				//try to reconnect
				if(flag === false && this.chats.privates[roomId].model.chats.length > 0) {
					this.socket.send( this.chats.privates[roomId].model.privateRoom.xport() );
				}
			}
		
		}	
	},
	
	clickAnchor: function(event) {
		window.open($(event.target).closest('a').attr("href"));
	},
	
	init: function() {
		this.socket.connect();
	}
});


var NodeChatController = $.createClass(NodeRoomController,{
	active: true,
	chats: {
		main: null,
		opens: {}, //to store more than one open chat in one window not supported yet (for now only one) 
		privates: {}
	},
	activeRoom: null,
	constructor: function(roomId) {
		NodeChatController.superclass.constructor.apply(this,arguments);

		this.socket.bind('openPrivateRoom',  $.proxy(this.onOpenPrivateRoom, this));
		this.socket.bind('updateUser',  $.proxy(this.onUpdateUser, this));

		this.bind('afterJoin', $.proxy(this.afterJoin, this));
		this.viewUsers = new NodeChatUsers({model: this.model, el: $('body')});
		
		this.viewUsers.bind('showPrivateMessage', $.proxy(this.privateMessage, this) );
		this.viewUsers.bind('kickBan', $.proxy(this.kickBan, this) );
		this.viewUsers.bind('giveChatMod', $.proxy(this.giveChatMod, this) );
		
		
		this.viewUsers.bind('blockPrivateMessage', $.proxy(this.blockPrivate, this) );
		this.viewUsers.bind('allowPrivateMessage', $.proxy(this.allowPrivate, this) );
		
		this.viewUsers.bind('mainListClick', $.proxy(this.mainListClick, this) );
		this.viewUsers.bind('privateListClick', $.proxy(this.privateListClick, this) );

		this.viewUsers.bind('clickAnchor', $.proxy(this.clickAnchor, this) );

		this.viewUsers.render();
		this.viewDiscussion.show();
		
		// Handle Away status 
		//TODO: move widnow to view ??? 
		$(window)
			.mousemove($.proxy(this.resetActivityTimer, this))
			.keypress($.proxy(this.resetActivityTimer, this))
			.focus($.proxy(this.resetActivityTimer, this));
		
		this.chats.main = this;
		return this;
	},
	
	afterJoin: function(newuser) {
		var privateUser = this.model.privateUsers.findByName(newuser.get('name'));
		
		if(typeof privateUser == "undefined"){
			return true;
		}
		
		if( typeof( this.chats.privates[ privateUser.get('roomId') ] ) != "undefined" ){
			this.chats.privates[ privateUser.get('roomId') ].model.room.set({
				'blockedMessageInput': false
			});
		}
	},

	menuHavePrivatBlock: function(name) {
		var user = this.model.blockedUsers.findByName(name);
		$().log(this.model.blockedUsers);
		if(typeof(user) == "undefined") {
			return true;
		}	
		return false;
	},
	
	mainListClick: function(obj) {
		var user = this.model.users.findByName(obj.name);
		var userMain = this.model.users.findByName(wgUserName);
		var userYouAreBlockedBy = this.model.blockedByUsers.findByName(obj.name); 
		var userPrivate = this.model.privateUsers.findByName(obj.name);
		
		var actions = ['profile', 'contribs' ]; 

		if(this.menuHavePrivatBlock(obj.name)) {
		//	actions.push( 'private-block' );	
		
			if( typeof(userPrivate) == 'undefined' && typeof(userYouAreBlockedBy) == 'undefined' ) {
				actions.push( 'private' );	
			}
		} else {
			actions.push( 'private-allow' );	
		}

		if(userMain.get('isCanGiveChatMode') === true && user.get('isModerator') === false ){
			actions.push('give-chat-mod');
		}

		if(userMain.get('isModerator') === true && user.get('isModerator') === false ) {
			actions.push('kickban');
		}

		this.viewUsers.showMenu(obj.target, actions);
		
		if(this.model.get('isStaff') === true){
			$(this.el).addClass('staff');
		}
	},
	
	privateListClick: function(obj) {
		var user = this.model.users.findByName(obj.name);
		var userMain = this.model.users.findByName(wgUserName);
		
		var actions = ['profile', 'contribs', 'private-block' ];
		
		//, 'private-close'
		if(!this.privateMessage(obj)) {
			this.viewUsers.showMenu(obj.target, actions);	
		}
	},
	
	showRoom: function(roomId) {
		$().log(roomId);
		if( this.activeRoom == roomId ) {
			return false;
		}
		
		this.activeRoom = roomId;
		if(roomId == 'main') {
			this.chats.main.setActive(true);
		} else {
			this.chats.main.setActive(false);
		}
		
		for(var i in this.chats.privates) {
			if(i == roomId) {
				this.chats.privates[i].setActive(true);
			} else {
				this.chats.privates[i].setActive(false);
			}
		}
		return true;
	},
	
	privateMessage: function(obj) {
		var connectedUser = false;
		var userData;
		this.model.privateUsers.find(function(userEl){
			if(userEl.get('name') == obj.name) {
				connectedUser = true;
				userData = userEl;
			}
		});

		if(connectedUser) {
			return this.showRoom(userData.get('roomId'))
		} else {
			this.openPrivateChat([obj.name]);
			return true;
		}
	}, 
	
	openPrivateChat: function(users) {
		users.push( wgUserName );
		$.ajax({
			type: 'POST',
			url: wgScript + '?action=ajax&rs=ChatAjax&method=getPrivateRoomID',
			data: {
				users : users.join(',')
			},
			success: $.proxy(function(data) {
				$().log("Attempting create private room with users " + users.join(','));	
				var data = new models.OpenPrivateRoom({roomId: data.id, users: users});
				this.baseOpenPrivateRoom(data, true);
				this.showRoom(data.get('roomId') );
				this.chats.privates[ data.get('roomId') ].init();
				//this.socket.send(data.xport());
			}, this)
		});
		this.viewUsers.hideMenu();
	},

	
	blockAllowPrivateAjax: function(name, dir, callback) {
		$.ajax({
			type: 'POST',
			url: wgScript + '?action=ajax&rs=ChatAjax&method=blockPrivate',
			data: {
				userToBan : name,
				dir: dir 
			},
			success: callback
		});
	},
	
	blockPrivate: function(obj) {
		
		this.blockAllowPrivateAjax(obj.name, 'add', $.proxy(function(data) {
			var user = this.model.privateUsers.findByName(obj.name);
			var userClear = new models.User({'name': obj.name});

			this.model.blockedUsers.add(userClear);
			if(typeof(user) != "undefined") {
				this.chats.privates[ user.get('roomId') ].model.room.set({
					'hidden':  true
				});
				
				var newChatEntry = new models.InlineAlert({text: $.msg( 'chat-user-blocked', wgUserName, userClear.get('name') ) });
				this.chats.privates[ user.get('roomId') ].socket.send(newChatEntry.xport());	
				
				if(this.chats.privates[ user.get('roomId') ].active) {
					this.chats.privates[ user.get('roomId') ].setActive(false);
					this.setActive(true);
				} 
			}
		}, this));
		
		this.viewUsers.hideMenu();
	},

	allowPrivate: function(obj) {
		
		this.blockAllowPrivateAjax(obj.name, 'remove', $.proxy(function(data) {
			var privateUser = this.model.privateUsers.findByName(obj.name);
			var user = this.model.blockedUsers.findByName(obj.name);
			
			if(typeof(user) != "undefined") {
				this.model.blockedUsers.remove(user);
			}
		
			if(typeof(privateUser) != "undefined") {
				this.chats.privates[ privateUser.get('roomId') ].model.room.set({
					'hidden':  false
				});

				var newChatEntry = new models.InlineAlert({text: $.msg('chat-user-allow', wgUserName, privateUser.get('name') ) });
				this.chats.privates[ user.get('roomId') ].socket.send(newChatEntry.xport());		
			}
		}, this));
		
		this.viewUsers.hideMenu();
	},
	
	// Set the current user's status to 'away' and set an away message if provided.
	setAway: function(){
		var msg = '';
		$().log("Attempting to go away with message: " + msg);
		var setStatusCommand = new models.SetStatusCommand({
			statusState: STATUS_STATE_AWAY,
			statusMessage: msg
		});
		this.socket.send(setStatusCommand.xport());
	},
	
	// Set the user as being back from their "away" state (they are here again) and remove the status message.
	setBack: function(){
		if( ! this.comingBackFromAway){ // if we have sent this command (but just haven't finished coming back yet), don't keep spamming the server w/this command
			$().log("Telling the server that I'm back.");
			this.comingBackFromAway = true;
			var setStatusCommand = new models.SetStatusCommand({
				statusState: STATUS_STATE_PRESENT,
				statusMessage: ''
			});
			this.socket.send(setStatusCommand.xport());
		}
	},
	
	startActivityTimer: function() {
		this.activityTimer = setTimeout($.proxy(this.setAway, this), 5 * 60 * 1000); // the first number is minutes.
	},

	resetActivityTimer: function() {
		clearTimeout(this.activityTimer);
		this.startActivityTimer();
		
		// If user had been set to away, ping server to unset away.
		if($('#ChatHeader .User').hasClass('away')){
			this.setBack();
		}
	},

	kickBan: function(userToBan){
		$().log("Attempting to kickban user: " + userToBan);
		var kickBanCommand = new models.KickBanCommand({userToBan: userToBan.name});
		this.socket.send(kickBanCommand.xport());
		
		this.viewUsers.hideMenu(); 
	},

	giveChatMod: function(user){
		$().log("Attempting to give chat mod to user: " + user.name);
		var giveChatModCommand = new models.GiveChatModCommand({userToPromote: user.name});
		this.socket.send(giveChatModCommand.xport());

		this.viewUsers.hideMenu();
	},

	onUpdateUser: function(message) {
		var updatedUser = new models.User();
		updatedUser.mport(message.data);
		
		var connectedUser = this.model.users.find(function(user){
								return user.get('name') == updatedUser.get('name');
							});
		
		if(typeof connectedUser != "undefined"){
			// Is this the right way to do it?
			this.model.users.remove(connectedUser);
			this.model.users.add(updatedUser);
			
			// If it was the current user who changed (and they are "back") set them as no longer in the process of comingBackFromAway.
			if((this.comingBackFromAway) && (connectedUser.get('name') == wgUserName) && (connectedUser.get('statusState') != STATUS_STATE_AWAY)){
				this.comingBackFromAway = false;
			}
		}
	},
	
	baseOpenPrivateRoom: function(data, active) {
		this.chats.privates[ data.get('roomId') ] = new NodeRoomController(data.get('roomId'));
		this.chats.privates[ data.get('roomId') ].mainController = this; //set main controller for this chat room
		this.chats.privates[ data.get('roomId') ].model.privateRoom =  data;
		var users = data.get('users'); 
		for( var i in users) {
			if( users[i] != wgUserName ) {
				var privateUser = new models.PrivateUser(this.model.users.findByName(users[i]).attributes);
				
				privateUser.set({
					'name' : users[i],
					'active': active,
					'roomId' : data.get('roomId')
				});
	
				this.model.privateUsers.add( privateUser );
				var roomData = { 'privateUser':  privateUser };
				
				//hide blocked room for case of allow
				
				this.chats.privates[ data.get('roomId') ].model.room.set(roomData);
				
				break;
			}
		}
	},
	
	onOpenPrivateRoom: function(message) {
		var room = new models.OpenPrivateRoom();
		room.mport(message.data);
		
		var users = room.get('users'); 
		for( var i in users) {
			if( users[i] != wgUserName ) {
				var blockedUser = this.model.blockedUsers.findByName( users[i] );
				if(typeof(blockedUser ) != 'undefined' ) {
					return ; 
				}
			}
		}
		
		if( typeof( this.chats.privates[ room.get('roomId')  ] ) == 'undefined' ) {
			this.baseOpenPrivateRoom(room, false);
		}
		this.chats.privates[ room.get('roomId') ].init();
	},
	
	init: function() {
		$.ajax({
			type: 'POST',
			url: wgScript + '?action=ajax&rs=ChatAjax&method=getListOfBlockedPrivate',
			success: $.proxy(function(data) {
				for( var i in data.blockedChatUsers ) {
					var userClear = new models.User({'name': data.blockedChatUsers[i] });
					this.model.blockedUsers.add(userClear);					
				}
				
				for( var i in data.blockedByChatUsers ) {
					var userClear = new models.User({'name': data.blockedByChatUsers[i] });
					this.model.blockedByUsers.add(userClear);					
				}
				this.socket.connect();
			}, this)
		});
	}
});

//
// Bootstrap the app
//
$(function() {
	window.mainRoom = new NodeChatController(roomId);
	window.mainRoom.init();
});
