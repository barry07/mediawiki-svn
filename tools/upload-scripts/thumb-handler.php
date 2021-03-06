<?php

# lighttpd puts the original request in REQUEST_URI, while
# sjs sets that to the 404 handler, and puts the original
# request in REDIRECT_URL.
if ( isset( $_SERVER['REDIRECT_URL'] ) ) {
	# The URL is un-encoded, so put it back how it was.
	$uri = str_replace("%2F", "/", urlencode($_SERVER['REDIRECT_URL']));
} else {
	$uri = $_SERVER['REQUEST_URI'];
}

# Is this a thumbnail?
if ( preg_match('!^(?:http://upload.wikimedia.org)?/+([\w-]*)/([\w-]*)/thumb(/archive|/temp|)/\w/\w\w/([^/]*)/' . 
	'(page(\d*)-)*(\d*)px-([^/]*)$!', $uri, $matches ) )
{
	list( $all, $site, $lang, $archOrTemp, $filename, $pagefull, $pagenum, $size, $fn2 ) = $matches;
	$params = array( 
		'f' => $filename,
		'width' => $size
	);
	if ( $pagenum ) {
		$params['page'] = $pagenum;
	}
	if ( $archOrTemp == '/archive' ) {
		$params['archived'] = 1;
	} else if ( $archOrTemp == '/temp' ) {
		$params['temp'] = 1;
	}
} elseif ( preg_match('!^(?:http://upload.wikimedia.org)?/+([\w-]*)/([\w-]*)/thumb(/archive|)/' . 
	'\w/\w\w/([^/]*\.(?:(?i)ogg|ogv|oga))/' . 
	'(mid|seek(?:=|%3D|%3d)[0-9.]+)-([^/]*)$!', $uri, $matches ) ) 
{
	# OggHandler
	list( $all, $site, $lang, $arch, $filename, $timeFull, $fn2 ) = $matches;
	$params = array( 'f' => $filename );
	if ( $timeFull != 'mid' ) {
		list( $seek, $thumbtime ) = explode( '=', urldecode( $timeFull ), 2 );
		$params['thumbtime'] = $thumbtime;
	}
	if ( $arch ) {
		$params['archived'] = 1;
	}
} elseif ( preg_match( '!^(?:http://upload.wikimedia.org)?/+([\w-]*)/([\w-]*)/thumb(/archive|)/' . 
	'\w/\w\w/([^/]*\.(?:(?i)tiff|tif))/' .
	'(lossy|lossless)-page(\d+)-(\d+)px-([^/]*)$!', $uri, $matches ) )
{
	# PagedTiffHandler
	list( $all, $site, $lang, $arch, $filename, $lossy, $pagenum, $size, $fn2 ) = $matches;
	$params = array(
		'f' => $filename,
		'lossy' => $lossy,
		'width' => $size,
		'page' => $pagenum,
	);
	if ( $arch ) {
		$params['archived'] = 1;
	}
} else {
	# No, display standard 404
	header( 'X-Debug: no regex match' );
	require_once( '404.php' );
	exit;
}

# Do some basic checks on the filename
if ( preg_match( '/[\x80-\xff]/', $uri ) ) {
	header( 'HTTP/1.0 400 Bad request' );
	header( 'Content-Type: text/html' );
	echo "<html><head><title>Bad request</title></head><body>" . 
		"The URI contained bytes with the high bit set, this is not allowed." . 
		"</body></html>";
	exit;
}
if ( strpos( $filename, '%20' ) !== false ) {
	header( 'HTTP/1.0 404 Not found' );
	header( 'Content-Type: text/html' );
	header( 'X-Debug: filename contains a space' );
	echo "<html><head><title>Not found</title></head><body>" . 
		"The URL contained spaces, we don't have any thumbnail files with spaces." . 
		"</body></html>";
	exit;
}

