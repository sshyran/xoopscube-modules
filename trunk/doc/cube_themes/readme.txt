//  ------------------------------------------------------------------------ //
//                     XOOPS Cube/XOOPS JP Default Theme Hack Ver5.5               //
//                 Just enjoy! Internet for everyone!!                           //
//                  wanikoo < http://www.wanisys.net/ >                       //
//  ------------------------------------------------------------------------ //
//                 Based on XOOPS Cube/XOOPS JP Default Theme                     //
//                 ---JavaScript Author--                                         //
//         - prototype.js ( Sam Stephenson http://www.prototypejs.org/ )           //
//         - rico.js ( Sabre Airline Solutions http://openrico.org/rico/ )      //
//	   - Scriptaculous ( Thomas Fuchs http://script.aculo.us )		//
//	   - Prototype Window ( bastien Gruhier, http://prototype-window.xilinus.com ) //
//  ------------------------------------------------------------------------ //


With this Theme,
You can D&D(Drag and Drop)/Resize each block of your XOOPS Cube/XOOPS JP Site!
It means visitor can reorder/resize blocks freely by D&Ding each of them.

^^;;
-Ver5.5-
(cube_)dd#default themes are bug-fixed and improved! Now you can enjoy more enhanced D&Ding!
and even 
##XOOPS Cube Only!!(cube_dd4dedault theme, cube_dd6default theme)##
you can save the status of reordered blocks ( per module ) using cookie!
( a cookie will be made per your membership! 
 ex)  3_dd4theme => guest,  2_dd4theme => registered user, 1_2dd4theme => administrator
