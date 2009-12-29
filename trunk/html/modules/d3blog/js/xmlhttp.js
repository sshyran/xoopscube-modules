// HTTPRequest Object
var httpObj ;
var timerID ;

// set Ajax object(global ajax object is httpObj)
function createXMLHttpRequest(onreadystatechangeFunc)
{
	var XMLhttpObject = null;
	try{
		XMLhttpObject = new XMLHttpRequest();
	}catch(e){
		try{
			XMLhttpObject = new ActiveXObject("Msxml2.XMLHTTP");
		}catch(e){
			try{
				XMLhttpObject = new ActiveXObject("Microsoft.XMLHTTP");
			}catch(e){
				return null;
			}
		}
	}
	if (XMLhttpObject) XMLhttpObject.onreadystatechange = onreadystatechangeFunc;
	return XMLhttpObject;
}

// Timer
function httpObjAbort()
{
	httpObj.abort();
}

function $(tagId)
{
	return document.getElementById(tagId);
}