# Determine hostname
if ( $site == 'wikipedia' ) {
	switch ( $lang ) {
		case 'meta':
		case 'commons':
		case 'internal':
		case 'grants':
		case 'wikimania2006':
			$host = "$lang.wikimedia.org";
			break;
		case 'mediawiki':
			$host = "www.mediawiki.org";
			break;
		case 'sources':
			$host = 'wikisource.org';
			break;
		default:
			$host = "$lang.wikipedia.org";
	}
} else {
	$sitelang = str_replace( '-', '.', $lang );
	$host = "$sitelang.$site.org";
}

# Send request using CURL
$reqURL = "http://$host/w/thumb.php?";
$first = true;
foreach ( $params as $name => $value ) {
	if ( $first ) {
		$first = false;
	} else {
		$reqURL .= '&';
	}
	// Note: value is already urlencoded
	$reqURL .= "$name=$value";
}

header( "X-Wikimedia-Thumb: $reqURL" );

$ch = curl_init( $reqURL );
curl_setopt($ch, CURLOPT_PROXY, '10.2.1.21:80');

# Set an XFF header for abuse tracking
# Use $_SERVER not apache_request_headers because this runs under fastcgi
if ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
	$xff = $_SERVER['HTTP_X_FORWARDED_FOR'] . ', ' . $_SERVER['REMOTE_ADDR'];
} else {
	$xff = $_SERVER['REMOTE_ADDR'];
}

$headers = array(
	"X-Forwarded-For: " . str_replace( "\n", '', $xff ),
	"X-Original-URI: " . str_replace( "\n", '', $uri )
);

# Pass through some other headers
$passthrough = array( 
	'If-Modified-Since',
	'Referer',
	'User-Agent'
);
foreach ( $passthrough as $headerName ) {
	$serverVarName = 'HTTP_' . str_replace( '-', '_', strtoupper( $headerName ) );
	if ( !empty( $_SERVER[$serverVarName] ) ) {
		$headers[] = $headerName . ': ' . 
			str_replace( "\n", '', $_SERVER[$serverVarName] );
	}
}

curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

# Leave it long enough to generate a ulimit timeout in ordinary cases
# But short enough to avoid a local PHP timeout (55s)
curl_setopt( $ch, CURLOPT_TIMEOUT, 53 );

$text = curl_exec( $ch );

# Send it on to the client
$errno = curl_errno( $ch );
$contentType = curl_getinfo( $ch, CURLINFO_CONTENT_TYPE );
$httpCode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
if ( $errno ) {
	header( 'HTTP/1.1 500 Internal server error' );
	header( 'Cache-Control: no-cache' );
	$contentType = 'text/html';
	$error = htmlspecialchars( curl_error( $ch ) );
	$text = <<<EOT
<html>
<head><title>Thumbnail error</title></head>
<body>Error retrieving thumbnail from scaling server: $error</body>
</html>
EOT;
} elseif ( $httpCode == 304 ) {
	header( 'HTTP/1.1 304 Not modified' );
	$contentType = '';
	$text = '';
} elseif ( strval( $text ) == '' ) {
	header( 'HTTP/1.1 500 Internal server error' );
	header( 'Cache-Control: no-cache' );
	$contentType = 'text/html';
	$error = htmlspecialchars( curl_error( $ch ) );
	$text = <<<EOT
<html>
<head><title>Thumbnail error</title></head>
<body>Error retrieving thumbnail from scaling server: empty response</body>
</html>
EOT;
} elseif ( $httpCode == 404 ) {
	header( 'HTTP/1.1 404 Not found' );
	// header( 'Cache-Control: no-cache' );
	header( 'Cache-Control: s-maxage=300, must-revalidate, max-age=0' );
} elseif ( $httpCode != 200 || substr( $contentType, 0, 9 ) == 'text/html' || substr( $text, 0, 5 ) == '<html' ) {
	# Error message, suppress cache
	header( 'HTTP/1.1 500 Internal server error' );
	header( 'Cache-Control: no-cache' );
}

if ( !$contentType ) {
	header( 'Content-Type:' );
} else {
	header( "Content-Type: $contentType" );
}

print $text;

curl_close( $ch );
