<?
/**
 * Lib functions for the cubic theme.
 * @copyright 2013 Bruno Sampaio
 */


/**
 * LAYOUT FUNCTIONS
 *-------------------------------------------------------------------------------------------------*/

/**
 * Get logo base on theme settings.
 * @return string (HTML)
 */
function cubic_get_layout_conditions() {
	global $PAGE, $OUTPUT;
	
	$conditions = array();
	
	//Main Sections
	$conditions['bar'] = empty($PAGE->layout_options['nobar']);
	$conditions['lang'] = !empty($PAGE->layout_options['langmenu']);
	$conditions['navbar'] = empty($PAGE->layout_options['nonavbar']) && $PAGE->has_navbar();
	$conditions['blocks'] = empty($PAGE->layout_options['noblocks']);
	$conditions['footer'] = empty($PAGE->layout_options['nofooter']);
	
	$hassidepre = false;
	$hassidepost = false;
	
	try {
		
		//Blocks Sections
		$hassidepre = $PAGE->blocks->region_has_content('side-pre', $OUTPUT);
		$hassidepost = $PAGE->blocks->region_has_content('side-post', $OUTPUT);
		
	} 
	catch (Exception $e) {}
	
	$conditions['side-pre'] = $conditions['blocks'] && $hassidepre;
	$conditions['side-post'] = $conditions['blocks'] && $hassidepost;
	

	//Custom Menu
	$conditions['custom-menu-content'] = $OUTPUT->custom_menu();
	$conditions['custom-menu'] = empty($PAGE->layout_options['nocustommenu']) && !empty($conditions['custom-menu-content']);

	//Body Classes
	$bodyclasses = array();
	
	if ($conditions['side-pre'] && !$conditions['side-post']) {
	    $bodyclasses[] = 'side-pre-only';
	} 
	else if (!$conditions['side-pre'] && $conditions['side-post']) {
	    $bodyclasses[] = 'side-post-only';
	} 
	else if (!$conditions['side-pre'] && !$conditions['side-post']) {
	    $bodyclasses[] = 'content-only';
	}
	
	if ($conditions['custom-menu']) {
	    $bodyclasses[] = 'has-custom-menu';
	}
	
	$conditions['body-classes'] = $PAGE->bodyclasses.' '.join(' ', $bodyclasses);
	
	//Course Page
	$conditions['course-view'] = ($PAGE->course->id > 1) && ($PAGE->bodyid == 'page-course-view-topics');
	
	return $conditions;
}


/**
 * Get table or file error message.
 * @return string (HTML)
 */
function cubic_get_file_error($url) {
	return
		html_writer::start_tag('div', array('class' => 'notifytiny notifyproblem')).
			get_string('plugin-missing', 'theme_cubic')." <a href=\"$url\" >$url</a>".
		html_writer::end_tag('div').
		html_writer::start_tag('div', array('class' => 'notifytiny notifywarning')).
			get_string('plugin-note', 'theme_cubic').
		html_writer::end_tag('div');
}

/**
 * USER BAR FUNCTIONS
 *-------------------------------------------------------------------------------------------------*/

/**
 * Get logo base on theme settings.
 * @return string (HTML)
 */
function cubic_get_logo() {
	global $PAGE, $OUTPUT;
	
	if (!empty($PAGE->theme->settings->bar_logo)) {
	    $image = $OUTPUT->pix_url($PAGE->theme->settings->bar_logo, 'theme');
	} else {
	    $image = $OUTPUT->pix_url('logo', 'theme');
	}
	
	$html = '<img src="'.$image.'" alt="'.cubic_get_title().'" />';
	return $html;
}

/**
 * Get user picture.
 * @param int $size - picture size.
 * @return string (HTML)
 */
function cubic_get_user_picture($size) {
	global $PAGE, $OUTPUT, $USER;
	
	$html = '';
	if(isloggedin() && !isguestuser()) {
		$html.= $OUTPUT->user_picture($USER, array('size' => $size));
	}
	else {
		if($size > 35) {
			$html.= '<img src="'.$OUTPUT->pix_url('g/f1').'" />';
		}
		else {
			$html.= '<img src="'.$OUTPUT->pix_url('g/f2').'" />';
		}
	}
	return $html;
}

/**
 * Check if is to show institutions section on user bar.
 * @return bool
 */
