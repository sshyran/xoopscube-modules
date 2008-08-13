// Init.
var wikihelper_elem;
var wikihelper_mapLoad=0;
var wikihelper_initLoad=0;
var wikihelper_root_url = 'http://localhost/xoopscube/modules/wiki';
var XpWikiModuleUrl = 'http://localhost/xoopscube/modules';
var XpWikiEncHint = 'ÿ';
var XpWikiCharSet = 'ISO-8859-1';

var xpwiki_ajax_edit_var = new Object();
xpwiki_ajax_edit_var['id'] = '';
xpwiki_ajax_edit_var['html'] = '';
xpwiki_ajax_edit_var['mode'] = '';
xpwiki_ajax_edit_var['func_post'] = '';

// cookie
var wikihelper_adv;

function wikihelper_show_fontset_img()
{
	var str = '<small> [&nbsp;<a href="#" onClick="javascript:wikihelper_show_hint(); return false;">' + wikihelper_msg_hint + '<'+'/'+'a>&nbsp;]<'+'/'+'small>';
	
	if (wikihelper_adv == "on") {
		str = str + '<small> [&nbsp;<a href="#" title="'+wikihelper_msg_to_easy_t+'" onClick="javascript:wikihelper_adv_swich(); return false;">' + 'Easy' + '<'+'/'+'a>&nbsp;]<'+'/'+'small>';
	} else {
		str = str + '<small> [&nbsp;<a href="#" title="'+wikihelper_msg_to_adv_t+'" onClick="javascript:wikihelper_adv_swich(); return false;">' + 'Adv.' + '<'+'/'+'a>&nbsp;]<'+'/'+'small>';
	}
	
	str += ' <a href="#" title="Close" onClick="javascript:wikihelper_hide_helper(); return false;"><img src="http://localhost/xoopscube/modules/wiki/skin/loader.php?src=close.gif" border="0" alt="Close" '+'/'+'><'+'/'+'a>';

	if (!wikihelper_mapLoad)
	{
		wikihelper_mapLoad = 1;
		var map='<map name="map_button">'+
			'<area shape="rect" coords="0,0,22,16" title="URL" alt="URL" href="#" onClick="javascript:wikihelper_linkPrompt(\'url\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="24,0,40,16" title="B" alt="B" href="#" onClick="javascript:wikihelper_tag(\'b\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="43,0,59,16" title="I" alt="I" href="#" onClick="javascript:wikihelper_tag(\'i\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="62,0,79,16" title="U" alt="U" href="#" onClick="javascript:wikihelper_tag(\'u\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="81,0,103,16" title="SIZE" alt="SIZE" href="#" onClick="javascript:wikihelper_tag(\'size\'); return false;" '+'/'+'>'+
			'<'+'/'+'map>'+
			'<map name="map_color">'+
			'<area shape="rect" coords="0,0,8,8" title="Black" alt="Black" href="#" onClick="javascript:wikihelper_tag(\'Black\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="8,0,16,8" title="Maroon" alt="Maroon" href="#" onClick="javascript:wikihelper_tag(\'Maroon\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="16,0,24,8" title="Green" alt="Green" href="#" onClick="javascript:wikihelper_tag(\'Green\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="24,0,32,8" title="Olive" alt="Olive" href="#" onClick="javascript:wikihelper_tag(\'Olive\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="32,0,40,8" title="Navy" alt="Navy" href="#" onClick="javascript:wikihelper_tag(\'Navy\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="40,0,48,8" title="Purple" alt="Purple" href="#" onClick="javascript:wikihelper_tag(\'Purple\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="48,0,55,8" title="Teal" alt="Teal" href="#" onClick="javascript:wikihelper_tag(\'Teal\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="56,0,64,8" title="Gray" alt="Gray" href="#" onClick="javascript:wikihelper_tag(\'Gray\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="0,8,8,16" title="Silver" alt="Silver" href="#" onClick="javascript:wikihelper_tag(\'Silver\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="8,8,16,16" title="Red" alt="Red" href="#" onClick="javascript:wikihelper_tag(\'Red\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="16,8,24,16" title="Lime" alt="Lime" href="#" onClick="javascript:wikihelper_tag(\'Lime\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="24,8,32,16" title="Yellow" alt="Yellow" href="#" onClick="javascript:wikihelper_tag(\'Yellow\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="32,8,40,16" title="Blue" alt="Blue" href="#" onClick="javascript:wikihelper_tag(\'Blue\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="40,8,48,16" title="Fuchsia" alt="Fuchsia" href="#" onClick="javascript:wikihelper_tag(\'Fuchsia\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="48,8,56,16" title="Aqua" alt="Aqua" href="#" onClick="javascript:wikihelper_tag(\'Aqua\'); return false;" '+'/'+'>'+
			'<area shape="rect" coords="56,8,64,16" title="White" alt="White" href="#" onClick="javascript:wikihelper_tag(\'White\'); return false;" '+'/'+'>'+
			'<'+'/'+'map>'+
			'<div id="wikihelper_base" style="position:absolute;display:none;"><'+'/'+'div>';
		
		var src;
		
		src = document.createElement('link');
		src.href = 'http://localhost/xoopscube/modules/wiki/skin/loader.php?src=wikihelper.css';
		src.rel  = 'stylesheet';
		src.type = 'text/css';
		document.body.appendChild(src);

		src = document.createElement('div');
		src.innerHTML = map;
		src.zIndex = 1000;
		document.body.appendChild(src);
	}

	// Helper image tag set
	var wikihelper_adv_tag = '';
	if (wikihelper_adv == "on")
	{
		wikihelper_adv_tag =
			'<img src="http://localhost/xoopscube/modules/wiki/image/clip.png" width="18" height="16" border="0" title="'+wikihelper_msg_attach+'" alt="&amp;ref;" onClick="javascript:wikihelper_ins(\'&ref();\'); return false;" '+'/'+'>'+
			'<img src="http://localhost/xoopscube/modules/wiki/image/ncr.gif" width="22" height="16" border="0" title="'+wikihelper_msg_to_ncr+'" alt="'+wikihelper_msg_to_ncr+'" onClick="javascript:wikihelper_charcode(); return false;" '+'/'+'>'+
			'<img src="http://localhost/xoopscube/modules/wiki/image/br.gif" width="18" height="16" border="0" title="&amp;br;" alt="&amp;br;" onClick="javascript:wikihelper_ins(\'&br;\'); return false;" '+'/'+'>'+
			'<img src="http://localhost/xoopscube/modules/wiki/image/iplugin.gif" width="18" height="16" border="0" title="Inline Plugin" alt="Inline Plugin" onClick="javascript:wikihelper_ins(\'&(){};\'); return false;" '+'/'+'>';
	}

	var wikihelper_helper_img = 
		'<img src="http://localhost/xoopscube/modules/wiki/image/buttons.gif" width="103" height="16" border="0" usemap="#map_button" tabindex="-1" '+'/'+'>'+
		' '+
		wikihelper_adv_tag +
		' '+
		'<img src="http://localhost/xoopscube/modules/wiki/image/colors.gif" width="64" height="16" border="0" usemap="#map_color" tabindex="-1" '+'/'+'> '+
		str+
		'<br '+'/'+'>';
	
	if (wikihelper_adv == "on") {
		wikihelper_helper_img += '<img src="http://localhost/xoopscube/uploads/smil2a2745843730700f0ccf8c6398611901.gif" border="0" title=":)" alt=":)" onClick="javascript:wikihelper_face(\':)\');return false;" />'+'<img src="http://localhost/xoopscube/modules/wiki/image/face/bigsmile.png" border="0" title=":D" alt=":D" onClick="javascript:wikihelper_face(\':D\');return false;" />'+'<img src="http://localhost/xoopscube/modules/wiki/image/face/huh.png" border="0" title=":p" alt=":p" onClick="javascript:wikihelper_face(\':p\');return false;" />'+'<img src="http://localhost/xoopscube/modules/wiki/image/face/oh.png" border="0" title="XD" alt="XD" onClick="javascript:wikihelper_face(\'XD\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil02946154c274f6554ebc00c303d01a2e.gif" border="0" title=";)" alt=";)" onClick="javascript:wikihelper_face(\';)\');return false;" />'+'<img src="http://localhost/xoopscube/modules/wiki/image/face/sad.png" border="0" title=";(" alt=";(" onClick="javascript:wikihelper_face(\';(\');return false;" />'+'<img src="http://localhost/xoopscube/modules/wiki/image/face/worried.png" border="0" title="&amp;worried;" alt="&amp;worried;" onClick="javascript:wikihelper_face(\'&amp;worried;\');return false;" />'+'<img src="http://localhost/xoopscube/modules/wiki/image/face/heart.png" border="0" title="&amp;heart;" alt="&amp;heart;" onClick="javascript:wikihelper_face(\'&amp;heart;\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil9714c069d291028ee1c5b65ed4139657.gif" border="0" title=":(" alt=":(" onClick="javascript:wikihelper_face(\':(\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil5ee94bc39363e1222324e84d58d5a67e.gif" border="0" title=":-/" alt=":-/" onClick="javascript:wikihelper_face(\':-/\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil9903e60a83d11ab938cb598afeddd66c.gif" border="0" title=":x" alt=":x" onClick="javascript:wikihelper_face(\':x\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smilf99bff276ebde4d27522aa6e4cd6a515.gif" border="0" title=":&quot;&gt;" alt=":&quot;&gt;" onClick="javascript:wikihelper_face(\':&quot;&gt;\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil5d28fc0994314e7288e8607798811528.gif" border="0" title=":P" alt=":P" onClick="javascript:wikihelper_face(\':P\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil7943d48feb3a0e94c09d9e2c0358684a.gif" border="0" title=":-O" alt=":-O" onClick="javascript:wikihelper_face(\':-O\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil0123c7c705fb9b071dca94c37d1ac759.gif" border="0" title="B-)" alt="B-)" onClick="javascript:wikihelper_face(\'B-)\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil16859f49147a6897bb3cd3ca0a40d003.gif" border="0" title=":-c" alt=":-c" onClick="javascript:wikihelper_face(\':-c\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil07013862d42aab5caa95c0dc22347ebe.gif" border="0" title=":-w" alt=":-w" onClick="javascript:wikihelper_face(\':-w\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smileea27e4bd6e280afa981a72b118b35b8.gif" border="0" title=":-S" alt=":-S" onClick="javascript:wikihelper_face(\':-S\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil5bf7b1f3e0d20da9acc59eee3c76560a.gif" border="0" title=":((" alt=":((" onClick="javascript:wikihelper_face(\':((\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil3724991839ecdddf503ca786fdd221b0.gif" border="0" title=":))" alt=":))" onClick="javascript:wikihelper_face(\':))\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smilc58e3108409b643e80bfcccc5868e518.gif" border="0" title="&lt;:-P" alt="&lt;:-P" onClick="javascript:wikihelper_face(\'&lt;:-P\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil254323cec18faca07a7f22f55578e779.gif" border="0" title=":|" alt=":|" onClick="javascript:wikihelper_face(\':|\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smild8a35cfcc7e4ea68318de0fe00a57aee.gif" border="0" title="=))" alt="=))" onClick="javascript:wikihelper_face(\'=))\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smild994c1346e3005569f33fef632b158fc.gif" border="0" title="X(" alt="X(" onClick="javascript:wikihelper_face(\'X(\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smilf9f5e743d4265a3dffaf3fbbe4561741.gif" border="0" title="&gt;:)" alt="&gt;:)" onClick="javascript:wikihelper_face(\'&gt;:)\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil28a50d50f2a07ae3b4ebbdddcbda1cf0.gif" border="0" title=":O)" alt=":O)" onClick="javascript:wikihelper_face(\':O)\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil4f9f7e08dc46ebd856e4ff2d7d31bf16.gif" border="0" title=":-$" alt=":-$" onClick="javascript:wikihelper_face(\':-$\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil3a2b239670f1ddd98da5070f10030f33.gif" border="0" title=":)]" alt=":)]" onClick="javascript:wikihelper_face(\':)]\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smilffaf8cf514c75c3c8d70d3c52d872bec.gif" border="0" title="8-|" alt="8-|" onClick="javascript:wikihelper_face(\'8-|\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil112623f998d4323f1eaa1b47b6cc0bfe.gif" border="0" title="=D&gt;" alt="=D&gt;" onClick="javascript:wikihelper_face(\'=D&gt;\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil6c6194c10b5bd3ab80291e98aa7543b5.gif" border="0" title="(:|" alt="(:|" onClick="javascript:wikihelper_face(\'(:|\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil6b1d0839450518ec4fa1122779aea11f.gif" border="0" title="O:-)" alt="O:-)" onClick="javascript:wikihelper_face(\'O:-)\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil7a8b12f977b3c91a6fa53fe1c189bef6.gif" border="0" title=":-h" alt=":-h" onClick="javascript:wikihelper_face(\':-h\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil7a1566bd6b41473dc66071531dfb7fcd.gif" border="0" title=":-bd" alt=":-bd" onClick="javascript:wikihelper_face(\':-bd\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smild81b00cd45e478c47ab0942fe32cce01.gif" border="0" title=":-q" alt=":-q" onClick="javascript:wikihelper_face(\':-q\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil1949cf7c5a40d7ce2d300c14be5cd286.gif" border="0" title=":-&amp;" alt=":-&amp;" onClick="javascript:wikihelper_face(\':-&amp;\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil75312af1e0d7c33a948c0fd6c2d9947b.gif" border="0" title="&lt;3" alt="&lt;3" onClick="javascript:wikihelper_face(\'&lt;3\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smilc01b7a32dac7ffd108705de5d1fc9483.gif" border="0" title=":beer:" alt=":beer:" onClick="javascript:wikihelper_face(\':beer:\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil6419cb416deb9d951b1e3d3bd23d5677.gif" border="0" title=":coffee:" alt=":coffee:" onClick="javascript:wikihelper_face(\':coffee:\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil8a0b51616db28c0f0f6c9f00d6dbf136.gif" border="0" title=":-B" alt=":-B" onClick="javascript:wikihelper_face(\':-B\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil5a41e484b191ce72efee5f151ba83c72.gif" border="0" title="I-)" alt="I-)" onClick="javascript:wikihelper_face(\'I-)\');return false;" />';
	} else {
		wikihelper_helper_img += '<img src="http://localhost/xoopscube/uploads/smil2a2745843730700f0ccf8c6398611901.gif" border="0" title=":)" alt=":)" onClick="javascript:wikihelper_face(\':)\');return false;" />'+'<img src="http://localhost/xoopscube/modules/wiki/image/face/bigsmile.png" border="0" title=":D" alt=":D" onClick="javascript:wikihelper_face(\':D\');return false;" />'+'<img src="http://localhost/xoopscube/modules/wiki/image/face/huh.png" border="0" title=":p" alt=":p" onClick="javascript:wikihelper_face(\':p\');return false;" />'+'<img src="http://localhost/xoopscube/modules/wiki/image/face/oh.png" border="0" title="XD" alt="XD" onClick="javascript:wikihelper_face(\'XD\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil02946154c274f6554ebc00c303d01a2e.gif" border="0" title=";)" alt=";)" onClick="javascript:wikihelper_face(\';)\');return false;" />'+'<img src="http://localhost/xoopscube/modules/wiki/image/face/sad.png" border="0" title=";(" alt=";(" onClick="javascript:wikihelper_face(\';(\');return false;" />'+'<img src="http://localhost/xoopscube/modules/wiki/image/face/worried.png" border="0" title="&amp;worried;" alt="&amp;worried;" onClick="javascript:wikihelper_face(\'&amp;worried;\');return false;" />'+'<img src="http://localhost/xoopscube/modules/wiki/image/face/heart.png" border="0" title="&amp;heart;" alt="&amp;heart;" onClick="javascript:wikihelper_face(\'&amp;heart;\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil9714c069d291028ee1c5b65ed4139657.gif" border="0" title=":(" alt=":(" onClick="javascript:wikihelper_face(\':(\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil5ee94bc39363e1222324e84d58d5a67e.gif" border="0" title=":-/" alt=":-/" onClick="javascript:wikihelper_face(\':-/\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil9903e60a83d11ab938cb598afeddd66c.gif" border="0" title=":x" alt=":x" onClick="javascript:wikihelper_face(\':x\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smilf99bff276ebde4d27522aa6e4cd6a515.gif" border="0" title=":&quot;&gt;" alt=":&quot;&gt;" onClick="javascript:wikihelper_face(\':&quot;&gt;\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil5d28fc0994314e7288e8607798811528.gif" border="0" title=":P" alt=":P" onClick="javascript:wikihelper_face(\':P\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil7943d48feb3a0e94c09d9e2c0358684a.gif" border="0" title=":-O" alt=":-O" onClick="javascript:wikihelper_face(\':-O\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil0123c7c705fb9b071dca94c37d1ac759.gif" border="0" title="B-)" alt="B-)" onClick="javascript:wikihelper_face(\'B-)\');return false;" />'+'<img src="http://localhost/xoopscube/uploads/smil16859f49147a6897bb3cd3ca0a40d003.gif" border="0" title=":-c" alt=":-c" onClick="javascript:wikihelper_face(\':-c\');return false;" />';
	}

	$("wikihelper_base").style.width = 'auto';
	$("wikihelper_base").innerHTML = wikihelper_helper_img;

	new Draggable('wikihelper_base');
	new Resizable('wikihelper_base', {mode:'x'});
}

