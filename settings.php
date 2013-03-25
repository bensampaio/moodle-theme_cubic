<?php

/**
 * Settings for the cubic theme
 * @copyright 2012 Bruno Sampaio
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {
	
	// System Name
	$name = 'theme_cubic/title';
	$title = get_string('title','theme_cubic');
	$description = get_string('title_desc', 'theme_cubic');
	$default = get_string('pluginname', 'theme_cubic');
	$settings->add(new admin_setting_configtext($name, $title, $description, $default, PARAM_CLEAN));

	// Bar Logo file setting
	$name = 'theme_cubic/bar_logo';
	$title = get_string('bar_logo','theme_cubic');
	$description = get_string('bar_logo_desc', 'theme_cubic');
	$default = 'logo';
	$settings->add(new admin_setting_configtext($name, $title, $description, $default, PARAM_URL));

	// Institutions
	$name = 'theme_cubic/show_institutions';
	$title = get_string('show_institutions','theme_cubic');
	$description = get_string('show_institutions_desc', 'theme_cubic');
	$settings->add(new admin_setting_configcheckbox($name, $title, $description, true));

	// Applications
	$name = 'theme_cubic/show_applications';
	$title = get_string('show_applications','theme_cubic');
	$description = get_string('show_applications_desc', 'theme_cubic');
	$settings->add(new admin_setting_configcheckbox($name, $title, $description, true));

	// Course Default View
	$name = 'theme_cubic/activity_view';
	$title = get_string('activity_view','theme_cubic');
	$description = get_string('activity_view_desc', 'theme_cubic');
	$default = 'Icons';
	$choices = array('icons' => get_string('activity_icons_view','theme_cubic'), 'list' => get_string('activity_list_view','theme_cubic'));
	$settings->add(new admin_setting_configselect($name, $title, $description, $default, $choices));

	// Bar color setting
	$name = 'theme_cubic/bar_color';
	$title = get_string('bar_color','theme_cubic');
	$description = get_string('bar_color_desc', 'theme_cubic');
	$default = '#295A34';
	$previewconfig = array('selector'=>'#user-bar', 'style'=>'background-color');
	$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

	// Bar border color setting
	$name = 'theme_cubic/bar_border_color';
	$title = get_string('bar_border_color','theme_cubic');
	$description = get_string('bar_border_color_desc', 'theme_cubic');
	$default = '#173920';
	$previewconfig = array('selector'=>'#user-bar', 'style'=>'border-bottom-color');
	$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

	// Bar text color setting
	$name = 'theme_cubic/bar_text_color';
	$title = get_string('bar_text_color','theme_cubic');
	$description = get_string('bar_text_color_desc', 'theme_cubic');
	$default = '#B0DDBA';
	$previewconfig = array('selector'=>'#user-bar', 'style'=>'color');
	$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

	// Bar hover color setting
	$name = 'theme_cubic/bar_hover_color';
	$title = get_string('bar_hover_color','theme_cubic');
	$description = get_string('bar_hover_color_desc', 'theme_cubic');
	$default = '#397548';
	$previewconfig = array('selector'=>'#user-bar > div > ul > li:hover', 'style'=>'background-color');
	$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

	// Menu all section color setting
	$name = 'theme_cubic/menu_all_color';
	$title = get_string('menu_all_color','theme_cubic');
	$description = get_string('menu_all_color_desc', 'theme_cubic');
	$default = '#E2F3E6';
	$previewconfig = array('selector'=>'#user-bar #menus .menu .all', 'style'=>'background-color');
	$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

	// Text color setting
	$name = 'theme_cubic/text_color';
	$title = get_string('text_color','theme_cubic');
	$description = get_string('text_color_desc', 'theme_cubic');
	$default = '#000000';
	$previewconfig = array('selector'=>'body', 'style'=>'color');
	$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

	// Hover color setting
	$name = 'theme_cubic/hover_color';
	$title = get_string('hover_color','theme_cubic');
	$description = get_string('hover_color_desc', 'theme_cubic');
	$default = '#F1F1F1';
	$previewconfig = array('selector'=>'', 'style'=>'');
	$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

	// Links color setting
	$name = 'theme_cubic/links_color';
	$title = get_string('links_color','theme_cubic');
	$description = get_string('links_color_desc', 'theme_cubic');
	$default = '#295A34';
	$previewconfig = array('selector'=>'a', 'style'=>'color');
	$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

	// Borders color setting
	$name = 'theme_cubic/borders_color';
	$title = get_string('borders_color','theme_cubic');
	$description = get_string('borders_color_desc', 'theme_cubic');
	$default = '#DDD';
	$previewconfig = array('selector'=>'', 'style'=>'');
	$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

	// Buttons top color setting
	$name = 'theme_cubic/button_top_color';
	$title = get_string('button_top_color','theme_cubic');
	$description = get_string('button_top_color_desc', 'theme_cubic');
	$default = '#5ECC76';
	$previewconfig = array('selector'=>'', 'style'=>'');
	$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

	// Buttons bottom color setting
	$name = 'theme_cubic/button_bottom_color';
	$title = get_string('button_bottom_color','theme_cubic');
	$description = get_string('button_bottom_color_desc', 'theme_cubic');
	$default = '#3B804A';
	$previewconfig = array('selector'=>'', 'style'=>'');
	$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

	// Buttons border color setting
	$name = 'theme_cubic/button_border_color';
	$title = get_string('button_border_color','theme_cubic');
	$description = get_string('button_border_color_desc', 'theme_cubic');
	$default = '#2A6639';
	$previewconfig = array('selector'=>'', 'style'=>'');
	$settings->add(new admin_setting_configcolourpicker($name, $title, $description, $default, $previewconfig));

	// Custom CSS file
	$name = 'theme_cubic/custom_css';
	$title = get_string('custom_css','theme_cubic');
	$description = get_string('custom_css_desc', 'theme_cubic');
	$settings->add(new admin_setting_configtextarea($name, $title, $description, ''));
}