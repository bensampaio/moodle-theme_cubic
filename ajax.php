<?
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
	
	if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
		require_once('../../config.php');
		include_once('lib.php');
		$PAGE->set_context(context_system::instance());
		
	    $action = $_REQUEST['action'];
		$count = !empty($_REQUEST['count']);
		$max_records = 5;
		
	    switch($action) {
	        case 'institutions': echo cubic_get_user_institutions(); break;
	
			case 'courses': echo cubic_get_user_courses(null); break;
		
			case 'applications': echo cubic_get_user_applications(null); break;
			
			case 'activities': echo cubic_get_user_activities(null); break;
			
			case 'notifications': 
				if($count) {
					echo cubic_get_notifications_count();
				}
				else {
					echo cubic_get_user_notifications($max_records);
				}
				break;
				
			case 'events':
				if($count) {
					echo cubic_get_events_count();
				}
				else {
					echo cubic_get_user_events($max_records);
				}
				break;
				
			case 'messages':
				if($count) {
					echo cubic_get_messages_count();
				}
				else {
					echo cubic_get_user_messages($max_records);
				}
				break;
	    }
	}
}
?>