function cubic_show_institutions() {
	global $PAGE;
	
	if (!empty($PAGE->theme->settings->show_institutions)) {
	    return true;
	} else {
	    return false;
	}
}

/**
 * Check if is to show applications section on user bar.
 * @return bool
 */
function cubic_show_applications() {
	global $PAGE;
	
	if (!empty($PAGE->theme->settings->show_applications)) {
	    return true;
	} else {
	    return false;
	}
}

/**
 * Get current logged user courses.
 * @return array
 */
function cubic_get_courses_list($fields=null) {
	global $CFG;
	
	include_once($CFG->dirroot . '/course/lib.php');
	return enrol_get_my_courses($fields, 'visible DESC, fullname ASC');
}

/**
 * Get current logged user events for his courses.
 * @param int $records - num of records to search for.
 * @return array
 */
function cubic_get_events_list($records, $count=false) {
	global $CFG;
	
	if(isloggedin() && !isguestuser()) {
		
		//Filter Events by Course
		include_once($CFG->dirroot .'/calendar/lib.php');
		$filtercourse = calendar_get_default_courses();
		list($coursesIds, $group, $user) = calendar_set_filters($filtercourse);

		$key = array_search(1, $coursesIds);
		unset($coursesIds[$key]);

		//Get User Preferences for Calendar
		if($count) {
			$lookahead = 7;

			//Count Events
			return count(calendar_get_upcoming($coursesIds, $group, $user, $lookahead, $records));
		}
		else {
			$defaultlookahead = CALENDAR_DEFAULT_UPCOMING_LOOKAHEAD;
	    	if (isset($CFG->calendar_lookahead)) {
	    		$defaultlookahead = intval($CFG->calendar_lookahead);
	    	}
			$lookahead = get_user_preferences('calendar_lookahead', $defaultlookahead);

			//Get Events
			return calendar_get_upcoming($coursesIds, $group, $user, $lookahead, $records);
		}
	}
	else {
		return array();
	}
}

/**
 * Get current logged user notifications for his courses.
 * @param array $coursesList - current user courses.
 * @param int $records - num of records to search for.
 * @param bool $count - determines if its returned the number or the list of notifications.
 * @param bool $recent - if true the query will search for notifications only for the current day.
 * @return string or array
 */
function cubic_get_notifications_list($coursesList, $records=0, $count=false, $recent=false) {
	global $CFG, $DB, $USER;
	
	if(isloggedin() && !isguestuser()) {
		
		//Get User Courses
		$i = 0;
		$courses = '';
		$extra = '';
		$len = count($coursesList);

		if($len > 0) {

			foreach($coursesList as $course) {
				$courses.= $course->id;

				if($i != $len - 1) {
					$courses.=', ';
				}

				$i++;
			}

			//Set Notifications Date
			if($recent) {
				$extra.= 'AND DATE(FROM_UNIXTIME({forum_posts}.modified)) = DATE(NOW()) ';
			}
			
			// Set User (if counting do not count the current user posts)
			if($count) {
				//$extra = 'AND {forum_posts}.userid != '.$USER->id;
			}

			//Set Limit
			if($records > 0) {
				$records = ' LIMIT '.$records;
			}
			else {
				$records = ';';
			}

			//Query
			$query = 
				'SELECT {forum_posts}.id as idP, {forum_posts}.discussion, {forum_posts}.subject, '.
					'{forum_posts}.message, {forum_posts}.modified, {forum_posts}.userid, '.
					'{forum_discussions}.id as idD, {forum_discussions}.forum, '.
					'{forum}.id as idF, {forum}.course, {forum}.type '.
				'FROM {forum} JOIN {forum_discussions} ON {forum}.id = {forum_discussions}.forum '.
				'JOIN {forum_posts} ON {forum_discussions}.id = {forum_posts}.discussion '.
				'WHERE {forum}.type = "news" '.$extra.' AND {forum}.course IN ('.$courses.') '.
				'ORDER BY {forum_posts}.modified DESC'.$records;
				
			$list = $DB->get_records_sql($query);

			return $count? count($list) : $list;
		}
		else {
			return $count? 0 : array();
		}
	}
	else {
		return array();
	}
}

/**
 * Count notifications for current day.
 * @return string (HTML)
 */
