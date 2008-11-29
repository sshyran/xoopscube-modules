function onoff( elmid ){
	var chk_elm = document.getElementById( elmid+'ONOFF' );
	var onoff_elm = document.getElementById( elmid );
	if( chk_elm.checked ){
		onoff_elm.style.display = 'block';
	}else{
		onoff_elm.style.display = 'none';
	}
}

function addHTML( moto , saki ){
	var motoElm = document.getElementById(moto) ;
	var sakiElm = document.getElementById(saki) ;
	var nodeNum = sakiElm.childNodes.length ;
	var nd = document.createElement('div') ;
	var idName = moto +'_add_'+nodeNum ;
	nd.setAttribute('id',idName) ;
	sakiElm.appendChild( nd ) ;
	
	var newElm = document.getElementById(idName) ;
	newElm.innerHTML  = motoElm.innerHTML ;
	newElm.innerHTML += "\n&nbsp;<a href='javascript:void(0)' onclick='delThis(\""+idName+"\");'>DELETE</a>" ;
}

function delThis(id){
	var elm = document.getElementById(id) ;
	for(i=0;i<elm.childNodes.length;i++){
		elm.removeChild(elm.childNodes.item(i));
	}
	elm.style.height = '0' ;
}