<?php
/**
Welcome Message(PM/Mail) Preload Hack(?) version 2.5 by wanikoo
 ( http://www.wanisys.net/ )
*/

if (!defined('XOOPS_ROOT_PATH')) die();

//subject of welcome message! %s will be substituted by uname!
if (!defined('_MD_USER_LANG_WELCOMEPM_HACK')) {
define('_MD_USER_LANG_WELCOMEPM_HACK', "Welcome Message for %s");
}

//body of welcome message!
//If template file(ex:welcome_pm.tpl) for welcome message doesn't exist, 
//this text will be used as body  for emergency!! 
if (!defined('_MD_USER_LANG_WELCOMEPM_HACK2')) {
define('_MD_USER_LANG_WELCOMEPM_HACK2', '
Hi!! {X_UNAME}

Welcome!!

Have a nice and happy time!!

-----------
Best Regards
{SITENAME}
({SITEURL}) 
{ADMINMAIL}
');
}

class User_WelcomeMsg extends XCube_ActionFilter
{
	function preBlockFilter()
	{
		$this->mRoot->mDelegateManager->add('Legacy.Event.RegistUser.Success', "User_WelcomeMsg::sendWelcomeMsg");
		
	}
	
	function sendWelcomeMsg(&$xoopsUser)
	{
		//please change this value if you also want to send a welcome-mail to new-user!
		//$useMail = true;
		$usePM = true;
		$useMail = false;

		$root =& XCube_Root::getSingleton();
		if (is_object($xoopsUser)) {

		$uid = $xoopsUser->getVar('uid');
		//ver2.5
		$url = null;
		$service =& $root->mServiceManager->getService('privateMessage');
		if ($service != null) {
			$client =& $root->mServiceManager->createClient($service);
			$url = $client->call('getPmInboxUrl', array('uid' => $uid));
		}

		if($url == null ) {
		$usePM = false;				
		}
		
		$builder = new User_WelcomeMsgBuilder();
		$director =& new User_WelcomeMsgDirector($builder, $xoopsUser, $root->mContext->getXoopsConfig());
		$director->construct($usePM, $useMail);
		$mailer =& $builder->getResult();

		if (!$mailer->send()) {
		// maybe.. no need to show any error-msg
		}

		}
	}


}


class User_WelcomeMsgDirector
{
	var $mBuilder;
	
	var $mUser;
	
	var $mXoopsConfig;
	

	function User_WelcomeMsgDirector(&$builder, &$user, $xoopsConfig)
	{
		$this->mBuilder =& $builder;
		
		$this->mUser =& $user;
		$this->mXoopsConfig =$xoopsConfig;

	}
	
	function construct($usePM, $useMail)
	{
		if ( $useMail == true ) {
		$this->mBuilder->setUseMail();
		}
		if ( $usePM == true ) {
		$this->mBuilder->setUsePM();
		}
		$this->mBuilder->setTemplate();
		$this->mBuilder->setToUsers($this->mUser);
		$this->mBuilder->setFromEmail($this->mXoopsConfig);
		$this->mBuilder->setSubject($this->mUser, $this->mXoopsConfig);
		$this->mBuilder->setBody($this->mUser, $this->mXoopsConfig);
	}
}



class User_WelcomeMsgBuilder
{
	var $mMailer;
	
	function User_WelcomeMsgBuilder()
	{
		$this->mMailer = $this->getMailer();
	}

	function setUseMail()
	{
		$this->mMailer->useMail();
	}

	function setUsePM()
	{
		$this->mMailer->usePM();
	}

	function setTemplate()
	{
		$root=&XCube_Root::getSingleton();
		$language = $root->mContext->getXoopsConfig('language');
		$this->mMailer->setTemplateDir(XOOPS_ROOT_PATH . '/modules/user/language/' . $language . '/mail_template/');
		$this->mMailer->setTemplate('welcome_pm.tpl');
	}

	function setToUsers($user)
	{
		$this->mMailer->setToUsers($user);
	}
	
	function setFromEmail($xoopsConfig)
	{
		$this->mMailer->setFromEmail($xoopsConfig['adminmail']);
		$this->mMailer->setFromName($xoopsConfig['sitename']);
	}
	
	function setSubject($user, $xoopsConfig)
	{
		$this->mMailer->setSubject(@sprintf(_MD_USER_LANG_WELCOMEPM_HACK, $user->getShow('uname')));
	}

	function setBody($user,$xoopsConfig)
	{
		$this->mMailer->assign('SITENAME', $xoopsConfig['sitename']);
		$this->mMailer->assign('ADMINMAIL', $xoopsConfig['adminmail']);
		$this->mMailer->assign('SITEURL', XOOPS_URL . '/');

		if ( !file_exists($this->mMailer->templatedir.$this->mMailer->template) ) {
		$this->mMailer->setTemplate('');
		$this->mMailer->setBody(_MD_USER_LANG_WELCOMEPM_HACK2);
		}
	}

	function &getMailer()
	{

	$ret = null;

    	$ret =& new WelcomeMsgMailer();
	return $ret;
	}

	
	function &getResult()
	{
		return $this->mMailer;
	}
}



require_once XOOPS_ROOT_PATH."/class/xoopsmailer.php";
if ( file_exists(XOOPS_ROOT_PATH."/language/".$GLOBALS['xoopsConfig']['language']."/xoopsmailerlocal.php") ) {
require_once XOOPS_ROOT_PATH."/language/".$GLOBALS['xoopsConfig']['language']."/xoopsmailerlocal.php";
if ( class_exists("XoopsMailerLocal") ) {

class WelcomeMsgMailer extends XoopsMailerLocal {

	function sendPM($uid, $subject, $body)
	{
		$pm_handler =& xoops_gethandler('privmessage');
		$pm =& $pm_handler->create();
		$pm->setVar("subject", $subject);
		//from_userid => Site-admin's uid is  1
		//You can customize it !!
		$pm->setVar('from_userid', 1);
		$pm->setVar("msg_text", $body);
		$pm->setVar("to_userid", $uid);
		if (!$pm_handler->insert($pm)) {
			return false;
		}
		return true;
	}

}

}
}
else {

class WelcomeMsgMailer extends XoopsMailer {

	function sendPM($uid, $subject, $body)
	{
		$pm_handler =& xoops_gethandler('privmessage');
		$pm =& $pm_handler->create();
		$pm->setVar("subject", $subject);
		//from_userid => Site-admin's uid is  1
		//You can customize it !!
		$pm->setVar('from_userid', 1);
		$pm->setVar("msg_text", $body);
		$pm->setVar("to_userid", $uid);
		if (!$pm_handler->insert($pm)) {
			return false;
		}
		return true;
	}

}

}




?>