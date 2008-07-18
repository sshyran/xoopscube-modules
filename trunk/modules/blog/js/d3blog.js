// Multiple onload function created by: Simon Willison
// http://simon.incutio.com/archive/2004/05/26/addLoadEvent
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}

//addLoadEvent(nameOfSomeFunctionToRunOnPageLoad);
addLoadEvent(function() {
  	/* more code to run on page load */
    //commentForm();
});

// figure handler
// http://code.google.com/p/easy-designs/wiki/FigureHandler
if( typeof( Prototype ) != 'undefined' &&
    typeof( FigureHandler ) != 'undefined' ){
  Event.observe( window, 'load', function(){
    new FigureHandler( 'MainColumn' ); } );
}

function loadFigureHandler() {
	if( typeof( Prototype ) != 'undefined' ){
		Event.observe( window, 'load', function(){ new FigureHandler; } );
    }
}

function hideDocumentElement(id) {
    var el = document.getElementById(id);
    if (el) el.style.display = 'none';
}

function showDocumentElement(id) {
    var el = document.getElementById(id);
    if (el) el.style.display = 'block';
}

function formValidate_d3blogForm(f) {
	myform = window.document.weblogForm;
	if (f.cid.value == "") {
	    window.alert("CATEGORY is required.");
	    f.com_text.focus();
	    return false;
	}
	if (f.title.value == "") {
	    window.alert("TITLE is required.");
	    f.title.focus();
	    return false;
	}
	if (f.contents.value == "") {
	    window.alert("CONTENTS is required.");
	    f.contents.focus();
	    return false;
	}
	return true;
}

// JS QuickTags version 1.2
//
// Copyright (c) 2002-2005 Alex King
// http://www.alexking.org/
//
// Licensed under the LGPL license
// http://www.gnu.org/copyleft/lesser.html
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
// **********************************************************************
//
// This JavaScript will insert the tags below at the cursor position in IE and
// Gecko-based browsers (Mozilla, Camino, Firefox, Netscape). For browsers that
// do not support inserting at the cursor position (Safari, OmniWeb) it appends
// the tags to the end of the content.
//
// The variable 'ed2Canvas' must be defined as the <textarea> element you want
// to be editing in. See the accompanying 'index.html' page for an example.

var ed2Buttons = new Array();
var ed2Links = new Array();
var ed2OpenTags = new Array();

function ed2Button(id, display, tagStart, tagEnd, access, open) {
    this.id = id;               // used to name the toolbar button
    this.display = display;     // label on button
    this.tagStart = tagStart;   // open tag
    this.tagEnd = tagEnd;       // close tag
    this.access = access;           // set to -1 if tag does not need to be closed
    this.open = open;           // set to -1 if tag does not need to be closed
}

ed2Buttons.push(
    new ed2Button(
        'ed2_bold'
        ,'B'
        ,'[b]'
        ,'[/b]'
        ,'b'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_italic'
        ,'I'
        ,'[i]'
        ,'[/i]'
        ,'i'
    )
);

/*ed2Buttons.push(
    new ed2Button(
        'ed2_link'
        ,'Link'
        ,''
        ,'[/url]'
        ,'a'
    )
); // special case*/
ed2Buttons.push(
    new ed2Button(
        'ed2_link'
        ,'Link'
        ,''
        ,''
        ,'a'
        ,'-1'
    )
); // special case

ed2Buttons.push(
    new ed2Button(
        'ed2_ext_link'
        ,'Ext. Link'
        ,''
        ,'[/url]'
        ,'e'
    )
); // special case

ed2Buttons.push(
    new ed2Button(
        'ed2_img'
        ,'IMG'
        ,''
        ,''
        ,'m'
        ,-1
    )
); // special case

