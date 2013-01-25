
function GetURLOutput(url)
{
	var xhr_object = null; 
		 
	if(window.XMLHttpRequest) // Firefox 
		xhr_object = new XMLHttpRequest(); 
	else if(window.ActiveXObject) // Internet Explorer 
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
	else{ // XMLHttpRequest non supporté par le navigateur 
		return false;
	}
		
	xhr_object.open("GET",url, false); 
	xhr_object.send(null);
	return xhr_object.responseText;
}

function GetURLPostOutput(url,post)
{
	var xhr_object = null; 
		 
	if(window.XMLHttpRequest) // Firefox 
		xhr_object = new XMLHttpRequest(); 
	else if(window.ActiveXObject) // Internet Explorer 
		xhr_object = new ActiveXObject("Microsoft.XMLHTTP"); 
	else{ // XMLHttpRequest non supporté par le navigateur 
		return false;
	}
		
	xhr_object.open("POST",url, false); 
	xhr_object.send(post);
	return xhr_object.responseText;
}