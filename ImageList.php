<?php
/**
 *
 * Documentation: https://github.com/jamesmontalvo3/ImageList
 * Support:       https://github.com/jamesmontalvo3/ImageList
 * Source code:   https://github.com/jamesmontalvo3/ImageList
 *
 * @file ImageList.php
 * @addtogroup Extensions
 * @author James Montalvo
 * @copyright © 2016 by James Montalvo
 * @licence GNU GPL v3+
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( ! defined( 'MEDIAWIKI' ) ) {
	die( 'ImageList extension' );
}

$GLOBALS['wgExtensionCredits']['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'ImageList',
	'namemsg'        => 'ext-imagelist-name',
	'url'            => 'http://github.com/jamesmontalvo3/ImageList',
	'author'         => 'James Montalvo',
	'descriptionmsg' => 'ext-imagelist-desc',
	'version'        => '0.1.0'
);

$GLOBALS['wgMessagesDirs']['ImageList'] = __DIR__ . '/i18n';
$GLOBALS['wgExtensionMessagesFiles']['ImageListMagic'] = __DIR__ . '/Magic.php';

// Autoload for setup
$GLOBALS['wgAutoloadClasses']['ImageList\Setup'] = __DIR__ . '/includes/Setup.php';

// Autoload for each parser function
$GLOBALS['wgAutoloadClasses']['ImageList\ImageList'] = __DIR__ . '/includes/ImageList.php';

// Setup parser functions
$GLOBALS['wgHooks']['ParserFirstCallInit'][] = 'ImageList\Setup::setupParserFunctions';


$GLOBALS['wgImageListPrefixes'] = array();


// $ExtensionMeetingMinutesResourceTemplate = array(
// 	'localBasePath' => __DIR__ . '/modules',
// 	'remoteExtPath' => 'MeetingMinutes/modules',
// );

// $GLOBALS['wgResourceModules'] += array(

// 	'ext.meetingminutes.form' => $ExtensionMeetingMinutesResourceTemplate + array(
// 		'styles' => 'form/meeting-minutes.css',
// 		'scripts' => array( 'form/SF_MultipleInstanceRefire.js', 'form/meeting-minutes.js' ),
// 		// 'dependencies' => array( 'mediawiki.Uri' ),
// 	),

// 	'ext.meetingminutes.template' => $ExtensionMeetingMinutesResourceTemplate + array(
// 		'styles' => 'template/template.css',
// 	),

// );