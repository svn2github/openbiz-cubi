function highlight_menu(){
	$('#site-header .menu a').each(function(index)
	{
		$(this).removeClass('current');
	});
	
	var url = window.location.toString();
	if( url.match(/\/cubi(.*)/) ){
		$('#site-header .menu .cubi').addClass('current');
	}
	else if(url.match(/\/framework(.*)/)){
		$('#site-header .menu .framework').addClass('current');
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