ed2Buttons.push(
    new ed2Button(
        'ed2_ul'
        ,'UL'
        ,'[ul]\n'
        ,'[/ul]\n\n'
        ,'u'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_ol'
        ,'OL'
        ,'[ol]\n'
        ,'[/ol]\n\n'
        ,'o'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_li'
        ,'LI'
        ,'\t[li]'
        ,'[/li]\n'
        ,'l'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_block'
        ,'B-QUOTE'
        ,'[blockquote]'
        ,'[/blockquote]'
        ,'q'
    )
);

var extendedStart = ed2Buttons.length;

// below here are the extended buttons

ed2Buttons.push(
    new ed2Button(
        'ed2_h1'
        ,'H1'
        ,'[h1]'
        ,'[/h1]\n\n'
        ,'1'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_h2'
        ,'H2'
        ,'[h2]'
        ,'[/h2]\n\n'
        ,'2'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_h3'
        ,'H3'
        ,'[h3]'
        ,'[/h3]\n\n'
        ,'3'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_h4'
        ,'H4'
        ,'[h4]'
        ,'[/h4]\n\n'
        ,'4'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_p'
        ,'P'
        ,'[p]'
        ,'[/p]\n\n'
        ,'p'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_code'
        ,'CODE'
        ,'[code]'
        ,'[/code]'
        ,'c'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_pre'
        ,'PRE'
        ,'[pre]'
        ,'[/pre]'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_dl'
        ,'DL'
        ,'[dl]\n'
        ,'[/dl]\n\n'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_dt'
        ,'DT'
        ,'\t[dt]'
        ,'[/dt]\n'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_dd'
        ,'DD'
        ,'\t[dd]'
        ,'[/dd]\n'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_table'
        ,'TABLE'
        ,'[table]\n[tbody]'
        ,'[/tbody]\n[/table]\n'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_tr'
        ,'TR'
        ,'\t[tr]\n'
        ,'\n\t[/tr]\n'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_td'
        ,'TD'
        ,'\t\t[td]'
        ,'[/td]\n'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_under'
        ,'U'
        ,'[u]'
        ,'[/u]'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_strike'
        ,'S'
        ,'[s]'
        ,'[/s]'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_nobr'
        ,'NOBR'
        ,'[nobr]'
        ,'[/nobr]'
    )
);

ed2Buttons.push(
    new ed2Button(
        'ed2_footnote'
        ,'Footnote'
        ,''
        ,''
        ,'f'
    )
);

function ed2Link(display, URL, newWin) {
    this.display = display;
    this.URL = URL;
    if (!newWin) {
        newWin = 0;
    }
    this.newWin = newWin;
}


ed2Links[ed2Links.length] = new ed2Link('alexking.org'
                                    ,'http://www.alexking.org/'
                                    );

function ed2ShowButton(button, i) {
    if (button.access) {
        var accesskey = ' accesskey = "' + button.access + '"'
    }
    else {
        var accesskey = '';
    }
    switch (button.id) {
        case 'ed2_img':
            document.write('<input type="button" id="' + button.id + '" ' + accesskey + ' class="ed2_button" onclick="ed2InsertImage(ed2Canvas);" value="' + button.display + '" />');
            break;
        case 'ed2_link':
            document.write('<input type="button" id="' + button.id + '" ' + accesskey + ' class="ed2_button" onclick="ed2InsertLink(ed2Canvas, ' + i + ');" value="' + button.display + '" />');
            break;
        case 'ed2_ext_link':
            document.write('<input type="button" id="' + button.id + '" ' + accesskey + ' class="ed2_button" onclick="ed2InsertExtLink(ed2Canvas, ' + i + ');" value="' + button.display + '" />');
            break;
        case 'ed2_footnote':
            document.write('<input type="button" id="' + button.id + '" ' + accesskey + ' class="ed2_button" onclick="ed2InsertFootnote(ed2Canvas);" value="' + button.display + '" />');
            break;
        default:
            document.write('<input type="button" id="' + button.id + '" ' + accesskey + ' class="ed2_button" onclick="ed2InsertTag(ed2Canvas, ' + i + ');" value="' + button.display + '"  />');
            break;
    }
}

