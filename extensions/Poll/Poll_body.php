<?php
/**
 * Poll_body - Body for the Special Page Special:Poll
 *
 * @ingroup Extensions
 * @author Jan Luca <jan@toolserver.org>
 * @license http://creativecommons.org/licenses/by-sa/3.0/ Attribution-Share Alike 3.0 Unported or later
 */


class Poll extends SpecialPage {
	
	public function __construct() {
		parent::__construct( 'Poll' );
		wfLoadExtensionMessages( 'Poll' );
	}

	public function execute( $par ) {
		global $wgRequest, $wgOut;

		$this->setHeaders();

		# Get request data from, e.g.
		$action = htmlentities( $wgRequest->getText( 'action' ) );
		$id = htmlentities( $wgRequest->getText( 'id' ) );
		
		if ( $action == "" OR $action == "list" ) {
		    $this->make_list();
		}

		if ( $action == "create" ) {
			$this->create();
		}

		if ( $action == "vote" ) {
			$this->vote( $id );
		}
		
		if ( $action == "change" ) {
			$this->change( $id );
		}
		
		if ( $action == "delete" ) {
			$this->delete( $id );
		}

    	if ( $action == "submit" ) {
      		$this->submit( $id );
    	}
	}
	
  public function make_list() {
      global $wgRequest, $wgOut, $wgUser, $wgTitle;
	  $wgOut->setPagetitle( wfMsg( 'poll' ) );
	  
	  $dbr = wfGetDB( DB_SLAVE );
	  $query = $dbr->select( 'poll', 'question, dis, id' );
	  
	  $wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=create').'">'.wfMsg( 'poll-create-link' ).'</a>' );
	  
	  $wgOut->addWikiMsg( 'poll-list-current' );
	  $wgOut->addHtml( Xml::openElement( 'table' ) );
	  $wgOut->addHtml( '<tr><th>'.wfMsg( 'poll-question' ).'</th><th>'.wfMsg( 'poll-dis' ).'</th></tr>' );
	  
	  while( $row = $dbr->fetchObject( $query ) ) {
		  $wgOut->addHtml( '<tr><td><a href="'.$wgTitle->getFullURL( 'action=vote&id='.$row->id ).'">'.htmlentities( $row->question, ENT_QUOTES, "UTF-8" ).'</a></td>' );
		  $wgOut->addHtml( '<td>'.$row->dis.'</td></tr>' );
	  }
	  
	  $wgOut->addHtml( Xml::closeElement( 'table' ) );
	  
  }