##you must install DD4themePreload.class.php, DD6themePreload.class.php into modules/legacyRender/preload/  ##
#########################
-Ver5.0-
Now you can save location/status of each window
( default : saved separately by dirname(module) 
( => if you want to keep it regardless of dirname(module), just delete <{$xoops_dirname}> ! )
(     ex) win5theme => xcubecontentwindow.setCookie('<{$xoops_dirname}>'+'win5'+'contentsectionwin');  )
and  experience new minimize/maximize function like that of prototype window
( minimize func => it works like slideup/slidedown func of my old win4theme )
( maximize func => it works like maximize/restore func of MS Windows )
and  even change style(win-theme) of each window dynamically. 
( Currently, alphacube, darkX, spread, dialog are available! ((from prototype window 1.3 package!))
-Ver4.0-
Now you can browse/experience your XOOPS Cube/XOOPS JP Site on Windows-like Interface!
(Basic Windows: Left Block Window, Right Block Window, Center Block Window, Main Content Window )
+ TrashCan Window(Trashcan function to restore closed windows).
-Ver3.0-
Now you can slide up/down each block and each blocksecton of your XOOPS Cube/XOOPS JP Site.
and 
With Handle,you can D&D(Drag and Drop) each block of your XOOPS Cube/XOOPS JP Site.
-Ver2.0-
Now you can minimize/restore each block of your XOOPS Cube/XOOPS JP Site like Windows.

-<notice>-
I changed some codes of javascript files(used in these themes)to fix some bugs and add new functions!
so...
when you use these themes, you have to use javascript files modified by me and included in this package.

------------------
Browser Support:(Firefox recommended !)
------------------
This has been tested on 
IE 5.5, IE 6, IE 7, Firefox 1.x/Win, Firefox 2.x/Win, Firefox 3.x/Win, Google Chrome, etc.(-.-;;)  
( Currently, some themes are not supported on Safari )

-------------------
How to install
------------------
Just copy each theme to /themes dir.
and..
Make it workable through Preference configuration section of Admin menu
----------------

-----------------------
<How to Use>(Ver2.0)
---------------------
D&D function
------------
When some page is loaded, 
Basically, 
each of blocks is fixed(I mean you cannot drag it)and has a Drag button.
So..
If you want to drag any block, you have to click(toggle) its Drag button.
When its Drag buttion clicked, it will be changed into the Draggable mode(I mean you can drag it now) 
and its button will be toggled into UnDrag button.
Umm...
And..
When you finish D&Ding(Drag and Drop) any block,
you should/had better make it Undraggable mode...(especially the block has form elements) 
by click(toggle)ing its UnDrag button.
( When its UnDrag button clicked, it will be changed into the Undraggable mode and its button will be toggled into Drag button. 
  Umm...if you want to D&D it again, Just click/toggle its Drag button again )
^^;;

In brief,
Just click/toggle its button!!!!!

--------------------
Resizing function
--------------
When some page is loaded, 
Basically, 
each of blocks has a Minimize button.
So..
If you want to minimize any block, you have to click(toggle) its Minimize button.
When its Minimize buttion clicked, it will be resized into the Minimized-mode 
and its button will be toggled into Restore button.
And..
When you want to restore it,
just click its Restore button and it will be restored and its buttion will be toggled into Minimize button.
( If you want to minimize it again, Just click/toggle its Minimize button again )
^^;;

In brief,
Just click/toggle its button like Windows!!!!!
----------------------

-----------------------
<change>
---------------------
<Ver5.5>
. dd2themes(dd2default theme, cube_dd2default theme) are bug-fixed and improved!  
  - javascript error(occurred in case of null element) fixed!
  - now dropOnEmpty works properly! (I mean you can D&D any block into any empty column!)
. New D&Dthemes(with new functions) added to this package.
  - cube_dd4default theme( for XOOPS Cube 2.1 ) : dd2theme + Cookie
       (### you must install DD4themePreload.class.php into modules/legacyRender/preload/ ### )
  - cube_dd5default theme( for XOOPS Cube 2.1 ) : extended dd2theme
  - cube_dd6default theme( for XOOPS Cube 2.1 ) : dd5theme(extended dd2theme) + Cookie
       (### you must install DD6themePreload.class.php into modules/legacyRender/preload/ ### )
  - dd5default theme( for XOOPS 2.0.x JP ) : extended dd2theme
   (^.^
       Cookie => you can save the status of reordered blocks ( per module ) using cookie!
       ( a cookie will be made per your membership! 
        ex)  3_dd4theme => guest,  2_dd4theme => registered user, 1_2dd4theme => administrator
       extended dd2theme => you can D&D any block into any block-column even if it's empty column originally! 
   ^.^)
<Ver5.0>
. New windows-like themes(with new functions) added to this package.
  - cube_win5default theme( for XOOPS Cube 2.1 ) : win4 + Cookie
  - cube_win6default theme( for XOOPS Cube 2.1 ) : win4 + Cookie + Resize(+)
  - cube_win7default theme( for XOOPS Cube 2.1 ) : win4 + Cookie + Resize(+) + Trashcan(+)
  - cube_win8default theme( for XOOPS Cube 2.1 ) : win4 + Cookie + Resize(+) + Trashcan(+) + Multi-theme
  - win5default theme( for XOOPS 2.0.x JP ) : win4 + Cookie
  - win6default theme( for XOOPS 2.0.x JP ) : win4 + Cookie + Resize(+)
  - win7default theme( for XOOPS 2.0.x JP ) : win4 + Cookie + Resize(+) + Trashcan(+)
  - win8default theme( for XOOPS 2.0.x JP ) : win4 + Cookie + Resize(+) + Trashcan(+) + Multi-theme
  (^.^ 
    Cookie => You can save location/status of each window
    Resize(+) => minimize/maximize func like that of prototype window )
    Trashcan(+) => Trashcan + close_all/restore_all func )
    Multi-theme => You can change style(win-theme) of each window dynamically.
  ^.^)
. All javascript files upgraded !
. theme1.css renamed into trashcan.css !
. package.ini.php replaced with manifesto.ini.php
. All themes for XOOPS 2.0.x removed to another package( xoopstheme.zip )!
   - some themes of this package doesn't work properly on latest XOOPS 2.0.x and XOOPS 2.3.x!
. some code upgraded for the latest XOOPS Cube.
. some code refined!
. etc
<Ver4.0>
.New themes(with new functions) added to this package.
(you can browse/experience your XOOPS Cube/XOOPS JP Site on Windows-like Interface!
(Basic Windows: Left Block Window, Right Block Window, Center Block Window, Main Content Window )
(All windows are draggable, resizbale, closable -common in win2 themes,win3 themes,win4 themes)
(each window has close button/slideup(minimize)button/slidedown(restore)button -common in win3 themes,win4 themes )
(+ Trashcan function to restore closed windows -common in win3 themes,win4 themes)
(each block in each window has minimize/restore button -only in win4 themes )
.bug of size3themes fixed.
( Slide up/down function of each block section didn't work properly on Firefox.)
--------
<ver3.0>
.New themes(with new functions) added to this package.
( You can slide up/down each block or each blocksecton(ex:left blocksection) of your XOOPS Cube Site. )
( With Handle,you can D&D(Drag and Drop) each block of your XOOPS Cube/XOOPS JP Site. )
--------
<ver2.0>
.most of code modified to fix some bugs of Ver1.0
( when you click/select some form elements in block, old themes behaved in a strange way. )
.Resizing function added.
(you can minimize/restore each block of your XOOPS Cube Site like Windows.)
--------
<ver1.0>
--------
.first-release with D&D(Drag and Drop) function!
----------------------


---------------------------------------------------------------------------
Themes included in this package
( All themes have been tested on latest XOOPS JP and XOOPS Cube Legacy )
------------------------------------------------------------------------------
-------------------------------------------------------------------------------
Ver5.5 New themes added to this package!
------------------------------------------------------------------------------
--------------------
cube_dd4default theme ( for XOOPS Cube 2.1 )
### you must install DD4themePreload.class.php into modules/legacyRender/preload/ ###
---------------------
Name="Default Theme-DD4(Drag and Drop with Handle, Cookie) Version"
Depends=Legacy_RenderSystem,legacy
RenderSystem=Legacy_RenderSystem
Format="XOOPS2 Legacy Style"
Version="5.5"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous, prototype and javawin
Description="Default theme-DD4(Drag and Drop with Handle, Cookie)Version of XOOPS Cube 2.1"

--------------------
cube_dd5default theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-DD5(Drag and Drop+ with Handle) Version"
Depends=Legacy_RenderSystem,legacy
RenderSystem=Legacy_RenderSystem
Format="XOOPS2 Legacy Style"
Version="5.5"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous, prototype and javawin
Description="Default theme-DD5(Drag and Drop+ with Handle)Version of XOOPS Cube 2.1"

--------------------
cube_dd6default theme ( for XOOPS Cube 2.1 )
### you must install DD6themePreload.class.php into modules/legacyRender/preload/ ###
---------------------
Name="Default Theme-DD6(Drag and Drop+ with Handle, Cookie) Version"
Depends=Legacy_RenderSystem,legacy
RenderSystem=Legacy_RenderSystem
Format="XOOPS2 Legacy Style"
Version="5.5"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous, prototype and javawin
Description="Default theme-DD6(Drag and Drop+ with Handle, Cookie)Version of XOOPS Cube 2.1"

--------------------
dd5default theme ( for XOOPS 2.0.x JP )
---------------------
Name="Default Theme-DD5(Drag and Drop+ with Handle, Cookie) Version"
Depends=Legacy_RenderSystem,legacy
RenderSystem=Legacy_RenderSystem
Format="XOOPS2 Legacy Style"
Version="5.5"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous, prototype and javawin
Description="Default theme-DD5(Drag and Drop+ with handle)Version of XOOPS 2.0 JP"


-------------------------------------------------------------------------------
Ver5.0 New themes added to this package!
------------------------------------------------------------------------------
--------------------
cube_win5default theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-Win5(Window with Trashcan, Resize and Cookie)Version"
Depends=Legacy_RenderSystem,legacy
RenderSystem=Legacy_RenderSystem
Format="XOOPS2 Legacy Style"
Version="5.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous, prototype and javawin
Description="Default theme-Win5(Window with Trashcan, Resize and Cookie)Version of XOOPS Cube2.1"

--------------------
cube_win6default theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-Win6(Window with Trashcan, Resize+ and Cookie)Version"
Depends=Legacy_RenderSystem,legacy
RenderSystem=Legacy_RenderSystem
Format="XOOPS2 Legacy Style"
Version="5.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous, prototype and javawin
Description="Default theme-Win6(Window with Trashcan, Resize+ and Cookie)Version of XOOPS Cube2.1"

--------------------
cube_win7default theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-Win7(Window with Trashcan+, Resize+ and Cookie)Version"
Depends=Legacy_RenderSystem,legacy
RenderSystem=Legacy_RenderSystem
Format="XOOPS2 Legacy Style"
Version="5.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous, prototype and javawin
Description="Default theme-Win7(Window with Trashcan+, Resize+ and Cookie)Version of XOOPS Cube2.1"

--------------------
cube_win8default theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-Win8(Window with Trashcan+, Resize+, Cookie and Multi-theme)Version"
Depends=Legacy_RenderSystem,legacy
RenderSystem=Legacy_RenderSystem
Format="XOOPS2 Legacy Style"
Version="5.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous, prototype and javawin
Description="Default theme-Win8(Window with Trashcan, Resize, Cookie and Multi-theme)Version of XOOPS Cube2.1"

--------------------
win5default theme ( for XOOPS 2.0.x JP )
---------------------
Name="Default Theme-Win5(Window with Trashcan, Resize and Cookie)Version"
Depends=Legacy_RenderSystem,legacy
RenderSystem=Legacy_RenderSystem
Format="XOOPS2 Legacy Style"
Version="5.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous, prototype and javawin
Description="Default theme-Win5(Window with Trashcan, Resize and Cookie)Version of XOOPS 2.0.x JP"

--------------------
win6default theme ( for XOOPS 2.0.x JP )
---------------------
Name="Default Theme-Win6(Window with Trashcan, Resize+ and Cookie)Version"
Depends=Legacy_RenderSystem,legacy
RenderSystem=Legacy_RenderSystem
Format="XOOPS2 Legacy Style"
Version="5.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous, prototype and javawin
Description="Default theme-Win6(Window with Trashcan, Resize+ and Cookie)Version of XOOPS 2.0.x JP"

--------------------
win7default theme ( for XOOPS 2.0.x JP )
---------------------
Name="Default Theme-Win7(Window with Trashcan+, Resize+ and Cookie)Version"
Depends=Legacy_RenderSystem,legacy
RenderSystem=Legacy_RenderSystem
Format="XOOPS2 Legacy Style"
Version="5.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous, prototype and javawin
Description="Default theme-Win7(Window with Trashcan+, Resize+ and Cookie)Version of XOOPS 2.0.x JP"

--------------------
win8default theme ( for XOOPS 2.0.x JP )
---------------------
Name="Default Theme-Win8(Window with Trashcan+, Resize+, Cookie and Multi-theme)Version"
Depends=Legacy_RenderSystem,legacy
RenderSystem=Legacy_RenderSystem
Format="XOOPS2 Legacy Style"
Version="5.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous, prototype and javawin
Description="Default theme-Win8(Window with Trashcan, Resize, Cookie and Multi-theme)Version of XOOPS 2.0.x JP"

-------------------------------------------------------------------------------
Ver4.0 New themes added to this package!
------------------------------------------------------------------------------
--------------------
cube_win2default theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-Win2(Window) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="4.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of scriptaculous, prototype and javawin
ScreenShot="screenshot.png"
Description="Default theme-Win2(Window) Version of XOOPS Cube 2.1"

--------------------
cube_win3default theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-Win3(Window with Trashcan) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="4.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of scriptaculous, prototype and javawin
ScreenShot="screenshot.png"
Description="Default theme-Win3(Window with Trashcan) Version of XOOPS Cube 2.1"

--------------------
cube_win4default theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-Win4(Window with Trashcan and Block Resize) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="4.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of scriptaculous, prototype and javawin
ScreenShot="screenshot.png"
Description="Default theme-Win4(Window with Trashcan and Block Resize) Version of XOOPS Cube 2.1"

--------------------
win2default theme ( for XOOPS 2.0.x JP )
---------------------
Name="Default Theme-Win2(Window) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="4.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of scriptaculous, prototype and javawin
ScreenShot="screenshot.png"
Description="Default theme-Win2(Window) Version of XOOPS 2.0.x JP"

--------------------
win3default theme ( for XOOPS 2.0.x JP )
---------------------
Name="Default Theme-Win3(Window with Trashcan) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="4.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of scriptaculous, prototype and javawin
ScreenShot="screenshot.png"
Description="Default theme-Win3(Window with Trashcan) Version of XOOPS 2.0.x JP"

--------------------
win4default theme ( for XOOPS 2.0.x JP )
---------------------
Name="Default Theme-Win4(Window with Trashcan and Block Resize) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="4.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of scriptaculous, prototype and javawin
ScreenShot="screenshot.png"
Description="Default theme-Win4(Window with Trashcan and Block Resize) Version of XOOPS 2.0.x JP"

--------------------------------------------------------------------------------------
-------------------------------------------------------------------------------
Ver3.0 New themes added to this package!
------------------------------------------------------------------------------
--------------------
cube_dd2default theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-DD2(Drag and Drop with Handle) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="3.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of scriptaculous and prototype
ScreenShot="screenshot.png"
Description="Default theme-DD2(Drag and Drop with Handle)Version of XOOPS Cube 2.1"

--------------------
cube_dd3default theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-DD3(Free Drag and Drop with Handle) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="3.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of scriptaculous and prototype
ScreenShot="screenshot.png"
Description="Default theme-DD3(Free Drag and Drop with Handle)Version of XOOPS Cube 2.1"

--------------------
cube_size2default theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-SIZE2(Slide Resize) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="3.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of scriptaculous and prototype
ScreenShot="screenshot.png"
Description="Default theme-SIZE2(Slide Resize) Version of XOOPS Cube 2.1"

--------------------
cube_size3default theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-SIZE3(Slide Resize Dx) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="3.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of scriptaculous and prototype
ScreenShot="screenshot.png"
Description="Default theme-SIZE (Slide Resize Dx) Version of XOOPS Cube 2.1"

------------------
dd2default theme ( for XOOPS 2.0.x JP)
-------------------
Name="Default Theme-DD2(Drag and Drop with handle)Version"
Url="http://xoopscube.org and http://www.wanisys.net"
Version="3.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous and prototype
ScreenShot="screenshot.png"
Description="Default theme-DD2(Drag and Drop with handle)Version of XOOPS 2.0 JP"
------------------
dd3default theme ( for XOOPS 2.0.x JP)
-------------------
Name="Default Theme-DD3(Free Drag and Drop with handle)Version"
Url="http://xoopscube.org and http://www.wanisys.net"
Version="3.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous and prototype
ScreenShot="screenshot.png"
Description="Default theme-DD3(Free Drag and Drop with handle)Version of XOOPS 2.0 JP"
------------------
size2default theme ( for XOOPS 2.0.x JP)
-------------------
Name="Default Theme-SIZE2(Slide Resize) Version"
Url="http://xoopscube.org and http://www.wanisys.net"
Version="3.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous and prototype
ScreenShot="screenshot.png"
Description="Default theme-SIZE2(Slide Resize) Version of XOOPS 2.0 JP"
------------------
size3default theme ( for XOOPS 2.0.x JP)
-------------------
Name="Default Theme-SIZE3(Slide Resize Dx) Version"
Url="http://xoopscube.org and http://www.wanisys.net"
Version="3.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of scriptaculous and prototype
ScreenShot="screenshot.png"
Description="Default theme-SIZE3(Slide Resize Dx) Version of XOOPS 2.0 JP"

-------------------------------------------------------------------------------

--------------------------------------------------------------------------------
Ver2.0
------------------------------------------------------------------------------
--------------------
cube_windefault theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-Win(Drag and Drop and Resizing) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="2.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of rico and prototype
ScreenShot="screenshot.png"
Description="Default theme-Win(Drag and Drop and Resizing) Version of XOOPS Cube 2.1"

------------------
windefault theme ( for XOOPS 2.0.x JP)
-------------------
Name="Default Theme-Win(Drag and Drop and Resizing) Version"
Url="http://xoopscube.org and http://www.wanisys.net"
Version="2.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of rico and prototype
ScreenShot="screenshot.png"
Description="Default theme-Win(Drag and Drop and Resizing) Version of XOOPS 2.0 JP"


--------------------------------------------------------------------------------------------
--------------------
cube_dddefault theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-DD (Drag and Drop) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="2.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of rico and prototype
ScreenShot="screenshot.png"
Description="Default theme-DD(Drag and Drop)Version of XOOPS Cube 2.1"

------------------
dddefault theme ( for XOOPS 2.0.x JP)
-------------------
Name="Default Theme-DD(Drag and Drop)Version"
Url="http://xoopscube.org and http://www.wanisys.net"
Version="2.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of rico and prototype
ScreenShot="screenshot.png"
Description="Default theme-DD(Drag and Drop)Version of XOOPS 2.0 JP"

--------------------
cube_sizedefault theme ( for XOOPS Cube 2.1 )
---------------------
Name="Default Theme-SIZE (Resizing) Version"
Depends=Legacy_RenderSystem
Url="http://xoopscube.org and http://www.wanisys.net/"
Version="2.00"
Author=XOOPS Cube Project Team and Wanikoo  and Authors of rico and prototype
ScreenShot="screenshot.png"
Description="Default theme-SIZE (Resizing) Version of XOOPS Cube 2.1"

------------------
sizedefault theme ( for XOOPS 2.0.x JP)
-------------------
Name="Default Theme-SIZE (Resizing) Version"
Url="http://xoopscube.org and http://www.wanisys.net"
Version="2.00"
Author=XOOPS Cube Project Team and Wanikoo and Authors of rico and prototype
ScreenShot="screenshot.png"
Description="Default theme-SIZE (Resizing) Version of XOOPS 2.0 JP"

-----------------------------------------------------------------------------


-----------------------------------------
Credit of Javascripts used in these themes
-----------------------------------------
prototype.js
/*  Prototype JavaScript framework
 *  (c) 2005-2008 Sam Stephenson
 *
 *  Prototype is freely distributable under the terms of an MIT-style license.
 *  For details, see the Prototype web site: http://www.prototypejs.org/
 *
 *--------------------------------------------------------------------------*/

Rico.js
/**
  *
  *  Copyright 2005 Sabre Airline Solutions
  *
  *  Licensed under the Apache License, Version 2.0 (the "License"); you may not use this
  *  file except in compliance with the License. You may obtain a copy of the License at
  *
  *         http://www.apache.org/licenses/LICENSE-2.0
  *
  *  Unless required by applicable law or agreed to in writing, software distributed under the
  *  License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND,
  *  either express or implied. See the License for the specific language governing permissions
  *  and limitations under the License.
  **/

scriptaculous.js
// Copyright (c) 2005 Thomas Fuchs (http://script.aculo.us, http://mir.aculo.us)
// MIT-style license
// Permission is hereby granted, free of charge, to any person obtaining
// a copy of this software and associated documentation files (the
// "Software"), to deal in the Software without restriction, including
// without limitation the rights to use, copy, modify, merge, publish,
// distribute, sublicense, and/or sell copies of the Software, and to
// permit persons to whom the Software is furnished to do so, subject to
// the following conditions:

window.js
// Copyright (c) 2006 bastien Gruhier (http://xilinus.com, http://itseb.com)
// MIT-style license
// Permission is hereby granted, free of charge, to any person obtaining
// a copy of this software and associated documentation files (the
// "Software"), to deal in the Software without restriction, including
// without limitation the rights to use, copy, modify, merge, publish,
// distribute, sublicense, and/or sell copies of the Software, and to
// permit persons to whom the Software is furnished to do so, subject to
// the following conditions:


PS:
-----------------------
You can easily apply these functions(D&D and Resizing) to other XOOPS(Cube) Themes!

----------------------------------------------------------------------------------
Ver5.5
---------------------------------------------------------------------------------
Basically, New themes of Ver5.5 are extended ones of dd2theme!
please refer to codes of each theme!
----------------------------------------------------------------------------------
Ver5.0
---------------------------------------------------------------------------------
Basically, Ver5.0 is extended version of Ver4.0!
please refer to Ver4.0
----------------------------------------------------------------------------------
Ver4.0
---------------------------------------------------------------------------------
You can more easily apply these functions( (Free)D&D with handle and Slide Resize of Block orBlockSection ) to other XOOPS(Cube) Themes!
1) add new css links after xoops css link (referring to theme.html of each theme.)
2) add new javascript codes after xoops_js
( please refer to theme.html of each theme ! You can easily find it. )
3) You have to environ block loop with this code!
<div id="xcubecontentsection" style="visibility:hidden;" >  ~~ </div>
*WARNING
win3 theme and win4 theme has some codes(related with trashcan func) before block-loop.
<div id="trashcan"> ~~~ </div>  
3) modify each block-loop refering  to theme.html of each theme!