function cubic_get_notifications_count() {
	global $USER;
	
	$html = '';
	if(isloggedin() && !isguestuser()) {
		$notifications = cubic_get_notifications_list(cubic_get_courses_list(), 0, true, true);

		if($notifications > 0 && $notifications < 100) {
			$html = '<span class="counter">'.$notifications.'</span>';
		}
		else if($notifications >= 100) {
			$html = '<span class="counter">99</span>';
		}
	}
	
	return $html;
}

/**
 * Count events for next week.
 * @return string (HTML)
 */
function cubic_get_events_count() {
	global $USER;
	
	$html = '';
	if(isloggedin() && !isguestuser()) {
		$events = cubic_get_events_list(99, true);

		if($events > 0 && $events < 100) {
			$html = '<span class="counter">'.$events.'</span>';
		}
		else if($events >= 100) {
			$html = '<span class="counter">99</span>';
		}
	}
	return $html;
}

/**
 * Count unread messages.
 * @return string (HTML)
 */
function cubic_get_messages_count() {
	global $DB, $USER;
	
	$html = '';
	if(isloggedin() && !isguestuser()) {
		//Get Number of Unread Messages
		$messages = $DB->count_records('message', array('useridto' => $USER->id));

		if($messages > 0 && $messages < 100) {
			$html = '<span class="counter">'.$messages.'</span>';
		}
		else if($messages >= 100) {
			$html = '<span class="counter">99</span>';
		}
	}
	return $html;
}

/**
 * Get current user institutions menu.
 * @return string (HTML)
 */
function cubic_get_user_institutions() {
	global $CFG, $OUTPUT;
	
	$file = $CFG->dirroot . '/local/institutions/lib.php';
	$html = '<div class="container">';
	
	if(!@file_exists($file) ) {
		$html.= cubic_get_file_error('https://moodle.org/plugins/view.php?plugin=local_institutions').'</div>';
	}
	else {
		include_once($file);

		$title = get_string('menu-intitutions','theme_cubic');

		if(!local_institutions_table_exists()) {
			$html.= local_institutions_print_table_error();
		}
		else {
			$institutionsList = local_institutions_get_all();

			if(count($institutionsList) > 0) {
				foreach($institutionsList as $institution) {
					$html.= 
						'<div class="institution">'.
							'<a href="'.$CFG->wwwroot.'/local/institutions/view.php?id='.$institution->id.'">'.
								$institution->shortname.
								'<img src="'.$institution->logo.'" />'.
							'</a>'.
						'</div>';
				}
			}
			else {
				$html.= 
					'<div class="empty">'.
						get_string('empty-institutions','theme_cubic').
					'</div>';
			}
		}

		$html.= 
			'</div>'.
			'<a href="'.$CFG->wwwroot.'/local/institutions/" class="all">'.
				get_string('see-all','theme_cubic').' '.$title.
			'</a>';
	}
	
	return $html;
}

/**
 * Get current user courses menu.
 * @param string $title - menu title.
 * @return string (HTML)
 */
function cubic_get_user_courses() {
	global $DB, $CFG, $OUTPUT;
	
	$title = get_string('menu-courses','theme_cubic');
	
	$html = '';
	if(isloggedin() && !isguestuser()) {
		$html.= '<div class="container">';

		//Get User Courses
		$coursesList = cubic_get_courses_list('id, fullname');
		if(count($coursesList) > 0) {
			foreach($coursesList as $course) {
				$html.= 
					'<div class="course">'.
						'<a href="'.$CFG->wwwroot.'/course/view.php?id='.$course->id.'">'.
							$course->fullname.
							'<img src="'.$OUTPUT->pix_url('i/course').'" class="icon" />'.
						'</a>'.
					'</div>';
			} 
		}
		else {
			$html.= 
				'<div class="empty">'.
					get_string('empty-courses','theme_cubic').
				'</div>';
		}

		$html.= 
			'</div>'.
			'<a href="'.$CFG->wwwroot.'/course/" class="all">'.
				get_string('see-all','theme_cubic').' '.$title.
			'</a>';
	}
			
	return $html;
}

/**
 * Get current user applications menu.
 * @param string $title - menu title.
 * @return string (HTML)
 */
