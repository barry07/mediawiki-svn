/**
 * metavid: mv_flashEmbed builds off of: 
 *  
 * samples from: flashembed 0.25. Adobe Flash embedding script
 *
 * http://flowplayer.org/player/flash-embed.html
 *
 * Copyright (c) 2008 Tero Piirainen (tero@flowplayer.org)
 *
 * Released under the MIT License:
 * http://www.opensource.org/licenses/mit-license.php
 *
 * = Basically you can do anything but leave this header as is
 *
 */	
var flashEmbed = {
	instanceOf:'flashEmbed',
	monitorTimerId : 0,
	startedTimedPlayback:false,	
    supports: {
    	'play_head':true, 
	    'play_or_pause':true,
	    'stop':true, 
	    'fullscreen':true, 
	    'time_display':true, 
	    'volume_control':true,
	    'overlay':false
    },
    flashParams : {
		// very common params
		src: '#',
		width: 400,
		height:300,
		
		// flashembed defaults
		allowfullscreen: true,
		allowscriptaccess: 'always',
		quality: 'high',
		bgcolor: '#ffffff',
		type: 'application/x-shockwave-flash',
		pluginspage: 'http://www.adobe.com/go/getflashplayer'
	},
	flashVars :{
		config: { 	autoPlay: true, 
					hideControls: true,
					initialScale:'fit',
					loop:false
	           	}
	},
    getEmbedHTML: function (){
        setTimeout('document.getElementById(\''+this.id+'\').postEmbedJS()', 150);
        return this.wrapEmebedContainer( this.getEmbedObj() );
    },
    getEmbedObj:function(){
    	if(!this.duration)this.duration=30;
       	var html = "";       		
       	//set up custom params/config 
	    this.flashParams.src	= mv_embed_path + 'FlowPlayerDark.swf';
	    this.flashParams.width 	= this.width;
	    this.flashParams.height = this.height;
	    this.flashParams.id		= this.pid;
	   
	    this.flashVars.config.videoFile =  this.media_element.selected_source.uri; 
	    
	    if(this.muted)
	    	 this.flashVars.config.initialVolumePercentage=0;
	    	 
		// mozilla
		if (navigator.plugins && navigator.mimeTypes && navigator.mimeTypes.length) {
			html = '<embed ' +
					'id="'+this.pid+'" ';							
			for(var key in this.flashParams) {
				if (this.flashParams[key] != null)
					html += [key] + '="' +this.flashParams[key]+ '"\n\t';
			}
			if (this.flashVars) {
				html += 'flashvars=\'';
				for(var key in this.flashVars) {
					html += [key] + '=' + asString(this.flashVars[key]) + '&';
				}
				html += '\'';
			}
			html += '/>';
		// ie
		} else {
			html = '<object id="'+this.pid+'" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ';
			html += 'width="' +  this.flashParams.width + '" height="' +  this.flashParams.height + '"';
			if ( this.flashParams.id) html += ' id="' +  this.pid + '"';
			html += '>';
			html += '\n\t<param name="movie" value="'+  this.flashParams.src +'" />';
			this.flashParams.id =  this.flashParams.src =  this.flashParams.width =  this.flashParams.height = null;
			for (var key in this.flashParams) {
				if (this.flashParams[key] != null)
					html += '\n\t<param name="'+ key +'" value="'+ this.flashParams[key] +'" />';
			}
			if (this.flashVars) {
				html += '\n\t<param name="flashvars" value=\'';
				for(var key in this.flashVars) {
					html += [key] + '=' + asString(this.flashVars[key]) + '&';
				}
				html += '\' />';
			}
			html += "</object>";
		}
		return html;
    },
    postEmbedJS: function()
    {   
    	this.getFLA();    
        if(this.fla){
       		setTimeout('$j(\'#'+this.id+'\').get(0).monitor()', 250);
        }else{
        	js_log('flash not ready');
    		setTimeout('$j(\'#'+this.id+'\').get(0).postEmbedJS()',250);	
        }
    },
    /* js hooks/controls */
    play : function(){    	
    	this.getFLA();
    	if(!this.fla || this.thumbnail_disp)
        {
	    	//call the parent
    		this.parent_play();
    	}else{
            this.fla.DoPlay();
			this.paused=false;
			setTimeout('$j(\'#'+this.id+'\').get(0).monitor()', 250);
    	}
    },
    pause : function()
    {
    	this.getFLA();
    	var flv = document.getElementById(this.pid);
    	if(this.fla['Pause'])
    		this.fla.Pause();
		//stop updates: 
		if( this.monitorTimerId != 0 )
	    {
	        clearInterval(this.monitorTimerId);
	        this.monitorTimerId = 0;
	    }
    },
    monitor : function()
    {
    	this.getFLA();
        if(!this.fla['getTime'])
            return js_log('can not monitor without time');
                        
        this.currentTime = this.fla.getTime();              
        
        if(this.currentTime > 0 ){
        	this.startedTimedPlayback=true;
        	js_log("time is "+ this.currentTime + " started playback");        	
        }
        
        
        //flash is giving ogus duration get from this        
        var end_ntp = (this.media_element.selected_source.end_ntp)?
        			   		this.media_element.selected_source.end_ntp : 
        			   		seconds2ntp( this.fla.getDuration() );
		var start_ntp =  (this.media_element.selected_source.start_ntp)?
        			   		this.media_element.selected_source.start_ntp : 0;
        			   		       		
        if((this.currentTime - ntp2seconds(start_ntp))<0){
        	this.setStatus('buffering...');
        }else{        			   		       		
	       	this.setStatus( seconds2ntp(this.currentTime) + '/' + end_ntp);      		
	        this.setSliderValue((time - ntp2seconds(start_ntp)) / (ntp2seconds(end_ntp)-ntp2seconds(start_ntp)) );
        }
        //do monitor update: 
	    if( ! this.monitorTimerId ){
	    	if(document.getElementById(this.id)){
	        	this.monitorTimerId = setInterval('$j(\'#'+this.id+'\').get(0).monitor()', 250);
	    	}
	    }
	    js_log('cur perc loaded: ' + this.fla.getPercentLoaded() + 
	    		' cur time : ' + (time - ntp2seconds(start_ntp)) +' / ' +(ntp2seconds(end_ntp)-ntp2seconds(start_ntp)));
    },
    // get the embed fla object 
    getFLA : function (){
    	this.fla = this.getPluginEmbed();   		
    },
    stop : function(){    
    	js_log('f:flashEmbed:stop');	
    	if (this.monitorTimerId != 0 )
	    {
	        clearInterval(this.monitorTimerId);
	        this.monitorTimerId = 0;
	    }
    	this.parent_stop();
    },
    onStop: function(){
    	js_log('f:onStop');
    	//stop updates: 
		if( this.monitorTimerId != 0 )
	    {
	        clearInterval(this.monitorTimerId);
	        this.monitorTimerId = 0;
	    }
    }
}
function asString(obj) {
	switch (typeOf(obj)){
		case 'string':
			return '"'+obj.replace(new RegExp('(["\\\\])', 'g'), '\\$1')+'"';
		case 'array':

			return '['+ map(obj, function(el) {
				return asString(el);
			}).join(',') +']';


		case 'object':
			var str = [];
			for (var property in obj) {

				str.push('"'+property+'":'+ asString(obj[property]));
			}
			return '{'+str.join(',')+'}';
	}
	// replace ' --> "  and remove spaces
	return String(obj)
		.replace(/\s/g, " ")
		.replace(/\'/g, "\""); //'
}


// private functions
function typeOf(obj){
	if (obj === null || obj === undefined) return false;
	var type = typeof obj;
	return (type == 'object' && obj.push) ? 'array' : type;
}
	
function locateFlashEmbed(clip)
{
    for(var i in global_ogg_list)
    {
        var embed = document.getElementById(global_ogg_list[i]);
        if(embed.media_element.selected_source.uri.match(clip.fileName))
        {
            //js_log('found flash embed');
            return embed;
        }
    }
}

/* flowplayer callbacks */
function onFlowPlayerReady()
{
    js_log('onFlowPlayerReady');
}

function onClipDone(clip)
{	
    var embed = locateFlashEmbed(clip);
    js_log('f:onClipDone:'+embed.id + ' embed time: '+ embed.time);
    
    if( ! embed.startedTimedPlayback){
    	js_log('clip done before timed playback started .. not good...re-issuing play in .250 seconds');
    	setTimeout('$j(\''+embed.id+'\').get(0).play()', 250);
    }else{
    	js_log('clip done and '+ embed.startedTimedPlayback);
	    embed.setStatus("Clip Done...");
	    //stop the 
	    embed.onClipDone();
    }
}

function onLoadBegin(clip)
{
    var embed = locateFlashEmbed(clip);
    embed.setStatus("Loading Begun...");
}

function onPlay(clip)
{
    var embed = locateFlashEmbed(clip);
    embed.setStatus("Playing...");
}

function onStop(clip)
{
    var embed = locateFlashEmbed(clip);
    embed.setStatus("Stopped...");
}

function onPause(clip)
{
    var embed = locateFlashEmbed(clip);
    embed.pause();
    embed.setStatus("Paused...");
}

function onResume(clip)
{
    var embed = locateFlashEmbed(clip);
    embed.setStatus("Resumed...");
}

function onStartBuffering(clip)
{
    var embed = locateFlashEmbed(clip);
    embed.setStatus("Buffering Started...");
}