I believe you can do this job easily.
Notice:
You can customize each window by modifying css file.
(I mean you can assign different css file to each window. )
(ex: basic windows use default.css and trashcan window use theme1.css. )
(For more information, please analyze window.js and theme.html of each theme )   
----------------------------------------------------------------------------------
Ver3.0
---------------------------------------------------------------------------------
You can more easily apply these functions( (Free)D&D with handle and Slide Resize of Block orBlockSection ) to other XOOPS(Cube) Themes!
1) add this after css link
<script type="text/javascript" src="<{$xoops_imageurl}>javascripts/prototype.js"></script>
<script type="text/javascript" src="<{$xoops_imageurl}>javascripts/scriptaculous.js"></script>
2) add some javascript code after xoops_js
please refer to theme.html of each theme ! You can easily find it.
3) modify each block-loop refering  to theme.html of each theme!
I believe you can do this job easily.

----------------------------------------------------------------------------------
Ver2.0
----------------------------------------------------------------------------------
--------------------------------
in case of D&D and Resizing
--------------------------------
1) add this after css link
<script type="text/javascript" src="<{$xoops_imageurl}>prototype.js"></script>
<script type="text/javascript" src="<{$xoops_imageurl}>rico.js"></script>
2) add this after xoops_js
[code]
<script type="text/javascript">
<!--
window.onload = function()
{

<{foreach name=lblockcount item=block from=$xoops_lblocks}>
dndMgr.registerDropZone( new Rico.Dropzone("ldropzone<{$smarty.foreach.lblockcount.iteration}>") );
<{/foreach}>

<{if $xoops_showcblock == 1}>
<{foreach name=ccblockcount item=block from=$xoops_ccblocks}>
dndMgr.registerDropZone( new Rico.Dropzone("ccdropzone<{$smarty.foreach.ccblockcount.iteration}>") );
<{/foreach}>
<{foreach name=clblockcount item=block from=$xoops_clblocks}>
dndMgr.registerDropZone( new Rico.Dropzone("cldropzone<{$smarty.foreach.clblockcount.iteration}>") );
<{/foreach}>
<{foreach name=crblockcount item=block from=$xoops_crblocks}>
dndMgr.registerDropZone( new Rico.Dropzone("crdropzone<{$smarty.foreach.crblockcount.iteration}>") );
<{/foreach}>
<{/if}>

<{if $xoops_showrblock == 1}>
<{foreach name=rblockcount item=block from=$xoops_rblocks}>
dndMgr.registerDropZone( new Rico.Dropzone("rdropzone<{$smarty.foreach.rblockcount.iteration}>") );
<{/foreach}>
<{/if}>

}
// -->
</script>


