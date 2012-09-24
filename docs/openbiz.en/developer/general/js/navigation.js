function highlight_secondary_navigation()
{
	$('#site-secondary-navigation ul li a').each(function(index)
	{
		$(this).removeClass('current');
	});
	
	var url = window.location.toString();
	if( url.match(/\/appbuilder\.php(.*)/) ){
		$('#site-secondary-navigation ul li a.appbuilder').addClass('current');
	}
	else if(url.match(/\/cubi\.php(.*)/)){
		$('#site-secondary-navigation ul li a.cubi').addClass('current');
	}
	else if(url.match(/\/appcloud\.php(.*)/)){
		$('#site-secondary-navigation ul li a.appcloud').addClass('current');
	}
	else if(url.match(/\/framework\.php(.*)/)){
		$('#site-secondary-navigation ul li a.framework').addClass('current');
	}	
	else{
		$('#site-secondary-navigation ul li a.developer').addClass('current');
	}
	
}