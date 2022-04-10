(function($) { // Avoid conflicts with other libraries
'use strict';

var elems = Array.prototype.slice.call(document.querySelectorAll('.psec-switch'));

elems.forEach(function(html) {
  var switchery = new Switchery(html, {secondaryColor: 'red'});
});

// Hover tooltips
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

$(function() {
	var settings = {
			min: 200,
			scrollSpeed: 400
		},
		toTop = $('.scroll-btn'),
		toTopHidden = true;

	$(window).scroll(function() {
		var pos = $(this).scrollTop();
		if (pos > settings.min && toTopHidden) {
			toTop.stop(true, true).fadeIn();
			toTopHidden = false;
		} else if(pos <= settings.min && !toTopHidden) {
			toTop.stop(true, true).fadeOut();
			toTopHidden = true;
		}
	});

	toTop.bind('click touchstart', function() {
		$('html, body').animate({
			scrollTop: 0
		}, settings.scrollSpeed);
	});
});

$(document).ready(function() {
	
	$(".select2").select2();

	$('#dt-basic').dataTable( {
		"responsive": true,
        "order": [[ 1, "desc" ]],
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
	
	$('#dt-basicphpconf').dataTable( {
		"responsive": true,
		"order": [],
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
	
	$('#dt-basicloghist').dataTable( {
		"responsive": true,
		"order": [[ 2, "desc" ]],
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
	
	$('#dt-basiclogs').dataTable( {
		"responsive": true,
        "order": [[ 2, "desc" ]],
		dom: 'Bfrtip',
		buttons: [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
	
	$('#dt-basicbans').dataTable( {
		"responsive": true,
        "order": [[ 1, "desc" ]],
		dom: 'Bfrtip',
		buttons: [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
	
	$('#dt-basiclivetraff').dataTable( {
		"responsive": true,
		"order": [[ 6, "desc" ]],
		dom: 'Bfrtip',
		buttons: [
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ],
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
	
	$('#dt-basic2').dataTable( {
		"responsive": true,
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
    
    $('#dt-basic3').dataTable( {
		"responsive": true,
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
	
	$('#dt-basic4').dataTable( {
		"responsive": true,
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
	
	$('#dt-basicbadwords').dataTable( {
		"responsive": true,
        "order": [[ 0, "asc" ]],
		"language": {
			"paginate": {
			  "previous": '<i class="fas fa-angle-left"></i>',
			  "next": '<i class="fas fa-angle-right"></i>'
			}
		}
	} );
	
	if (window.location.href.indexOf("dashboard.php") > -1) {
		$.get("chart_dashboard.php", function(data) {
			
			var threats_count = JSON.parse(data);
			var sqli_count = threats_count["SQLi"];
			var badbots_count = threats_count["Bad Bot"];
			var proxies_count = threats_count["Proxies"];
			var spammers_count = threats_count["Spammers"];

			var barChartData = {
				labels: [
					'January',
					'February',
					'March',
					'April',
					'May',
					'June',
					'July',
					'August',
					'September',
					'October',
					'November',
					'December'
				],
				datasets: [{
					label: 'SQLi',
					backgroundColor: '#007bff',
					stack: '1',
					data: sqli_count
				}, {
					label: 'Bad Bot',
					backgroundColor: '#dc3545',
					stack: '2',
					data: badbots_count
				}, {
					label: 'Proxies',
					backgroundColor: '#28a745',
					stack: '3',
					data: proxies_count
				}, {
					label: 'Spammers',
					backgroundColor: '#ffc107',
					stack: '4',
					data: spammers_count
				}]

			};
			
			var ctx = $("#log-stats");

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: barChartData
			});

		});
	}
	
	if (window.location.href.indexOf("visit-analytics.php") > -1) {
		$.get("chart_visitanalytics.php", function(data) {
			
			var analytics_data = JSON.parse(data);
			
			// Browser Stats
			var bcount1 = analytics_data["bcount1"];
			var bcount2 = analytics_data["bcount2"];
			var bcount3 = analytics_data["bcount3"];
			var bcount4 = analytics_data["bcount4"];
			var bcount5 = analytics_data["bcount5"];
			var bcount6 = analytics_data["bcount6"];
			var bcount7 = analytics_data["bcount7"];
			
			// OS Stats
			var ocount1 = analytics_data["ocount1"];
			var ocount2 = analytics_data["ocount2"];
			var ocount3 = analytics_data["ocount3"];
			var ocount4 = analytics_data["ocount4"];
			var ocount5 = analytics_data["ocount5"];
			var ocount6 = analytics_data["ocount6"];
			
			// Platform Stats
			var pcount1 = analytics_data["pcount1"];
			var pcount2 = analytics_data["pcount2"];
			var pcount3 = analytics_data["pcount3"];
		
			// Total and Unqiue Visits
			var dateFY        = analytics_data["dateFY"];
			var v_labels      = analytics_data["v_labels"];
			var total_visits  = analytics_data["total_visits"];
			var unique_visits = analytics_data["unique_visits"];
		
			var config = {
				type: 'pie',
				data: {
					datasets: [{
						data: [bcount1, bcount2, bcount3, bcount4, bcount5, bcount6, bcount7],
						backgroundColor: [
							'#32CD32',
							'#FFD700',
							'#FF0000',
							'#00BFFF',
							'#1E90FF',
							'#B0C4DE',
							'#000000'
						]
					}],
					labels: [
						'Google Chrome',
						'Firefox',
						'Opera',
						'Edge',
						'Internet Explorer',
						'Safari',
						'Other'
					]
				},
				options: {
					responsive: true
				}
			};
		  
			var config2 = {
				type: 'pie',
				data: {
					datasets: [{
						data: [ocount1, ocount2, ocount3, ocount4, ocount5, ocount6],
						backgroundColor: [
							'#1E90FF',
							'#FFD700',
							'#7CFC00',
							'#D3D3D3',
							'#B0C4DE',
							'#000000'
						]
					}],
					labels: [
						'Windows',
						'Linux',
						'Android',
						'iOS',
						'Mac OS X',
						'Other'
					]
				},
				options: {
					responsive: true
				}
			};
		  
			var config3 = {
				type: 'pie',
				data: {
					datasets: [{
						data: [pcount2, pcount3, pcount1],
						backgroundColor: [
							'#00BFFF',
							'#FFD700',
							'#FF0000'
						]
					}],
					labels: [
						'Mobile',
						'Tablet',
						'Computer'
					]
				},
				options: {
					responsive: true
				}
			};
		  
			var config4 = {
				type: 'line',
				data: {
					labels: v_labels,
					datasets: [{
						label: 'Total Visits',
						backgroundColor: '#1E90FF',
						borderColor: '#1E90FF',
						data: total_visits,
						fill: false
					}, {
						label: 'Unique Visits',
						fill: false,
						backgroundColor: '#3CB371',
						borderColor: '#3CB371',
						data: unique_visits
					}]
				},
				options: {
					responsive: true,
					bezierCurve: false,
					tooltips: {
						mode: 'index',
						intersect: false
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					elements: {
						line: {
							tension: 0
						}
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: dateFY
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Visits'
							}
						}]
					}
				}
			};
		  
			var ctx = document.getElementById('browser-graph').getContext('2d');
			window.browsergraph = new Chart(ctx, config);
			var ctx2 = document.getElementById('os-graph').getContext('2d');
			window.osgraph = new Chart(ctx2, config2);
			var ctx3 = document.getElementById('device-graph').getContext('2d');
			window.devicegraph = new Chart(ctx3, config3);
			var ctx4 = document.getElementById('visits-chart').getContext('2d');
			window.visitschart = new Chart(ctx4, config4);
		
		});
	}
	
});

})(jQuery);