<script type="text/javascript">
<!--
   var selectDone = new Array();
   var myDraggable = new Array();

   function toggleSelect(type, htmlelement, selectimg, idnumber) {
      if ( !selectDone[idnumber] ) {
         registerD(type, htmlelement, idnumber);
         selectDone[idnumber] = true;
         $(selectimg).src = '<{$xoops_imageurl}>undrag.gif';
         $(selectimg).alt = 'Click me if you want to fix this block';

      }
      else {
         unregisterD(idnumber);
         selectDone[idnumber] = false;
         $(selectimg).src = '<{$xoops_imageurl}>drag.gif';
         $(selectimg).alt = 'Click me if you want to drag this block';
      }
   }

   function registerD(type, htmlelement, idnumber) {
  myDraggable[idnumber] = new Rico.Draggable(type, htmlelement)
  dndMgr.registerDraggable( myDraggable[idnumber] );
   }

   function unregisterD(idnumber) {
  dndMgr.deregisterDraggable( myDraggable[idnumber] );
   }

// -->
</script>

<script type="text/javascript">
<!--
   var startHeight = new Array();
   var effectDone = new Array();
   var original = new Array();
   function toggleEffect(resizetarget, toggleimg, idnum) {
      if ( !effectDone[idnum] ) {
         original[idnum] = $(resizetarget).innerHTML;
         $(resizetarget).innerHTML = "";
         startEffect(resizetarget);
         effectDone[idnum] = true;
         $(toggleimg).src = '<{$xoops_imageurl}>restore.gif';
         $(toggleimg).alt = 'Click me if you want to restore this block';
      }
      else {
         $(resizetarget).innerHTML = original[idnum];
         resetEffect(resizetarget);
         effectDone[idnum] = false;
         $(toggleimg).src = '<{$xoops_imageurl}>minimize.gif';
         $(toggleimg).alt = 'Click me if you want to minimize this block';
      }
   }

   function startEffect(resizetarget) {
      startHeight = $(resizetarget).offsetHeight;
      new Rico.Effect.Size( $(resizetarget), null, 0, 500, 10, {complete:function() {setStatus();}} );
   }

   function setStatus() {
   }

   function resetEffect(resizetarget) {
      $(resizetarget).style.height = startHeight;
   }
