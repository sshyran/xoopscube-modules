$Id: readme_jp.txt,v 1.4 2008/07/09 06:15:12 ohwada Exp $

=================================================
Version: 0.20
Date:   2008-07-09
Author: Kenichi OHWADA
URL:    http://linux.ohwada.jp/
Email:  webmaster@ohwada.jp
=================================================

�̿���ư���������륢��Хࡦ�⥸�塼��Ǥ���

�� ����ѹ�
1. ư�赡ǽ�γ�ĥ
(1) ffmpeg ��ɬ�פǤ�
http://ffmpeg.mplayerhq.hu/

(2) �������֤�ư��������
(3) ����ͥ����ư��������
(4) Flash ư���ư��������

2. Flash ư��κ���
(1) mediaplayer.swf �ˤ�����
http://www.jeroenwijering.com/?item=JW_FLV_Media_Player

3. MIME ������
(1) 3g2, 3gp, asf, flv ���ɲä���
(2) asx �ϥ᥿�������ä��Τǡ��������

4. �����ξ��� Exif ������������
(1) �桼�����̤ο�����Ͽ���ѹ�
(2) �����Բ��̤� myalbum �� imagemanger ����Υ���ݡ���
(3) �����Բ��̤β��������Ͽ
(4) �����Բ��̤Υ���ͥ���κƹ���

5. Pathinfo �����ѤǤ��ʤ��Ķ��ˤ��б�����

6. xoops_module_header ����β�������Ѱդ���

7. �Х��к�
(1) RSS �ˤ� fatal error
http://linux.ohwada.jp/modules/newbb/viewtopic.php?forum=13&topic_id=818

(2) spinner40.gif �� 404 error
http://linux.ohwada.jp/modules/newbb/viewtopic.php?forum=13&topic_id=818

(3) typo
http://linux.ohwada.jp/modules/newbb/viewtopic.php?forum=13&topic_id=821

(4) <br> �����Ϥ���
http://linux.ohwada.jp/modules/newbb/viewtopic.php?topic_id=823&forum=13

(5) imagemaneger �ˤ� fatal error

8. �ǡ����١�����¤
(1) mime �ơ��֥�� mime_ffmpeg ���ܤ��ɲä���


�� ���åץǡ���
(1) ���ह��ȡ�html �� xoops_trust_path �Σ��ĥǥ��쥯�ȥ꤬����ޤ���
���줾�졢XOOPS �γ�������ǥ��쥯�ȥ�˾�񤭤��Ƥ���������
(2)  �����Բ��̤ˤƥ⥸�塼�롦���åץǡ��Ȥ�¹Ԥ���


�� ���Ѿ�����
1. ffmpeg
ffmpeg �� �С������䥳��ѥ��롦���ץ�����ư��ۤʤ�ޤ���
Flash ư��������ˤϡ��ե����������˸��̤��б���ɬ�פˤʤ뤳�Ȥ�����ޤ���
mime �ơ��֥�� Flash ư���������Υ��ޥ�ɡ����ץ��������Ǥ��ޤ���
�ǥե���ȤǤϡ����ƤΥӥǥ��� "-ar 44100" �����ꤷ�Ƥ��ޤ���

2. xoops_module_header ����β����
�֥�å��ˤƼ̿��Υݥåץ��åפ�����ʤ����Ȥ�����ޤ���
�����Σ��Ĥˡ��ƥ�ץ졼���ѿ� xoops_module_header �λ��Ѥ�¾�Υ⥸�塼���֥�å��ȶ��礷�Ƥ��뤳�Ȥ�����ޤ���
�������򤹤���ˡ�򣲤��Ѱդ�����

2.1 ���ѤΥƥ�ץ졼���ѿ����Ѱդ�����ˡ
(1) �ơ��ޤΥƥ�ץ졼�Ȥ����ѤΥƥ�ץ졼���ѿ����ɲä���

XOOPS_ROOT_PATH/themes/�����Υơ���/theme.html
-----
<{$xoops_module_header}>
<{* �������ɵ����� *}>
<{$xoops_webphoto_header}>
-----

(2) preload �ե�������͡��ह��
XOOPS_TRUUST_PATH/modules/webphoto/preload/_constants.php (��������С�����)
 -> constants.php (��������С��ʤ�)