function cubic_get_user_applications() {
	global $CFG, $OUTPUT;
	
	$file = $CFG->dirroot . '/local/applications/lib.php';
	$html = '<div class="container">';
	
	if(!@file_exists($file) ) {
		$html.= cubic_get_file_error('https://moodle.org/plugins/view.php?plugin=local_applications').'</div>';
	}
	else {
		include_once($file);
		
		$title = get_string('menu-applications','theme_cubic');

		if(!local_applications_table_exists()) {
			$html.= local_applications_print_table_error();
		}
		else {
			$applicationsList = local_applications_get_user_apps();

			if(count($applicationsList) > 0) {
				foreach($applicationsList as $application) {
					$html.= 
						'<div class="application">'.
							'<a href="'.$CFG->wwwroot.'/local/applications/view.php?id='.$application->id.'">'.
								$application->name.
								'<img src="'.$application->icon.'" />'.
							'</a>'.
						'</div>';
				}
			}
			else {
				$html.= 
					'<div class="empty">'.
						get_string('empty-applications','theme_cubic').
					'</div>';
			}
		}

		$html.= 
			'</div>'.
			'<a href="'.$CFG->wwwroot.'/local/applications/" class="all">'.
				get_string('see-all','theme_cubic').' '.$title.
			'</a>';
	}
	return $html;
}

/**
 * Get current user activities menu.
 * @param string $title - menu title.
 * @return string (HTML)
 */
function cubic_get_user_activities() {
	global $DB, $CFG, $OUTPUT, $USER;
	
	$title = get_string('menu-activities','theme_cubic');
	
	$html = '';
	if(isloggedin() && !isguestuser()) {
		$html.= '<div class="container">';

		//Get User Courses
		$coursesList = cubic_get_courses_list('id, fullname');
		$hasActivities = false;
		foreach($coursesList as $course) {

			//Get Activities of Current Course
			$activitiesList = get_array_of_activities($course->id);

			if(count($activitiesList) > 0) {

				$html.= '<div class="division">'.$course->fullname.'</div>';

				foreach($activitiesList as $activity) {
					if($activity->mod != 'label' && $activity->mod != 'folder' && $activity->mod != 'resource'
						&& ($activity->visible or $activity->has_view())) {

						$hasActivities = true;
						$imgsrc = isset($activity->iconurl)? $activity->iconurl->out() : $OUTPUT->pix_url('icon', $activity->mod);
						$html.=
							'<div class="activity">'.
								'<a href="'.$CFG->wwwroot.'/mod/'.$activity->mod.'/view.php?id='.$activity->cm.'">'.
									$activity->name.
									'<img src="'.$imgsrc.'" class="icon" />'.
								'</a>'.
							'</div>';
					}
				}
			}
		}

		if(!$hasActivities) {
			$html.= 
				'<div class="empty">'.
					get_string('empty-activities','theme_cubic').
				'</div>';
		}

		$html.= '</div>';
	}
	return $html;
}

/**
 * Get current user notifications menu.
 * @param string $title - menu title.
 * @param int $records - num of records to search for.
 * @return string (HTML)
 */
function cubic_get_user_notifications($records=0) {
	global $DB, $CFG, $OUTPUT;
	
	$title = get_string('menu-notifications','theme_cubic');
	
	$html = '';
	if(isloggedin() && !isguestuser()) {
		
		if(!$records) {
			$html.= '<div class="title">'.$title.'</div><div class="ajax"></div><div class="container">';
		}
		else {
			$hasNotifications = false;

			//Get Notifications of Current Course
			$coursesList = cubic_get_courses_list('id, shortname');
			$notificationsList = cubic_get_notifications_list($coursesList, $records);

			foreach($notificationsList as $notification) {
				$hasNotifications = true;

				$user = $DB->get_record('user', array('id' => $notification->userid), 'id, firstname, lastname, email, picture, imagealt');

				$html.=
					'<div class="notification">'.
						'<a href="'.$CFG->wwwroot.'/mod/forum/discuss.php?d='.$notification->idd.'#p'.$notification->idp.'" />'.
						'<div class="picture">'.
							$OUTPUT->user_picture($user, array('size' => 50)).
						'</div>'.
						'<div class="content">'.
							'<p class="subject">' . $notification->subject . '</p>'.
							'<p class="body">' . $notification->message . '</p>'.
							'<p class="course">' . $coursesList[$notification->course]->shortname . '</p>'.
							'<p class="time">' . userdate($notification->modified, get_string('strftimerecent')) . '</p>'.
						'</div>'.
					'</div>';
			}

			if(!$hasNotifications) {
				$html.= 
					'<div class="empty">'.
						get_string('empty-notifications','theme_cubic').
					'</div>';
			}
		}

		if(!$records) {
			$html.= '</div>';
		}
	}
	return $html;
}