// -->
</script>
[/code]
3) modify each block-loop like this!
ex)
[code]
  <table cellspacing="0">
    <tr>
      <td id="leftcolumn">
        <!-- Start left blocks loop -->
        <{foreach name=lblockloop item=block from=$xoops_lblocks}>
	<div id="ldropzone<{$smarty.foreach.lblockloop.iteration}>">
	<div id="DDlblock<{$smarty.foreach.lblockloop.iteration}>">
	<div class="blockTitle">
	<{$block.title}>
	<a href="javascript:toggleSelect('xoopsDDlblock<{$smarty.foreach.lblockloop.iteration}>', 'DDlblock<{$smarty.foreach.lblockloop.iteration}>', 'ldragimage<{$smarty.foreach.lblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration}> );"><img id="ldragimage<{$smarty.foreach.lblockloop.iteration}>" src="<{$xoops_imageurl}>drag.gif" alt="Click me if you want to drag this block" /></a>&nbsp;<a href="javascript:toggleEffect('resizelblock<{$smarty.foreach.lblockloop.iteration}>', 'lsizeimage<{$smarty.foreach.lblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration}>)"><img id="lsizeimage<{$smarty.foreach.lblockloop.iteration}>" src="<{$xoops_imageurl}>minimize.gif" alt="Click me if you want to minimize this block" /></a>
	</div>
	<div id="resizelblock<{$smarty.foreach.lblockloop.iteration}>" class="blockContent">
	<{$block.content}>
	</div>
	</div>
	</div>
        <{/foreach}>
        <!-- End left blocks loop -->

      </td>

      <td id="centercolumn">

        <!-- Display center blocks if any -->
        <{if $xoops_showcblock == 1}>

        <table cellspacing="0">
          <tr>
            <td id="centerCcolumn" colspan="2">

            <!-- Start center-center blocks loop -->
            <{foreach name=ccblockloop item=block from=$xoops_ccblocks}>
	<div id="ccdropzone<{$smarty.foreach.ccblockloop.iteration}>">
	<div id="DDccblock<{$smarty.foreach.ccblockloop.iteration}>">
	<div style="padding: 5px;">
  	<fieldset>
    	<legend class="blockTitle"><{$block.title}>
	<a href="javascript:toggleSelect('xoopsDDccblock<{$smarty.foreach.ccblockloop.iteration}>', 'DDccblock<{$smarty.foreach.ccblockloop.iteration}>', 'ccdragimage<{$smarty.foreach.ccblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration}> );"><img id="ccdragimage<{$smarty.foreach.ccblockloop.iteration}>" src="<{$xoops_imageurl}>drag.gif" alt="Click me if you want to drag this block" /></a>&nbsp;<a href="javascript:toggleEffect('resizeccblock<{$smarty.foreach.ccblockloop.iteration}>', 'ccsizeimage<{$smarty.foreach.ccblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration}>)"><img id="ccsizeimage<{$smarty.foreach.ccblockloop.iteration}>" src="<{$xoops_imageurl}>minimize.gif" alt="Click me if you want to minimize this block" /></a>
	</legend>
    	<div  id="resizeccblock<{$smarty.foreach.ccblockloop.iteration}>" class="blockContent"><{$block.content}></div>
  	</fieldset>
	</div>
	</div>
	</div>
            <{/foreach}>
            <!-- End center-center blocks loop -->

            </td>
          </tr>
          <tr>
            <td id="centerLcolumn">

            <!-- Start center-left blocks loop -->
              <{foreach name=clblockloop item=block from=$xoops_clblocks}>
	<div id="cldropzone<{$smarty.foreach.clblockloop.iteration}>">
	<div id="DDclblock<{$smarty.foreach.clblockloop.iteration}>">
	<div style="padding: 0px 0px 0px 8px;">
  	<fieldset>
    	<legend class="blockTitle"><{$block.title}>
	<a href="javascript:toggleSelect('xoopsDDclblock<{$smarty.foreach.clblockloop.iteration}>', 'DDclblock<{$smarty.foreach.clblockloop.iteration}>', 'cldragimage<{$smarty.foreach.clblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration+$smarty.foreach.clblockloop.iteration}> );"><img id="cldragimage<{$smarty.foreach.clblockloop.iteration}>" src="<{$xoops_imageurl}>drag.gif" alt="Click me if you want to drag this block" /></a>&nbsp;<a href="javascript:toggleEffect('resizeclblock<{$smarty.foreach.clblockloop.iteration}>', 'clsizeimage<{$smarty.foreach.clblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration+$smarty.foreach.clblockloop.iteration}>)"><img id="clsizeimage<{$smarty.foreach.clblockloop.iteration}>" src="<{$xoops_imageurl}>minimize.gif" alt="Click me if you want to minimize this block" /></a>
	</legend>
    	<div  id="resizeclblock<{$smarty.foreach.clblockloop.iteration}>" class="blockContent"><{$block.content}></div>
  	</fieldset>
	</div>
	</div>
	</div>
              <{/foreach}>
            <!-- End center-left blocks loop -->

            </td><td id="centerRcolumn">

            <!-- Start center-right blocks loop -->
              <{foreach name=crblockloop item=block from=$xoops_crblocks}>
	<div id="crdropzone<{$smarty.foreach.crblockloop.iteration}>">
	<div id="DDcrblock<{$smarty.foreach.crblockloop.iteration}>">
	<div style="padding: 0px 5px 0px 0px;">
  	<fieldset>
    	<legend class="blockTitle"><{$block.title}>
	<a href="javascript:toggleSelect('xoopsDDcrblock<{$smarty.foreach.crblockloop.iteration}>', 'DDcrblock<{$smarty.foreach.crblockloop.iteration}>', 'crdragimage<{$smarty.foreach.crblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration+$smarty.foreach.clblockloop.iteration+$smarty.foreach.crblockloop.iteration}> );"><img id="crdragimage<{$smarty.foreach.crblockloop.iteration}>" src="<{$xoops_imageurl}>drag.gif" alt="Click me if you want to drag this block" /></a>&nbsp;<a href="javascript:toggleEffect('resizecrblock<{$smarty.foreach.crblockloop.iteration}>', 'crsizeimage<{$smarty.foreach.crblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration+$smarty.foreach.clblockloop.iteration+$smarty.foreach.crblockloop.iteration}>)"><img id="crsizeimage<{$smarty.foreach.crblockloop.iteration}>" src="<{$xoops_imageurl}>minimize.gif" alt="Click me if you want to minimize this block" /></a>
	</legend>
    	<div  id="resizecrblock<{$smarty.foreach.crblockloop.iteration}>" class="blockContent"><{$block.content}></div>
  	</fieldset>
	</div>
	</div>
	</div>
              <{/foreach}>
            <!-- End center-right blocks loop -->

            </td>
          </tr>
        </table>

        <{/if}>
        <!-- End display center blocks -->

        <div id="content">
          <{$xoops_contents}>
        </div>
      </td>

      <{if $xoops_showrblock == 1}>

      <td id="rightcolumn">
        <!-- Start right blocks loop -->
        <{foreach name=rblockloop item=block from=$xoops_rblocks}>
	<div id="rdropzone<{$smarty.foreach.rblockloop.iteration}>">
	<div id="DDrblock<{$smarty.foreach.rblockloop.iteration}>">
	<div class="blockTitle"><{$block.title}>
	<a href="javascript:toggleSelect('xoopsDDrblock<{$smarty.foreach.rblockloop.iteration}>', 'DDrblock<{$smarty.foreach.rblockloop.iteration}>', 'rdragimage<{$smarty.foreach.rblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration+$smarty.foreach.clblockloop.iteration+$smarty.foreach.crblockloop.iteration+$smarty.foreach.rblockloop.iteration}> );"><img id="rdragimage<{$smarty.foreach.rblockloop.iteration}>" src="<{$xoops_imageurl}>drag.gif" alt="Click me if you want to drag this block" /></a>&nbsp;<a href="javascript:toggleEffect('resizerblock<{$smarty.foreach.rblockloop.iteration}>', 'rsizeimage<{$smarty.foreach.rblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration+$smarty.foreach.clblockloop.iteration+$smarty.foreach.crblockloop.iteration+$smarty.foreach.rblockloop.iteration}>)"><img id="rsizeimage<{$smarty.foreach.rblockloop.iteration}>" src="<{$xoops_imageurl}>minimize.gif" alt="Click me if you want to minimize this block" /></a>
	</div>
    	<div  id="resizerblock<{$smarty.foreach.rblockloop.iteration}>" class="blockContent"><{$block.content}></div>
	</div>
	</div>
        <{/foreach}>
        <!-- End right blocks loop -->
      </td>

      <{/if}>

    </tr>
  </table>