  public function create() {
      global $wgRequest, $wgOut, $wgUser, $wgTitle;
      
      $wgOut->setPagetitle( wfMsg( 'poll-title-create' ) );
      
      $controll_create_right = $wgUser->isAllowed( 'poll-create' );
      $controll_create_blocked = $wgUser->isBlocked();
      if ( $controll_create_right != true ) {
          $wgOut->addWikiMsg( 'poll-create-right-error' );
		  $wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
      }
      elseif ( $controll_create_blocked == true ) {
          $wgOut->addWikiMsg( 'poll-create-block-error' );
		  $wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
      }
      else {
          $wgOut->addHtml( Xml::openElement( 'form', array('method'=> 'post', 'action' => $wgTitle->getFullURL('action=submit') ) ) );
          $wgOut->addHtml( Xml::openElement( 'table' ) );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-question' ).':</td><td>'.Xml::input('question').'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 1:</td><td>'.Xml::input('poll_alternative_1').'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 2:</td><td>'.Xml::input('poll_alternative_2').'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 3:</td><td>'.Xml::input('poll_alternative_3').'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 4:</td><td>'.Xml::input('poll_alternative_4').'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 5:</td><td>'.Xml::input('poll_alternative_5').'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 6:</td><td>'.Xml::input('poll_alternative_6').'</td></tr>' );
		  $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-dis' ).':</td><td>'.Xml::textarea('dis', '').'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.Xml::submitButton(wfMsg( 'poll-submit' )).''.Xml::hidden('type', 'create').'</td></tr>' );
          $wgOut->addHtml( Xml::closeElement( 'table' ) );
          $wgOut->addHtml( Xml::closeElement( 'form' ) );
      }
  }
  
   public function vote( $vid ) {
      global $wgRequest, $wgOut, $wgUser, $wgTitle;
      
      $wgOut->setPagetitle( wfMsg( 'poll-title-vote' ) );
      
      $controll_vote_right = $wgUser->isAllowed( 'poll-vote' );
      $controll_vote_blocked = $wgUser->isBlocked();
      if ( $controll_vote_right != true ) {
          $wgOut->addWikiMsg( 'poll-vote-right-error' );
		  $wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
      }
      elseif ( $controll_vote_blocked == true ) {
          $wgOut->addWikiMsg( 'poll-vote-block-error' );
		  $wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
      }
      else {
          $dbr = wfGetDB( DB_SLAVE );
		  $query = $dbr->select( 'poll', 'question, alternative_1, alternative_2, alternative_3, alternative_4, alternative_5, alternative_6, creater', 'id = ' . $vid);
		  $poll_admin = $wgUser->isAllowed( 'poll-admin' );
		  $user = $wgUser->getName();
		  
		  while( $row = $dbr->fetchObject( $query ) ) {
		      $question = htmlentities( $row->question, ENT_QUOTES, 'UTF-8' );
			  $alternative_1 = htmlentities( $row->alternative_1, ENT_QUOTES, 'UTF-8'  );
			  $alternative_2 = htmlentities( $row->alternative_2, ENT_QUOTES, 'UTF-8'  );
			  $alternative_3 = htmlentities( $row->alternative_3, ENT_QUOTES, 'UTF-8'  );
			  $alternative_4 = htmlentities( $row->alternative_4, ENT_QUOTES, 'UTF-8'  );
			  $alternative_5 = htmlentities( $row->alternative_5, ENT_QUOTES, 'UTF-8'  );
			  $alternative_6 = htmlentities( $row->alternative_6, ENT_QUOTES, 'UTF-8'  );
			  $creater = htmlentities( $row->creater, ENT_QUOTES, 'UTF-8'  );
		  }
		  
		  $wgOut->addHtml( Xml::openElement( 'form', array('method'=> 'post', 'action' => $wgTitle->getFullURL('action=submit&id='.$vid) ) ) );
          $wgOut->addHtml( Xml::openElement( 'table' ) );
		  $wgOut->addHtml( '<tr><th>'.$question.'</th></tr>' );
          $wgOut->addHtml( '<tr><td>'.Xml::radio('vote', '1').' '.$alternative_1.'</td></tr>' );
		  $wgOut->addHtml( '<tr><td>'.Xml::radio('vote', '2').' '.$alternative_2.'</td></tr>' );
		  if($alternative_3 != "") { $wgOut->addHtml( '<tr><td>'.Xml::radio('vote', '3').' '.$alternative_3.'</td></tr>' ); }
		  if($alternative_4 != "") { $wgOut->addHtml( '<tr><td>'.Xml::radio('vote', '4').' '.$alternative_4.'</td></tr>' ); }
		  if($alternative_5 != "") { $wgOut->addHtml( '<tr><td>'.Xml::radio('vote', '5').' '.$alternative_5.'</td></tr>' ); }
		  if($alternative_6 != "") { $wgOut->addHtml( '<tr><td>'.Xml::radio('vote', '6').' '.$alternative_6.'</td></tr>' ); }
          $wgOut->addHtml( '<tr><td>'.Xml::submitButton(wfMsg( 'poll-submit' )).''.Xml::hidden('type', 'vote').'</td></tr>' );
		  $wgOut->addHtml( '<tr><td>' );
		  $wgOut->addWikiText( '<small>erstellt von [[Benutzer:'.$creater.']]</small>' );
		  $wgOut->addHtml( '</td></tr>' );
          $wgOut->addHtml( Xml::closeElement( 'table' ) );
		  if( ($poll_admin == true) OR ($creater == $user) ) {
		      $wgOut->addHtml( 'Administration: <a href="'.$wgTitle->getFullURL('action=change&id='.$vid).'">'.wfMsg('poll-change').'</a> · <a href="'.$wgTitle->getFullURL('action=delete&id='.$vid).'">'.wfMsg('poll-delete').'</a>' );
		  }
          $wgOut->addHtml( Xml::closeElement( 'form' ) );
      }
  }
  
  public function change($cid) {
      global $wgRequest, $wgOut, $wgUser, $wgTitle;
      
      $wgOut->setPagetitle( wfMsg( 'poll-title-change' ) );
	  
	  $dbr = wfGetDB( DB_SLAVE );
	  $query = $dbr->select( 'poll', 'question, alternative_1, alternative_2, alternative_3, alternative_4, alternative_5, alternative_6, creater, dis', 'id = ' . $cid);
      $user = $wgUser->getName();
	  
	  while( $row = $dbr->fetchObject( $query ) ) {
		  $question = $row->question;
		  $alternative_1 = $row->alternative_1;
		  $alternative_2 = $row->alternative_2;
		  $alternative_3 = $row->alternative_3;
		  $alternative_4 = $row->alternative_4;
		  $alternative_5 = $row->alternative_5;
		  $alternative_6 = $row->alternative_6;
	      $creater = $row->creater;
		  $dis = $row->dis;
	  }
	  
      $controll_create_blocked = $wgUser->isBlocked();
      if ( $user != $creater ) {
          $wgOut->addWikiMsg( 'poll-change-right-error' );
		  $wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
      }
      elseif ( $controll_create_blocked == true ) {
          $wgOut->addWikiMsg( 'poll-change-block-error' );
		  $wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
      }
      else {
          $wgOut->addHtml( Xml::openElement( 'form', array('method'=> 'post', 'action' => $wgTitle->getFullURL('action=submit&id='.$cid) ) ) );
          $wgOut->addHtml( Xml::openElement( 'table' ) );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-question' ).':</td><td>'.Xml::input('question', false, $question).'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 1:</td><td>'.Xml::input('poll_alternative_1', false, $alternative_1).'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 2:</td><td>'.Xml::input('poll_alternative_2', false, $alternative_2).'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 3:</td><td>'.Xml::input('poll_alternative_3', false, $alternative_3).'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 4:</td><td>'.Xml::input('poll_alternative_4', false, $alternative_4).'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 5:</td><td>'.Xml::input('poll_alternative_5', false, $alternative_5).'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-alternative' ).' 6:</td><td>'.Xml::input('poll_alternative_6', false, $alternative_6).'</td></tr>' );
		  $wgOut->addHtml( '<tr><td>'.wfMsg( 'poll-dis' ).':</td><td>'.Xml::textarea('dis', $dis).'</td></tr>' );
          $wgOut->addHtml( '<tr><td>'.Xml::submitButton(wfMsg( 'poll-submit' )).''.Xml::hidden('type', 'change').'</td></tr>' );
          $wgOut->addHtml( Xml::closeElement( 'table' ) );
          $wgOut->addHtml( Xml::closeElement( 'form' ) );
      }
  }
  
  public function submit( $pid ) {
      global $wgRequest, $wgOut, $wgUser, $wgTitle;
	  
	  $type = $_POST['type'];
	  
	  if($type == 'create') {
	    $controll_create_right = $wgUser->isAllowed( 'poll-create' );
        $controll_create_blocked = $wgUser->isBlocked();
        if ( $controll_create_right != true ) {
            $wgOut->addWikiMsg( 'poll-create-right-error' );
			$wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
        }
        elseif ( $controll_create_blocked == true ) {
            $wgOut->addWikiMsg( 'poll-create-block-error' );
			$wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
        }

		else {
		  $dbw = wfGetDB( DB_MASTER );
		  $question = $_POST['question'];
		  $alternative_1 = $_POST['poll_alternative_1'];
	      $alternative_2 = $_POST['poll_alternative_2'];
		  $alternative_3 = ($_POST['poll_alternative_3'] != "")? $_POST['poll_alternative_3'] : "";
		  $alternative_4 = ($_POST['poll_alternative_4'] != "")? $_POST['poll_alternative_4'] : "";
		  $alternative_5 = ($_POST['poll_alternative_5'] != "")? $_POST['poll_alternative_5'] : "";
		  $alternative_6 = ($_POST['poll_alternative_6'] != "")? $_POST['poll_alternative_6'] : "";
		  $dis = ($_POST['dis'] != "")? $_POST['dis'] : "Keine Beschreibung vorhanden!";
		  $user = $wgUser->getName();
		  
		  if($question != "" && $alternative_1 != "" && $alternative_2 != "") {
            $dbw->insert( 'poll', array( 'question' => $question, 'alternative_1' => $alternative_1, 'alternative_2' => $alternative_2,
			'alternative_3' => $alternative_3, 'alternative_4' => $alternative_4, 'alternative_5' => $alternative_5,
			'alternative_6' => $alternative_6, 'creater' => $user, 'dis' => $dis ) );
			
			$wgOut->addWikiMsg( 'poll-create-pass' );
			$wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
		  }
		  else {
		      $wgOut->addWikiMsg( 'poll-create-fields-error' );
			  $wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
		  }
	    }
      }
	  
	  if($type == 'vote') {
	    $controll_vote_right = $wgUser->isAllowed( 'poll-vote' );
        $controll_vote_blocked = $wgUser->isBlocked();
        if ( $controll_vote_right != true ) {
            $wgOut->addWikiMsg( 'poll-vote-right-error' );
			$wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
        }
        elseif ( $controll_vote_blocked == true ) {
            $wgOut->addWikiMsg( 'poll-vote-block-error' );
			$wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
        }

		else {
		  $dbw = wfGetDB( DB_MASTER );
		  $dbr = wfGetDB( DB_SLAVE );
		  $vote = $_POST['vote'];
		  $user = $wgUser->getName();
		  $uid = $wgUser->getId();
		  
		  $query = $dbr->select( 'poll_answer', 'uid', 'uid = ' . $uid);
		  $num = 0;
		  
		  while( $row = $dbr->fetchObject( $query ) ) {
		      if($row->uid != "") {
			      $num++;
			  }
		  }
		  
		  if( $num == 0 ) {
            $dbw->insert( 'poll_answer', array( 'pid' => $pid, 'uid' => $uid, 'vote' => $vote, 'user' => $user ) );
			
			$wgOut->addWikiMsg( 'poll-vote-pass' );
			$wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
		  }
		  else {
		      $wgOut->addWikiMsg( 'poll-vote-already-error' );
			  $wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
		  }
	    }
      }
	  
	  if($type == 'change') {
	    $dbr = wfGetDB( DB_SLAVE );
	    $query = $dbr->select( 'poll', 'creater', 'id = ' . $pid);
        $user = $wgUser->getName();
	  
	    while( $row = $dbr->fetchObject( $query ) ) {
	        $creater = htmlentities( $row->creater );
	    } 
	  
        $controll_create_blocked = $wgUser->isBlocked();
        if ( $user != $creater ) {
            $wgOut->addWikiMsg( 'poll-change-right-error' );
		    $wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
        }
        elseif ( $controll_create_blocked == true ) {
            $wgOut->addWikiMsg( 'poll-change-block-error' );
		    $wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
        }
        else {
		  $dbw = wfGetDB( DB_MASTER );
		  $question = $_POST['question'];
		  $alternative_1 = $_POST['poll_alternative_1'];
	      $alternative_2 = $_POST['poll_alternative_2'];
		  $alternative_3 = ($_POST['poll_alternative_3'] != "")? $_POST['poll_alternative_3'] : "";
		  $alternative_4 = ($_POST['poll_alternative_4'] != "")? $_POST['poll_alternative_4'] : "";
		  $alternative_5 = ($_POST['poll_alternative_5'] != "")? $_POST['poll_alternative_5'] : "";
		  $alternative_6 = ($_POST['poll_alternative_6'] != "")? $_POST['poll_alternative_6'] : "";
		  $dis = ($_POST['dis'] != "")? $_POST['dis'] : "Keine Beschreibung vorhanden!";
		  $user = $wgUser->getName();
		  
		  $dbw->update( 'poll', array( 'question' => $question, 'alternative_1' => $alternative_1, 'alternative_2' => $alternative_2,
			'alternative_3' => $alternative_3, 'alternative_4' => $alternative_4, 'alternative_5' => $alternative_5,
			'alternative_6' => $alternative_6, 'creater' => $user, 'dis' => $dis ), array( 'id' => $pid ) );
			
		  $wgOut->addWikiMsg( 'poll-change-pass' );
		  $wgOut->addHtml( '<a href="'.$wgTitle->getFullURL('action=list').'">'.wfMsg('poll-back').'</a>' );
	    }
      }
	  
  }
}
