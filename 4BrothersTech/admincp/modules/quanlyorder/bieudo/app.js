$(document).ready(function(){
	$.ajax({
		url: "http://localhost/4brotherstech/admincp/modules/quanlyorder/bieudo/getdata.php",	
		method: "GET",
		success: function(data) {
			console.log(data);
			var user = [];
			var total = [];

			for(var i in data){
				user.push("User " + data[i].user_id);
				total.push(data[i].total);
			}

			var chartdata = {
				labels: user,
				datasets: [
					{
						labels: 'User total',
						backgroundColor : 'rgba(200, 200, 200, 0.75)', 
						borderColor : 'rgba(200, 200, 200, 0.75)',
						hoverBackgroundColor : 'rgba(200, 200, 200, 1)',
						hoverBorderColor : 'rgba(200, 200, 200, 1)',
						data: total
					}
				]
			};
			var ctx = $("#mycanvas");

			var barGraph = new Chart(ctx, {
				type: 'bar',
				data: chartdata
			})
		},
		error: function(data) {
			console.log(data);
		}
	});
});