[/code]
4)That's all! Just enjoy!!

--------------------------------
in case of only D&D
--------------------------------
1) add this after css link
<script type="text/javascript" src="<{$xoops_imageurl}>prototype.js"></script>
<script type="text/javascript" src="<{$xoops_imageurl}>rico.js"></script>
2) add this after xoops_js
[code]
<script type="text/javascript">
<!--
window.onload = function()
{

<{foreach name=lblockcount item=block from=$xoops_lblocks}>
dndMgr.registerDropZone( new Rico.Dropzone("ldropzone<{$smarty.foreach.lblockcount.iteration}>") );
<{/foreach}>

<{if $xoops_showcblock == 1}>
<{foreach name=ccblockcount item=block from=$xoops_ccblocks}>
dndMgr.registerDropZone( new Rico.Dropzone("ccdropzone<{$smarty.foreach.ccblockcount.iteration}>") );
<{/foreach}>
<{foreach name=clblockcount item=block from=$xoops_clblocks}>
dndMgr.registerDropZone( new Rico.Dropzone("cldropzone<{$smarty.foreach.clblockcount.iteration}>") );
<{/foreach}>
<{foreach name=crblockcount item=block from=$xoops_crblocks}>
dndMgr.registerDropZone( new Rico.Dropzone("crdropzone<{$smarty.foreach.crblockcount.iteration}>") );
<{/foreach}>
<{/if}>

<{if $xoops_showrblock == 1}>
<{foreach name=rblockcount item=block from=$xoops_rblocks}>
dndMgr.registerDropZone( new Rico.Dropzone("rdropzone<{$smarty.foreach.rblockcount.iteration}>") );
<{/foreach}>
<{/if}>

}
// -->
</script>


<script type="text/javascript">
<!--
   var selectDone = new Array();
   var myDraggable = new Array();

   function toggleSelect(type, htmlelement, selectimg, idnumber) {
      if ( !selectDone[idnumber] ) {
         registerD(type, htmlelement, idnumber);
         selectDone[idnumber] = true;
         $(selectimg).src = '<{$xoops_imageurl}>undrag.gif';
         $(selectimg).alt = 'Click me if you want to fix this block';

      }
      else {
         unregisterD(idnumber);
         selectDone[idnumber] = false;
         $(selectimg).src = '<{$xoops_imageurl}>drag.gif';
         $(selectimg).alt = 'Click me if you want to drag this block';
      }
   }

   function registerD(type, htmlelement, idnumber) {
  myDraggable[idnumber] = new Rico.Draggable(type, htmlelement)
  dndMgr.registerDraggable( myDraggable[idnumber] );
   }

   function unregisterD(idnumber) {
  dndMgr.deregisterDraggable( myDraggable[idnumber] );
   }

