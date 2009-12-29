function fckeditor_exec(width, height, url) {
	var area_width = width;
	var area_height = height;
	var xoops_url = url;
	var oFCKeditor = new FCKeditor( "contents", area_width, area_height, "Default" );
	oFCKeditor.BasePath = xoops_url + "/common/fckeditor/";
	oFCKeditor.ReplaceTextarea();
}