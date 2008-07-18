<?php
/**
 * HSP キーワード定義ファイル
 */

$switchHash['\''] = $this->cont['PLUGIN_CODE_NONESCAPE_LITERAL'];   // " は非エスケープ文字
$switchHash['#'] = $this->cont['PLUGIN_CODE_SPECIAL_IDENTIFIRE'];  // # から始まる予約語あり
$switchHash['*'] = $this->cont['PLUGIN_CODE_SPECIAL_IDENTIFIRE'];  // * から始まるのはラベル
$capital = 1;                    // 予約語の大文字小文字を区別しない

// コメント定義
$switchHash['/'] = $this->cont['PLUGIN_CODE_COMMENT'];     // コメントは /* から */ までと // から改行までと
$switchHash[';'] = $this->cont['PLUGIN_CODE_COMMENT'];     // コメントは ; から改行まで
$code_comment = Array(
	'/' => Array(
				 Array('/^\/\*/', '*/', 2),
				 Array('/^\/\//', "\n", 1),
	),
	';' => Array(
				 Array('/^;/', "\n", 1),
	)
);

// アウトライン用
if($mkoutline){
  $switchHash['{'] = $this->cont['PLUGIN_CODE_BLOCK_START'];
  $switchHash['}'] = $this->cont['PLUGIN_CODE_BLOCK_END'];
}

$code_css = Array(
  'operator',		// オペレータ関数
  'identifier',	// その他の識別子
  'pragma',		// module, import と pragma
  'system',		// 処理系組み込みの奴 __stdcall とか
  );