function wikihelper_adv_swich()
{
	if (wikihelper_adv == "on")	{
		wikihelper_adv = "off";
	} else {
		wikihelper_adv = "on";
	}
	wikihelper_save_cookie("__whlp",wikihelper_adv,90,"/");
	wikihelper_show_fontset_img();
	$('wikihelper_base').style.width = 'auto';
	$('wikihelper_base').style.height = 'auto';
	$('wikihelper_base').style.width = $('wikihelper_base').getStyle('width');
	wikihelper_elem.focus();
}

function wikihelper_save_cookie(arg1,arg2,arg3,arg4){
	XpWiki.cookieSave(arg1, arg2, arg3, arg4);
}

function wikihelper_load_cookie(arg){
	return XpWiki.cookieLoad(arg);
}

function wikihelper_area_highlite(id,mode) {
	if (mode) {
		$(id).className += '_highlight';
	} else {
		$(id).className = $(id).className.replace(/_highlight$/, '');
	}
	
}

function wikihelper_check(f) {
	if (wikihelper_elem && wikihelper_elem.type == "text") {
		if (!confirm(wikihelper_msg_submit)) {
			wikihelper_elem.focus();
			return false;
		}
	}
	
	for (i = 0; i < f.elements.length; i++) {
		oElement = f.elements[i];
		if (oElement.type == "submit" && (!oElement.name || oElement.name == "comment")) {
			oElement.disabled = true;
		}
	}
	
	return true;

}

