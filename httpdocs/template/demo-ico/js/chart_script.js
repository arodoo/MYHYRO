/*!
 * Chart_script.js
*/
var config = {
	type: 'doughnut',
	data: {
		datasets: [{
		data: [7, 10, 13, 9, 8],
		backgroundColor: ['#F18024','#36FFAC','#069AF9','#FFC107','#28A745'],
		hoverBackgroundColor: ['#F18024','#36FFAC','#069AF9','#FFC107','#28A745'],
		borderWidth: 3,
		borderColor: '#fff',
		hoverBorderColor: '#fff',
		labels: [
			"Private/Pre Sale",
			"Public ICO",
		 	"Team & Advisor",
		  	"Marketing & General",
		  	"Bounty"
	  	]
	}],
	},
	options: {
		maintainAspectRatio : false,
		responsive: true,
		cutoutPercentage: 70,
		legend: {
			display: false,
		},
	tooltips: {
		callbacks: {
			label: function(tooltipItem, data) {
				var dataset = data.datasets[tooltipItem.datasetIndex];
				var index = tooltipItem.index;
				return dataset.labels[index] ;
			},
			afterLabel: function(tooltipItem, data) {
				var dataset = data['datasets'][0];
				var percent = Math.round((dataset['data'][tooltipItem['index']] / dataset["_meta"][0]['total']) * 100)
				return '(' + percent + '%)';
			}
		},
		displayColors: false,
		bodyFontSize: 14,
	},
		title: {
			display: false,
		},
		animation: {
			animateScale: true,
			animateRotate: true
		},
	}
};

var config2 = {
	type: 'doughnut',
	data: {
		datasets: [{
		data: [9, 5, 14, 18, 10],
		backgroundColor: ['#E45356','#36FFAC','#E1C14E','#069AF9','#865AF4'],
		hoverBackgroundColor: ['#E45356','#36FFAC','#E1C14E','#069AF9','#865AF4'],
		borderWidth: 3,
		borderColor: '#fff',
		hoverBorderColor: '#fff',
		labels: [
			"Mobile Ad Platform",
			"Operational Overhead",
		 	"Reward Program",
		  	"Platform Integration",
		  	"Promotion/Marketing"
	  	]
	}],
	},
	options: {
		maintainAspectRatio : false,
		responsive: true,
		cutoutPercentage: 70,
		legend: {
			display: false,
		},
	tooltips: {
		callbacks: {
			label: function(tooltipItem, data) {
				var dataset = data.datasets[tooltipItem.datasetIndex];
				var index = tooltipItem.index;
				return dataset.labels[index] ;
			},
			afterLabel: function(tooltipItem, data) {
				var dataset = data['datasets'][0];
				var percent = Math.round((dataset['data'][tooltipItem['index']] / dataset["_meta"][1]['total']) * 100)
				return '(' + percent + '%)';
			}
		},
		displayColors: false,
		bodyFontSize: 14,
	},
		title: {
			display: false,
		},
		animation: {
			animateScale: true,
			animateRotate: true
		},
	}
};

window.onload = function() {
	var ctx = document.getElementById('token_sale').getContext('2d');
	window.myPie = new Chart(ctx, config);
	var ctx2 = document.getElementById('token_dist').getContext('2d');
	window.myPie = new Chart(ctx2, config2);
};