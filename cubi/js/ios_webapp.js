var a=document.getElementsByTagName("a");
for(var i=0;i<a.length;i++)
{
	if(a[i].getAttribute("href").indexOf('javascript:')==-1)
		{
		    a[i].onclick=function()
		    {
		    	try{
		    		show_loader();
		    	}catch(e){
		    		
		    	}
		        window.location=this.getAttribute("href");
		        return false
		    }
		}else{
		}
}

if(window.navigator.standalone === true) {
    var lastpage = localStorage.getItem('exitsatus');
    if (lastpage==null){
        lastpage = "index.html";
    }
    if(document.referrer.length > 0 && document.referrer.indexOf("mysite.com") != -1){
        var lastpageupdate = window.location;
        localStorage.setItem('exitsatus',lastpageupdate);      
    } else {
        window.location = lastpage;
    }
}