$(document).ready(function() {
	$('#shutdown').click(function() {
		var $button = $(this);
		$button.attr('disabled', true);

		OCA.System.requireRootPassword(function(rootPassword) {
			$.ajax({
				url: OC.linkToOCS('apps/system/api/v1/', 2) + 'shutdown?format=json',
				type: 'POST',
				data: {
					rootPassword: rootPassword
				},
				success: function(response) {
					$button.attr('disabled', false);
				},
				error: function(xhr) {
					$button.attr('disabled', false);
					OC.Notification.showTemporary(t('system', 'An error occurred.'));
				}
			});
		}, {}, function() {
			$button.attr('disabled', false);
			OC.Notification.showTemporary(t('system', 'An error occurred.'));
		});

	});

	$('#reboot').click(function() {
		var $button = $(this);
		$button.attr('disabled', true);

		OCA.System.requireRootPassword(function(rootPassword) {
			$.ajax({
				url: OC.linkToOCS('apps/system/api/v1/', 2) + 'reboot?format=json',
				type: 'POST',
				data: {
					rootPassword: rootPassword
				},
				success: function (response) {
					$button.attr('disabled', false);

				},
				error: function (xhr) {
					$button.attr('disabled', false);
					OC.Notification.showTemporary(t('system', 'An error occurred.'));

				}
			});
		}, {}, function() {
			$button.attr('disabled', false);
			OC.Notification.showTemporary(t('system', 'An error occurred.'));
		})
	});

});

$(document).ready(function(){
	$.ajax({
		url: OC.linkToOCS('apps/system/api/v1/', 2) + 'diskdata?format=json',
		method: "GET",
		success: function(response) {
			var diskdata = response.ocs.data;
			var x = document.querySelectorAll(".DiskChart");
			var i;
			for (i = 0; i < x.length; i++) {
				var chartdata = {
					labels: ["Used GB", "Available GB"],
					datasets : [
						{
							backgroundColor: [
				                'rgb(54, 129, 195)',
				                'rgb(220, 220, 220)',
				            ],
				            borderWidth: 0,
							data: diskdata[i]
						}
					]
				};
				var ctx = x[i];
				var barGraph = new Chart(ctx, {
					type: 'doughnut',
					data: chartdata,
					options: {
						legend: {
							display: false,
						},
						tooltips: {
							enabled: true,
						},
						cutoutPercentage: 60
					}
				});
			}
		},
		error: function(data) {
			console.log(data);
		}
	});

	var interval = 1000;  // 1000 = 1 second, 3000 = 3 seconds
	function doAjax() {
		$.ajax({
			url: OC.linkToOCS('apps/system/api/v1/', 2) + 'time?format=json',
			method: "GET",
			success: function(response) {
				var data = response.ocs.data;
				document.getElementById("servertime").innerHTML = data.servertime;
				document.getElementById("uptime").innerHTML = data.uptime;
				document.getElementById("timeservers").innerHTML = data.timeservers;
			},
			error: function(data) {
				console.log(data);
			},
			complete: function (data) {
				setTimeout(doAjax, interval);
			}
		});
	}
	setTimeout(doAjax, interval);


});

OCA.System = OCA.System || {};

/**
 *
 * @param {Function} callback
 * @param {Object} options
 * @param {Function} rejectCallback
 */
OCA.System.requireRootPassword = function(callback, options, rejectCallback) {
	options = typeof options !== 'undefined' ? options : {};
	var defaults = {
		title: t('system','Root password required'),
		text: t(
			'system',
			'This action requires you to enter your server\'s root password'
		),
		confirm: t('system', 'Confirm'),
		label: t('system','Password'),
		error: '',
	};

	var config = _.extend(defaults, options);
	var self = this;

	OC.dialogs.prompt(
		config.text,
		config.title,
		function (result, password) {
			if (result && password !== '') {
				if (_.isFunction(callback)) {
					callback(password);
				}
			} else if (_.isFunction(rejectCallback)) {
				rejectCallback()
			}
		},
		true,
		config.label,
		true
	).then(function() {
		var $dialog = $('.oc-dialog:visible');
		$dialog.find('.ui-icon').remove();
		$dialog.addClass('password-confirmation');
		if (config.error !== '') {
			var $error = $('<p></p>').addClass('msg warning').text(config.error);
		}
		$dialog.find('.oc-dialog-content').append($error);
		$dialog.find('.oc-dialog-buttonrow').addClass('aside');

		var $buttons = $dialog.find('button');
		$buttons.eq(0).hide();
		$buttons.eq(1).text(config.confirm);
	});
}