/**
 * Get current user events menu.
 * @param string $title - menu title.
 * @param int $records - num of records to search for.
 * @return string (HTML)
 */
function cubic_get_user_events($records=0) {
	global $DB, $CFG, $OUTPUT;
	
	$title = get_string('menu-events','theme_cubic');
	
	$html = '';
	if(isloggedin() && !isguestuser()) {
		
		if(!$records) {
			$html.= '<div class="title">'.$title.'</div><div class="ajax"></div><div class="container">';
		}
		else {
			$coursesList = cubic_get_courses_list();
			$eventsList = cubic_get_events_list($records);

			if(count($eventsList) > 0) {
				foreach($eventsList as $event) {
					$date = getdate($event->timestart);

					$html.= 
						'<div class="event">'.
							'<a href="'.$CFG->wwwroot.'/calendar/view.php?view=day&course='.$event->courseid.'&cal_d='.$date['mday'].'&cal_m='.$date['mon'].'&cal_y='.$date['year'].'#event_'.$event->id.'"></a>'.
							'<div class="picture">'.
								'<img src="'.$OUTPUT->pix_url('c/'.$event->eventtype).'" class="icon" />'.
								'<div class="color calendar_event_'.$event->eventtype.'"></div>'.
							'</div>'.

							'<div class="content">'.
								'<p class="name">' . $event->name . '</p>'.
								$event->description;

								if($event->eventtype == 'course') { 
									$html.= '<p class="course">' . $coursesList[$event->courseid]->shortname . '</p>';
								}

								$html.= 
								'<p class="time">'.
									userdate($event->timestart, get_string('strftimerecent')).
								'</p>'.
							'</div>'.
						'</div>';
				}
			}
			else {
				$html.=
					'<div class="empty">'.
						get_string('empty-events','theme_cubic').
					'</div>';
			}
		}

		if(!$records) {
			$html.= 
			'</div>'.
			'<a href="'.$CFG->wwwroot.'/calendar/view.php" class="all">'.
				get_string('see-all','theme_cubic').' '.$title.
			'</a>';
		}
	}
	return $html;
}

/**
 * Get current user messages menu.
 * @param string $title - menu title.
 * @param int $records - num of records to search for.
 * @return string (HTML)
 */
function cubic_get_user_messages($records=0) {
	global $DB, $CFG, $USER, $OUTPUT;
	
	$title = get_string('menu-messages','theme_cubic');
	
	$html = '';
	if(isloggedin() && !isguestuser()) {
		
		if(!$records) {
			$html.= '<div class="title">'.$title.'</div><div class="ajax"></div><div class="container">';
		}
		else {
			//Get Unread Messages
			$messagesList = $DB->get_records('message', array('useridto' => $USER->id), 'timecreated desc', 'id, useridfrom, useridto, smallmessage, timecreated', 0, $records);

			if(count($messagesList) < $records) {

				//Get Read Messages
				$readMessages = $DB->get_records('message_read', array('useridto' => $USER->id), 'timecreated desc', 'id, useridfrom, useridto, smallmessage, timecreated', 0, $records-count($messagesList));

				$messagesList = array_merge($messagesList, $readMessages);
			}

			if(count($messagesList) > 0) {
				foreach($messagesList as $message) {
					$from = $DB->get_record('user', array('id' => $message->useridfrom), 'id, firstname, lastname, email, picture, imagealt');

					$html.=
						'<div class="message">'.
							'<a href="'.$CFG->wwwroot.'/message/index.php?viewing=unread&user2='.$message->useridfrom.'" />'.
							'<div class="picture">'.
								$OUTPUT->user_picture($from, array('size' => 50)).
							'</div>'.
							'<div class="content">'.
								'<p class="sender">' . $from->firstname.' '.$from->lastname. '</p>'.
								'<p class="body">' . $message->smallmessage . '</p>'.
								'<p class="time">' . userdate($message->timecreated, get_string('strftimerecent')) . '</p>'.
							'</div>'.
						'</div>';
				}
			}
			else {
				$html.=
					'<div class="empty">'.
						get_string('empty-messages','theme_cubic').
					'</div>';
			}
		}

		if(!$records) {
			$html.= 
				'</div>'.
				'<a href="'.$CFG->wwwroot.'/message/" class="all">'.
					get_string('see-all','theme_cubic').' '.$title.
				'</a>';
		}
	}
	return $html;
}

