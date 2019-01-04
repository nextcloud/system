$(document).ready(function() {
	var $section = $('#system');

	$section.find('#shutdown').click(function() {
		var $button = $(this);
		$button.attr('disabled', true);
		$.ajax({
			url: OC.linkToOCS('apps/system/api/v1/', 2) + 'shutdown?format=json',
			type: 'POST',
			success: function(response) {
				$button.attr('disabled', false);
			},
			error: function(xhr) {
				$button.attr('disabled', false);
				OC.Notification.showTemporary(t('system', 'An error occurred.'));
			}
		});
	});

	$section.find('#reboot').click(function() {
		var $button = $(this);
		$button.attr('disabled', true);
		$.ajax({
			url: OC.linkToOCS('apps/system/api/v1/', 2) + 'reboot?format=json',
			type: 'POST',
			success: function(response) {
				$button.attr('disabled', false);

			},
			error: function(xhr) {
				$button.attr('disabled', false);
				OC.Notification.showTemporary(t('system', 'An error occurred.'));

			}
		});
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




$(document).ready(function() {

	var modalreboot = document.querySelector(".modalreboot");
	var triggerreboot = document.querySelector(".triggerreboot");
	var modalshutdown = document.querySelector(".modalshutdown");
	var triggershutdown = document.querySelector(".triggershutdown");
	var rebootcloseButton = document.querySelector(".rebootclose-button");
	var shutdowncloseButton = document.querySelector(".shutdownclose-button");


	function toggleModalReboot() {
    	modalreboot.classList.toggle("show-modalreboot");
	}

	function toggleModalShutdown() {
		modalshutdown.classList.toggle("show-modalshutdown");
	}

	function windowOnClick(event) {
    	if (event.target === modalreboot) {
        	toggleModalReboot();
    	}
		if (event.target === modalshutdown) {
			toggleModalShutdown();
		}

	}

	triggerreboot.addEventListener("click", toggleModalReboot);
	triggershutdown.addEventListener("click", toggleModalShutdown);

	rebootcloseButton.addEventListener("click", toggleModalReboot);
	shutdowncloseButton.addEventListener("click", toggleModalShutdown);
	window.addEventListener("click", windowOnClick);

});
