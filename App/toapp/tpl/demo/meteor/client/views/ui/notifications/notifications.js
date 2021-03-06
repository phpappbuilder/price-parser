/**
 * Created by dinos on 10/07/15.
 */

/** Rendered Initialisation */
Template.notifications.onRendered(function () {
	var tpl = this;
	// tpl.$(".fooJqueryPlugin").initialise()
	$.Pages.initSelectFxPlugin();
	
	$('.btn-notification-style').click(function(e) {
		$('.btn-notification-style').removeClass('active');
		$(this).addClass('active');
	});

	$('.show-notification').click(function(e) {
		var button = $(this);
		var style = $('.btn-notification-style.active').text(); // Type of notification
		var message = $('.notification-message').val(); // Message to display inside the notification
		var type = $('select.notification-type').val(); // Info, Success, Error etc
		var position = $('.tab-pane.active .position.active').attr('data-placement'); // Placement of the notification

		if (style == 'Bar') {
			// Show an bar notification attached to top and bottom of the screen
			$('body').pgNotification({
				style: 'bar',
				message: message,
				position: position,
				timeout: 0,
				type: type
			}).show();
		} else if (style == 'Bouncy Flip') {
			// Show a flipping notification animated
			// using CSS3 transforms and animations
			$('body').pgNotification({
				style: 'flip',
				message: message,
				position: position,
				timeout: 0,
				type: type
			}).show();
		} else if (style == 'Circle Notification') {
			// Slide-in a circle notification from sides
			// You have to provide the HTML for thumbnail
			$('body').pgNotification({
				style: 'circle',
				title: 'John Doe',
				message: message,
				position: position,
				timeout: 0,
				type: type,
				thumbnail: '<img width="40" height="40" style="display: inline-block;" src="/img/profiles/avatar2x.jpg" data-src="/img/profiles/avatar.jpg" data-src-retina="/img/profiles/avatar2x.jpg" alt="">'
			}).show();
		} else if (style == 'Simple Alert') {
			// Simple notification having bootstrap's .alert class
			$('body').pgNotification({
				style: 'simple',
				message: message,
				position: position,
				timeout: 0,
				type: type
			}).show();
		} else {
			return;
		}

		e.preventDefault();
	});

	$('.position').click(function() {
		$(this).closest('.notification-positions').find('.position').removeClass('active');
		$(this).addClass('active');
	});

	$('.btn-notification-style').click(function() {
		var target = $(this).attr('data-type');
		$('a[href=#' + target + ']').tab('show');
	});

	// remove previously added notifications from the screen
	$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
		$('.pgn').remove();
	});
});

/** Template Helpers */
 /*
Template.notifications.helpers({
	// Register template helpers with arguments {{foo "John" "Doe" title="President"}}
	// foo: function (first, last, keyword) { return keyword.hash.title + firstName + " " + lastName; }
	
});
*/

/** jQuery Events */

 /*
Template.notifications.events({
	// Fires when 'accept' is clicked or focused, or a key is pressed
	// 'click .accept, focus .accept, keypress': function (event) { ... }
	
});
*/

/** Set-Up Subscriptions and Registrations */
 /*
Template.notifications.onCreated(function () {
	var tpl = this; 
	// set up subscriptions, local reactive variables, registrations
	// tpl.subscribe("notifications");
});
*/


/** De-Registrations */

 /*
Template.notifications.onDestroyed(function () {
	var tpl = this; 
	// de-registration
	
});
*/
 