$code_keyword = Array(
	'_break' => 2,
	'_clrobj' => 2,
	'_cls' => 2,
	'_continue' => 2,
	'_makewnd' => 2,
	'_objsel' => 2,
	'about' => 2,
	'addbg' => 2,
	'addbox' => 2,
	'addmesh' => 2,
	'addplate' => 2,
	'addspr' => 2,
	'alloc' => 2,
	'aplact' => 2,
	'apledit' => 2,
	'aplfocus' => 2,
	'aplget' => 2,
	'aplkey' => 2,
	'aplkeyd' => 2,
	'aplkeyu' => 2,
	'aplobj' => 2,
	'aplsel' => 2,
	'aplstr' => 2,
	'await' => 2,
	'bcopy' => 2,
	'bgscr' => 2,
	'bload' => 2,
	'bmpsave' => 2,
	'boxf' => 2,
	'break' => 2,
	'bsave' => 2,
	'btnimg' => 2,
	'buffer' => 2,
	'button' => 2,
	'bval' => 2,
	'cammode' => 2,
	'case' => 2,
	'charlower' => 2,
	'charupper' => 2,
	'chdir' => 2,
	'chgdisp' => 2,
	'chkbox' => 2,
	'clipget' => 2,
	'clipset' => 2,
	'clipsetg' => 2,
	'clrobj' => 2,
	'cls' => 2,
	'clsblur' => 2,
	'clscolor' => 2,
	'clstex' => 2,
	'cmdline' => 2,
	'cnt' => 2,
	'color' => 2,
	'combox' => 2,
	'comclose' => 2,
	'comget' => 2,
	'comgetc' => 2,
	'comopen' => 2,
	'comput' => 2,
	'computc' => 2,
	'console' => 2,
	'console_color' => 2,
	'console_end' => 2,
	'console_pos' => 2,
	'continue' => 2,
	'copybuf' => 2,
	'csrx' => 2,
	'csry' => 2,
	'csvfind' => 2,
	'csvflag' => 2,
	'csvnote' => 2,
	'csvopt' => 2,
	'csvres' => 2,
	'csvsel' => 2,
	'csvstr' => 2,
	'curdir' => 2,
	'dbbye' => 2,
	'dbclose' => 2,
	'dbgets' => 2,
	'dbini' => 2,
	'dbopen' => 2,
	'dbsend' => 2,
	'dbspchr' => 2,
	'dbstat' => 2,
	'dd_accept' => 2,
	'dd_reject' => 2,
	'default' => 2,
	'delete' => 2,
	'delobj' => 2,
	'dialog' => 2,
	'dim' => 2,
	'dirlist' => 2,
	'dirlist2' => 2,
	'dirlist2h' => 2,
	'dirlist2r' => 2,
	'dispx' => 2,
	'dispy' => 2,
	'dllproc' => 2,
	'do' => 2,
	'draw_icon' => 2,
	'dup' => 2,
	'dupnode' => 2,
	'dxfconv' => 2,
	'dxfgetpoly' => 2,
	'dxfload' => 2,
	'ematan' => 2,
	'emath' => 2,
	'emcnv' => 2,
	'emcos' => 2,
	'emint' => 2,
	'emsin' => 2,
	'emsqr' => 2,
	'emstr' => 2,
	'end' => 2,
	'err' => 2,
	'es_adir' => 2,
	'es_aim' => 2,
	'es_ang' => 2,
	'es_apos' => 2,
	'es_area' => 2,
	'es_boxf' => 2,
	'es_buffer' => 2,
	'es_bye' => 2,
	'es_caps' => 2,
	'es_check' => 2,
	'es_chr' => 2,
	'es_clear' => 2,
	'es_cls' => 2,
	'es_copy' => 2,
	'es_draw' => 2,
	'es_fill' => 2,
	'es_find' => 2,
	'es_flag' => 2,
	'es_fmes' => 2,
	'es_get' => 2,
	'es_getbuf' => 2,
	'es_getfps' => 2,
	'es_ini' => 2,
	'es_kill' => 2,
	'es_link' => 2,
	'es_mes' => 2,
	'es_new' => 2,
	'es_offset' => 2,
	'es_opt' => 2,
	'es_palfade' => 2,
	'es_palset' => 2,
	'es_pat' => 2,
	'es_pos' => 2,
	'es_put' => 2,
	'es_release' => 2,
	'es_screen' => 2,
	'es_set' => 2,
	'es_size' => 2,
	'es_sync' => 2,
	'es_timer' => 2,
	'es_type' => 2,
	'es_window' => 2,
	'es_xfer' => 2,
	'es_zoom' => 2,
	'evmodel' => 2,
	'exec' => 2,
	'exedir' => 2,
	'exgoto' => 2,
	'exist' => 2,
	'f2i' => 2,
	'f2str' => 2,
	'fadd' => 2,
	'falpha' => 2,
	'fcmp' => 2,
	'fcos' => 2,
	'fdiv' => 2,
	'findobj' => 2,
	'fmul' => 2,
	'font' => 2,
	'for' => 2,
	'fprt' => 2,
	'from_uni' => 2,
	'froti' => 2,
	'fsin' => 2,
	'fsqr' => 2,
	'fsub' => 2,
	'fv2str' => 2,
	'fvadd' => 2,
	'fvdir' => 2,
	'fvdiv' => 2,
	'fvface' => 2,
	'fvinner' => 2,
	'fvmax' => 2,
	'fvmin' => 2,
	'fvmul' => 2,
	'fvouter' => 2,
	'fvset' => 2,
	'fvseti' => 2,
	'fvsub' => 2,
	'fvunit' => 2,
	'fxaget' => 2,
	'fxaset' => 2,
	'fxcopy' => 2,
	'fxdir' => 2,
	'fxinfo' => 2,
	'fxlink' => 2,
	'fxren' => 2,
	'fxshort' => 2,
	'fxtget' => 2,
	'fxtset' => 2,
	'gcopy' => 2,
	'get_fileicon' => 2,
	'get_icon' => 2,
	'getbg' => 2,
	'getcoli' => 2,
	'getdebug' => 2,
	'getkey' => 2,
	'getmchild' => 2,
	'getmfv' => 2,
	'getmodel' => 2,
	'getmpoly' => 2,
	'getmsibling' => 2,
	'getmtex' => 2,
	'getmuv' => 2,
	'getobjsize' => 2,
	'getpal' => 2,
	'getpath' => 2,
	'getptr' => 2,
	'getreg' => 2,
	'gets' => 2,
	'getstr' => 2,
	'getsync' => 2,
	'gettex' => 2,
	'gettime' => 2,
	'gettree' => 2,
	'gfcopy' => 2,
	'gfdec' => 2,
	'gfinc' => 2,
	'gfini' => 2,
	'ginfo' => 2,
	'gmode' => 2,
	'gosub' => 2,
	'goto' => 2,
	'grect' => 2,
	'grotate' => 2,
	'gsel' => 2,
	'gsquare' => 2,
	'gval' => 2,
	'gzoom' => 2,
	'hgbye' => 2,
	'hgdraw' => 2,
	'hgdst' => 2,
	'hggetreq' => 2,
	'hgini' => 2,
	'hgreset' => 2,
	'hgsetreq' => 2,
	'hgsync' => 2,
	'hsc_bye' => 2,
	'hsc_clrmes' => 2,
	'hsc_comp' => 2,
	'hsc_compath' => 2,
	'hsc_getmes' => 2,
	'hsc_ini' => 2,
	'hsc_objname' => 2,
	'hsc_refname' => 2,
	'hsc_ver' => 2,
	'hsc3_getsym' => 2,
	'hsc3_make' => 2,
	'hsc3_messize' => 2,
	'hspstat' => 2,
	'hspver' => 2,
	'hsvcolor' => 2,
	'if' => 2,
	'imeinit' => 2,
	'imeopen' => 2,
	'imesend' => 2,
	'imestr' => 2,
	'input' => 2,
	'instr' => 2,
	'int' => 2,
	'iparam' => 2,
	'ipget' => 2,
	'keybd_event' => 2,
	'line' => 2,
	'linesel' => 2,
	'listadd' => 2,
	'listaddcl' => 2,
	'listbox' => 2,
	'listdel' => 2,
	'listdelcl' => 2,
	'listget' => 2,
	'listhit' => 2,
	'listicon' => 2,
	'listmax' => 2,
	'listsel' => 2,
	'listview' => 2,
	'll_bin' => 2,
	'll_call' => 2,
	'll_callfnv' => 2,
	'll_callfunc' => 2,
	'll_dll' => 2,
	'll_free' => 2,
	'll_func' => 2,
	'll_getproc' => 2,
	'll_getptr' => 2,
	'll_libfree' => 2,
	'll_libload' => 2,
	'll_n' => 2,
	'll_p' => 2,
	'll_peek' => 2,
	'll_peek1' => 2,
	'll_peek2' => 2,
	'll_peek4' => 2,
	'll_poke' => 2,
	'll_poke1' => 2,
	'll_poke2' => 2,
	'll_poke4' => 2,
	'll_ret' => 2,
	'll_retset' => 2,
	'll_s' => 2,
	'll_str' => 2,
	'll_type' => 2,
	'll_z' => 2,
	'logmes' => 2,
	'logmode' => 2,
	'loop' => 2,
	'looplev' => 2,
	'lparam' => 2,
	'lzcopy' => 2,
	'lzdist' => 2,
	'maload' => 2,
	'mci' => 2,
	'memcpy' => 2,
	'memfile' => 2,
	'memset' => 2,
	'mes' => 2,
	'mesbox' => 2,
	'mkdir' => 2,
	'modelmovef' => 2,
	'modelshade' => 2,
	'mouse' => 2,
	'mouse_event' => 2,
	'mousex' => 2,
	'mousey' => 2,
	'mref' => 2,
	'msgdlg' => 2,
	'multiopen' => 2,
	'mxaconv' => 2,
	'mxconv' => 2,
	'mxgetname' => 2,
	'mxgetpoly' => 2,
	'mxload' => 2,
	'mxsave' => 2,
	'mxsend' => 2,
	'mxtex' => 2,
	'next' => 2,
	'nextobj' => 2,
	'nodemax' => 2,
	'noteadd' => 2,
	'notedel' => 2,
	'noteget' => 2,
	'noteload' => 2,
	'notemax' => 2,
	'notesave' => 2,
	'notesel' => 2,
	'objact' => 2,
	'objadd1' => 2,
	'objadd2' => 2,
	'objadd3' => 2,
	'objaddf1' => 2,
	'objaddf2' => 2,
	'objaddf3' => 2,
	'objaddfv' => 2,
	'objcheck' => 2,
	'objgetfv' => 2,
	'objgetstr' => 2,
	'objgetv' => 2,
	'objgray' => 2,
	'objmode' => 2,
	'objmov1' => 2,
	'objmov1r' => 2,
	'objmov2' => 2,
	'objmov2r' => 2,
	'objmov3' => 2,
	'objmov3r' => 2,
	'objmovf1' => 2,
	'objmovf2' => 2,
	'objmovf3' => 2,
	'objmovfv' => 2,
	'objmovmode' => 2,
	'objmovopt' => 2,
	'objprm' => 2,
	'objscan2' => 2,
	'objscanf2' => 2,
	'objsel' => 2,
	'objsend' => 2,
	'objset1' => 2,
	'objset1r' => 2,
	'objset2' => 2,
	'objset2r' => 2,
	'objset3' => 2,
	'objset3r' => 2,
	'objsetf1' => 2,
	'objsetf2' => 2,
	'objsetf3' => 2,
	'objsetfv' => 2,
	'objsetv' => 2,
	'objsize' => 2,
	'on' => 2,
	'onclick' => 2,
	'onerror' => 2,
	'onexit' => 2,
	'onkey' => 2,
	'p_scrwnd' => 2,
	'p_wndscr' => 2,
	'pack_exe' => 2,
	'pack_get' => 2,
	'pack_ini' => 2,
	'pack_make' => 2,
	'pack_opt' => 2,
	'pack_rt' => 2,
	'pack_view' => 2,
	'palcolor' => 2,
	'palcopy' => 2,
	'palette' => 2,
	'palfade' => 2,
	'paluse' => 2,
	'peek' => 2,
	'pget' => 2,
	'picload' => 2,
	'pipeexec' => 2,
	'pipeget' => 2,
	'pipeput' => 2,
	'poke' => 2,
	'pos' => 2,
	'print' => 2,
	'prmx' => 2,
	'prmy' => 2,
	'progbox' => 2,
	'progrng' => 2,
	'progset' => 2,
	'pset' => 2,
	'putmodel' => 2,
	'puts' => 2,
	'randomize' => 2,
	'redraw' => 2,
	'refstr' => 2,
	'regkey' => 2,
	'regkill' => 2,
	'reglist' => 2,
	'regobj' => 2,
	'repeat' => 2,
	'resizeobj' => 2,
	'return' => 2,
	'rnd' => 2,
	'run' => 2,
	'rval' => 2,
	'screen' => 2,
	'sdim' => 2,
	'sel_listview' => 2,
	'sel_progbox' => 2,
	'sel_trackbox' => 2,
	'sel_treebox' => 2,
	'sel_udbtn' => 2,
	'selang' => 2,
	'selcam' => 2,
	'selcang' => 2,
	'selcint' => 2,
	'selcpos' => 2,
	'seldir' => 2,
	'selefx' => 2,
	'selfolder' => 2,
	'selget' => 2,
	'sellang' => 2,
	'sellcolor' => 2,
	'sellight' => 2,
	'sellpos' => 2,
	'selmoc' => 2,
	'selpos' => 2,
	'selscale' => 2,
	'sendmsg' => 2,
	'setbg' => 2,
	'setborder' => 2,
	'setcoli' => 2,
	'setcolor' => 2,
	'setfont' => 2,
	'setmap' => 2,
	'setmchild' => 2,
	'setmfv' => 2,
	'setmode' => 2,
	'setmpoly' => 2,
	'setmsibling' => 2,
	'setmtex' => 2,
	'setmuv' => 2,
	'setobjm' => 2,
	'setobjmode' => 2,
	'setreg' => 2,
	'setsizef' => 2,
	'settex' => 2,
	'settimer' => 2,
	'setuv' => 2,
	'skiperr' => 2,
	'snd' => 2,
	'sndload' => 2,
	'sndoff' => 2,
	'sockcheck' => 2,
	'sockclose' => 2,
	'sockget' => 2,
	'sockgetb' => 2,
	'sockgetc' => 2,
	'sockmake' => 2,
	'sockopen' => 2,
	'sockput' => 2,
	'sockputb' => 2,
	'sockputc' => 2,
	'sockwait' => 2,
	'sortget' => 2,
	'sortnote' => 2,
	'sortstr' => 2,
	'sortval' => 2,
	'ss_chgpwd' => 2,
	'ss_chkpwd' => 2,
	'ss_running' => 2,
	'stat' => 2,
	'stick' => 2,
	'stop' => 2,
	'str' => 2,
	'str2f' => 2,
	'str2fv' => 2,
	'strlen' => 2,
	'strmid' => 2,
	'strsize' => 2,
	'strtoint' => 2,
	'sublev' => 2,
	'swbreak' => 2,
	'swend' => 2,
	'switch' => 2,
	'sync' => 2,
	'sysexit' => 2,
	'sysfont' => 2,
	'sysinfo' => 2,
	'texload' => 2,
	'texloadbg' => 2,
	'text' => 2,
	'title' => 2,
	'to_uni' => 2,
	'tooltip' => 2,
	'trackbox' => 2,
	'trackmrk' => 2,
	'trackpos' => 2,
	'trackrng' => 2,
	'tracksel' => 2,
	'treeadd' => 2,
	'treebox' => 2,
	'treedel' => 2,
	'treeget' => 2,
	'treehit' => 2,
	'treeicon' => 2,
	'treemax' => 2,
	'treesel' => 2,
	'treesort' => 2,
	'udbtn' => 2,
	'udget' => 2,
	'udset' => 2,
	'until' => 2,
	'uvanim' => 2,
	'val' => 2,
	'verinfo' => 2,
	'wait' => 2,
	'wend' => 2,
	'while' => 2,
	'width' => 2,
	'windir' => 2,
	'winver' => 2,
	'winx' => 2,
	'winy' => 2,
	'wparam' => 2,
	'wpeek' => 2,
	'wpoke' => 2,
	'xnoteadd' => 2,
	'xnotesel' => 2,

  );?>