/**
 * Get system languages menu.
 * @param string $title - menu title.
 * @return string (HTML)
 */
function cubic_get_languages() {
	global $OUTPUT;
	
	$title = get_string('menu-languages','theme_cubic');
	$html = 
		'<div class="title">'.$title.'</div>'.
		$OUTPUT->lang_menu().
		'<div class="container"></div>';
	
	return $html;
}

/**
 * Get current user information menu.
 * @return string (HTML)
 */
function cubic_get_user_info() {
	global $CFG, $USER, $OUTPUT;
	
	$html = '<table><tr><td>';
				
	if(isloggedin() && !isguestuser()) {
		$html.=
			'<a href="' . $CFG->wwwroot.'/user/view.php?id='.$USER->id . '">'.
				'<h2>' . $USER->firstname.' '.$USER->lastname . '</h2>'.
			'</a>';
			
		if(!empty($USER->email)) {
			$html.= '<p class="email">' . $USER->email . '</p>';
		}
		
		if(!empty($USER->phone2)) {
			$html.= '<p class="phone">' . $USER->phone2 . '</p>';
		}
		
		$social = '';
		if(!empty($USER->url)) {
			$social.= '<a class="website" title="Website" href="'.$USER->url.'" target="_blank"></a>';
		}
		if(!empty($USER->icq)) {
			$social.= '<span class="icq" title="'.$USER->icq.'"></span>';
		}
		if(!empty($USER->skype)) {
			$social.= '<span class="skype" title="'.$USER->skype.'"></span>';
		}
		if(!empty($USER->yahoo)) {
			$social.= '<span class="yahoo" title="'.$USER->yahoo.'"></span>';
		}
		if(!empty($USER->aim)) {
			$social.= '<span class="aim" title="'.$USER->aim.'"></span>';
		}
		if(!empty($USER->msn)) {
			$social.= '<span class="msn" title="'.$USER->msn.'"></span>';
		}
		
		$html.= '<div class="social">'.$social.'</div></td>';
	}
	else {
		$html.=
			'<h2>'.get_string('guest','theme_cubic').'</h2>'.
			'<p class="desc">'.get_string('nouser-info','theme_cubic').'</p>';
	}
	
	$html.= '</td><td>'.cubic_get_user_picture(85).'</td></tr></table>';
	
	return $html;
}

/**
 * Get current user settings menu.
 * @param string $title - menu title.
 * @return string (HTML)
 */
function cubic_get_user_settings() {
	global $CFG, $USER, $OUTPUT;
	
	$title = get_string('menu-settings','theme_cubic');
	$html = '<div class="title">'.$title.'</div>';
	if(isloggedin() && !isguestuser()) {
		$html.= 
			'<div class="container">'.
				'<div class="setting">'.
					'<a href="'.$CFG->wwwroot.'/user/edit.php?id='.$USER->id.'">'.
						'Edit Profile'.
						'<img src="'.$OUTPUT->pix_url('t/edit').'" class="icon" />'.
					'</a>'.
				'</div>'.
				'<div class="setting">'.
					'<a href="'.$CFG->wwwroot.'/login/change_password.php?id=1">'.
						'Change Password'.
						'<img src="'.$OUTPUT->pix_url('i/key').'" class="icon" />'.
					'</a>'.
				'</div>'.
				'<div class="setting">'.
					'<a href="'.$CFG->wwwroot.'/message/edit.php?id='.$USER->id.'">'.
						'Messaging'.
						'<img src="'.$OUTPUT->pix_url('t/email').'" class="icon" />'.
					'</a>'.
				'</div>'.
				'<div class="setting">'.
					'<a href="'.$CFG->wwwroot.'/login/logout.php?sesskey='.sesskey().'">'.
						'Logout'.
						'<img src="'.$OUTPUT->pix_url('a/logout').'" class="icon" />'.
					'</a>'.
				'</div>'.
			'</div>';
	}
	else {
		$html.=
			'<div class="container">'.
				'<div class="setting">'.
					'<a href="'.$CFG->wwwroot.'/login/index.php">'.
						'Login'.
						'<img src="'.$OUTPUT->pix_url('a/login').'" class="icon" />'.
					'</a>'.
				'</div>'.
				'<div class="setting">'.
					'<a href="'.$CFG->wwwroot.'/login/forgot_password.php">'.
						'Recover Password'.
						'<img src="'.$OUTPUT->pix_url('i/key').'" class="icon" />'.
					'</a>'.
				'</div>'.
			'</div>';
	}
	
	return $html;
}


