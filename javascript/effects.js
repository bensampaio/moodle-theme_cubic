var PAGE = '#page';
var BAR = '#user-bar';

var ICONS_VIEW = 'icons';
var LIST_VIEW = 'list';

var REQUEST_TIMEOUT = 15000;
var COUNTER_TIMEOUT = 10000;

var currentSelector = null;
var currentMenu = null;
var currentCount = new Array();
var currentCourseView = DEFAULT_VIEW_MODE;

String.prototype.lcfirst = function() {
    return this.charAt(0).toLowerCase() + this.slice(1);
}

/* Menu Functions
-----------------------*/
function clickSelector(selector, side, position) {
	var menu = $('#' + selector.attr('id') + '_menu');
	var isSame = false;
	
	if($(currentSelector).length > 0 && $(currentMenu).length > 0) {
		isSame = (currentSelector[0] === selector[0]);
		hideMenu(currentSelector, currentMenu);
	}
	
	if(!isSame) {
		if(menu.length > 0) {
			if(selector.hasClass('selected')) {
				hideMenu(selector, menu);
			}
			else {
				showMenu(selector, menu, side, position);
			}
		}
		else {
			alert('The menu is missing.');
		}
	}
}

function showMenu(selector, menu, side, position) {
	var id = selector.attr('id');
	selector.addClass('selected');
	menu.css(side, position);
	
	menu.fadeToggle(300, function() {
		if(id == 'notifications' || id == 'events' || id == 'messages') {
			var mainContainer = menu.find('.container');
			var container = menu.find('.mCSB_container');
			var loader = menu.find('.ajax');
			
			if(container.length == 0) {
				var container = mainContainer;
			}
			
			var refresh = true;
			if(id in currentCount) {
				refresh = currentCount[id] || container.is(':empty');
			}
			
			if(refresh) {
				mainContainer.css('height', '');
				loader.show();
				container.hide();
				
				$.ajax({
					type: 'GET',
					url: SERVER+'/theme/'+THEME.lcfirst()+'/ajax.php',
					data: {action: id},
					dataType: 'html',
					timeout: REQUEST_TIMEOUT,
					error: function(jqXHR, textStatus, errorThrown) {
						container.html(jqXHR + ' ' + textStatus + ' ' + errorThrown);
					},
					success: function(output) {
						container.html(output);
						container.find('.userpicture').unwrap();

						container.children('div').click(function(event) {
							var link = $(this).children('a');
							window.location = $(link).attr('href');
						});

						container.find('.picture, .content').click(function(event) {
							var parent = $(this).parent();
							$(parent).click();
						});
						
						currentCount[id] = false;
					},
					complete: function(jqXHR, textStatus) {
						loader.hide();
						container.show();
						updateScroll(menu);
					}
				});
			}
		}
		else {
			updateScroll(menu);
		}
	});
	
	currentSelector = selector;
	currentMenu = menu;
}

function hideMenu(selector, menu) {
	selector.removeClass('selected');
	menu.hide();
	
	currentSelector = null;
	currentMenu = null;
}

function updateScroll(menu) {
	var container = menu.find('.container');
	container.css('height', '');
	container.css('height', container.height());
	
	var scrollbar = menu.find('.mCSB_scrollTools');
	if(scrollbar.length > 0) {
		scrollbar.css('height', container.height()-10);
		scrollbar.css('margin-top', 5);
		scrollbar.css('margin-bottom', 5);
	}
	
	container.mCustomScrollbar('update');
	
	if(scrollbar.length > 0) {
		scrollbar.animate({opacity:1}, 'slow');
	}
}

