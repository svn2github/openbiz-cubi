function switch_datasheet(id){
	var c = new Cookies();
	if($(jq(id)).is(':visible')==false){
		$(jq(id)).show();
		c.set(id,'show');
		$(jq(id+"_switcher")).attr('class','shrink');
	}else{
		$(jq(id)).hide();
		c.set(id,'hide');
		$(jq(id+"_switcher")).attr('class','expand');	
	}	
}

function load_default_status(id){	
	if($(jq(id))){
		var c = new Cookies();
		status = c.get(id);
		switch(status){
			default:
			case 'show':
				$(jq(id)).show();
				$(jq(id+"_switcher")).attr('class','shrink');
				break;
			case 'hide':
				$(jq(id)).hide();
				$(jq(id+"_switcher")).attr('class','expand');					
				break;
		
		}
	}
}