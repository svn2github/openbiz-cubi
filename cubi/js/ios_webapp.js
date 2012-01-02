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