// -->
</script>
[/code]
3) modify each block-loop like this!
ex)
[code]
  <table cellspacing="0">
    <tr>
      <td id="leftcolumn">
        <!-- Start left blocks loop -->
        <{foreach name=lblockloop item=block from=$xoops_lblocks}>
	<div id="ldropzone<{$smarty.foreach.lblockloop.iteration}>">
	<div id="DDlblock<{$smarty.foreach.lblockloop.iteration}>">
	<div class="blockTitle">
	<{$block.title}>
	<a href="javascript:toggleSelect('xoopsDDlblock<{$smarty.foreach.lblockloop.iteration}>', 'DDlblock<{$smarty.foreach.lblockloop.iteration}>', 'ldragimage<{$smarty.foreach.lblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration}> );"><img id="ldragimage<{$smarty.foreach.lblockloop.iteration}>" src="<{$xoops_imageurl}>drag.gif" alt="Click me if you want to drag this block" /></a>
	</div>
	<div class="blockContent">
	<{$block.content}>
	</div>
	</div>
	</div>
        <{/foreach}>
        <!-- End left blocks loop -->

      </td>

      <td id="centercolumn">

        <!-- Display center blocks if any -->
        <{if $xoops_showcblock == 1}>

        <table cellspacing="0">
          <tr>
            <td id="centerCcolumn" colspan="2">

            <!-- Start center-center blocks loop -->
            <{foreach name=ccblockloop item=block from=$xoops_ccblocks}>
	<div id="ccdropzone<{$smarty.foreach.ccblockloop.iteration}>">
	<div id="DDccblock<{$smarty.foreach.ccblockloop.iteration}>">
	<div style="padding: 5px;">
  	<fieldset>
    	<legend class="blockTitle"><{$block.title}>
	<a href="javascript:toggleSelect('xoopsDDccblock<{$smarty.foreach.ccblockloop.iteration}>', 'DDccblock<{$smarty.foreach.ccblockloop.iteration}>', 'ccdragimage<{$smarty.foreach.ccblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration}> );"><img id="ccdragimage<{$smarty.foreach.ccblockloop.iteration}>" src="<{$xoops_imageurl}>drag.gif" alt="Click me if you want to drag this block" /></a>
	</legend>
    	<div class="blockContent"><{$block.content}></div>
  	</fieldset>
	</div>
	</div>
	</div>
            <{/foreach}>
            <!-- End center-center blocks loop -->

            </td>
          </tr>
          <tr>
            <td id="centerLcolumn">

            <!-- Start center-left blocks loop -->
              <{foreach name=clblockloop item=block from=$xoops_clblocks}>
	<div id="cldropzone<{$smarty.foreach.clblockloop.iteration}>">
	<div id="DDclblock<{$smarty.foreach.clblockloop.iteration}>">
	<div style="padding: 0px 0px 0px 8px;">
  	<fieldset>
    	<legend class="blockTitle"><{$block.title}>
	<a href="javascript:toggleSelect('xoopsDDclblock<{$smarty.foreach.clblockloop.iteration}>', 'DDclblock<{$smarty.foreach.clblockloop.iteration}>', 'cldragimage<{$smarty.foreach.clblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration+$smarty.foreach.clblockloop.iteration}> );"><img id="cldragimage<{$smarty.foreach.clblockloop.iteration}>" src="<{$xoops_imageurl}>drag.gif" alt="Click me if you want to drag this block" /></a>
	</legend>
    	<div class="blockContent"><{$block.content}></div>
  	</fieldset>
	</div>
	</div>
	</div>
              <{/foreach}>
            <!-- End center-left blocks loop -->

            </td><td id="centerRcolumn">

            <!-- Start center-right blocks loop -->
              <{foreach name=crblockloop item=block from=$xoops_crblocks}>
	<div id="crdropzone<{$smarty.foreach.crblockloop.iteration}>">
	<div id="DDcrblock<{$smarty.foreach.crblockloop.iteration}>">
	<div style="padding: 0px 5px 0px 0px;">
  	<fieldset>
    	<legend class="blockTitle"><{$block.title}>
	<a href="javascript:toggleSelect('xoopsDDcrblock<{$smarty.foreach.crblockloop.iteration}>', 'DDcrblock<{$smarty.foreach.crblockloop.iteration}>', 'crdragimage<{$smarty.foreach.crblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration+$smarty.foreach.clblockloop.iteration+$smarty.foreach.crblockloop.iteration}> );"><img id="crdragimage<{$smarty.foreach.crblockloop.iteration}>" src="<{$xoops_imageurl}>drag.gif" alt="Click me if you want to drag this block" /></a>
	</legend>
    	<div class="blockContent"><{$block.content}></div>
  	</fieldset>
	</div>
	</div>
	</div>
              <{/foreach}>
            <!-- End center-right blocks loop -->

            </td>
          </tr>
        </table>

        <{/if}>
        <!-- End display center blocks -->

        <div id="content">
          <{$xoops_contents}>
        </div>
      </td>

      <{if $xoops_showrblock == 1}>

      <td id="rightcolumn">
        <!-- Start right blocks loop -->
        <{foreach name=rblockloop item=block from=$xoops_rblocks}>
	<div id="rdropzone<{$smarty.foreach.rblockloop.iteration}>">
	<div id="DDrblock<{$smarty.foreach.rblockloop.iteration}>">
	<div class="blockTitle"><{$block.title}>
	<a href="javascript:toggleSelect('xoopsDDrblock<{$smarty.foreach.rblockloop.iteration}>', 'DDrblock<{$smarty.foreach.rblockloop.iteration}>', 'rdragimage<{$smarty.foreach.rblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration+$smarty.foreach.clblockloop.iteration+$smarty.foreach.crblockloop.iteration+$smarty.foreach.rblockloop.iteration}> );"><img id="rdragimage<{$smarty.foreach.rblockloop.iteration}>" src="<{$xoops_imageurl}>drag.gif" alt="Click me if you want to drag this block" /></a>
	</div>
    	<div class="blockContent"><{$block.content}></div>
	</div>
	</div>
        <{/foreach}>
        <!-- End right blocks loop -->
      </td>

      <{/if}>

    </tr>
  </table>
[/code]
4)That's all! Just enjoy!!