(3) _C_WEBPHOTO_PRELOAD_XOOPS_MODULE_HEADER ��ͭ���ˤ���
��Ƭ�� // ��������
-----
//define("_C_WEBPHOTO_PRELOAD_XOOPS_MODULE_HEADER", "xoops_webphoto_header" )
-----

(4) �����Բ��� -> �����ƥ�����ᥤ�� -> �������� �ˤ�
��themes/ �ǥ��쥯�ȥ꤫��μ�ư���åץǡ��Ȥ�ͭ���ˤ���פ�֤Ϥ��פˤ���

(5) �֥�å��ˤƼ̿��Υݥåץ��åפ���ǧ�Ǥ����顢
��themes/ �ǥ��쥯�ȥ꤫��μ�ư���åץǡ��Ȥ�ͭ���ˤ���פ�֤������פˤ���

2.2 body ���� style_sheet �� javascript �򵭽Ҥ�����ˡ
body ���� style_sheet �򵭽Ҥ���Τϡ�HTML ʸˡ��ȿ�Ǥ������֥饦����ư��ˤϻپ�ʤ��褦�Ǥ���

(1) preload �ե�������͡��ह��
XOOPS_TRUUST_PATH/modules/webphoto/preload/_constants.php (��������С�����)
 -> constants.php (��������С��ʤ�)

(2) _C_WEBPHOTO_PRELOAD_BLOCK_POPBOX_JS ��ͭ���ˤ���
��Ƭ�� // ��������
-----
//define("_C_WEBPHOTO_PRELOAD_BLOCK_POPBOX_JS", "1" )
-----


�� ���
�礭������Ϥʤ��Ϥ��Ǥ���������������Ϥ���Ȼפ��ޤ���
�������꤬�ФƤ⡢��ʬ�Ǥʤ�Ȥ������ͤΤߤ��Ȥ�����������
�Х�����Х����ʤɤϴ��ޤ��ޤ���


=================================================
Version: 0.10
Date:   2008-06-21
=================================================

�̿���ư���������륢��Хࡦ�⥸�塼��Ǥ���

����Хࡦ�⥸�塼������֤Ǥ��� myalbum �ȴ���Ū�ʻ��ͤȵ�ǽ��Ʊ���Ǥ���
�����������ۤʤ�ޤ���


�� ��ʵ�ǽ
1. myalbum ��Ѿ�������ǽ
myalbum v2.88 �����Ƥε�ǽ

2. ����ǥå�������γ�ĥ
(1) ������
(2) ���ƾ��
(3) ���Ƶ���
(4) ���������饦��
(5) ����켭��ˤ�뤢���ޤ�����

(6) GoogleMaps �б�
http://code.google.com/intl/ja/apis/maps/

(7) Exif �б�
http://ja.wikipedia.org/wiki/Exchangeable_image_file_format

3. �̿���ư���층Ū�˰�������ε�ǽ
(1) MIME�����״����δʰײ�
(2) ����ͥ�����Ͽ���ɲ�

4. ��å������󥿡��ե�����
(1) popbox.js �ˤ�� �̿��Υݥåץ��å�
(2) prototype.js �ˤ�� ɽ������ɽ�������ؤ�
(3) pathinfo �����Ѥ�����Ū�� URL

(4) piclens �б�
http://www.cooliris.com/

(5) Google �������å��б�
http://desktop.google.com/plugins/i/mediarssslideshow.html

5. RSS
(1) MediaRSS �б�
(2) GeoRSS �б�

6. ��������
(1) D3 ����
(2) �ץ���� 

7. ����¾
(1) ��䤷�ˤ����ե�����̾�κ���

8. �ǡ����١�����¤

�� myalbun ��Ѿ����� �ơ��֥�
8.1 �̿��ơ��֥� (photo table)
(1) �ᥤ������Υե�URL���Ǽ������ܤ��ɲ�
(2) ����ͥ�������Υե�URL���Ǽ������ܤ��ɲ�
(3) �������礭���ʤɤ�°�����ܤ��ɲ�
(4) ������ �ʤɤΥ���ǥå������ܤ��ɲ�
(5) �������ޥ����ѤΥƥ����ȹ��ܤ��ɲ�

8.2 ���ƥ���ơ��֥� (cat table)
(1) �������礭���ʤɤ�°�����ܤ��ɲ�
(2) �������ޥ����ѤΥƥ����ȹ��ܤ��ɲ�

8.3 ��ɼ�ơ��֥� (vote table)
����̾���ѹ����������Ƥˤ��ѹ��ʤ���

�� �ɲä����ơ��֥�
8.4 Google ��������ơ��֥� (gicon table)
Google�ޥåפΥ���������Ǽ����ơ��֥�

8.5 MIME�����ץơ��֥� (mime table)
MIME�����פ��Ǽ����ơ��֥�

8.6 �����ơ��֥� (tag table)
�������Ǽ����ơ��֥�

8.7 �̿�������Ϣ�ơ��֥� (p2te table)
�̿��ơ��֥�ȥ����ơ��֥���Ϣ�դ�����ơ��֥�

8.8 �����ơ��֥� (syno table)
�����ޤ������Τ�����������Ǽ����ơ��֥�


�� ���󥹥ȡ���
1. ���� ( xoops 2.0.16a JP ����� XOOPS Cube 2.1.x )
���ह��ȡ�html �� xoops_trust_path �Σ��ĥǥ��쥯�ȥ꤬����ޤ���
���줾�졢XOOPS �γ�������ǥ��쥯�ȥ�˳�Ǽ����������

����ȡ�����˲����Τ褦�� Warning ���Фޤ�����
ư��ˤϻپ�ʤ��Τǡ�̵�뤷�Ƥ���������
-----
Warning [Xoops]: Smarty error: unable to read resource: "db:_inc_gmap_js.html" in file class/smarty/Smarty.class.php line 1095
-----

2. xoops 2.0.18
�嵭�˲ä���
(1) preload �ե�������͡��ह��
XOOPS_TRUUST_PATH/modules/webphoto/preload/_constants.php (��������С�����)
 -> constants.php (��������С��ʤ�)

(2) _C_WEBPHOTO_PRELOAD_XOOPS_2018 ��ͭ���ˤ���
��Ƭ�� // ��������
-----
//define("_C_WEBPHOTO_PRELOAD_XOOPS_2018", 1 ) ;
-----


�� �⥸�塼��ʣ��
1. ���� ( xoops 2.0.16a JP ����� XOOPS Cube 2.1.x )
�ǥ��쥯�ȥ�򥳥ԡ���������Ǥ���

�㤨�С��ǥ��쥯�ȥ� hoge �˥��ԡ����롣
XOOPS_ROOT_PATH/modules/webphoto/* 
 -> XOOPS_ROOT_PATH/modules/hoge/* 

2. xoops 2.0.18
�嵭�˲ä��ơ��ƥ�ץ졼�ȥե�������͡��ष�Ƥ���������

XOOPS_ROOT_PATH/modules/hoge/templates/webphoto_*.html 
 -> XOOPS_ROOT_PATH/modules/hoge/templates/hoge_*.html 


�� picles
piclens ���б����Ƥ��ޤ�
http://www.cooliris.com/

RSS ��ʣ�����Ϥ��� XOOPS �����Ȥι����ˤ��Ƥ�����ϡ�
webphoto �⥸�塼��ν��Ϥ��� RSS �����ֺǽ�ˤʤ�褦�����ꤷ�Ƥ�������

�㤨�С��ơ��ޥƥ�ץ졼�Ȥ� whatsnew �⥸�塼��� RSS �����ꤷ�Ƥ�����ϡ�
�����ν��֤ˤ���

themes/xxx/theme,html
-----
<{$xoops_module_header}>

<!-- xoops_module_header �β��˵��Ҥ��� -->
<link rel="alternate" type="application/rdf+xml" title="RDF" href="<{$xoops_url}>/modules/whatsnew/rdf.php" />
<link rel="alternate" type="application/rss+xml" title="RSS" href="<{$xoops_url}>/modules/whatsnew/rss.php" />
<link rel="alternate" type="application/atom+xml" title="ATOM" href="<{$xoops_url}>/modules/whatsnew/atom.php" />
-----


�� ���
�ե륹����å��Υ���ե��ǤǤ���
�礭������Ϥʤ��Ϥ��Ǥ���������������Ϥ���Ȼפ��ޤ���
�������꤬�ФƤ⡢��ʬ�Ǥʤ�Ȥ������ͤΤߤ��Ȥ�����������
�Х�����Х����ʤɤϴ��ޤ��ޤ���
