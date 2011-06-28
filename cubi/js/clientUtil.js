 /*
   Openbiz client utility file includes
   @author rockys swen
 */

 // ****** Set the bin path. *********
 var appHome = GetAppHome();
 
//****** Set Pupup Suffix - Should match same variable in sysheader.inc *********
 var Popup_Suffix = '_popupx_';
 
 
 if (appHome == "")
   appHome = cfg_apphome;
 var bizsrvr = appHome+"bin/"+"controller.php";
  //
 // **********************************

 var RPC_DEBUG = false;

 var objectArray = new Array();
 var activeForm = null;
 var onElement = null;
 var onLoadNewView = false;
 
 /**
  * Shows an alert message; useful if you want to customize error message handling
  * @param msg
  * @return
  */
 function showErrorMessage (msg)
 {
	 if (msg != "") {
		 alert(msg);
	 } else {
		 // we do nothing; no message to show
	 }
	 return msg;
 }

 function GetAppHome()
 {
   var _url = window.location;
   var _pathname = _url.pathname;
   // url is like http://hostname/apphome/binpath/controller.php?...
   if ((pos = _pathname.indexOf("/bin/controller.php")) >= 0)
      return _pathname.substring(0,pos)+"/";
   // url is like http://hostname/apphome/binpath/abc.php?...
   if ((pos = _pathname.indexOf("/bin")) >= 0)
      return _pathname.substring(0,pos)+"/";
   // url is like http://hostname/apphome/pages/abc.html
   if ((pos = _pathname.indexOf("/pages")) >= 0)
      return _pathname.substring(0,pos)+"/";

   // TODO: how to handle url rewrite? we have to hardcode app home in case of url rewrite
   return "";
 }

 function SetOnElement(elmName)
 {
   onElement = elmName;
 }

 function NewObject(objname, classname)
 {
   //alert(objname);
   if (objectArray[objname])
      return;
   else
   {
     if (!classname) return;
     try
     {
       var newobj  = eval("new "+classname+"('"+objname+"')");
       if (newobj)
         objectArray[objname] = newobj;
     }
     catch(e) {}
   }
 }
 function GetObject(objname)
 { 
   popname = objname+Popup_Suffix;
   if (objectArray[objname])
      return objectArray[objname];
   else if (objectArray[popname])
      return objectArray[popname];
   /*else if ( objname.search(Popup_Suffix) != -1) 
   { 
	   try
	   {
		   NewObject(objname,'jbForm');
		   return objectArray[objname];
	   }
	   catch(e) {}
   } else*/
   return null;
 }

 function SetActiveForm(formname, active_form_cls, inactive_form_cls)
 {
    if (active_form_cls!=null)
      active_form_class = active_form_cls
    else
      active_form_class = 'active_form';
    if (inactive_form_cls!=null)
      inactive_form_class = inactive_form_cls;
    else
      inactive_form_class = 'inactive_form';
    // turn off the current form
    if (activeForm != null) {
      //document.forms[activeForm].classname = inactive_form_class;
      for (i=0; i<document.forms.length; i++)
         if (document.forms[i].name == activeForm) {
            document.forms[i].className = inactive_form_class;
            break;
         }
    }
    // turn on the new form
    activeForm = formname;
    for (i=0; i<document.forms.length; i++)
      if (document.forms[i].name == activeForm) {
         document.forms[i].className = active_form_class;
         break;
      }
 }

 function GoToView(view, rule, loadPageTarget, form, mode)
 {
   URL = bizsrvr+"?view="+view;
   if (form)
      URL += "&form="+form+"&mode="+mode;
   if (rule)
      URL += "&rule="+rule;
   loadPage(URL, loadPageTarget);
 }

 function DrillDownToView(view, rule, loadPageTarget)
 {
   // need to render a fresh view.
   URL = bizsrvr+"?view="+view+"&form="+"&rule="+rule+"&hist=N";
   loadPage(URL, loadPageTarget);
 }
 
 function SetOnLoadNewView()
 {
    onLoadNewView = true;   
 }
 
 function invokeAction(objectName, actionName, params, funcType, loadPageTarget)
 {
    if (funcType == null)
      funcType = "RPC";
    var params_array = Array();
    if (params)
        params_array = params.split(",");

    // try to call client object function
    var client_obj = GetObject(objectName);
    if (client_obj)
        return CallObjectMethod(client_obj, actionName, funcType, loadPageTarget, params_array);
	else
        alert("No object is found with name "+objectName);
 }
 
 // obj_method_params as format "obj.method(param1,param2,...)"
 // service, method, params, ...
 // funcType can be
 //   'RPC'(default)
 //   'Page'(reload url),
 //   'Form'(submit form with post),
 //   'Popup'(open popup with url),
 //   'FormPopup'(open popup with form submit)
 function CallFunction(obj_method_params, funcType, loadPageTarget)
 {
   if (onLoadNewView) return;
   
   //alert (obj_method_params + "," + funcType + "," + loadPageTarget);
   if (funcType == null)
      funcType = "RPC";

   // find the first "("
   var pos0 = obj_method_params.indexOf("(");
   var obj_method = obj_method_params.substring (0,pos0);

   pos0 = obj_method.lastIndexOf(".");
   // parse object name
   var obj = "NULL";
   var attachData= null;
   if (pos0>0)
      obj = obj_method.substring(0,pos0);

   // parse method/function name
   var pos1 = obj_method_params.indexOf("(");
   if (pos1>pos0)
   {
      var method = obj_method_params.substring(pos0+1,pos1);
      var pos2 = obj_method_params.indexOf(")");
      if (pos1>pos0)
      {
         // get parameters
         var params = obj_method_params.substring(pos1+1,pos2);
         var params_array = Array();
         if (params)
            params_array = params.split(",");
         var paramArray = new Array(2+params_array.length);
         paramArray[0] = obj;
         paramArray[1] = method;
         for(i=0;i<params_array.length;i++)  paramArray[2+i] = params_array[i];

         // try to call client object function
         var client_obj = GetObject(obj);
         if (client_obj)
            return CallObjectMethod(client_obj, method, funcType, loadPageTarget, params_array);

         if (funcType=="RPC") {
            XmlHttpRPC(bizsrvr, CallbackFunction, "RPCInvoke", paramArray, null);
            document.body.style.cursor = "default";
            return;
         }
         if (funcType=="Modal") {
             XmlHttpRPC(bizsrvr, CallbackFunction, "RPCInvoke", paramArray, null);
             document.body.style.cursor = "default";
             return;
          }                  
         if (funcType=="Window") {
             XmlHttpRPC(bizsrvr, CallbackFunction, "RPCInvoke", paramArray, null);
             document.body.style.cursor = "default";
             return;
          }   
         
         URL = composeURL(bizsrvr, "Invoke", paramArray, null, funcType, loadPageTarget);
         if (funcType=="Page")
            loadPage(URL, loadPageTarget);
         else if (funcType=="Popup")
            loadPopup(URL, "popup", 600, 500);
         else if (funcType=="Prop_Window")
            loadPopup(URL, "window", 600, 500);
         else if (funcType=="Form")
            alert("Cannot submit an unknown form.");
         else if (funcType=="FormPopup")
            alert("Cannot submit an unknown form to show a popup.");
         else
            alert("invalid function type '"+funcType+"'");
      }
    }
 }

function CallObjectMethod(client_obj, method, funcType, loadPageTarget, params_array)
{
   //Reset Parent Object
   if(client_obj.m_Name.search(Popup_Suffix) != -1) {
	   var parent_name = client_obj.m_Name;
	   parent_name = parent_name.replace(Popup_Suffix, "");
	   
       // try to call client object function
       var parent_obj = GetObject(parent_name);
       if (parent_obj)
    	 parent_obj.m_FunctionType = funcType;  
   }
	   
	   
   client_obj.m_FunctionType = funcType;      
   client_obj.m_LoadPageTarget = loadPageTarget;
   if (client_obj[method])
      client_obj[method](params_array);
   else
      client_obj.CallFunction(method,params_array);
   document.body.style.cursor = "default";
}

function dummy_callback(returval) {}

// TODO: replace with JASON return content ???
function CallbackFunction(returval)
 {
   document.body.style.cursor = "default";

   if (returval == "")
      return;
   if (returval.length > 10 && returval.indexOf("<___TARGET___>") < 0)
   {
      popupErrorText(returval, 600, 500);
      return;
   }

   var tmp = new Array(2);
   tmp[0] = ""; // store the content
   tmp[1] = 0; // store the next start position
 for (i=0;i<10;i++)
 {
   tmp = ExtractItem(returval, "<___TARGET___>", tmp[1]);
   if (!tmp) return;
   var tgtname = tmp[0];
   tmp = ExtractItem(returval, "<___CONTENT___>", tmp[1]);
   if (!tmp) return;
   var content = tmp[0];

   if (tgtname == "ERROR") {
      popupErrorText(content);
      return;
   }
   if (tgtname == "POPUP") {
      popupWindow(content,600,500);
      return;
   }
   if (tgtname == "MODAL") {
	      popupWindow(content,600,500);
	      return;
   }
   if (tgtname == "WINDOW") {
	      popupWindow(content,600,500);
	      return;
   }       
   if (tgtname == "FUNCTION") {
      eval(content);
      //alert(content);
      continue;
   }
   if (tgtname == "SCRIPT") {
      content.evalScripts();
      continue;
   }
   if (tgtname == "Prop_Window") {
      loadPopup(content, "window", 600, 500);
      return;
   }

   // try to call client object function
   var client_obj = GetObject(tgtname);
   if (client_obj)
   {
      client_obj.CallbackFunction(content);
      CallbackFunction(returval.substring(tmp[1], returval.length));
      return;
   }
   else if (window.opener)     // for popup window
   {
      if (window.opener.window.GetObject)
      {
         var client_obj = window.opener.window.GetObject(tgtname);
         if (client_obj)
         {
            client_obj.CallbackFunction(content);
            CallbackFunction(returval.substring(tmp[1], returval.length));
            //self.close();  // update parent opener form, close the popup itself
            return;
         }
      }
   }
   else 
   {
      if (window.top.window.GetObject)
      {
         var client_obj = window.top.window.GetObject(tgtname);
         if (client_obj)
         {
            client_obj.CallbackFunction(content);
            CallbackFunction(returval.substring(tmp[1], returval.length));
            //self.close();  // update parent opener form, close the popup itself
            return;
         }
      }
   }

   // if no client object, default handle the return content
   dt = $(tgtname).parentNode;
   if (dt)
      dt.innerHTML = content;
   else
      alert("Cannot find html object with name as "+tgtname);
 }
}
 /*
 var str = "TARGET:7:LCOrder;CONTENT:13:<html></html>;";
 var r = ExtractItem(str, "TARGET", 0);
 var r = ExtractItem(str, "CONTENT", r[1]);
 */
 function ExtractItem(str, startTag, start)
 {
   var endTag = startTag.substring(0,1)+"/"+startTag.substring(1,startTag.length);
   var pos0 = str.indexOf(startTag, start);
   if (pos0>=0)
   {
      pos0 += startTag.length;
      var pos1 = str.indexOf(endTag, start);
      if (pos1>pos0)
      {
         var tmparray = Array(2);
         tmparray[0] = str.substring(pos0, pos1);
         tmparray[1] = pos1 + endTag.length;
         return tmparray;
      }
   }
   return null;
 }

function CollectData(formName)
{
   return $(formName).serialize();
}

function FlagField(field_name)
{
   var field = myform[field_name];
   field.className ='err';
}


// TODO: PROTOTYPE.js Object.extend ???
// http://wanderingken.com/2006/04/01/extending-prototype-classextend
// --------- AjaxForm ----------- //

Function.prototype.inheritsFrom = function( parentClassOrObject ){
	if ( parentClassOrObject.constructor == Function )
	{
		this.prototype = new parentClassOrObject;
		this.prototype.constructor = this;
		this.prototype.parent = parentClassOrObject.prototype;
	}
	return this;
}

function AjaxForm(name)
{
   this.m_Name = name;
   this.m_FunctionType = "RPC"
   this.m_LoadPageTarget = null;
}
//set methods
AjaxForm.prototype.GetFormControl = function (controlName)
{eval
   var myform = document.getElementById(this.m_Name);
   return myform[controlName];
}
AjaxForm.prototype.CallFunction = function (method, params_array)
{
   funcType = this.m_FunctionType;
   loadPageTarget = this.m_LoadPageTarget;

   if (window.CKEDITOR && CKEDITOR) {
       for(var i in CKEDITOR.instances) {
          CKEDITOR.instances[i].updateElement();
          CKEDITOR.remove(CKEDITOR.instances[i]);
       }
   }

   if(typeof(isRichText) != 'undefined' && window.hasRTEControls && hasRTEControls()) // check if current mode has RTE control
      updateRTEs();

   var paramArray = new Array(2+params_array.length);
   obj = this.m_Name;
   paramArray[0] = obj;
   paramArray[1] = method;
   for(i=0;i<params_array.length;i++)  paramArray[2+i] = params_array[i];

   formData = this.CollectFormData();
   
   if (funcType=="RPC" || funcType=="Modal" || funcType=="Window") {
      if (hasFileToUpload(this.m_Name)) {
         UploadFileRPC(bizsrvr, CallbackFunction, "RPCInvoke", paramArray, this.m_Name);
      }
      else {
         // TODO: move formData into XmlHttpRPC call. pass formName instead
         //formData = this.CollectFormData();
         XmlHttpRPC(bizsrvr, CallbackFunction, "RPCInvoke", paramArray, formData);
      }
      return;
   }

   // TODO: do we need formData, funcType, loadPageTarget ??? I guess not. Because formData is only used in ajax call
   URL = composeURL(bizsrvr, "Invoke", paramArray, null, funcType, loadPageTarget);
   if (funcType=="Page")
      loadPage(URL, loadPageTarget);
   else if (funcType=="Popup")
      loadPopup(URL, "popup", 600, 500);
   else if (funcType=="Prop_Window")
   {
      //URL = composeURL(bizsrvr, "Invoke", paramArray, formData, funcType, loadPageTarget);
      if (formData != null) URL = URL+"&"+formData
      loadPopup(URL, "window", 600, 500);
   }
   else if (funcType=="Prop_Dialog")
   {
      if (formData != null) URL = URL+"&"+formData
      loadPopup(URL, "dialog", 600, 500);
   }
   else if (funcType=="Form")
      submitForm(this.m_Name, URL);
   else if (funcType=="FormPopup")
      alert("not support FormPopup yet...");
   else
      alert("invalid function type '"+funcType+"'");
}
AjaxForm.prototype.CallbackFunction = function (retContent)
{
	if (this.m_FunctionType=="Modal") {
		Modalbox.show(retContent, {title: " ",  overlayOpacity: .1, width: 725, overlayDuration: .1, slideDownDuration: .01, slideUpDuration: .01});	
	} else if (this.m_FunctionType=="Window") {
		//Run WINDOW
		show_close_button=1;
		show_maximize_button=1;
		mydow_default_h=windowHeight;
		mydow_default_w=windowWidth;
		var window = new_mydow(windowTitle);	
		$(window.body).update (retContent);
		
	} else {
		try {		
			kill_mydow(windowTitle); 		
			Modalbox.hide();		
			this.Show(retContent);
		} catch (err){
			this.Show(retContent);
		}
	}
}
AjaxForm.prototype.CollectFormData = function ()
{
   if (funcType=="RPC" || funcType=="Prop_Dialog" )
      return CollectData(this.m_Name);
}
AjaxForm.prototype.Show = function (retContent)
{
   if (retContent.indexOf("UPD_FLDS")==0)
   {
      var myform = document.getElementById(this.m_Name);
      if (!myform)
      {
         alert("Cannot find the form with name "+formName);
         return;
      }
      pos0=0; pos1=0;
      while(1)
      {
         fld=""; val="";
         pos0 = retContent.indexOf("[", pos1);
         if (pos0<0) break;
         pos1 = retContent.indexOf("]", pos0);
         if (pos0>0 && pos1>pos0)
            fld = retContent.substring(pos0+1,pos1);
         pos0 = retContent.indexOf("<", pos1);
         if (pos0<0) break;
         pos1 = retContent.indexOf(">", pos0);
         if (pos0>0 && pos1>pos0)
            val = retContent.substring(pos0+1,pos1);
         form_fld = myform.elements[fld];
         if (form_fld)  form_fld.value = val;
      }
      return;
   }
   //var containerName = this.m_Name+"_container";
   //var dt = $(containerName);
   var dt = $(this.m_Name).parentNode;
   if (dt) {
      //dt.update(retContent);? // update doesn't work well in IE7
      dt.innerHTML = retContent.stripScripts();
      retContent.evalScripts.bind(retContent).defer();
      var tbody = document.getElementById(this.m_Name+"_tbody");
      if (tbody) {
         var selrow = tbody.getAttribute("SelectedRow");
         if (selrow)
            this.m_SelectedRow = selrow;
      }
      //if (window.TableKit)
      /*{
         $A(TableKit.options.resizableSelector).each(function(s){
					$$(s).each(function(t) {
						TableKit.Resizable.init(t);
					});
				});
      }*/
   }
   else
      alert("Cannot find html object with name as "+containerName);
}

// --------- jbForm ----------- //
function jbForm(name)
{
   jbForm.prototype.AjaxForm = AjaxForm;
   this.AjaxForm(name);

   //set properties
   this.m_FreshLoad = true;
   this.m_SelectedRow = 1;
   this.m_HasSubCtrls = 0;
   // TODO: add NotifyOnSelectRecord
   // TODO: add SelectedRecId
   this.m_SortColumn = null;
   this.m_ReverseSort = 0;
}
//set inheritance
jbForm.inheritsFrom(AjaxForm);
//set methods
jbForm.prototype.CollectFormData = function ()
{
   if (funcType=="RPC" || funcType=="Prop_Dialog" )
   {
      formData = CollectData(this.m_Name);
      //formData += "&__SelectedRow=" + this.m_SelectedRow;   // TODO: no need 
      formData += "&__url=" + encodeURIComponent(top.location);
      /*if (onElement) {  // get onfocus element, necessary for evenhandler's postaction
         formData += "&__this=" + onElement;
         onElement = null;
      }*/
      return formData;
   }
}
// TODO: no need on this function
jbForm.prototype.GetSelectRow = function ()
{
   /*if (this.m_FreshLoad == true) {
      var tbody = document.getElementById(this.m_Name+"_tbody");
      if (tbody) {
         var selrow = tbody.getAttribute("SelectedRow");
         if (selrow)
            this.m_SelectedRow = selrow;
         var range = tbody.getAttribute("Range");
         if (range)
            this.m_Range = range;
      }
      this.m_FreshLoad = false;
   }*/
}

jbForm.prototype.GetSelectId = function ()
{
   var curSelRecIdElem = $(this.m_Name+"_selectedId");
   if (!curSelRecIdElem) 
      return null;
   return curSelRecIdElem.getAttribute('value');
}

// TODO: selectrecord (record_id)
jbForm.prototype.SelectRecord = function (params_array)
{
   var selRecId = params_array[0];
   var curSelRecIdElem = $(this.m_Name+"_selectedId");
   if (curSelRecIdElem) 
   {
       var curSelRecId = curSelRecIdElem.getAttribute('value');
       if (selRecId == curSelRecId)
          return;

       var cur_elem_id = this.m_Name+"-"+curSelRecId;
       var sel_elem_id = this.m_Name+"-"+selRecId;
       FocusOn(sel_elem_id, cur_elem_id);
       curSelRecIdElem.setAttribute('value', selRecId);
   }
   
   // the reason that has to notify server - keep track of the active record. Is it true ???
   var hasSubform = params_array[1];  
   if(hasSubform == "0" || hasSubform == 0)
      return;
   
   this.CallFunction("SelectRecord", params_array);
}
/*
jbForm.prototype.NextRow = function (params_array)
{
   this.GetSelectRow();
   param_array = new Array(parseInt(this.m_SelectedRow) + 1, 0);
   this.SelectRecord(param_array);
}
jbForm.prototype.PrevRow = function (params_array)
{
   this.GetSelectRow();
   param_array = new Array(parseInt(this.m_SelectedRow) -1, 0);
   this.SelectRecord(param_array);
}
*/
jbForm.prototype.SortRecord = function (params_array)
{
   var sort_col = params_array[0];
   if (this.m_SortColumn == sort_col)
      this.m_ReverseSort = 1 - this.m_ReverseSort;
   else
      this.m_ReverseSort = 0;
   this.m_SortColumn = sort_col;
   params_array[0] = sort_col+","+this.m_ReverseSort;

   this.CallFunction("SortRecord", params_array);
}

jbForm.prototype.SaveRecord = function (params_array)
{
   //myform = document.getElementById(this.m_Name);
   //if (validateStandard(myform, 'err') == false)
   //   return;

   this.CallFunction("SaveRecord", params_array);
}

jbForm.prototype.DeleteRecord = function (params_array)
{
   //Dialog.confirm("test confirm",{className: "alphacube", showEffect:Effect.Appear, hideEffect: Effect.Fade});
   //Dialog.confirm("test confirm",{className: "alphacube"});
   
   if (!confirm("Are you sure you want to delete this record?"))
      return;

   this.CallFunction("DeleteRecord", params_array);
}

jbForm.prototype.Show = function (retContent)
{
   // call parent Show method
   //this.parent.Show.call(this,retContent);
   AjaxForm.prototype.Show.call(this,retContent);

   // set class as active_form. if this form is not the activeform, do nothing
   //if (this.m_Name == activeForm)
   //   SetActiveForm(this.m_Name);

   // add key event handler for each enabled visible control
}

// ---- end of jbFom

var browserType = BrowserSniff();
function BrowserSniff(){
  if (document.layers) return "NS";
  if (document.all) return "IE";
  if (document.getElementById) return "MOZ";
  return "OTHER";
}

// RPC call using XMLHTTP
// TODO: replace formData with formName
function XmlHttpRPC(rspage, callback, func, parms, formdata)
{
   var activeForm = parms[0];
   new Ajax.Request(rspage, {
      onLoading: function() {
         Element.show(activeForm+'.load_disp'); 
      },
      onComplete: function() {
         Element.hide(activeForm+'.load_disp');
      },
      onSuccess: function(transport){
         //Element.hide(activeForm+'.load_disp');
         var response = transport.responseText || "";
         if (RPC_DEBUG)
            debugWindow(response);
         callback(response);
      },
      onFailure: function(transport){
        //alert('Something went wrong...')
        alert("There was a problem with the request. Status="+transport.status+", reason="+transport.statusText+", page="+rspage);
      },
      parameters: composeURLString(func, parms, formdata)
   })
}

function UploadFileRPC(rspage, callback, func, parms, formName)
{
   URL = composeURL(bizsrvr, func, parms, null, "", "");
   formobj = document.forms[formName];
   if (!formobj) {
      alert("Cannot locate form "+formName);
      return;
   }
   activeForm = parms[0];
   formobj.method = "post";
   formobj.action = URL+"&jsrs=1";
   formobj.enctype = "multipart/form-data";
   formobj.encoding = "multipart/form-data";
   AIM.submit(formobj, {
      'onStart' : function() {
         Element.show(activeForm+'.load_disp');
         return true;
      },
      'onComplete' : function(response){
         Element.hide(activeForm+'.load_disp');
         if (RPC_DEBUG)
            debugWindow(response);
         callback(response);
      }
   });
   formobj.submit();
}

function composeURL(rsPage, func, parms, formdata, funcType, loadPageTarget)
{
   base_url = composeURLString(func, parms, formdata);
   // insert __tgt="other" if popup or targetframe
   if (funcType == "Popup" || loadPageTarget)
      base_url = "_tgt=other&"+base_url;
   return rsPage+"?"+base_url;
}

function composeURLString(func, parms, formdata)
{
  funcData = "";
  if (func != null) {
    funcData = "F=" + escape(func);
    if (parms != null){
        for( var i=0; i < parms.length; i++ ){
          funcData += "&P" + i + "=[" + escape(parms[i]+'') + "]";
        }
    } // parms
  } // func
  else
    return "";

  if (onElement) {  // get onfocus element, necessary for evenhandler's postaction
     funcData += "&__this=" + onElement;
     onElement = null;
  }

  if (formdata != null) {
      urlStr = funcData+"&"+formdata
  }
  else
      urlStr = funcData;
 
  return urlStr;
}

function loadPage(URL, targetFrame)
{
   if (!targetFrame)
   {
     window.location = URL;
   }
   else
   {
    tgtFrm = FindFrame(targetFrame);
    if (tgtFrm)
      tgtFrm.location = URL;   // traverse all frames
   }
}

// the following functions are added for popup function call
// popup type can be popup, window, dialog
function loadPopup(URL, type, w, h)
{
    w = w ? w : 600;
    h = h ? h : 500;
    LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
    TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
    
    if (type == "window")
    {
        //var win = new Window({className: "spread", title: "", width:w, height:h, url: URL, showEffectOptions: {duration:1.5}});
        var win = new Window({width:w, height:h, url: URL});
        win.setDestroyOnClose();
        win.showCenter();
    }
    else if (type == "dialog")
    {
        Dialog.info({url: URL, options: {method: 'post'}}, {className: "dialog", width:w, height:h, closable:true, resizable:true, draggable:true});
    }
    else
    {
        settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars=0,resizable=1,status=0';
        // open a window with name as form_popup and submit form to this new popup as target
        window.open (URL, "", settings);
    }
}

function closePopup()
{
    if (window.opener)
        window.close();
    
    _win = getPropWindow();
    if (_win != null)
        _win.close();
    
    Dialog.closeInfo();
}

function getPropWindow()
{
    iframe_name = window.name;
    win_name = iframe_name.replace("_content","");
    
    if (window.Windows) {
        _wins = window.Windows;
        _win = _wins.getWindow(win_name);
        if (typeof(_win) !== 'undefined')
            return _win;
    }
    if (window.top.Windows) {
        _wins = window.top.Windows;
        _win = _wins.getWindow(win_name);
        if (typeof(_win) !== 'undefined')
            return _win;
    }
    return null;
}

function submitForm(formName, URL)
{
   formobj = document.forms[formName];
   if (!formobj) {
      alert("Cannot locate form "+formName);
      return;
   }
   formobj.method = "post";
   formobj.action = URL;
   formobj.submit();
}

function FindFrame(targetFrame)
{
   for (i=0; i<top.frames.length; i++)
   {
      if (top.frames[i].name == targetFrame)
         return top.frames[i];
   }
   return null;
}

function RedirectPage(sTargetURL)
{
   //window.top.location.replace(sTargetURL);   // no browser history change
   //window.top.location.href = sTargetURL;
   self.location.href = sTargetURL;
}

function FocusOn(elemId, hltId)
{
   var elem = document.getElementById(elemId);
   if (elem) {
      if (hltId) {
         var hlt_elem = document.getElementById(hltId);
         if (hlt_elem) {
            var normalAttr = hlt_elem.getAttribute("normal");
            if (!normalAttr)
               hlt_elem.style.background = "white";
            else
               hlt_elem.className = normalAttr;
         }
      }
      var selAttr = elem.getAttribute("select");
      if (!selAttr)
         elem.style.background = selAttr ? selAttr : "#A4D3EE";
      else
         elem.className = selAttr;
   }
}

function popupErrorText(text)
{
   w = 500;
   h = 200;
   LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
   TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
   settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars=0,resizable=1';

   debugWindow = window.open("","",settings);
   body = "<body bgcolor=#D9D9D9>";
   body += text;
   body += "<center><p><input type=button value='Close Window' onclick='window.close();'></center></body>";
   debugWindow.document.writeln("<head><title>error</title>"+body+"</head>");
}

function moveToCenter(win, w, h)
{
   LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
   TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
   win.resizeTo(w,h);
   win.moveTo(LeftPosition, TopPosition);
   return;
}

function popupWindow(content, w, h)
{
   LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
   TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
   settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars=0,resizable=1,menubar=0,status=0';

   popupWindow = window.open("","",settings);
   popupWindow.document.writeln(content);
}

function debugWindow(content)
{
   w=600; h=480;
   LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
   TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
   settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars=1,resizable=1';

   dbgWindow = window.open("","rpc_debug",settings);
   //dbgWindow.document.writeln("<textarea rows='20' cols='80'>"+content+"</textarea>");
   dbgWindow.document.writeln(content);
}

function popupIWin(content, w, h)
{
   xi = document.body.clientWidth/2-w/2;
   yi = document.body.clientHeight/2-h/2;
	divStyle = "position: absolute; border:2 outset white; width:"+w+";height:"+h+";top: "+xi+"px; left: "+yi+"px;";
   var newDiv = document.createElement("<div id='tempbox' style='"+divStyle+"'>");

   shtml = "<div id='title' class='handle' handlefor='tempbox'>title</div>";
   shtml += content;
   newDiv.innerHTML = shtml;

   document.body.appendChild(newDiv);

   //obj = document.getElementById(objId);
   //if (obj)
   //{
   //   obj.style.display = '';
   //   obj.style.left=document.body.clientWidth/2-obj.offsetWidth/2+'px';
   //   obj.style.top=document.body.clientHeight/2-obj.offsetHeight/2+'px';
   //}
}

function resizeFrame(rows, cols)
{
   if (rows)
      top.document.body.rows = rows;
   if (cols)
      top.document.body.cols = cols;
}

function popupConfirm(question, yesFunc, noFunc)
{
   answer = confirm(question);
   if (answer)
   // do yesFunc
   eles
   // do noFunc
}

function focusFirstInput(formName)
{
   var inputs = $(formName).getElements();
   for (i=0; i<inputs.length; i++)
   {
      if (inputs[i].type != 'button' && !inputs[i].disabled)
      {
         inputs[i].focus();
         activeForm = inputs[i].form.name;
         /*if (inputs[i].type != 'text')
         {
            inputs[i].select();
         }*/
         return;
      }
   }
   if (inputs.length >= 1)
      inputs[0].focus();
}

function hasFileToUpload(formName)
{
   var inputs = $(formName).getInputs('file');
   for (i=0; i<inputs.length; i++)
   {
      if (inputs[i].value != "")
         return true;
   }
   return false;
}

/**
 * handler for expanding / collapsing topic tree
 */
function mouseClickHandler(clickedNode) {
  	//var clickedNode = getTarget(e);
    if (clickedNode.className == "collapsed")
        expand(clickedNode);
    else if (clickedNode.className == "expanded")
        collapse(clickedNode);
}

/**
 * Collapses a tree rooted at the specified element
 */
function collapse(node) {
  node.className = "collapsed";
  node.src = plus.src;
  // set the UL as well
  var ul = getChildNode(node.parentNode, "UL");
  if (ul != null) ul.className = "collapsed";
}

/**
 * Expands a tree rooted at the specified element
 */
function expand(node) {
  	node.className = "expanded";
  	node.src = minus.src;
  	// set the UL as well
  	var ul = getChildNode(node.parentNode, "UL");
  	if (ul != null){
  		ul.className = "expanded";
  	}
}

/**
 * Returns the child node with specified tag
 */
function getChildNode(parent, childTag)
{
	var list = parent.childNodes;
	if (list == null) return null;
	for (var i=0; i<list.length; i++)
		if (list.item(i).tagName == childTag)
			return list.item(i);
	return null;
}

// rte stands for rich text editor
function editRichText(rte, w, h)
{
   rte_container = document.getElementById(rte + '_container');
   if (!rte_container) 
   {
       alert("Cannot get rte parent element");
       return;
   }
   // replace the control (div) with editor
   if (!rte_container.onedit)
   {
      //Usage: writeRichText(fieldname, html, width, height, buttons, readOnly, inContainer)
      writeRichText(rte, rte_container.innerHTML, w, h, true, false, true);
      rte_container.onedit = "Y";
      rte_container.onclick = "";
   }
}

function setLanguage(lang)
{
   var _url = window.location;
   if (!_url.search || _url.search == "")
      _url_str = _url+'?&lang='+lang;
   else
   		_url_str = _url.toString().replace(new RegExp('&lang=[^&]*','g'),'')+'&lang='+lang;
   window.location=_url_str;
}

function initAutoSuggest(form, method, input, input_choice)
{
   if (!$(input).onedit)
   {
      var url = bizsrvr+"?"+composeURLString("RPCInvoke",[form,method,input]);
      new Ajax.Autocompleter(input, input_choice, url, {afterUpdateElement:getSelectionId});
      $(input).onedit = "Y";
   }
}

//Support AutoSuggest where user sees one value but system submits another value.
function getSelectionId(text, li) {
    var name = text.id;
    var name_pos = name.search('_hidden');
    var hidden_name = name.substring(0,name_pos);
    if(document.getElementById(hidden_name)){
	    var hidden_obj =  document.getElementById(hidden_name);
	    hidden_obj.value = li.id;
    }
}

function checkAll(ckbox, ckboxlist)
{
	if (!ckboxlist.length)
		ckboxlist.checked = ckbox.checked;
	else
	{
		for (counter = 0; counter < ckboxlist.length; counter++)
		{
			ckboxlist[counter].checked = ckbox.checked;
		}
	}
}

var ie5=document.all&&document.getElementById;
var ns6=document.getElementById&&!document.all;

var menuobj = null;

function showmenu(e, menuid){
	//Find out how close the mouse is to the corner of the window
	var rightedge=ie5? document.body.clientWidth-event.clientX : window.innerWidth-e.clientX;
	var bottomedge=ie5? document.body.clientHeight-event.clientY : window.innerHeight-e.clientY;

	menuobj=document.getElementById(menuid);
	if (!menuobj)
	   return true;

	//if the horizontal distance isn't enough to accomodate the width of the context menu
	if (rightedge<menuobj.offsetWidth)
		//move the horizontal position of the menu to the left by it's width
		menuobj.style.left=ie5? document.body.scrollLeft+event.clientX-menuobj.offsetWidth+'px' : window.pageXOffset+e.clientX-menuobj.offsetWidth+'px';
	else
		//position the horizontal position of the menu where the mouse was clicked
		menuobj.style.left=ie5? document.body.scrollLeft+event.clientX+'px' : window.pageXOffset+e.clientX+'px';

	//same concept with the vertical position
	if (bottomedge<menuobj.offsetHeight)
		menuobj.style.top=ie5? document.body.scrollTop+event.clientY-menuobj.offsetHeight+'px' : window.pageYOffset+e.clientY-menuobj.offsetHeight+'px';
	else
		menuobj.style.top=ie5? document.body.scrollTop+event.clientY+'px' : window.pageYOffset+e.clientY-15+'px';
	
	menuobj.style.display='block';
	
	return false;
}

function hidemenu(e){
	if (menuobj)
		menuobj.style.display='none';
		
	menuobj = null;
}

/* 
 *  validate element only
 *  elemObj: the element object to be validated
 *  rules: validation rules (yav rules)
 *  alertType: inline, innerHTML, classic
 */
function validate(elemObj, validationRules, alertType)
{
    if (!alertType) alertType = 'inline';
    formObj = elemObj.form;
    formName = formObj.name;
    elemName = elemObj.name;

    if (!validationRules)
        return;
    // split the rules in to array and add prefix as elementName
    var rules = validationRules.split(",");
    for (i=0;i<rules.length;i++)
    {
        rules[i] = elemName+"|"+rules[i];
    }
    yav.performCheck(formName, rules, alertType, elemName);
}

if(window.addEventListener){ // Mozilla, Netscape, Firefox
	document.addEventListener('click', hidemenu, false);
} else { // IE
	document.attachEvent('onclick', hidemenu);
}


/**
*
* AJAX IFRAME METHOD (AIM)
* http://www.webtoolkit.info/
*
**/

AIM = {

    frame : function(c) {

        var n = 'f' + Math.floor(Math.random() * 99999);
        var d = document.createElement('DIV');
        d.innerHTML = '<iframe style="display:none" src="about:blank" id="'+n+'" name="'+n+'" onload="AIM.loaded(\''+n+'\')"></iframe>';
        document.body.appendChild(d);

        var i = document.getElementById(n);
        if (c && typeof(c.onComplete) == 'function') {
            i.onComplete = c.onComplete;
        }

        return n;
    },

    form : function(f, name) {
        f.setAttribute('target', name);
    },

    submit : function(f, c) {
        AIM.form(f, AIM.frame(c));
        if (c && typeof(c.onStart) == 'function') {
            return c.onStart();
        } else {
            return true;
        }
    },

    loaded : function(id) {
        var i = document.getElementById(id);
        if (i.contentDocument) {
            var d = i.contentDocument;
        } else if (i.contentWindow) {
            var d = i.contentWindow.document;
        } else {
            var d = window.frames[id].document;
        }
        if (d.location.href == "about:blank") {
            return;
        }

        if (typeof(i.onComplete) == 'function') {
            try {
                i.onComplete(d.forms['jsrs_Form']['jsrs_Payload'].value);
            } 
            catch (ex)
            {
                CallbackFunction((d.body.innerHTML));
            }
        }
    }

}