function ed2ShowLinks() {
    var tempStr = '<select onchange="ed2QuickLink(this.options[this.selectedIndex].value, this);"><option value="-1" selected>(Quick Links)</option>';
    for (i = 0; i < ed2Links.length; i++) {
        tempStr += '<option value="' + i + '">' + ed2Links[i].display + '</option>';
    }
    tempStr += '</select>';
    document.write(tempStr);
}

function ed2AddTag(button) {
    if (ed2Buttons[button].tagEnd != '') {
        ed2OpenTags[ed2OpenTags.length] = button;
        document.getElementById(ed2Buttons[button].id).value = '/' + document.getElementById(ed2Buttons[button].id).value;
    }
}

function ed2RemoveTag(button) {
    for (i = 0; i < ed2OpenTags.length; i++) {
        if (ed2OpenTags[i] == button) {
            ed2OpenTags.splice(i, 1);
            document.getElementById(ed2Buttons[button].id).value =       document.getElementById(ed2Buttons[button].id).value.replace('/', '');
        }
    }
}

function ed2CheckOpenTags(button) {
    var tag = 0;
    for (i = 0; i < ed2OpenTags.length; i++) {
        if (ed2OpenTags[i] == button) {
            tag++;
        }
    }
    if (tag > 0) {
        return true; // tag found
    }
    else {
        return false; // tag not found
    }
}

function ed2CloseAllTags() {
    var count = ed2OpenTags.length;
    for (o = 0; o < count; o++) {
        ed2InsertTag(ed2Canvas, ed2OpenTags[ed2OpenTags.length - 1]);
    }
}

function ed2QuickLink(i, thisSelect) {
    if (i > -1) {
        var newWin = '';
        if (ed2Links[i].newWin == 1) {
            newWin = ' target="_blank"';
        }
        var tempStr = '<a href="' + ed2Links[i].URL + '"' + newWin + '>'
                    + ed2Links[i].display
                    + '</a>';
        thisSelect.selectedIndex = 0;
        ed2InsertContent(ed2Canvas, tempStr);
    }
    else {
        thisSelect.selectedIndex = 0;
    }
}

function ed2Spell(myField) {
    var word = '';
    if (document.selection) {
        myField.focus();
        var sel = document.selection.createRange();
        if (sel.text.length > 0) {
            word = sel.text;
        }
    }
    else if (myField.selectionStart || myField.selectionStart == '0') {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        if (startPos != endPos) {
            word = myField.value.substring(startPos, endPos);
        }
    }
    if (word == '') {
        word = prompt('Enter a word to look up:', '');
    }
    if (word != '') {
        window.open('http://www.answers.com/' + escape(word));
    }
}

function ed2Toolbar() {
    document.write('<div id="ed2_toolbar"><span>');
    for (i = 0; i < extendedStart; i++) {
        ed2ShowButton(ed2Buttons[i], i);
    }
    if (ed2ShowExtraCookie()) {
        document.write(
            '<input type="button" id="ed2_close" class="ed2_button" onclick="ed2CloseAllTags();" value="Close Tags" />'
            + '<input type="button" id="ed2_spell" class="ed2_button" onclick="ed2Spell(ed2Canvas);" value="Dict" />'
            + '<input type="button" id="ed2_extra_show" class="ed2_button" onclick="ed2ShowExtra()" value="&raquo;" style="visibility: hidden;" />'
            + '</span><br />'
            + '<span id="ed2_extra_buttons">'
            + '<input type="button" id="ed2_extra_hide" class="ed2_button" onclick="ed2HideExtra();" value="&laquo;" />'
        );
    }
    else {
        document.write(
            '<input type="button" id="ed2_close" class="ed2_button" onclick="ed2CloseAllTags();" value="Close Tags" />'
            + '<input type="button" id="ed2_spell" class="ed2_button" onclick="ed2Spell(ed2Canvas);" value="Dict" />'
            + '<input type="button" id="ed2_extra_show" class="ed2_button" onclick="ed2ShowExtra()" value="&raquo;" />'
            + '</span><br />'
            + '<span id="ed2_extra_buttons" style="display: none;">'
            + '<input type="button" id="ed2_extra_hide" class="ed2_button" onclick="ed2HideExtra();" value="&laquo;" />'
        );
    }
    for (i = extendedStart; i < ed2Buttons.length; i++) {
        ed2ShowButton(ed2Buttons[i], i);
    }
    document.write('</span>');
//  ed2ShowLinks();
    document.write('</div>');
}