/**
 * SETTINGS FUNCTIONS
 *-------------------------------------------------------------------------------------------------*/

/**
 * Get system name.
 * @return string
 */
function cubic_get_title() {
	global $PAGE;

	if (!empty($PAGE->theme->settings->title)) {
		return $PAGE->theme->settings->title;
	} else {
	    return get_string('pluginname', 'theme_cubic');
	}
}

/**
 * Get activities view mode.
 * @return string
 */
function cubic_get_activities_view() {
	global $PAGE;

	if (!empty($PAGE->theme->settings->activity_view)) {
		return $PAGE->theme->settings->activity_view;
	} else {
	    return 'icons';
	}
}

/**
 * Process CSS files based on theme settings.
 */
function cubic_process_css($css, $theme) {

	//Set Bar Color
    if (!empty($theme->settings->bar_color)) {
        $bar_color = $theme->settings->bar_color;
    } else {
        $bar_color = null;
    }
    $css = cubic_set_bar_color($css, $bar_color);

	//Set Bar Border Color
    if (!empty($theme->settings->bar_border_color)) {
        $bar_border_color = $theme->settings->bar_border_color;
    } else {
        $bar_border_color = null;
    }
    $css = cubic_set_bar_border_color($css, $bar_border_color);

	//Set Bar Text Color
    if (!empty($theme->settings->bar_text_color)) {
        $bar_text_color = $theme->settings->bar_text_color;
    } else {
        $bar_text_color = null;
    }
    $css = cubic_set_bar_text_color($css, $bar_text_color);

	//Set Bar Hover Color
    if (!empty($theme->settings->bar_hover_color)) {
        $bar_hover_color = $theme->settings->bar_hover_color;
    } else {
        $bar_hover_color = null;
    }
    $css = cubic_set_bar_hover_color($css, $bar_hover_color);

	//Set Menu Bottom Section Color
    if (!empty($theme->settings->menu_all_color)) {
        $menu_all_color = $theme->settings->menu_all_color;
    } else {
        $menu_all_color = null;
    }
    $css = cubic_set_menu_all_color($css, $menu_all_color);

	//Set Text Color
    if (!empty($theme->settings->text_color)) {
        $text_color = $theme->settings->text_color;
    } else {
        $text_color = null;
    }
    $css = cubic_set_text_color($css, $text_color);

	//Set Hover Color
    if (!empty($theme->settings->hover_color)) {
        $hover_color = $theme->settings->hover_color;
    } else {
        $hover_color = null;
    }
    $css = cubic_set_hover_color($css, $hover_color);

	//Set Links Color
    if (!empty($theme->settings->links_color)) {
        $links_color = $theme->settings->links_color;
    } else {
        $links_color = null;
    }
    $css = cubic_set_links_color($css, $links_color);

	//Set Borders Color
    if (!empty($theme->settings->borders_color)) {
        $borders_color = $theme->settings->borders_color;
    } else {
        $borders_color = null;
    }
    $css = cubic_set_borders_color($css, $borders_color);

	//Set Buttons Top Color
    if (!empty($theme->settings->button_top_color)) {
        $button_top_color = $theme->settings->button_top_color;
    } else {
        $button_top_color = null;
    }
    $css = cubic_set_button_top_color($css, $button_top_color);

	//Set Buttons Bottom Color
    if (!empty($theme->settings->button_bottom_color)) {
        $button_bottom_color = $theme->settings->button_bottom_color;
    } else {
        $button_bottom_color = null;
    }
    $css = cubic_set_button_bottom_color($css, $button_bottom_color);

	//Set Buttons Border Color
    if (!empty($theme->settings->button_border_color)) {
        $button_border_color = $theme->settings->button_border_color;
    } else {
        $button_border_color = null;
    }
    $css = cubic_set_button_border_color($css, $button_border_color);
 
    
 	//Set Custom CSS
    if (!empty($theme->settings->custom_css)) {
        $custom_css = $theme->settings->custom_css;
    } else {
        $custom_css = null;
    }
    $css = cubic_set_custom_css($css, $custom_css);
 
    return $css;
}

