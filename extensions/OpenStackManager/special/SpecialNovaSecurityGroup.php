<?php
class SpecialNovaSecurityGroup extends SpecialNova {

	var $adminNova, $userNova;
	var $userLDAP;

	function __construct() {
		parent::__construct( 'NovaSecurityGroup' );
	}

	function execute( $par ) {
		global $wgRequest, $wgUser;
		global $wgOpenStackManagerNovaAdminKeys;

		if ( ! $wgUser->isLoggedIn() ) {
			$this->notLoggedIn();
			return true;
		}
		$this->userLDAP = new OpenStackNovaUser();
		if ( ! $this->userLDAP->exists() ) {
			$this->noCredentials();
			return true;
		}
		$adminCredentials = $wgOpenStackManagerNovaAdminKeys;
		$this->adminNova = new OpenStackNovaController( $adminCredentials );

		$action = $wgRequest->getVal( 'action' );

		if ( $action == "create" ) {
			$this->createSecurityGroup();
		} else if ( $action == "delete" ) {
			$this->deleteSecurityGroup();
		} else if ( $action == "configure" ) {
			// Currently unsupported
			#$this->configureSecurityGroup();
			$this->listSecurityGroups();
		} else if ( $action == "addrule" ) {
			$this->addRule();
		} else if ( $action == "removerule" ) {
			$this->removeRule();
		} else {
			$this->listSecurityGroups();
		}
	}