function ed2ShowExtra() {
    document.getElementById('ed2_extra_show').style.visibility = 'hidden';
    document.getElementById('ed2_extra_buttons').style.display = 'block';
    ed2SetCookie(
        'js_quicktags_extra'
        , 'show'
        , new Date("December 31, 2100")
    );
}

function ed2HideExtra() {
    document.getElementById('ed2_extra_buttons').style.display = 'none';
    document.getElementById('ed2_extra_show').style.visibility = 'visible';
    ed2SetCookie(
        'js_quicktags_extra'
        , 'hide'
        , new Date("December 31, 2100")
    );
}

// insertion code

function ed2InsertTag(myField, i) {
    //IE support
    if (document.selection) {
        myField.focus();
        sel = document.selection.createRange();
        if (sel.text.length > 0) {
            sel.text = ed2Buttons[i].tagStart + sel.text + ed2Buttons[i].tagEnd;
        }
        else {
            if (!ed2CheckOpenTags(i) || ed2Buttons[i].tagEnd == '') {
                sel.text = ed2Buttons[i].tagStart;
                ed2AddTag(i);
            }
            else {
                sel.text = ed2Buttons[i].tagEnd;
                ed2RemoveTag(i);
            }
        }
        myField.focus();
    }
    //MOZILLA/NETSCAPE support
    else if (myField.selectionStart || myField.selectionStart == '0') {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        var cursorPos = endPos;
        var scrollTop = myField.scrollTop;
        if (startPos != endPos) {
            myField.value = myField.value.substring(0, startPos)
                          + ed2Buttons[i].tagStart
                          + myField.value.substring(startPos, endPos)
                          + ed2Buttons[i].tagEnd
                          + myField.value.substring(endPos, myField.value.length);
            cursorPos += ed2Buttons[i].tagStart.length + ed2Buttons[i].tagEnd.length;
        }
        else {
            if (!ed2CheckOpenTags(i) || ed2Buttons[i].tagEnd == '') {
                myField.value = myField.value.substring(0, startPos)
                              + ed2Buttons[i].tagStart
                              + myField.value.substring(endPos, myField.value.length);
                ed2AddTag(i);
                cursorPos = startPos + ed2Buttons[i].tagStart.length;
            }
            else {
                myField.value = myField.value.substring(0, startPos)
                              + ed2Buttons[i].tagEnd
                              + myField.value.substring(endPos, myField.value.length);
                ed2RemoveTag(i);
                cursorPos = startPos + ed2Buttons[i].tagEnd.length;
            }
        }
        myField.focus();
        myField.selectionStart = cursorPos;
        myField.selectionEnd = cursorPos;
        myField.scrollTop = scrollTop;
    }
    else {
        if (!ed2CheckOpenTags(i) || ed2Buttons[i].tagEnd == '') {
            myField.value += ed2Buttons[i].tagStart;
            ed2AddTag(i);
        }
        else {
            myField.value += ed2Buttons[i].tagEnd;
            ed2RemoveTag(i);
        }
        myField.focus();
    }
}

function ed2InsertContent(myField, myValue) {
    //IE support
    if (document.selection) {
        myField.focus();
        sel = document.selection.createRange();
        sel.text = myValue;
        myField.focus();
    }
    //MOZILLA/NETSCAPE support
    else if (myField.selectionStart || myField.selectionStart == '0') {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        var scrollTop = myField.scrollTop;
        myField.value = myField.value.substring(0, startPos)
                      + myValue
                      + myField.value.substring(endPos, myField.value.length);
        myField.focus();
        myField.selectionStart = startPos + myValue.length;
        myField.selectionEnd = startPos + myValue.length;
        myField.scrollTop = scrollTop;
    } else {
        myField.value += myValue;
        myField.focus();
    }
}

