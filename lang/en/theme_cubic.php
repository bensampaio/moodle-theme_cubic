<?php
/**
 * Strings for component 'theme_cubic', language 'en', branch 'MOODLE_22_STABLE'
 * @copyright 2012 Bruno Sampaio, Portugal
 */

/* Theme
------------------------*/
$string['pluginname'] = 'Cubic';
$string['region-side-post'] = 'Right';
$string['region-side-pre'] = 'Left';

$string['choosereadme'] = 
	'<div class="clearfix">
		<div class="theme_screenshot">
			<h2>Cubic</h2>
			<img src="cubic/pix/screenshot.png" />
		</div>
		<div class="theme_description">
			<h2>About</h2>
			<p>Cubic is a fluid-width, three-column theme for Moodle 2.3. Its objective is to provide users with a more user-friendly interface, which provides several forms of social awareness and some new concepts.</p>
			<h2>Tweaks</h2>
			<p>This theme is a base theme for Moodle, which introduces some new concepts and which takes advantage of some new technologies like HTML5 and CSS3.</p>
			<p>The user bar (top of the page) provides the users with several information menus. Each of these menus contain information about all the user courses, activities, notifications, events, messages, settings, and others.</p>
			<p>Furthermore, it introduces two new Moodle packages, the Institutions and the Applications. They are displayed on two different menus in the user bar, and they are used to display institutional links and user applications, respectively. Both the institutions and the applications can be accessed without leaving Moodle.</p>
			<p>Since the user bar contains a lot of usefull information, the blocks are no longer required in some contexts. For example, when embedding a page, Cubic uses all horizontal and vertical space leaving only the user bar in the top.</p>
			<p>Finally, it also provides a settings page where you can change several properties like logos, colors, system name, and others.</p>
			<h2>Credits</h2>
			<p>This theme was coded and is maintained by <a href="http://pessoa.fct.unl.pt/b.sampaio/index.php?language=en">Bruno Sampaio</a>. The decision to create this theme was made during his Master thesis, which was related with the use of new technologies on education, mainly video games. Moodle was chosen as a way to distribute educational games and since some studies pointed some problems with its user interface, it was decided to create a new theme to satisfy some of the Personal Learning Environments (PLEs) concepts.</p>
			<p>This theme wouldn\'t be so great without the help of <b>André Costa</b> which designed the Cubic logo and <b>Sónia Martins</b> which designed some of the icons used. Besides that some of the icons and scripts used are available on the internet.</p>
			<p>You can find the icons in the user bar <a href="http://www.iconfinder.com/search/15/?q=iconset%3Asuper-mono-reflection">here</a> (created by <a href="http://www.doublejdesign.co.uk/">Double-J Design</a>) and the mono chromatic icons <a href="http://www.iconfinder.com/search/?q=iconset%3Acc_mono_icon_set">here</a> (created by <a href="http://www.gentleface.com/">GentleFace</a>), both under the <a href="http://creativecommons.org/licenses/by-nc/3.0/">Creative Commons</a> license.</p>
			<p>The Javascript scripts used were the jQuery framework found <a href="http://jquery.com/">here</a>, the jQuery UI found <a href="http://jqueryui.com/">here</a> and the jQuery Custom Scrollbar found <a href="http://manos.malihu.gr/jquery-custom-content-scroller">here</a>.</p>
			<p>If you need help about anything related with this theme just send an e-mail to b.sampaio@campus.fct.unl.pt and I\'ll try to answer the faster I can.</p>
			<h2>Extras</h2>
			<p>In addition to this theme were also created two blocks. One to display the user favorite Applications. And other with a Global Chat, similar to the one provided by Google and Facebook, for example.</p>
		</div>
	</div>';

/* Menus
------------------------*/
$string['guest'] = 'Guest';
$string['nouser-info'] = 'Limited access.';

$string['menu-intitutions'] = 'Institutions';
$string['menu-courses'] = 'Courses';
$string['menu-applications'] = 'Applications';
$string['menu-activities'] = 'Activities';

$string['menu-notifications'] = 'Notifications';
$string['menu-events'] = 'Events';
$string['menu-messages'] = 'Messages';
$string['menu-languages'] = 'Languages';
$string['menu-settings'] = 'Settings';

$string['empty-institutions'] = 'You haven\'t';
$string['empty-courses'] = 'You haven\'t';
$string['empty-applications'] = 'You haven\'t';
$string['empty-activities'] = 'You haven\'t';
$string['empty-notifications'] = 'You haven\'t';
$string['empty-events'] = 'You haven\'t new';
$string['empty-messages'] = 'You haven\'t new';

$string['see-all'] = 'See All';

$string['file_error'] = 'Some files are missing you must install them first to use this component.';
$string['file_note'] = 'You can also remove this component from the user bar on theme settings page.';

/* Settings
------------------------*/
$string['configtitle'] = 'Cubic';

$string['title'] = 'Title';
$string['title_desc'] = 'Name to appear on the footer.';

$string['show_institutions'] = 'Show Institutions';
$string['show_institutions_desc'] = 'Show institutions section on user bar.';

$string['show_applications'] = 'Show Applications';
$string['show_applications_desc'] = 'Show applications section on user bar.';

$string['logo'] = 'Logo';
$string['logo_desc'] = 'URL for main logo image.';

$string['bar_logo'] = 'Bar Logo';
$string['bar_logo_desc'] = 'URL for logo image in the top bar. This URL must reference a file inside this theme pix folder without its extension (For example: if you have the file "/theme/cubic/pix/new_logo.png", the value for this field must be "new_logo").';

$string['bar_color'] = 'Bar Color';
$string['bar_color_desc'] = 'Background color for the top bar.';

$string['bar_border_color'] = 'Bar Border Color';
$string['bar_border_color_desc'] = 'Bottom border color for the top bar.';

$string['bar_text_color'] = 'Bar Text Color';
$string['bar_text_color_desc'] = 'Text color for the top bar.';

$string['bar_hover_color'] = 'Bar Hover Color';
$string['bar_hover_color_desc'] = 'Hover color for the top bar buttons.';

$string['menu_all_color'] = 'Menu Bottom Section Background Color';
$string['menu_all_color_desc'] = 'Background color for the bottom section in some menus.';

$string['text_color'] = 'Text Color';
$string['text_color_desc'] = 'Color for all headings and paragraphs.';

$string['hover_color'] = 'Hover Color';
$string['hover_color_desc'] = 'Main hover color for page elements.';

$string['links_color'] = 'Links Color';
$string['links_color_desc'] = 'Color of all links.';

$string['borders_color'] = 'Borders Color';
$string['borders_color_desc'] = 'Main borders color.';

$string['button_top_color'] = 'Buttons Top Color';
$string['button_top_color_desc'] = 'Top color of all buttons.';

$string['button_bottom_color'] = 'Buttons Bottom Color';
$string['button_bottom_color_desc'] = 'Bottom color of all buttons.';

$string['button_border_color'] = 'Buttons Border Color';
$string['button_border_color_desc'] = 'Border color of all buttons.';

$string['activity_view'] = 'Activities View';
$string['activity_view_desc'] = 'Default activities view mode on course pages.';
$string['activity_icons_view'] = 'Icons';
$string['activity_list_view'] = 'List';

$string['custom_css'] = 'Custom CSS';
$string['custom_css_desc'] = 'Set custom CSS rules here.';
