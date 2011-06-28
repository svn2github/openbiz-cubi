//I init the variables
var parentNode = null;
var parentName = null;
var classNameActive = '';
var classNameInactive = '';
var obj_styles = null;

function tabs( name )
{
   tabs.prototype.jbForm = jbForm;
   this.jbForm(name);
}
//set inheritance
tabs.inheritsFrom( jbForm );

/***
 * Set a javascript var in a PHP session
 * @params:
 * 		name  as String
 * 		value as String
 * @return:
 ***/
tabs.prototype.saveInSession = function (json_array){
	var parametros=new Array();

	parametros[0]='SessionContext';
	parametros[1]='SaveJSONArray';
	parametros[2]=json_array;

	XmlHttpRPC(bizsrvr,null,'RPCInvoke', parametros,null);
}

/***
 * Change the class name for each tab
 * @params:
 * 		tab as html object (ul)
 * @return:
 ***/
tabs.prototype.ChangeClassName = function (tab){
	var childNodes = parentNode.childNodes;
	
	for( var i = 0 ; i < childNodes.length ; i++ ){
		if( ! Object.isUndefined( childNodes[i].className ) ){			
			if( childNodes[i] == tab ){				
				childNodes[i].className = classNameActive;
			}else{				
				childNodes[i].className = classNameInactive;
			}
		}else{			
			//If className isn't defined, I don't set it.
		}
	}

	obj_styles['CURRENT_TAB_'+parentName]=tab.getAttribute('name');
}

/***
 * Hide or show a form
 * @params:
 * 		forms as String bidimensional array.
 * @return:
 ***/
tabs.prototype.HideShowForms = function (forms){
	for(var i=0;i<forms.length;i++){
		form=$(forms[i][0]+'_container');

		if(forms[i][1].toUpperCase() == 'NO'){
			form.hide();
		}else{
			form.show();
		}
		obj_styles[forms[i][0] + '_style'] = 'display: ' + form.style.display;
	}
}

/***
 * Change class name and hide or show forms when I click in a tab
 * @params:
 * 		tab 	as HTML Object (ul)
 * 		forms   as String bidimensional array
 * @return:
 ***/
function ChangeTab(tab, forms){
	parentNode = tab.parentNode;

	parentName = parentNode.getAttribute('name');

	if((parentName != null)&&(parentName.strip().empty() == false)){
		classNameActive = eval( parentName + '_active' );
		classNameInactive = eval( parentName + '_inactive' );
		
		if (tab.className == classNameInactive){
			obj_styles = new Object();
			tabs.prototype.ChangeClassName( tab );
			tabs.prototype.HideShowForms( forms );

			tabs.prototype.saveInSession( $H(obj_styles).toJSON() );

			delete obj_styles;
		}else{
			//I don't make actions if the tab clicked is the current tab
		}
	}else{
		alert("The html tabs haven't the 'name' attribute");
	}
}