function ed2InsertLink(myField, i, defaultValue) {
    if (!defaultValue) {
        defaultValue = 'http://';
    }
    if (!ed2CheckOpenTags(i)) {
        var URL = prompt('Enter the URL' ,defaultValue);
        if (URL) {
            var desc = prompt("Enter the Description/Reference","");
            if (desc) {
                 edButtons[i].tagStart = '[url=' + URL + ']' + desc + '[/url]';
            } else {
                edButtons[i].tagStart = '[url=' + URL + '][/url]';
            }
            edInsertTag(myField, i);

//            ed2Buttons[i].tagStart = '[url=' + URL + ']';
//            ed2InsertTag(myField, i);
        }
    }
    else {
        ed2InsertTag(myField, i);
    }
}

function ed2InsertExtLink(myField, i, defaultValue) {
    if (!defaultValue) {
        defaultValue = 'http://';
    }
    if (!ed2CheckOpenTags(i)) {
        var URL = prompt('Enter the URL' ,defaultValue);
        if (URL) {
            ed2Buttons[i].tagStart = '[url=' + URL + ' rel=external]';
            ed2InsertTag(myField, i);
        }
    }
    else {
        ed2InsertTag(myField, i);
    }
}

function ed2InsertImage(myField) {
    var myValue = prompt('Enter the URL of the image', 'http://');
    if (myValue) {
        myValue = '[img alt='
                + prompt('Enter a description of the image', '')
                + ']'
                + myValue
                + '[/img]';
        ed2InsertContent(myField, myValue);
    }
}

function ed2InsertFootnote(myField) {
    var note = prompt('Enter the footnote:', '');
    if (!note || note == '') {
        return false;
    }
    var now = new Date;
    var fnId = 'fn' + now.getTime();
    var fnStart = ed2Canvas.value.indexOf('[ol class=footnotes]');
    if (fnStart != -1) {
        var fnStr1 = ed2Canvas.value.substring(0, fnStart)
        var fnStr2 = ed2Canvas.value.substring(fnStart, ed2Canvas.value.length)
        var count = countInstances(fnStr2, '[li id=') + 1;
    }
    else {
        var count = 1;
    }
    var count = '[sup][url=#' + fnId + 'n id=' + fnId + ' class=footnote]' + count + '[/url][/sup]';
    ed2InsertContent(ed2Canvas, count);
    if (fnStart != -1) {
        fnStr1 = ed2Canvas.value.substring(0, fnStart + count.length)
        fnStr2 = ed2Canvas.value.substring(fnStart + count.length, ed2Canvas.value.length)
    }
    else {
        var fnStr1 = ed2Canvas.value;
        var fnStr2 = "\n\n" + '[ol class=footnotes]' + "\n"
                   + '[/ol]' + "\n";
    }
    var footnote = '    [li id=' + fnId + 'n]' + note + ' [[url=#' + fnId + ']back[/url]][/li]' + "\n"
                 + '[/ol]';
    ed2Canvas.value = fnStr1 + fnStr2.replace('[/ol]', footnote);
}

function countInstances(string, substr) {
    var count = string.split(substr);
    return count.length - 1;
}

function ed2SetCookie(name, value, expires, path, domain) {
    document.cookie= name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires.toGMTString() : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "");
}

function ed2ShowExtraCookie() {
    var cookies = document.cookie.split(';');
    for (var i=0;i < cookies.length; i++) {
        var cookieData = cookies[i];
        while (cookieData.charAt(0) ==' ') {
            cookieData = cookieData.substring(1, cookieData.length);
        }
        if (cookieData.indexOf('js_quicktags_extra') == 0) {
            if (cookieData.substring(19, cookieData.length) == 'show') {
                return true;
            }
            else {
                return false;
            }
        }
    }
    return false;
}