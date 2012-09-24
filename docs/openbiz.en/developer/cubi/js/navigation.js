function highlight_secondary_navigation()
{
	$('#site-secondary-navigation ul li a').each(function(index)
	{
		$(this).removeClass('current');
	});
	
	var url = window.location.toString();
	if( url.match(/\/rich\-modules\.php(.*)/) ){
		$('#site-secondary-navigation ul li a.rich-modules').addClass('current');
	}
	else if(url.match(/\/screenshot\.php(.*)/)){
		$('#site-secondary-navigation ul li a.screenshot').addClass('current');
	}
	else if(url.match(/\/create\-your\-brand\.php(.*)/)){
		$('#site-secondary-navigation ul li a.create\-your\-brand').addClass('current');
	}
	else if(url.match(/\/testimonials\.php(.*)/)){
		$('#site-secondary-navigation ul li a.testimonials').addClass('current');
	}	
	else if(url.match(/\/quick\-start\.php(.*)/)){
		$('#site-secondary-navigation ul li a.quick-start').addClass('current');
	}
	else{
		$('#site-secondary-navigation ul li a.introduction').addClass('current');
	}
	
}