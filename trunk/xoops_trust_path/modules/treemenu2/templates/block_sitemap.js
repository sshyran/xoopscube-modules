
function <{$mydirname}>openClose( blockNO ){
	var subblock = document.getElementById("<{$mydirname}>_sub"+blockNO);
	var opencloseimg = document.getElementById("<{$mydirname}>_sm_block"+blockNO);
	if( subblock.style.display == 'block' ){
		subblock.style.display = 'none';
		opencloseimg.innerHTML = '<img src="<{$xoops_url}>/modules/<{$mydirname}>/images/opn.gif" onClick="<{$mydirname}>openClose('+ blockNO +');" />';
		var cvalue = 'close'
	} else {
		subblock.style.display = 'block';
		opencloseimg.innerHTML = '<img src="<{$xoops_url}>/modules/<{$mydirname}>/images/cls.gif" onClick="<{$mydirname}>openClose('+ blockNO +');" />';
		var cvalue = 'open';
	}
	<{$mydirname}>setCookie( "<{$mydirname}>_TMsitemap"+ blockNO , cvalue , 7 );
}
function <{$mydirname}>Close( blockNO ){
	var subblock = document.getElementById("<{$mydirname}>_sub"+blockNO);
	var opencloseimg = document.getElementById("<{$mydirname}>_sm_block"+blockNO);
	var cookie = <{$mydirname}>getCookie( "<{$mydirname}>_TMsitemap"+ blockNO );
	if( cookie != null && cookie =='open' ){
		subblock.style.display = 'block';
		opencloseimg.innerHTML = '<img src="<{$xoops_url}>/modules/<{$mydirname}>/images/cls.gif" onClick="<{$mydirname}>openClose('+ blockNO +');" />';
	}else{
		subblock.style.display = 'none';
		opencloseimg.innerHTML = '<img src="<{$xoops_url}>/modules/<{$mydirname}>/images/opn.gif" onClick="<{$mydirname}>openClose('+ blockNO +');" />';
	}
}
function <{$mydirname}>setCookie( cname , cvalue , expidate ){
	var expi = new Date();
	expi.setTime(expi.getTime()+(expidate*24*60*60*1000));
	var setItem = "@" + cname + "=" + escape(cvalue) + ";";
	var Expires = "expires="+expi.toGMTString();
	var Path = "; path=/";
	document.cookie =  setItem + Expires + Path ;
}
function <{$mydirname}>getCookie(cname){
	myCookie = "@" + cname + "=";
	myValue = null;
	myStr = document.cookie + ";" ;
	myOfst = myStr.indexOf(myCookie);
	if (myOfst != -1){
		myStart = myOfst + myCookie.length;
		myEnd   = myStr.indexOf(";" , myStart);
		myValue = unescape(myStr.substring(myStart,myEnd));
	}
	return myValue;
}