function wikihelper_cumulativeOffset(forElement) {

	var valueT = 0, valueL = 0;
	var base = document.body;
	var element = forElement;
	do {
		if (Element.getStyle(element, 'position') == 'absolute') {
			base = element;
			//parent = element
			break;
		}
		valueT += element.offsetTop  || 0;
		valueL += element.offsetLeft || 0;
	} while (element = element.offsetParent);
	
	element = forElement;
	do {
		if (element != forElement) {
			valueT -= element.scrollTop  || 0;
			valueL -= element.scrollLeft || 0;
		}
		if (element.parentNode == base) break;		
	} while (element = element.parentNode);
	
	var helper = $('wikihelper_base');
	Element.remove($('wikihelper_base'));
	base.appendChild(helper);

	return Element._returnOffset(valueL, valueT);
}

function wikihelper_hide_helper() {
	var helper = $("wikihelper_base");
	if (helper) {
		Element.hide(helper);
		if (wikihelper_WinIE && ! XpWiki.isIE7) {
			oElements = document.getElementsByTagName("select");
			for (i = 0; i < oElements.length; i++)
			{
				oElement = oElements[i];
				oElement.style.visibility = "";
			}
		}
	}
}

function wikihelper_tagset (str, v) {
	if ( v == 'size' ) {
		var default_size = "%";
		v = prompt(wikihelper_msg_fontsize, default_size);
		if (!v) return false;
		if (!v.match(/(%|pt)$/))
			v += "pt";
		if (!v.match(/\d+(%|pt)/))
			return false;
	}
	if ( v == 'b') {
		str = '\'\'' + str.replace(/(\r\n|\r|\n)/g, "&br;") + '\'\'';
	} else if ( v == 'i') {
		str = '\'\'\'' + str.replace(/(\r\n|\r|\n)/g, "&br;") + '\'\'\'';
	} else if (str.match(/^&font\([^\)]*\)\{.*\};$/)) {
		str = str.replace(/^(&font\([^\)]*)(\)\{.*\};)$/,"$1," + v.replace(/(\r\n|\r|\n)/g, "&br;") + "$2");
	} else {
		str = '&font(' + v + '){' + str.replace(/(\r\n|\r|\n)/g, "&br;") + '};';
	}
	
	return str;
}

