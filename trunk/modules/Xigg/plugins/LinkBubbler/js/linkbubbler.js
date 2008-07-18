var LinkBubbler = {
  imagePath: 'plugins/LinkBubbler/images/bg.png',
  attachBubble: function(evt){
    var _ele = evt.element();
    var _a = (_ele.tagName.toLowerCase() == "a") ? _ele : _ele.up("a", 0);
    var _eleOffset = _ele.cumulativeOffset();
    var _eleDimensions = _ele.getDimensions();
    var _left = _eleOffset.left + _eleDimensions.width / 2;
    var _top = _eleOffset.top + _eleDimensions.height;
    var _img = new Element("img", {"src": "http://mozshot.nemui.org/shot?img_x=300:img_y=300;effect=true;uri=" + _a.href, "width": 300, "height": 300, "alt": _a.href}).setStyle({padding: 0, margin: 0, border: 0});
    var _div = new Element("div", {"class": "linkbubble"}).setStyle({textAlign:"center", zIndex:99999, position:"absolute", top:_top + "px", left:_left + "px", width:"300px", height:"300px", padding:0, margin:0});
    if (Client.browser == 'Internet Explorer') {
      _div.style.filter = "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + LinkBubbler.imagePath + "', sizingMethod='image')";
      _img.setStyle({marginLeft: "25px"});
    } else {
      _div.setStyle({background: "url(" + LinkBubbler.imagePath + ") no-repeat"});
    }
    _div.appendChild(_img);
    $$("body")[0].appendChild(_div);
  },
  detachBubble: function(evt){
    $$("div.linkbubble").each(function(div){div.remove();});
  },
  init: function(){
    $$("a.linkbubbler").each(function(anchor){
      anchor.observe("mouseover", LinkBubbler.attachBubble);
      anchor.observe("mouseout", LinkBubbler.detachBubble);
    });
  }
}
Event.observe(window, "load", function(){LinkBubbler.init();});