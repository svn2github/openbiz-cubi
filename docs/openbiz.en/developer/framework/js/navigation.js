function highlight_secondary_navigation()
{
	$('#site-secondary-navigation ul li a').each(function(index)
	{
		$(this).removeClass('current');
	});
	
	var url = window.location.toString();
	if( url.match(/\/architecture\.php(.*)/) ){
		$('#site-secondary-navigation ul li a.architecture').addClass('current');
	}
	else if(url.match(/\/data\-abstract\-layer\.php(.*)/)){
		$('#site-secondary-navigation ul li a.data-abstract-layer').addClass('current');
	}
	else if(url.match(/\/metadata\-oriented\.php(.*)/)){
		$('#site-secondary-navigation ul li a.metadata-oriented').addClass('current');
	}	
	else if(url.match(/\/plugin\-service\.php(.*)/)){
		$('#site-secondary-navigation ul li a.plugin-service').addClass('current');
	}
	else if(url.match(/\/presentation\-layer\.php(.*)/)){
		$('#site-secondary-navigation ul li a.presentation-layer').addClass('current');
	}
	else if(url.match(/\/simple\-expression\.php(.*)/)){
		$('#site-secondary-navigation ul li a.simple-expression').addClass('current');
	}	
	else if(url.match(/\/quick\-start\.php(.*)/)){
		$('#site-secondary-navigation ul li a.quick-start').addClass('current');
	}
	else{
		$('#site-secondary-navigation ul li a.introduction').addClass('current');
	}
	
}