function counter(selector) {
	setInterval(function() {
		var id = selector.attr('id');
		
		$.ajax({
			type: 'GET',
			url: SERVER+'/theme/'+THEME.lcfirst()+'/ajax.php',
			data: {action: id, count: true},
			dataType: 'html',
			timeout: REQUEST_TIMEOUT,
			success: function(output) {
				var span = selector.find('.counter');
				var oldValue = (span.length > 0)? span.text() : 0;
				var newValue = (output != '')? $(output).text() : 0;
				
				if(oldValue != newValue) {
					if(!(id in currentCount)) {
						currentCount[id] = true;
					}
					else if(!currentCount[id]) {
						currentCount[id] = true;
					}
					
					if(span.length > 0) {
						span.remove();
					}
					
					selector.prepend(output);
					counter(selector);
				}
				else {
					if(!(id in currentCount)) {
						currentCount[id] = false;
					}
				}
			}
		});
	}, COUNTER_TIMEOUT);
}

function wrapSelects() {
	$('.safari select:not(select[size])').wrap('<arrows></arrows>');
}

/* Document Events
-----------------------*/
$(document).ready(function() {
	$(window).resize();
	
	//HTML Corrections
	$(BAR + ' a .userpicture').unwrap();
	wrapSelects();
	changeCourseView(currentCourseView);
	
	//PHP Erros
	var errors = $('body > .notifytiny');
	if(errors.length > 0) {
		errors.detach();
		errors.addClass('errorbox generalbox');
		$(PAGE + ' .region-content').prepend(errors);
	}

	//Events
	$(document).click(function(event) {
		if(currentSelector != null && currentMenu != null) {
			hideMenu(currentSelector, currentMenu);
		}
	});
	
	//Counters
	counter($(BAR + ' #notifications'));
	counter($(BAR + ' #events'));
	counter($(BAR + ' #messages'));
	
	//Scrollbar
	$(BAR + ' .menu .container').mCustomScrollbar({
		scrollEasing:"easeOutCirc",
		advanced:{
			updateOnBrowserResize:true,
			updateOnContentResize:true
		}
	});
});

$(document).click(function(event) {
	if(currentSelector != null) {
		if(currentSelector.length > 0) {
			clickSelector(currentSelector, 0, 0);
		}
	}
});

/* Window Events
-----------------------*/
$(window).resize(function() {
	var windowHeight = $(window).height();
	var barHeight = $(BAR).outerHeight();
	
	$(PAGE).height(windowHeight-barHeight);
	
	if($('body').hasClass('pagelayout-frametop')) {
		var pageHeader = $('#page-header');
		if(pageHeader.length > 0) {
			$('#page-content-wrapper').height($(PAGE).height()-pageHeader.outerHeight());
		}
	}
});

/* Menu Events
-----------------------*/
$("#site-links li").click(function(event) {
	clickSelector($(this), 'left', $(this).offset().left);
});

$("#user-links li").click(function(event) {
	clickSelector($(this), 'right', $(window).width()-($(this).offset().left + $(this).outerWidth()));
});

$("#site-links li, #user-links li, #menus div").click(function(event){
    event.stopPropagation();
});

/* Languages Menu Events
-----------------------*/
$("#languages").click(function(event) {
	var menu = $('#' + $(this).attr('id') + '_menu');
	
	if(!menu.find('.language').length) {
		var langs = $(".langmenu select option");

		if(langs.length > 0) {
			var container = menu.find('.mCSB_container');
			
			if(container.length == 0) {
				container = menu.find('.container');
			}

			langs.each(function (i) {
				var language = $(this);
				var code = language.attr('value');
				container.append(
					'<div id="'+code+'" class="language">'+
						language.text()+
						'<div class="flag '+code+'"></div>'+
					'</div>'
				);

				container.find('#'+language.attr('value')).click(event, function() {
					$(".langmenu select option:selected").removeAttr('selected');
					language.attr('selected', 'selected');
					$('.langmenu form').submit();
				});
			});
		}
	}
});

/* Course Events
-----------------------*/
$('#page-course-view-topics .navbar .activities-views .'+ICONS_VIEW).click(function(event) {
	changeCourseView(ICONS_VIEW);
});

$('#page-course-view-topics .navbar .activities-views .'+LIST_VIEW).click(function(event) {
	changeCourseView(LIST_VIEW);
});

function changeCourseView(view) {
	$('.course-content .section, .course .section').removeClass(currentCourseView);
	$('.course-content .section, .course .section').addClass(view);
	currentCourseView = view;
}