	/**
	 * @return bool
	 */
	function createSecurityGroup() {
		global $wgRequest, $wgOut;

		$this->setHeaders();
		$wgOut->setPagetitle( wfMsg( 'openstackmanager-createsecuritygroup' ) );

		$project = $wgRequest->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'netadmin', $project ) ) {
			$this->notInRole( 'netadmin' );
			return false;
		}
		$securityGroupInfo = array();
		$securityGroupInfo['groupname'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-securitygroupname',
			'default' => '',
		);
		$securityGroupInfo['description'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-securitygroupdescription',
			'default' => '',
		);
		$securityGroupInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
		);

		$securityGroupInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'create',
		);

		$securityGroupForm = new SpecialNovaSecurityGroupForm( $securityGroupInfo, 'openstackmanager-novasecuritygroup' );
		$securityGroupForm->setTitle( SpecialPage::getTitleFor( 'NovaSecurityGroup' ) );
		$securityGroupForm->setSubmitID( 'openstackmanager-novainstance-createsecuritygroupsubmit' );
		$securityGroupForm->setSubmitCallback( array( $this, 'tryCreateSubmit' ) );
		$securityGroupForm->show();

		return true;

	}

	/**
	 * @return bool
	 */
	function configureSecurityGroup() {
		global $wgRequest, $wgOut;
		global $wgOpenStackManagerPuppetOptions;

		$this->setHeaders();
		$wgOut->setPagetitle( wfMsg( 'openstackmanager-configuresecuritygroup' ) );

		$securitygroupname = $wgRequest->getText( 'groupname' );
		$securitygroup = $this->adminNova->getSecurityGroup( $securitygroupname );
		$description = $securitygroup->getGroupDescription();
		$project = $wgRequest->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'netadmin', $project ) ) {
			$this->notInRole( 'netadmin' );
			return false;
		}
		$securityGroupInfo = array();
		$securityGroupInfo['groupname'] = array(
			'type' => 'hidden',
			'default' => $securitygroupname,
		);
		$securityGroupInfo['description'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-securitygroupdescription',
			'default' => $description,
		);
		$securityGroupInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
		);

		$securityGroupInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'configure',
		);

		$securityGroupForm = new SpecialNovaSecurityGroupForm( $securityGroupInfo, 'openstackmanager-novasecuritygroup' );
		$securityGroupForm->setTitle( SpecialPage::getTitleFor( 'NovaSecurityGroup' ) );
		$securityGroupForm->setSubmitID( 'openstackmanager-novainstance-configuresecuritygroupsubmit' );
		$securityGroupForm->setSubmitCallback( array( $this, 'tryConfigureSubmit' ) );
		$securityGroupForm->show();

		return true;

	}

	/**
	 * @return bool
	 */
	function deleteSecurityGroup() {
		global $wgOut, $wgRequest;

		$this->setHeaders();
		$wgOut->setPagetitle( wfMsg( 'openstackmanager-deletesecuritygroup' ) );

		$project = $wgRequest->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'netadmin', $project ) ) {
			$this->notInRole( 'netadmin' );
			return false;
		}
		$securitygroupname = $wgRequest->getText( 'groupname' );
		if ( ! $wgRequest->wasPosted() ) {
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-deletesecuritygroup-confirm', $securitygroupname ) );
		}
		$securityGroupInfo = array();
		$securityGroupInfo['groupname'] = array(
			'type' => 'hidden',
			'default' => $securitygroupname,
		);
		$securityGroupInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
		);
		$securityGroupInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'delete',
		);
		$securityGroupForm = new SpecialNovaSecurityGroupForm( $securityGroupInfo, 'openstackmanager-novasecuritygroup' );
		$securityGroupForm->setTitle( SpecialPage::getTitleFor( 'NovaSecurityGroup' ) );
		$securityGroupForm->setSubmitID( 'novainstance-form-deletesecuritygroupsubmit' );
		$securityGroupForm->setSubmitCallback( array( $this, 'tryDeleteSubmit' ) );
		$securityGroupForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function listSecurityGroups() {
		global $wgOut, $wgUser;

		$this->setHeaders();
		$wgOut->setPagetitle( wfMsg( 'openstackmanager-securitygrouplist' ) );

		$userProjects = $this->userLDAP->getProjects();
		$sk = $wgUser->getSkin();
		$out = '';
		$groupheader = Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygroupname' ) );
		$groupheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygroupdescription' ) );
		$groupheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygrouprule' ) );
		$groupheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-actions' ) );
		$ruleheader = Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygrouprule-fromport' ) );
		$ruleheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygrouprule-toport' ) );
		$ruleheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygrouprule-protocol' ) );
		$ruleheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygrouprule-ipranges' ) );
		$ruleheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygrouprule-groups' ) );
		$ruleheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-actions' ) );
		$projectArr = array();
		$securityGroups = $this->adminNova->getSecurityGroups();
		foreach ( $securityGroups as $group ) {
			$project = $group->getOwner();
			if ( ! in_array( $project, $userProjects ) ) {
				continue;
			}
			$groupname = $group->getGroupName();
			$groupOut = Html::element( 'td', array(), $groupname );
			$groupOut .= Html::element( 'td', array(), $group->getGroupDescription() );
			# Add rules
			$rules = $group->getRules();
			if ( $rules ) {
				$rulesOut = $ruleheader;
				foreach ( $rules as $rule ) {
					$fromport = $rule->getFromPort();
					$toport = $rule->getToPort();
					$ipprotocol = $rule->getIPProtocol();
					$ruleOut = Html::element( 'td', array(), $fromport );
					$ruleOut .= Html::element( 'td', array(), $toport );
					$ruleOut .= Html::element( 'td', array(), $ipprotocol );
					$ranges = $rule->getIPRanges();
					if ( $ranges ) {
						$rangesOut = '';
						foreach ( $ranges as $range ) {
							$rangesOut .= Html::element( 'li', array(), $range );
						}
						$rangesOut = Html::rawElement( 'ul', array(), $rangesOut );
						$ruleOut .= Html::rawElement( 'td', array(), $rangesOut );
					} else {
						$ruleOut .= Html::rawElement( 'td', array(), '' );
					}
					$sourcegroups = $rule->getGroups();
					$groupinfo = array();
					if ( $sourcegroups ) {
						$sourcegroupsOut = '';
						foreach ( $sourcegroups as $sourcegroup ) {
							$groupinfo[] = $sourcegroup['groupname'] . ':' . $sourcegroup['project'];
							$sourcegroupinfo = $sourcegroup['groupname'] . ' (' . $sourcegroup['project'] . ')';
							$sourcegroupsOut .= Html::element( 'li', array(), $sourcegroupinfo );
						}
						$sourcegroupsOut = Html::rawElement( 'ul', array(), $sourcegroupsOut );
						$ruleOut .= Html::rawElement( 'td', array(), $sourcegroupsOut );
					} else {
						$ruleOut .= Html::rawElement( 'td', array(), '' );
					}
					$msg = wfMsg( 'openstackmanager-removerule-action' );
					$args = array(  'action' => 'removerule',
							'project' => $project,
							'groupname' => $groupname,
							'fromport' => $fromport,
							'toport' => $toport,
							'protocol' => $ipprotocol,
							'ranges' => implode( ',', $ranges ),
							'groups' => implode( ',', $groupinfo ) );
					$link = $sk->link( $this->getTitle(), $msg, array(), $args, array() );
					$actions = Html::rawElement( 'li', array(), $link );
					$actions = Html::rawElement( 'ul', array(), $actions );
					$ruleOut .= Html::rawElement( 'td', array(), $actions );
					$rulesOut .= Html::rawElement( 'tr', array(), $ruleOut );
				}
				$rulesOut = Html::rawElement( 'table', array( 'id' => 'novasecuritygrouplist', 'class' => 'wikitable' ), $rulesOut );
				$groupOut .= Html::rawElement( 'td', array(), $rulesOut );
			} else {
				$groupOut .= Html::rawElement( 'td', array(), '' );
			}
			$msg = wfMsg( 'openstackmanager-delete' );
			$link = $sk->link( $this->getTitle(), $msg, array(),
								  array( 'action' => 'delete',
									   'project' => $project,
									   'groupname' => $group->getGroupName() ),
								  array() );
			$actions = Html::rawElement( 'li', array(), $link );
			#$msg = wfMsg( 'openstackmanager-configure' );
			#$link = $sk->link( $this->getTitle(), $msg, array(),
			#					   array( 'action' => 'configure',
			#							'project' => $project,
			#							'groupname' => $group->getGroupName() ),
			#					   array() );
			#$actions .= Html::rawElement( 'li', array(), $link );
			$msg = wfMsg( 'openstackmanager-addrule-action' );
			$link = $sk->link( $this->getTitle(), $msg, array(),
								   array( 'action' => 'addrule',
										'project' => $project,
										'groupname' => $group->getGroupName() ),
								   array() );
			$actions .= Html::rawElement( 'li', array(), $link );
			$actions = Html::rawElement( 'ul', array(), $actions );
			$groupOut .= Html::rawElement( 'td', array(), $actions );
			if ( isset( $projectArr["$project"] ) ) {
				$projectArr["$project"] .= Html::rawElement( 'tr', array(), $groupOut );
			} else {
				$projectArr["$project"] = Html::rawElement( 'tr', array(), $groupOut );
			}
		}
		foreach ( $userProjects as $project ) {
			$out .= Html::element( 'h2', array(), $project );
			$out .= $sk->link( $this->getTitle(), wfMsg( 'openstackmanager-createnewsecuritygroup' ), array(),
							   array( 'action' => 'create', 'project' => $project ), array() );
			if ( isset( $projectArr["$project"] ) ) {
				$projectOut = $groupheader;
				$projectOut .= $projectArr["$project"];
				$out .= Html::rawElement( 'table',
										  array( 'id' => 'novainstancelist', 'class' => 'wikitable' ), $projectOut );
			}
		}

		$wgOut->addHTML( $out );
		return true;
	}

	/**
	 * @return bool
	 */
	function addRule() {
		global $wgOut, $wgRequest;

		$this->setHeaders();
		$wgOut->setPagetitle( wfMsg( 'openstackmanager-addrule' ) );

		$project = $wgRequest->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'netadmin', $project ) ) {
			$this->notInRole( 'netadmin' );
			return false;
		}
		$group_keys = array();
		$securityGroups = $this->adminNova->getSecurityGroups();
		foreach ( $securityGroups as $securityGroup ) {
			$securityGroupName = $securityGroup->getGroupName();
			$securityGroupProject = $securityGroup->getOwner();
			$group_keys["$securityGroupName"] = $securityGroupName . ':' . $securityGroupProject;
		}
		$securitygroupname = $wgRequest->getText( 'groupname' );
		$securityGroupInfo = array();
		$securityGroupInfo['groupname'] = array(
			'type' => 'hidden',
			'default' => $securitygroupname,
		);
		$securityGroupInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
		);
		$securityGroupInfo['fromport'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-securitygrouprule-fromport',
			'default' => '',
		);
		$securityGroupInfo['toport'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-securitygrouprule-toport',
			'default' => '',
		);
		$securityGroupInfo['protocol'] = array(
			'type' => 'select',
			'label-message' => 'openstackmanager-securitygrouprule-protocol',
			'options' => array( '' => '', 'icmp' => 'icmp', 'tcp' => 'tcp', 'udp' => 'udp' ),
		);
		$securityGroupInfo['ranges'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-securitygrouprule-ranges',
			'help-message' => 'openstackmanager-securitygrouprule-ranges-help',
			'default' => '',
		);
		$securityGroupInfo['groups'] = array(
			'type' => 'multiselect',
			'label-message' => 'openstackmanager-securitygrouprule-groups',
			'help-message' => 'openstackmanager-securitygrouprule-groups-help',
			'options' => $group_keys,
		);
		$securityGroupInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'addrule',
		);
		$securityGroupForm = new SpecialNovaSecurityGroupForm( $securityGroupInfo, 'openstackmanager-novasecuritygroup' );
		$securityGroupForm->setTitle( SpecialPage::getTitleFor( 'NovaSecurityGroup' ) );
		$securityGroupForm->setSubmitID( 'novainstance-form-removerulesubmit' );
		$securityGroupForm->setSubmitCallback( array( $this, 'tryAddRuleSubmit' ) );
		$securityGroupForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function removeRule() {
		global $wgOut, $wgRequest;

		$this->setHeaders();
		$wgOut->setPagetitle( wfMsg( 'openstackmanager-removerule' ) );

		$project = $wgRequest->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'netadmin', $project ) ) {
			$this->notInRole( 'netadmin' );
			return false;
		}
		$securitygroupname = $wgRequest->getText( 'groupname' );
		if ( ! $wgRequest->wasPosted() ) {
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-removerule-confirm', $securitygroupname ) );
		}
		$securityGroupInfo = array();
		$securityGroupInfo['groupname'] = array(
			'type' => 'hidden',
			'default' => $securitygroupname,
		);
		$securityGroupInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
		);
		$securityGroupInfo['fromport'] = array(
			'type' => 'hidden',
			'default' => $wgRequest->getText( 'fromport' ),
		);
		$securityGroupInfo['toport'] = array(
			'type' => 'hidden',
			'default' => $wgRequest->getText( 'toport' ),
		);
		$securityGroupInfo['protocol'] = array(
			'type' => 'hidden',
			'default' => $wgRequest->getText( 'protocol' ),
		);
		if ( $wgRequest->getText( 'ranges' ) ) {
			$securityGroupInfo['ranges'] = array(
				'type' => 'hidden',
				'default' => $wgRequest->getText( 'ranges' ),
			);
		}
		if ( $wgRequest->getText( 'groups' ) ) {
			$securityGroupInfo['groups'] = array(
				'type' => 'hidden',
				'default' => $wgRequest->getText( 'groups' ),
			);
		}
		$securityGroupInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'removerule',
		);
		$securityGroupForm = new SpecialNovaSecurityGroupForm( $securityGroupInfo, 'openstackmanager-novasecuritygroup' );
		$securityGroupForm->setTitle( SpecialPage::getTitleFor( 'NovaSecurityGroup' ) );
		$securityGroupForm->setSubmitID( 'novainstance-form-removerulesubmit' );
		$securityGroupForm->setSubmitCallback( array( $this, 'tryRemoveRuleSubmit' ) );
		$securityGroupForm->show();

		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryCreateSubmit( $formData, $entryPoint = 'internal' ) {
		global $wgOut, $wgUser;

		$project = $formData['project'];
		$groupname = $formData['groupname'];
		$description = $formData['description'];
		$userCredentials = $this->userLDAP->getCredentials( $project );
		$this->userNova = new OpenStackNovaController( $userCredentials );
		$securitygroup = $this->userNova->createSecurityGroup( $groupname, $description );
		if ( $securitygroup ) {
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-createdsecuritygroup' ) );
		} else {
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-createsecuritygroupfailed' ) );
		}
		$sk = $wgUser->getSkin();
		$out = '<br />';
		$out .= $sk->link( $this->getTitle(), wfMsg( 'openstackmanager-backsecuritygrouplist' ), array(), array(), array() );

		$wgOut->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryDeleteSubmit( $formData, $entryPoint = 'internal' ) {
		global $wgOut, $wgUser;

		$project = $formData['project'];
		$userCredentials = $this->userLDAP->getCredentials( $project );
		$this->userNova = new OpenStackNovaController( $userCredentials );
		$securitygroup = $this->adminNova->getSecurityGroup( $formData['groupname'] );
		if ( ! $securitygroup ) {
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-nonexistantsecuritygroup' ) );
			return true;
		}
		$groupname = $securitygroup->getGroupName();
		$success = $this->userNova->deleteSecurityGroup( $groupname );
		if ( $success ) {
			# TODO: Ensure group isn't being used
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-deletedsecuritygroup' ) );
		} else {
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-deletesecuritygroupfailed' ) );
		}
		$sk = $wgUser->getSkin();
		$out = '<br />';
		$out .= $sk->link( $this->getTitle(), wfMsg( 'openstackmanager-backsecuritygrouplist' ), array(), array(), array() );

		$wgOut->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryConfigureSubmit( $formData, $entryPoint = 'internal' ) {
		global $wgOut, $wgUser;
		global $wgOpenStackManagerPuppetOptions;

		$groupname = $formData['groupname'];
		$description = $formData['description'];
		$group = $this->adminNova->getSecurityGroup( $groupname );
		if ( $group ) {
			# This isn't a supported function in the API for now. Leave this action out for now
			$success = $this->userNova->modifySecurityGroup( $groupname, array( 'description' => $description ) );
			if ( $success ) {
				$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-modifiedgroup' ) );
			} else {
				$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-modifygroupfailed' ) );
			}
		} else {
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-nonexistantgroup' ) );
		}
		$sk = $wgUser->getSkin();
		$out = '<br />';
		$out .= $sk->link( $this->getTitle(), wfMsg( 'openstackmanager-backsecuritygrouplist' ), array(), array(), array() );

		$wgOut->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryAddRuleSubmit( $formData, $entryPoint = 'internal' ) {
		global $wgOut, $wgUser;

		$project = $formData['project'];
		$fromport = $formData['fromport'];
		$toport = $formData['toport'];
		$protocol = $formData['protocol'];
		if ( isset( $formData['ranges'] ) && $formData['ranges'] ) {
			$ranges = explode( ',', $formData['ranges'] );
		} else {
			$ranges = array();
		}
		$groups = array();
		foreach ( $formData['groups'] as $group ) {
			$group = explode( ':', $group );
			$groups[] = array( 'groupname' => $group[0], 'project' => $group[1] );
		}
		$userCredentials = $this->userLDAP->getCredentials( $project );
		$this->userNova = new OpenStackNovaController( $userCredentials );
		$securitygroup = $this->adminNova->getSecurityGroup( $formData['groupname'] );
		if ( ! $securitygroup ) {
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-nonexistantsecuritygroup' ) );
			return false;
		}
		$groupname = $securitygroup->getGroupName();
		$success = $this->userNova->addSecurityGroupRule( $groupname, $fromport, $toport, $protocol, $ranges, $groups );
		if ( $success ) {
			# TODO: Ensure group isn't being used
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-addedrule' ) );
		} else {
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-addrulefailed' ) );
		}
		$sk = $wgUser->getSkin();
		$out = '<br />';
		$out .= $sk->link( $this->getTitle(), wfMsg( 'openstackmanager-backsecuritygrouplist' ), array(), array(), array() );

		$wgOut->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryRemoveRuleSubmit( $formData, $entryPoint = 'internal' ) {
		global $wgOut, $wgUser;

		$project = $formData['project'];
		$fromport = $formData['fromport'];
		$toport = $formData['toport'];
		$protocol = $formData['protocol'];
		if ( isset( $formData['ranges'] ) ) {
			$ranges = explode( ',', $formData['ranges'] );
		} else {
			$ranges = array();
		}
		$groups = array();
		if ( isset( $formData['groups'] ) ) {
			$rawgroups = explode( ',', $formData['groups'] );
			foreach ( $rawgroups as $rawgroup ) {
				$rawgroup = explode( ':', $rawgroup );
				$groups[] = array( 'groupname' => $rawgroup[0], 'project' => $rawgroup[1] );
			}
		}
		$userCredentials = $this->userLDAP->getCredentials( $project );
		$this->userNova = new OpenStackNovaController( $userCredentials );
		$securitygroup = $this->adminNova->getSecurityGroup( $formData['groupname'] );
		if ( ! $securitygroup ) {
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-nonexistantsecuritygroup' ) );
			return false;
		}
		$groupname = $securitygroup->getGroupName();
		$success = $this->userNova->removeSecurityGroupRule( $groupname, $fromport, $toport, $protocol, $ranges, $groups );
		if ( $success ) {
			# TODO: Ensure group isn't being used
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-removedrule' ) );
		} else {
			$wgOut->wrapWikiMsg( '<div>$1</div>', array( 'openstackmanager-removerulefailed' ) );
		}
		$sk = $wgUser->getSkin();
		$out = '<br />';
		$out .= $sk->link( $this->getTitle(), wfMsg( 'openstackmanager-backsecuritygrouplist' ), array(), array(), array() );

		$wgOut->addHTML( $out );
		return true;
	}
}

class SpecialNovaSecurityGroupForm extends HTMLForm {
}
