function switch_datasheet(id){
	var c = new Cookies();
	if($(id).style.display=='none'){
		$(id).show();
		c.set(id,'show');
		$(id+"_switcher").className='shrink';
	}else{
		$(id).hide();
		c.set(id,'hide');
		$(id+"_switcher").className='expand';		
	}	
}

function load_default_status(id){	
	if($(id)){
		var c = new Cookies();
		status = c.get(id);
		switch(status){
			default:
			case 'show':
				$(id).show();
				$(id+"_switcher").className='shrink';
				break;
			case 'hide':
				$(id).hide();
				$(id+"_switcher").className='expand';					
				break;
		
		}
	}
}