function xpwiki_now_loading(mode, id) {
	if (mode) {
		if (!id || !$(id)) {
			id = 'xpwiki_body';
		}
		wikihelper_hide_helper();
		
		if (!$("xpwiki_loading")) {
			var objBody = document.getElementsByTagName("body").item(0);
			var objBack = document.createElement("div");
			objBack.setAttribute('id', 'xpwiki_loading');
			Element.setStyle(objBack, {display : 'none'});
			Element.setStyle(objBack, {position: 'absolute'});
			objBody.appendChild(objBack);
		}
	
		//Position.clone($(id), $('xpwiki_loading'));
		Element.clonePosition('xpwiki_loading', id);
		
		Element.show('xpwiki_loading');
	} else {
		Element.hide('xpwiki_loading');
	}
}

function xpwiki_ajax_edit(url, id) {
	xpwiki_now_loading(true, id);
	
	url = location.pathname.replace(/[^\/]+$/, '')+'?page='+url;
	if ($(id)) {
		if (xpwiki_ajax_edit_var["id"]) {
			$(xpwiki_ajax_edit_var["id"]).innerHTML = xpwiki_ajax_edit_var["html"];
			$(xpwiki_ajax_edit_var["id"]).style.clear = xpwiki_ajax_edit_var["clear"];
		}
		wikihelper_area_highlite(id, 0);
		xpwiki_ajax_edit_var["id"] = id;
	} else {
		xpwiki_ajax_edit_var["id"] = 'xpwiki_body';
		id = '';
	}
	
	var pars = '';
	pars += 'cmd=edit';
	if (id) pars += '&paraid=' + encodeURIComponent(id);
	pars += '&ajax=1';
	var myAjax = new Ajax.Request(
		url, 
		{
			method: 'get',
			parameters: pars,
			onComplete: xpwiki_ajax_edit_show
		});
	return false;
}

