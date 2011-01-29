<?php 

return array(
	"mwEmbedSupport" => array( 
		'scripts' => array( 
			"mwEmbedSupport.js",
		),
		'dependencies' => array(
			// jQuery dependencies:
			'jquery.triggerQueueCallback',
			'jquery.mwEmbedUtil',
		),
		'messageFile' => 'MwEmbedSupport.i18n.php',			
	),
	'jquery.menu' => array(
		'scripts' => 'jquery.menu/jquery.menu.js',
		'styles' => 'jquery.menu/jquery.menu.css'
	),			
	"jquery.triggerQueueCallback"	=> array( 'scripts'=> "jquery/jquery.triggerQueueCallback.js" ),
	"jquery.mwEmbedUtil" => array( 'scripts' => "jquery/jquery.mwEmbedUtil.js" ),
)

?>