--------------------------------
in case of only Resizing
--------------------------------
1) add this after css link
<script type="text/javascript" src="<{$xoops_imageurl}>prototype.js"></script>
<script type="text/javascript" src="<{$xoops_imageurl}>rico.js"></script>
2) add this after xoops_js
[code]
<script type="text/javascript">
<!--
   var startHeight = new Array();
   var effectDone = new Array();
   var original = new Array();
   function toggleEffect(resizetarget, toggleimg, idnum) {
      if ( !effectDone[idnum] ) {
         original[idnum] = $(resizetarget).innerHTML;
         $(resizetarget).innerHTML = "";
         startEffect(resizetarget);
         effectDone[idnum] = true;
         $(toggleimg).src = '<{$xoops_imageurl}>restore.gif';
         $(toggleimg).alt = 'Click me if you want to restore this block';
      }
      else {
         $(resizetarget).innerHTML = original[idnum];
         resetEffect(resizetarget);
         effectDone[idnum] = false;
         $(toggleimg).src = '<{$xoops_imageurl}>minimize.gif';
         $(toggleimg).alt = 'Click me if you want to minimize this block';
      }
   }

   function startEffect(resizetarget) {
      startHeight = $(resizetarget).offsetHeight;
      new Rico.Effect.Size( $(resizetarget), null, 0, 500, 10, {complete:function() {setStatus();}} );
   }

   function setStatus() {
   }

   function resetEffect(resizetarget) {
      $(resizetarget).style.height = startHeight;
   }
// -->
</script>
[/code]
3) modify each block-loop like this!
ex)
[code]
  <table cellspacing="0">
    <tr>
      <td id="leftcolumn">
        <!-- Start left blocks loop -->
        <{foreach name=lblockloop item=block from=$xoops_lblocks}>
	<div class="blockTitle">
	<{$block.title}>
	<a href="javascript:toggleEffect('resizelblock<{$smarty.foreach.lblockloop.iteration}>', 'lsizeimage<{$smarty.foreach.lblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration}>)"><img id="lsizeimage<{$smarty.foreach.lblockloop.iteration}>" src="<{$xoops_imageurl}>minimize.gif" alt="Click me if you want to minimize this block" /></a>
	</div>
	<div id="resizelblock<{$smarty.foreach.lblockloop.iteration}>" class="blockContent">
	<{$block.content}>
	</div>
        <{/foreach}>
        <!-- End left blocks loop -->

      </td>

      <td id="centercolumn">

        <!-- Display center blocks if any -->
        <{if $xoops_showcblock == 1}>

        <table cellspacing="0">
          <tr>
            <td id="centerCcolumn" colspan="2">

            <!-- Start center-center blocks loop -->
            <{foreach name=ccblockloop item=block from=$xoops_ccblocks}>
	<div style="padding: 5px;">
  	<fieldset>
    	<legend class="blockTitle"><{$block.title}>
	<a href="javascript:toggleEffect('resizeccblock<{$smarty.foreach.ccblockloop.iteration}>', 'ccsizeimage<{$smarty.foreach.ccblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration}>)"><img id="ccsizeimage<{$smarty.foreach.ccblockloop.iteration}>" src="<{$xoops_imageurl}>minimize.gif" alt="Click me if you want to minimize this block" /></a>
	</legend>
    	<div  id="resizeccblock<{$smarty.foreach.ccblockloop.iteration}>" class="blockContent"><{$block.content}></div>
  	</fieldset>
	</div>
            <{/foreach}>
            <!-- End center-center blocks loop -->

            </td>
          </tr>
          <tr>
            <td id="centerLcolumn">

            <!-- Start center-left blocks loop -->
              <{foreach name=clblockloop item=block from=$xoops_clblocks}>
	<div style="padding: 0px 0px 0px 8px;">
  	<fieldset>
    	<legend class="blockTitle"><{$block.title}>
	<a href="javascript:toggleEffect('resizeclblock<{$smarty.foreach.clblockloop.iteration}>', 'clsizeimage<{$smarty.foreach.clblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration+$smarty.foreach.clblockloop.iteration}>)"><img id="clsizeimage<{$smarty.foreach.clblockloop.iteration}>" src="<{$xoops_imageurl}>minimize.gif" alt="Click me if you want to minimize this block" /></a>
	</legend>
    	<div  id="resizeclblock<{$smarty.foreach.clblockloop.iteration}>" class="blockContent"><{$block.content}></div>
  	</fieldset>
	</div>
              <{/foreach}>
            <!-- End center-left blocks loop -->

            </td><td id="centerRcolumn">

            <!-- Start center-right blocks loop -->
              <{foreach name=crblockloop item=block from=$xoops_crblocks}>
	<div style="padding: 0px 5px 0px 0px;">
  	<fieldset>
    	<legend class="blockTitle"><{$block.title}>
	<a href="javascript:toggleEffect('resizecrblock<{$smarty.foreach.crblockloop.iteration}>', 'crsizeimage<{$smarty.foreach.crblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration+$smarty.foreach.clblockloop.iteration+$smarty.foreach.crblockloop.iteration}>)"><img id="crsizeimage<{$smarty.foreach.crblockloop.iteration}>" src="<{$xoops_imageurl}>minimize.gif" alt="Click me if you want to minimize this block" /></a>
	</legend>
    	<div  id="resizecrblock<{$smarty.foreach.crblockloop.iteration}>" class="blockContent"><{$block.content}></div>
  	</fieldset>
	</div>
              <{/foreach}>
            <!-- End center-right blocks loop -->

            </td>
          </tr>
        </table>

        <{/if}>
        <!-- End display center blocks -->

        <div id="content">
          <{$xoops_contents}>
        </div>
      </td>

      <{if $xoops_showrblock == 1}>

      <td id="rightcolumn">
        <!-- Start right blocks loop -->
        <{foreach name=rblockloop item=block from=$xoops_rblocks}>
	<div class="blockTitle"><{$block.title}>
	<a href="javascript:toggleEffect('resizerblock<{$smarty.foreach.rblockloop.iteration}>', 'rsizeimage<{$smarty.foreach.rblockloop.iteration}>', <{$smarty.foreach.lblockloop.iteration+$smarty.foreach.ccblockloop.iteration+$smarty.foreach.clblockloop.iteration+$smarty.foreach.crblockloop.iteration+$smarty.foreach.rblockloop.iteration}>)"><img id="rsizeimage<{$smarty.foreach.rblockloop.iteration}>" src="<{$xoops_imageurl}>minimize.gif" alt="Click me if you want to minimize this block" /></a>
	</div>
    	<div  id="resizerblock<{$smarty.foreach.rblockloop.iteration}>" class="blockContent"><{$block.content}></div>
        <{/foreach}>
        <!-- End right blocks loop -->
      </td>

      <{/if}>

    </tr>
  </table>
[/code]
4)That's all! Just enjoy!!
--------------------------------------------

From wanikoo

the most educational site, wanisys.net
