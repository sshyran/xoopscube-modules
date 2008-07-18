function getTrackbackValidKey(id){
    blog_id=id;
    httpObj = createXMLHttpRequest(displayTrackbackURL);
    timerID = setTimeout("httpObjAbort()" ,5000);
    
   	httpObj.open("POST", "tbkey.php");
   	httpObj.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   	httpObj.setRequestHeader("Referer", location.href);
   	httpObj.send("bid=" + blog_id);
}

function displayTrackbackURL(){
    clearTimeout(timerID);	

    statusCode = new Array();
    statusCode["200"] = function (){
        xmlData = httpObj.responseXML; 
        isError = xmlData.getElementsByTagName("error")[0].firstChild.nodeValue;

        if(isError == 1){
            //alert('Failed to get TrackbackURL. Retry please.');
			errmsg = xmlData.getElementsByTagName("key")[0].firstChild.nodeValue;
			alert(errmsg);
        }else{
            tbkey = xmlData.getElementsByTagName("key");
            key = tbkey[0].firstChild.nodeValue ;
			tbURL = document.URL.split("?")[0].replace(/details/g, "tb") + '/' + key;
            document.getElementById('d3blogGetTrackbackURL').style.display = 'none';
            document.getElementById('d3blogTrackbackURL').innerHTML = tbURL;
            document.getElementById('d3blogTrackbackURL').style.display = 'inline';
        }

    }
    statusCode["401"] = function (){ alert("Auth Error"); }
    statusCode["403"] = function (){ alert("Forbidden"); }
    statusCode["404"] = function (){ alert("File Not Found"); }
    statusCode["500"] = function (){ alert( "Internal Server Error"); }
	statusCode["501"] = function (){ alert( "Server Not Implemented"); }
    
    if (httpObj.readyState == 4){
    	try {
        	statusCode[""+httpObj.status]();
        }catch(e){
            return;
        }
    }
}