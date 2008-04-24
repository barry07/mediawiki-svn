<?php

/**
  *
  * Equivalent of Special:Userrights for global groups.
  * @addtogroup extensions
  */
  
class SpecialGlobalGroupMembership extends UserrightsPage {
	var $mGlobalUser;
	function SpecialGlobalGroupMembership() {
		SpecialPage::SpecialPage( 'GlobalGroupMembership' );
		
		global $wgUser;
		$this->mGlobalUser = CentralAuthUser::getInstance( $wgUser );
	}
	
	function changeableGroups() {
		global $wgUser;
		
		## Should be a global user
		if (!$this->mGlobalUser->exists() || !$this->mGlobalUser->isAttached()) {
			return array();
		}
		
		$allgroups = CentralAuthUser::availableGlobalGroups();
		
		## Permission MUST be gained from global rights.
		return $this->mGlobalUser->hasGlobalPermission( 'globalgroupmembership' ) ? array( 'add' => $allgroups, 'remove' =>  $allgroups): array();
	}
	
	function fetchUser( $username ) {
		global $wgOut, $wgUser;
		
		$user = CentralAuthGroupMembershipProxy::newFromName( $username );
	
		if( !$user ) {
			$wgOut->addWikiMsg( 'nosuchusershort', $username );
			return null;
		}
	
		return $user;
	}
	
	protected static function getAllGroups() {
		return CentralAuthUser::availableGlobalGroups();
	}
	
	protected function showLogFragment( $user, $output ) {
		$pagetitle = Title::makeTitleSafe( NS_USER, $user->getName());
		$output->addHtml( Xml::element( 'h2', null, LogPage::logName( 'gblrights' ) . "\n" ) );
		LogEventsList::showLogExtract( $output, 'globalrights', $pagetitle->getPrefixedText );
	}
	
	function addLogEntry( $user, $oldGroups, $newGroups ) {
		global $wgRequest;
		
		$log = new LogPage( 'gblrights' );

		$log->addEntry( 'usergroups',
			$user->getUserPage(),
			$wgRequest->getText( 'user-reason' ),
			array(
				$this->makeGroupNameList( $oldGroups ),
				$this->makeGroupNameList( $newGroups )
			)
		);
	}
}