/**
 * Sets the bar background color variable in CSS
 *
 * @param string $css
 * @param mixed $bar_color
 * @return string
 */
function cubic_set_bar_color($css, $bar_color) {
    $tag = '[[setting:bar_color]]';
    $replacement = $bar_color;
    if (is_null($replacement)) {
        $replacement = '#295A34';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the bar border color variable in CSS
 *
 * @param string $css
 * @param mixed $bar_border_color
 * @return string
 */
function cubic_set_bar_border_color($css, $bar_border_color) {
    $tag = '[[setting:bar_border_color]]';
    $replacement = $bar_border_color;
    if (is_null($replacement)) {
        $replacement = '#173920';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the bar text color variable in CSS
 *
 * @param string $css
 * @param mixed $bar_text_color
 * @return string
 */
function cubic_set_bar_text_color($css, $bar_text_color) {
    $tag = '[[setting:bar_text_color]]';
    $replacement = $bar_text_color;
    if (is_null($replacement)) {
        $replacement = '#B0DDBA';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the bar hover color variable in CSS
 *
 * @param string $css
 * @param mixed $bar_hover_color
 * @return string
 */
function cubic_set_bar_hover_color($css, $bar_hover_color) {
    $tag = '[[setting:bar_hover_color]]';
    $replacement = $bar_hover_color;
    if (is_null($replacement)) {
        $replacement = '#397548';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the menu bottom section color variable in CSS
 *
 * @param string $css
 * @param mixed $menu_all_color
 * @return string
 */
function cubic_set_menu_all_color($css, $menu_all_color) {
    $tag = '[[setting:menu_all_color]]';
    $replacement = $menu_all_color;
    if (is_null($replacement)) {
        $replacement = '#E2F3E6';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the text color variable in CSS
 *
 * @param string $css
 * @param mixed $text_color
 * @return string
 */
function cubic_set_text_color($css, $text_color) {
    $tag = '[[setting:text_color]]';
    $replacement = $text_color;
    if (is_null($replacement)) {
        $replacement = '#000000';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the hover color variable in CSS
 *
 * @param string $css
 * @param mixed $hover_color
 * @return string
 */
function cubic_set_hover_color($css, $hover_color) {
    $tag = '[[setting:hover_color]]';
    $replacement = $hover_color;
    if (is_null($replacement)) {
        $replacement = '#F1F1F1';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the links color variable in CSS
 *
 * @param string $css
 * @param mixed $links_color
 * @return string
 */
function cubic_set_links_color($css, $links_color) {
    $tag = '[[setting:links_color]]';
    $replacement = $links_color;
    if (is_null($replacement)) {
        $replacement = '#295A34';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the borders color variable in CSS
 *
 * @param string $css
 * @param mixed $borders_color
 * @return string
 */
function cubic_set_borders_color($css, $borders_color) {
    $tag = '[[setting:borders_color]]';
    $replacement = $borders_color;
    if (is_null($replacement)) {
        $replacement = '#DDD';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the buttons top color variable in CSS
 *
 * @param string $css
 * @param mixed $button_top_color
 * @return string
 */
function cubic_set_button_top_color($css, $button_top_color) {
    $tag = '[[setting:button_top_color]]';
    $replacement = $button_top_color;
    if (is_null($replacement)) {
        $replacement = '#5ECC76';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the buttons bottom color variable in CSS
 *
 * @param string $css
 * @param mixed $button_bottom_color
 * @return string
 */
function cubic_set_button_bottom_color($css, $button_bottom_color) {
    $tag = '[[setting:button_bottom_color]]';
    $replacement = $button_bottom_color;
    if (is_null($replacement)) {
        $replacement = '#3B804A';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the buttons border color variable in CSS
 *
 * @param string $css
 * @param mixed $button_border_color
 * @return string
 */
function cubic_set_button_border_color($css, $button_border_color) {
    $tag = '[[setting:button_border_color]]';
    $replacement = $button_border_color;
    if (is_null($replacement)) {
        $replacement = '#2A6639';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}

/**
 * Sets the custom css variable in CSS
 *
 * @param string $css
 * @param mixed $custom_css
 * @return string
 */
function cubic_set_custom_css($css, $custom_css) {
    $tag = '[[setting:custom_css]]';
    $replacement = $custom_css;
    if (is_null($replacement)) {
        $replacement = '';
    }
    $css = str_replace($tag, $replacement, $css);
    return $css;
}