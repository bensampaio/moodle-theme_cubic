<?php
/**
 * Configuration for Moodle's Cubic theme.
 * @copyright 2013 Bruno Sampaio
 */


////////////////////////////////////////////////////
// Name of the theme. Most likely the name of
// the directory in which this file resides.
////////////////////////////////////////////////////

$THEME->name = 'cubic';


/////////////////////////////////////////////////////
// Which existing theme(s) in the /theme/ directory
// do you want this theme to extend. A theme can
// extend any number of themes. Rather than
// creating an entirely new theme and copying all
// of the CSS, you can simply create a new theme,
// extend the theme you like and just add the
// changes you want to your theme.
////////////////////////////////////////////////////

$THEME->parents = array();


////////////////////////////////////////////////////
// Name of the stylesheet(s) you've including in
// this theme's /styles/ directory.
////////////////////////////////////////////////////

$THEME->sheets = array(
	'pagelayout',	/** Must come first: Page layout **/
	'core',			/** Must come second: General styles **/
	'activities',
	'admin',
	'bar',
	'blocks',
	'calendar',
	'courses',
	'custom',
	'dock',
	'files',
	'grade',
	'message',
	'question',
	'scrollbar',
	'tabs',
	'user',
	'extras'
);


////////////////////////////////////////////////////
// An array of stylesheets to include within the
// body of the editor.
////////////////////////////////////////////////////

$THEME->editor_sheets = array('editor');


////////////////////////////////////////////////////
// An array of stylesheets not to inherit from the
// themes parents
////////////////////////////////////////////////////

// $THEME->parents_exclude_sheets


////////////////////////////////////////////////////
// An array of plugin sheets to ignore and not
// include.
////////////////////////////////////////////////////

// $THEME->plugins_exclude_sheets


///////////////////////////////////////////////////////////////
// These are all of the possible layouts in Moodle. The
// simplest way to do this is to keep the theme and file
// variables the same for every layout. Including them
// all in this way allows some flexibility down the road
// if you want to add a different layout template to a
// specific page.
///////////////////////////////////////////////////////////////

$THEME->layouts = array(
	// Most backwards compatible layout without the blocks - this is the layout used by default
    'base' => array(
        'file' => 'general.php',
        'regions' => array(),
		'options' => array('noblocks' => true, 'langmenu'=>true)
    ),
	// Standard layout with blocks, this is recommended for most pages with general information
    'standard' => array(
        'file' => 'general.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-post',
		'options' => array('langmenu'=>true)
    ),
	// Main course page
    'course' => array(
        'file' => 'general.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-post',
		'options' => array('langmenu'=>true)
    ),
    'coursecategory' => array(
        'file' => 'general.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-post',
		'options' => array('langmenu'=>true)
    ),
	// part of course, typical for modules - default page layout if $cm specified in require_login()
    'incourse' => array(
        'file' => 'general.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-post',
		'options' => array('langmenu'=>true)
    ),
	// The site home page.
    'frontpage' => array(
        'file' => 'general.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-post',
		'options' => array('langmenu'=>true, 'nonavbar' => true)
    ),
	// Server administration scripts.
    'admin' => array(
        'file' => 'general.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
		'options' => array('langmenu'=>true)
    ),
	// My dashboard page
    'mydashboard' => array(
        'file' => 'general.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-post',
        'options' => array('langmenu'=>true),
    ),
	// My public page
    'mypublic' => array(
        'file' => 'general.php',
        'regions' => array('side-pre', 'side-post'),
        'defaultregion' => 'side-post',
		'options' => array('langmenu'=>true)
    ),
    'login' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('langmenu'=>true)
    ),
	// Pages that appear in pop-up windows - no navigation, no blocks, no header.
    'popup' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nobar' => true, 'nonavbar'=>true, 'nocustommenu'=>true, 'nologininfo'=>true, 'noblocks'=>true, 'nofooter'=>true),
    ),
	// No blocks and minimal footer - used for legacy frame layouts only!
    'frametop' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('langmenu'=>true, 'noblocks' => true, 'nofooter' => true),
    ),
	// Used during upgrade and install, and for the 'This site is undergoing maintenance' message.
    // This must not have any blocks, and it is good idea if it does not have links to
    // other places - for example there should not be a home link in the footer...
    'maintenance' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nobar' => true, 'langmenu'=>true, 'nonavbar'=>true, 'nocustommenu'=>true, 'noblocks' => true),
    ),
	// Embeded pages, like iframe/object embeded in moodleform - it needs as much space as possible
    'embedded' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('langmenu'=>true, 'nonavbar' => true, 'nocustommenu'=>true, 'noblocks' => true, 'nofooter'=>true),
    ),
    // Should display the content and basic headers only.
    'print' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nobar' => true, 'langmenu' => true, 'nonavbar' => false, 'nocustommenu' => true, 'noblocks' => true, 'nofooter' => true)
    ),
	// The pagelayout used when a redirection is occuring.
    'redirect' => array(
        'file' => 'general.php',
        'regions' => array(),
        'options' => array('nobar' => true, 'nonavbar'=>true, 'nocustommenu'=>true, 'noblocks' => true, 'nofooter'=>true),
    ),
	// The pagelayout used for reports
    'report' => array(
        'file' => 'general.php',
        'regions' => array('side-pre'),
        'defaultregion' => 'side-pre',
		'options' => array('langmenu'=>true)
    ),
);


////////////////////////////////////////////////////
// An array containing the names of JavaScript files
// located in /javascript/ to include in the theme.
// (gets included in the head)
////////////////////////////////////////////////////

$THEME->javascripts = array();


////////////////////////////////////////////////////
// As above but will be included in the page footer.
////////////////////////////////////////////////////

$THEME->javascripts_footer = array('jquery-1.7.2.min', 'jquery-ui-1.8.min', 'jquery.mCustomScrollbar', 'jquery.mousewheel.min', 'effects');


////////////////////////////////////////////////////
// An array of JavaScript files NOT to inherit from
// the themes parents
////////////////////////////////////////////////////

// $THEME->parents_exclude_javascripts


////////////////////////////////////////////////////
// Allows the user to provide the name of a function
// that all CSS should be passed to before being
// delivered.
////////////////////////////////////////////////////

$THEME->csspostprocess = 'cubic_process_css';


////////////////////////////////////////////////////
// Sets a custom render factory to use with the
// theme, used when working with custom renderers.
////////////////////////////////////////////////////

// $THEME->rendererfactory


////////////////////////////////////////////////////
// Do you want to use the new navigation dock?
////////////////////////////////////////////////////

$THEME->enable_dock = true;


////////////////////////////////////////////////////
// Overrides the left arrow image used throughout
// Moodle
////////////////////////////////////////////////////

// $THEME->larrow


////////////////////////////////////////////////////
// Overrides the right arrow image used throughout Moodle
////////////////////////////////////////////////////

// $THEME->rarrow