function xpwiki_ajax_edit_show(orgRequest) {
	xpwiki_now_loading(false);
	xpwiki_ajax_edit_var["html"] = $(xpwiki_ajax_edit_var["id"]).innerHTML;
	xpwiki_ajax_edit_var["clear"] = $(xpwiki_ajax_edit_var["id"]).style.clear;
	var xmlRes = orgRequest.responseXML;
	if(xmlRes.getElementsByTagName("editform").length) {
		var str = xmlRes.getElementsByTagName("editform")[0].firstChild.nodeValue;
		str = str.replace(/wikihelper_msg_nowrap/, wikihelper_msg_nowrap);
		$(xpwiki_ajax_edit_var['id']).style.clear = 'both';
		$(xpwiki_ajax_edit_var['id']).innerHTML = str;
		new Resizable('xpwiki_edit_textarea', {mode:'xy'});
		XpWiki.addWrapButton('xpwiki_edit_textarea');
		$('xpwiki_edit_textarea').setAttribute("rel", "wikihelper");
		wikihelper_initTexts($(xpwiki_ajax_edit_var["id"]));

		location.hash = xpwiki_ajax_edit_var["id"];
	}
	orgRequest = null;
}

function xpwiki_ajax_edit_submit(IsTemplate) {
	xpwiki_now_loading(true, xpwiki_ajax_edit_var["id"]);
	url = location.pathname.replace(/[^\/]+$/, '');
	var frm = $('xpwiki_edit_form');
	var re = /input|textarea|select/i;
	var tag = '';
	var postdata = '';
	
	for (var i = 0; i < frm.length; i++ ) {
		var child = frm[i];
		tag = String(child.tagName);
		if (tag.match(re)) {
			if (child.type == 'checkbox') {
				if (child.checked) {
					if (postdata!='') postdata += '&';
					postdata += encodeURIComponent(child.name) +
						'=' + encodeURIComponent(child.value);
				}
			} else {
				if (postdata!='') postdata += '&';
				postdata += encodeURIComponent(child.name) +
					'=' + encodeURIComponent(child.value);
			}
		}
	}
	if (!IsTemplate) {
		postdata = postdata.replace(/&template=[^&]+/,'');
	}
	if (xpwiki_ajax_edit_var['mode'] == 'preview') {
		postdata = postdata.replace(/&write=[^&]+/,'');
	} else {
		postdata = postdata.replace(/&preview=[^&]+/,'');
	}
	postdata += '&ajax=1';
	
	var myAjax = new Ajax.Request(
		url, 
		{
			asynchronous: false,
			method: 'post',
			parameters: postdata
		});

	return xpwiki_ajax_edit_post(myAjax.transport);
}

