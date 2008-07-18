function lightwindowInit(lwDir)
{
    new lightwindow({
        resizeSpeed : 8,
        overlay: {
            opacity : 0.7,
            image: lwDir + '/images/black.png',
            presetImage: lwDir + '/images/black-70.png'
        },
        skin: 	{
            main: 	'<div id="lightwindow_container" >'+
							'<div id="lightwindow_title_bar" >'+
								'<div id="lightwindow_title_bar_inner" >'+
									'<span id="lightwindow_title_bar_title"></span>'+
									'<a id="lightwindow_title_bar_close_link" >close</a>'+
								'</div>'+
							'</div>'+
							'<div id="lightwindow_stage" >'+
								'<div id="lightwindow_contents" >'+
								'</div>'+
								'<div id="lightwindow_navigation" >'+
									'<a href="#" id="lightwindow_previous" >'+
										'<span id="lightwindow_previous_title"></span>'+
									'</a>'+
									'<a href="#" id="lightwindow_next" >'+
										'<span id="lightwindow_next_title"></span>'+
									'</a>'+
									'<iframe name="lightwindow_navigation_shim" id="lightwindow_navigation_shim" src="javascript:false;" frameBorder="0" scrolling="no"></iframe>'+
								'</div>'+
								'<div id="lightwindow_galleries">'+
									'<div id="lightwindow_galleries_tab_container" >'+
										'<a href="#" id="lightwindow_galleries_tab" >'+
											'<span id="lightwindow_galleries_tab_span" class="up" >Galleries</span>'+
										'</a>'+
									'</div>'+
									'<div id="lightwindow_galleries_list" >'+
									'</div>'+
								'</div>'+
							'</div>'+
							'<div id="lightwindow_data_slide" >'+
								'<div id="lightwindow_data_slide_inner" >'+
									'<div id="lightwindow_data_details" >'+
										'<div id="lightwindow_data_gallery_container" >'+
											'<span id="lightwindow_data_gallery_current"></span>'+
											' of '+
											'<span id="lightwindow_data_gallery_total"></span>'+
										'</div>'+
										'<div id="lightwindow_data_author_container" >'+
											'by <span id="lightwindow_data_author"></span>'+
										'</div>'+
									'</div>'+
									'<div id="lightwindow_data_caption" >'+
									'</div>'+
								'</div>'+
							'</div>'+
						'</div>',
            loading: 	'<div id="lightwindow_loading" >'+
								'<img src="' + lwDir + '/images/ajax-loading.gif" alt="loading" />'+
								'<span>Loading or <a href="javascript: myLightWindow.deactivate();">Cancel</a></span>'+
								'<iframe name="lightwindow_loading_shim" id="lightwindow_loading_shim" src="javascript:false;" frameBorder="0" scrolling="no"></iframe>'+
							'</div>',
            iframe: 	'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'+
							'<html xmlns="http://www.w3.org/1999/xhtml">'+
								'<body>'+
									'{body_replace}'+
								'</body>'+
							'</html>',
            gallery: {
                top:        '<div class="lightwindow_galleries_list">'+
                                '<h1>{gallery_title_replace}</h1>'+
                                '<ul>',
                middle:             '<li>' + '{gallery_link_replace}' + '</li>',
                bottom:         '</ul>'+
                            '</div>'
            }
        },
    });
}