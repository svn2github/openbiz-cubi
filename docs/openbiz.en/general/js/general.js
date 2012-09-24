function highlight_menu(){
	$('#site-header .menu a').each(function(index)
	{
		$(this).removeClass('current');
	});
	
	var url = window.location.toString();
	if( url.match(/\/about\/(.*)/) ){
		$('#site-header .menu .about').addClass('current');
	}
	else if(url.match(/\/enterprise\/(.*)/)){
		$('#site-header .menu .enterprise').addClass('current');
	}
	else if(url.match(/\/developer\/(.*)/)){
		$('#site-header .menu .developer').addClass('current');
	}
	else if(url.match(/\/certification\/(.*)/)){
		$('#site-header .menu .certification').addClass('current');
	}
	else if(url.match(/\/hardware\/(.*)/)){
		$('#site-header .menu .hardware').addClass('current');
	}	
	else{
		$('#site-header .menu .homepage').addClass('current');
	}
	
	try{
		highlight_secondary_navigation();
	}catch(e){};
}

$(document).ready(function(){
	//highlight menu 
	highlight_menu();
	
	//enable input hints
	try{
	    $('input[title]').inputHints();
	}catch(e){};
	
	//enable code prettify
	try{
		prettyPrint();
	}catch(e){};
});