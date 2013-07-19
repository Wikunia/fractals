$(function(){
	var zoom = 100;
	var links = 0;
	var oben = 0;
	var last_x;
	var last_y;
	var cr = GET("cr");
	var ci = GET("ci");
	var Re = GET("Re");
	var Im = GET("Im");
	var format = GET("format");
	var width = GET("width");
	var height = GET("height");
	var from = decodeURIComponent(GET("from")).substr(1,6);
	var middle = decodeURIComponent(GET("middle")).substr(1,6);
	var to = decodeURIComponent(GET("to")).substr(1,6);
	
	// Functions
	function GET(name) {
		return (RegExp(name + '=' + '(.+?)(&|$)'). 
		exec(location.search)||[,undefined])[1]; 
	}
	
	if (format == "Julia") {
		$("#cr").fadeIn(300);
		$("#ci").fadeIn(300);
	}
	if (format == "Mandelbrot") {
		$("#Re").fadeIn(300);
		$("#Im").fadeIn(300);
	}
	
	$("input[name='format']").change(function() {
         if ($("input[name='format']:checked").val() == 'Julia')
		 {
			$("#Re").fadeOut(300);
			$("#Im").fadeOut(300);
			$("#cr").fadeIn(300);
			$("#ci").fadeIn(300);
		 }
		  if ($("input[name='format']:checked").val() == 'Mandelbrot')
		 {
			$("#cr").fadeOut(300);
			$("#ci").fadeOut(300);
			$("#Re").fadeIn(300);
			$("#Im").fadeIn(300);
		 }
	});
	
	$("#pic").dblclick(function(e) {
		var xn = e.pageX - $(this).offset().left;
		var yn = e.pageY - $(this).offset().top;
		var x = links+(e.pageX - $(this).offset().left)/(zoom/100);
		var y = oben+(e.pageY - $(this).offset().top)/(zoom/100);

		
		zoom = zoom*2;
		links = x-Math.round(width/2)/(zoom/100);
		oben = y-Math.round(height/2)/(zoom/100); 
		$('body').css('cursor', 'wait');
		$("#pic").attr("src","zoom.php?x="+x+"&y="+y+"&zoom="+zoom+"&Re="+Re+"&Im="+Im+"&cr="+cr+"&ci="+ci+"&from="+from+"&middle="+middle+"&to="+to+"&format="+format+"&width="+width+"&height="+height).load(function() {
			$('body').css('cursor', 'auto');
		});
		
	});
	
	$("#pic").mousedown(function(e) {
		last_x = links+(e.pageX - $(this).offset().left)/(zoom/100);
		last_y = oben+(e.pageY - $(this).offset().top)/(zoom/100);
		return false;
	});
	
	$("#pic").mouseup(function(e) {
		var new_x = links+(e.pageX - $(this).offset().left)/(zoom/100);
		var new_y = oben+(e.pageY - $(this).offset().top)/(zoom/100);
		var dif_x = new_x-last_x; 
		var dif_y = new_y-last_y; 
		//alert(dif_x+" "+dif_y);
		oben = oben-dif_y;   
		links = links-dif_x;   
		var x=links+Math.round(width/2)/(zoom/100);
		var y=oben+Math.round(height/2)/(zoom/100);
		$('body').css('cursor', 'wait');
		$("#pic").attr("src","zoom.php?x="+x+"&y="+y+"&zoom="+zoom+"&Re="+Re+"&Im="+Im+"&cr="+cr+"&ci="+ci+"&from="+from+"&middle="+middle+"&to="+to+"&format="+format+"&width="+width+"&height="+height).load(function() {
			$('body').css('cursor', 'auto');
		});
	});
});