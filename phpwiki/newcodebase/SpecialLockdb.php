<?

function wfSpecialLockdb()
{
	global $wgUser, $wgOut, $action;

	if ( ! $wgUser->isDeveloper() ) {
		$wgOut->developerRequired();
		return;
	}
	$f = new DBLockForm();

	if ( "success" == $action ) { $f->showSuccess(); }
	else if ( "submit" == $action ) { $f->doSubmit(); }
	else { $f->showForm( "" ); }
}

class DBLockForm {

	function showForm( $err )
	{
		global $wgOut, $wgUser, $wgLang;
		global $wpLockConfirm;

		$wgOut->setPagetitle( wfMsg( "lockdb" ) );
		$wgOut->addWikiText( wfMsg( "lockdbtext" ) );

		if ( "" != $err ) {
			$wgOut->setSubtitle( wfMsg( "formerror" ) );
			$wgOut->addHTML( "<p><font color='red' size='+1'>{$err}</font>\n" );
		}
		$lc = wfMsg( "lockconfirm" );
		$lb = wfMsg( "lockbtn" );
		$action = wfLocalUrlE( $wgLang->specialPage( "Lockdb" ),
		  "action=submit" );

		$wgOut->addHTML( "<p>
<form method=post action=\"{$action}\">
<table border=0><tr>
<td align='right'>
<input type=checkbox name='wpLockConfirm'>
</td>
<td align='left'>{$lc}<td>
</tr><tr>
<td>&nbsp;</td><td align='left'>
<input type=submit name='wpLock' value=\"{$lb}\">
</td></tr></table>
</form>\n" );

	}

	function doSubmit()
	{
		global $wgOut, $wgUser, $wgLang;
		global $wpLockConfirm, $wgReadOnlyFile;

		if ( ! $wpLockConfirm ) {
			$this->showForm( wfMsg( "locknoconfirm" ) );
			return;
		}
		$fp = fopen( $wgReadOnlyFile, "w" );

		if ( false === $fp ) {
			$wgOut->fileNotFoundError( $wgReadOnlyFile );
			return;
		}
		fwrite( $fp, "Database locked by " . $wgUser->getName() . " at " .
		  $wgLang->timeanddate( date( "YmdHis" ) ) . "\n" );
		fclose( $fp );

		$success = wfLocalUrl( $wgLang->specialPage( "Lockdb" ),
		  "action=success" );
		$wgOut->redirect( $success );
	}

	function showSuccess()
	{
		global $wgOut, $wgUser;
		global $ip;

		$wgOut->setPagetitle( wfMsg( "lockdb" ) );
		$wgOut->setSubtitle( wfMsg( "lockdbsuccesssub" ) );
		$text = str_replace( "$1", $ip, wfMsg( "lockdbsuccesstext" ) );
		$wgOut->addWikiText( $text );
	}
}

?>