function xpwiki_ajax_edit_post(orgRequest) {
	xpwiki_now_loading(false);
	if (xpwiki_ajax_edit_var['func_post']) {
		xpwiki_ajax_edit_var['func_post'](orgRequest);
		return false;
	} else {
		var xmlRes = orgRequest.responseXML;
		if(xmlRes.getElementsByTagName("xpwiki").length) {
			var item = xmlRes.getElementsByTagName("xpwiki")[0];
			var str = item.getElementsByTagName("content")[0].firstChild.nodeValue;
			xpwiki_ajax_edit_var['mode'] = item.getElementsByTagName("mode")[0].firstChild.nodeValue;
			if (xpwiki_ajax_edit_var['mode'] == 'write') {
				if (xpwiki_ajax_edit_var['id']) location.hash = xpwiki_ajax_edit_var["id"];
				xpwiki_ajax_edit_var["id"] = '';
				xpwiki_ajax_edit_var['mode'] = '';
				xpwiki_ajax_edit_var['html'] = '';
				if (str.match(/<script[^>]+src=/)) {
					location.reload();
					orgRequest = null;
					return false;
				}
				$('xpwiki_body').innerHTML = str;
				wikihelper_initTexts($('xpwiki_body'));
			} else if (xpwiki_ajax_edit_var['mode'] == 'delete') {
				$('xpwiki_body').innerHTML = str;
				xpwiki_ajax_edit_var["id"] = '';
				xpwiki_ajax_edit_var['mode'] = '';
				xpwiki_ajax_edit_var['html'] = '';
				location.href = item.getElementsByTagName("url")[0].firstChild.nodeValue;
			} else if (xpwiki_ajax_edit_var['mode'] == 'preview') {
				if (xpwiki_ajax_edit_var['id']) location.hash = xpwiki_ajax_edit_var["id"];
				if (str.match(/<script[^>]+src=/)) {
					xpwiki_ajax_edit_var['html'] = '';
					orgRequest = null;
					return true;
				}
				str = str.replace(/wikihelper_msg_nowrap/, wikihelper_msg_nowrap);
				$(xpwiki_ajax_edit_var['id']).innerHTML = str;
				new Resizable('xpwiki_preview_area', {mode:'y'});
				new Resizable('xpwiki_edit_textarea', {mode:'xy'});
				XpWiki.addWrapButton('xpwiki_edit_textarea');
				$('xpwiki_edit_textarea').setAttribute("rel", "wikihelper");
				wikihelper_initTexts($(xpwiki_ajax_edit_var["id"]));
			}
		}
	}
	orgRequest = null;
	return false;
}

