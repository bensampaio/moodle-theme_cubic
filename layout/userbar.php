<div id="user-bar">
	
	<!-- GENERAL LINKS -->
	<div id="site-links">
		<ul>
			<?php if(cubic_show_institutions()) { ?>
			<li id="institutions">
				<?php echo get_string('menu-intitutions','theme_cubic'); ?>
				<div class="icon"></div>
			</li>
			<?php } ?>
			
			<?php if(isloggedin() && !isguestuser()) { ?>
			<li id="courses">
				<?php echo get_string('menu-courses','theme_cubic'); ?>
				<div class="icon"></div>
			</li>
			
			<?php if(cubic_show_applications()) { ?>
			<li id="applications">
				<?php echo get_string('menu-applications','theme_cubic'); ?>
				<div class="icon"></div>
			</li>
			<?php } ?>
			
			<li id="activities">
				<?php echo get_string('menu-activities','theme_cubic'); ?>
				<div class="icon"></div>
			</li>
			<?php } ?>
		</ul>
	</div>
	
	<!-- LOGO IMAGE -->
	<a id="logo" href="<?php echo $CFG->wwwroot; ?>">
		<?php echo cubic_get_logo(); ?>
	</a>
	
	<!-- USER LINKS -->
	<div id="user-links">
		<ul>
			<?php if(isloggedin() && !isguestuser()) { ?>
			<li id="notifications">
				<?php echo cubic_get_notifications_count(); ?>
				<div class="icon"></div>
			</li>
			
			<li id="events">
				<?php echo cubic_get_events_count(); ?>
				<div class="icon"></div>
			</li>
			
			<li id="messages">
				<?php echo cubic_get_messages_count(); ?>
				<div class="icon"></div>
			</li>
			<?php } ?>
			
			<?php if($conditions['lang']) { ?>
			<li id="languages">
				<div class="flag <?php echo current_language(); ?>"></div>
			</li>
			<?php } ?>
			
			<li id="info">
				<?php echo cubic_get_user_picture(20); ?>
			</li>
			
			<li id="settings">
				<div class="icon"></div>
			</li>
		</ul>
	</div>
	
	<!-- BAR MENUS -->
	<div id="menus">
		<!-- LEFT MENUS -->
		<?php if(cubic_show_institutions()) { ?>
		<div id="institutions_menu" class="menu">
			<?php echo cubic_get_user_institutions(); ?>
		</div>
		<?php } ?>
		
		<?php if(isloggedin() && !isguestuser()) { ?>
		<div id="courses_menu" class="menu">
			<?php echo cubic_get_user_courses(); ?>
		</div>
		
		<?php if(cubic_show_applications()) { ?>
		<div id="applications_menu" class="menu">
			<?php echo cubic_get_user_applications(); ?>
		</div>
		<?php } ?>
		
		<div id="activities_menu" class="menu">
			<?php echo cubic_get_user_activities(); ?>
		</div>
	
		<!-- RIGTH MENUS -->
		<div id="notifications_menu" class="menu">
			<?php echo cubic_get_user_notifications(); ?>
		</div>
		
		<div id="events_menu" class="menu">
			<?php echo cubic_get_user_events(); ?>
		</div>
		
		<div id="messages_menu" class="menu">
			<?php echo cubic_get_user_messages(); ?>
		</div>
		<?php } ?>
		
		<?php if($conditions['lang']) { ?>
		<div id="languages_menu" class="menu">
			<?php echo cubic_get_languages(); ?>
		</div>
		<?php } ?>
		
		<div id="info_menu" class="menu">
			<?php echo cubic_get_user_info(); ?>
		</div>
		
		<div id="settings_menu" class="menu">
			<?php echo cubic_get_user_settings(); ?>
		</div>
	</div>
</div>