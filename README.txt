CUBIC - MOODLE THEME

RECOMMENDATIONS

I changed the name of some Moodle core icons because they didn't make much sense to me, so if you want some icons to display correctly, I recommend that you make the changes listed bellow to your Moodle installation. However, these changes are not mandatory for this theme to work correctly.
	- Replace all occurrences of "t/delete" by "t/close" in the file "lib/javascript-static.js";
	- Replace all occurrences of "t/dockclose" by "t/close" in the file "blocks/dock.js";


CONTENTS ORGANISATION

	FOLDERS:
	- javascript: contains all javascript scripts;
	- lang: contains languages files for English and Portuguese (Portugal);
	- layout: contains two layout files:
		- general.php - used for all types of pages in Moodle, with different kind of options;
		- userbar.php - used to create the user bar code (it's not used as a layout file);
	- pix: contains all the images used by this theme which are not part of Moodle;
	- pix_core: contains all the images to replace the Moodle core pictures;
	- pix_plugins: contains all the images to replace the Moodle Activities core pictures;
	- style: contains all the CSS stylesheets.
		
	FILES:
	- ajax.php: file used for all ajax requests. It can only be accessed via ajax by a client and it maps certain strings to certain functions;
	- config.php: theme configuration;
	- lib.php: defines all functions used for layout generation, by ajax requests, and for css processing;
	- settings.php: defines all the theme settings which allow the user to control the system logo, the user bar colours, the use of institutions and applications package and the default course view;
	- version.php: theme version information;


APPLICATIONS & INSTITUTIONS

The applications and institutions are two new Moodle packages which allow the users to access their favourite applications and institutional pages without leaving Moodle. 
- The institutions package allows the administrator to add new institutional pages to be listed on the institutions menu on the user bar.
- The applications package allows each user to add their applications and list them on the user bar. Additionally, there is also a package to list only the user favourite applications. These applications can be accessed via IMS LTI, not as an activity, but as tools to manage learning resources.