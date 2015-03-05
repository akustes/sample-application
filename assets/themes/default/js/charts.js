$(function () {
	    var d1 = [];
	        d1.push([0, 20]);
	        d1.push([1, 16]);
	        d1.push([2, 17]);
	        d1.push([3, 25]);
	        d1.push([4, 51]);
	        d1.push([5, 57]);
	        d1.push([6, 46]);
	        d1.push([7, 36]);
	        d1.push([8, 27]);
	        d1.push([9, 36]);
	        d1.push([10, 38]);
	        d1.push([11, 41]);
	        d1.push([12, 45]);
	        d1.push([13, 48]);
	        d1.push([14, 40]);
	        d1.push([15, 36]);
	        d1.push([16, 34]);
	
	    $.plot($("#placeholder"), [ d1 ], { grid: { backgroundColor: 'white', color: '#999', borderWidth: 1, borderColor: '#DDD' }, colors: ["#6ECBE2"], series: { lines: { show: true, fill: true, fillColor: "rgba(110, 203, 226, 0.5)" } } });
});