function xpwiki_ajax_edit_cancel() {
	if (xpwiki_ajax_edit_var["id"]) {
		if (xpwiki_ajax_edit_var["html"].match(/<script[^>]+src=/)) {
			xpwiki_ajax_edit_var["html"] = '';
			location.reload();
			return false;
		}
		$(xpwiki_ajax_edit_var["id"]).innerHTML = xpwiki_ajax_edit_var["html"];
		$(xpwiki_ajax_edit_var["id"]).style.clear = xpwiki_ajax_edit_var["clear"];
		location.hash = xpwiki_ajax_edit_var["id"];
		wikihelper_initTexts($(xpwiki_ajax_edit_var["id"]));
	}
	xpwiki_ajax_edit_var["id"] = '';
	xpwiki_ajax_edit_var['mode'] = '';
	xpwiki_ajax_edit_var['html'] = '';
	return false;
}

function xpwiki_getDateStr() {
	var today = new Date();
	var yy = parseInt(today.getYear());
	if (yy < 2000) {yy = yy+1900;}
	var mm = parseInt(today.getMonth()) + 1;
	if (mm < 10) {mm = "0" + mm;}
	var dd = parseInt(today.getDate());
	if (dd < 10) {dd = "0" + dd;}
	var h = parseInt(today.getHours());
	if (h < 10) {h = "0" + h;}
	var m = parseInt(today.getMinutes());
	if (m < 10) {m = "0" + m;}
	var s = parseInt(today.getSeconds());
	if (s < 10) {s = "0" + s;}
	var ms = parseInt(today.getMilliseconds());
	if (ms < 10) {ms = "00" + ms;}
	else if (ms < 100) {ms = "0" + ms;}
	
	return ''+yy+mm+dd+h+m+s+ms;
}

_save = (window.onbeforeunload)? window.onbeforeunload : '';
window.onbeforeunload = function(e) {
	e = e || window.event;
	if (_save) _save(e);
	if (xpwiki_ajax_edit_var["html"]) {
		return wikihelper_msg_notsave;
	}
};

document.observe("dom:loaded", function() {
	// cookie
	wikihelper_adv = wikihelper_load_cookie("__whlp");
	if (wikihelper_adv) wikihelper_save_cookie("__whlp",wikihelper_adv,90,"/");

	XpWiki.addCssInHead('base.css');
	XpWiki.remakeTextArea();
	wikihelper_initTexts();
	XpWiki.initDomExtension();
	XpWiki.faviconSet();
});
