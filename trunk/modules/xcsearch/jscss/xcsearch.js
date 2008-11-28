//-------------------------------------------------------------------------
//keywords ranking block
var xcsearch_dir , cxid , ym ;
var cache_ranking = [] ;
function ranking( mydirname,num,len ){
  xcsearch_dir = mydirname ;
  var myform = window.document.keywordsranking ;
  cxid = myform.cxs.value ;
  ym = myform.ym.value ;
  if( cache_ranking[0] == undefined ) cache_ranking[0] = [] ;
  if( cache_ranking[0][0] == undefined ) cache_ranking[0][0] =  $("xcserch_keywords_block").innerHTML ;
  if( cache_ranking[cxid] == undefined ) cache_ranking[cxid] = [];
  if( cache_ranking[cxid][ym] == undefined ){
    new Ajax.Request( "/modules/"+ mydirname +"/include/ranking.php" , {
      method:"post" ,
      parameters:"cxid="+ cxid +"&ym="+ ym +"&num="+ num +"&len="+ len ,
      onSuccess:rankingRender
    });
  }else{
    $("xcserch_keywords_block").innerHTML = cache_ranking[cxid][ym];
  }
}

function rankingRender( rtn ){
  var data = eval(rtn.responseText);
  var results = data[0].results ;
  var html = "";
  for(i=0; i<results.length; i++ ){
    html += '<div style="clear:both;"><div style="float:left;"><b>'+ (i+1) +'</b> <a href="/modules/'+ xcsearch_dir +'/?cx='+ data[0].cxvalue +'&amp;q='+ results[i].keyword_enc +'&amp;cof=FORID%3A11&amp;ie='+ data[0].charset +'&amp;oe='+ data[0].charset +'" title="'+ results[i].keyword +'">'+ results[i].keyword_s +'</a></div><div style="text-align:right;color:#00a;">'+ results[i].count +'</div></div>';
  }
  cache_ranking[cxid][ym] = html ;
  $("xcserch_keywords_block").innerHTML = html;
}

//-------------------------------------------------------------------------
//search this site - show all
var id_no ;
//var perpage = 20 ;//TODO config
var recentpage = [] ;
var cache_results = [] ;
function showAll( mid , id , page ){
  id_no = id ;
  recentpage[mid] = page ;
  if( cache_results[mid] == undefined ) cache_results[mid] = [];
  if( cache_results[mid][recentpage[mid]] == undefined ){
    new Ajax.Request( "./include/showall.php" , {
      method:"post" ,
      parameters:"mid="+ mid +"&page="+ page +"&num="+ perpage ,
      onSuccess:showAllRender
    });
  }else{
    $("nos-result"+id_no).innerHTML = cache_results[mid][recentpage[mid]];
  }
}

function showAllRender( rtn ){
  var data = eval(rtn.responseText);
  var module_name = data[0].name ;
  var module_id = parseInt(data[0].mid) ;
  var results = data[0].results ;
  var html = "";
  for(i=0; i<results.length; i++ ){
    html += "<img src='"+ results[i].image +"' alt='"+ module_name +"' title='"+ module_name +"' /><a href='"+ results[i].link +"'>&nbsp;"+ results[i].title +"</a>&nbsp;<small>("+ results[i].time +")</small><br />";
  }
  html += "<div style='padding:8px 0;'>" ;
  if( recentpage[module_id] > 1 ){
    var previouspage = recentpage[module_id] - 1 ;
    html += "<a href='javascript:void(0);' onclick='showAll("+ module_id +","+ id_no +","+ previouspage +");'>&laquo; PREVIOUS["+ previouspage +"]</a>&nbsp;";
  }
  html += "&nbsp;<span style='color:red;font-weight:bold;'>["+ recentpage[module_id] +"]</span>&nbsp;" ;
  if( results.length >= perpage ){
    var nextpage = recentpage[module_id] + 1 ;
    html += "&nbsp;<a href='javascript:void(0);' onclick='showAll("+ module_id +","+ id_no +","+ nextpage +");'>["+ nextpage +"]NEXT &raquo;</a>";
  }
  html += "</div>" ;
  cache_results[module_id][recentpage[module_id]] = html;
  $("nos-result"+id_no).innerHTML = html;
}

//-------------------------------------------------------------------------
//search inside site
function nosChange( nosno , obj ){
	var nosrlt = getElementsByClass("nos-rlt","div");
	var noshdr = getElementsByClass("nos-tabHeader","a");
	for( i=0; i<nosrlt.length; i++ ){
		nosrlt[i].style.display = "none" ;
		noshdr[i].style.backgroundColor = "#DDD" ;
		noshdr[i].style.borderTop = "1px solid #CCC" ;
		noshdr[i].style.paddingTop = "2px" ;
		noshdr[i].style.paddingBottom = "2px" ;
	}
	document.getElementById("nos-result"+nosno).style.display = "block" ;
	obj.style.backgroundColor = "#FFF" ;
	obj.style.borderTop = "3px solid #F90" ;
	obj.style.paddingTop = "1px" ;
	obj.style.paddingBottom = "1px" ;
}

//Classes of the single classname is made classelements
function getElementsByClass(searchClass,elm) {
    var classElements = new Array();
    var allElements = document.getElementsByTagName(elm);
    for (i = 0, j = 0; i < allElements.length; i++) {
		if (allElements[i].className == searchClass) {
		    classElements[j] = allElements[i];
		    j++;
		}
    }
    return classElements;
}

// basic tabs 'onmouseover'
function mover( tabno , obj ){
  if( present != tabno ){
    obj.style.backgroundPosition ="0% -42px";
    obj.childNodes[0].style.backgroundPosition ="100% -42px";
  }
}
// basic tabs 'onmouseout'
function mout( tabno , obj ){
  if( present != tabno ){
    obj.style.backgroundPosition ="0% 0px";
    obj.childNodes[0].style.backgroundPosition ="100% 0px";
  }
}
// basic tabs 'onchange'
function changetab( tabno , obj ){
  xcs.style.backgroundPosition ="0% 0px";
  xcs.childNodes[0].style.backgroundPosition ="100% 0px";
  if(gas!=undefined) gas.style.backgroundPosition ="0% 0px";
  if(gas!=undefined) gas.childNodes[0].style.backgroundPosition ="100% 0px";
  if(nos!=undefined) nos.style.backgroundPosition ="0% 0px";
  if(nos!=undefined) nos.childNodes[0].style.backgroundPosition ="100% 0px";
  if( tabno == 1 ) {
    xcsearch.style.display ="block";
    gasearch.style.display ="none";
    nosearch.style.display ="none";
  }
  if( tabno == 2 ) {
    xcsearch.style.display ="none";
    gasearch.style.display ="block";
    nosearch.style.display ="none";
  }
  if( tabno == 3 ) {
    xcsearch.style.display ="none";
    gasearch.style.display ="none";
    nosearch.style.display ="block";
  }
  obj.style.backgroundPosition ="0% -42px";
  obj.childNodes[0].style.backgroundPosition ="100% -42px";
  present = tabno ;
  //alert(present);
  document.getElementById("tabno2").value = present ;
}

//Search inside site / switch AND and OR
function changeAndor( val ){
	document.getElementById("andor").value = val ;
}
