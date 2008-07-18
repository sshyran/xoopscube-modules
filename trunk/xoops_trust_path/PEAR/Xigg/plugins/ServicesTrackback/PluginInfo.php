<?php
require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_ServicesTrackback_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_ServicesTrackback_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0b2';
        $this->_summary = $this->_('Receive/Send trackbacks using Services_Trackback PEAR library');
        $this->_params = array('Wordlist' => array(
                                       'type'     => 'yesno',
                                       'label'    => $this->_('Use wordlist spam checker.'),
                                       'default'  => 1,
                                       'required' => true),
                               'Wordlist_words' => array(
                                       'type'     => 'textarea',
                                       'label'    => $this->_('List of words to check. Separate each word with "|".'),
                                       'default'  => 'acne|adipex|anal|blackjack|cash|casino|cigar|closet|daystore|diet|drugs|erection|fundslender|gambling|hire|hydrocodone|investing|lasik|loan|mattress|mortgage|naproxen|neurontin|payday|penis|pharma|phentermine|poker|porn|rheuma|roulette|sadism|sex|smoking|texas hold|tramadol|uxury|viagra|vioxx|weight loss|xanax|zantac',
                                       'required' => false),
                               'Regex' => array(
                                       'type'     => 'yesno',
                                       'label'    => $this->_('Use regex spam checker.'),
                                       'default'  => 1,
                                       'required' => true),
                               'Regex_formats' => array(
                                       'type'     => 'textarea',
                                       'label'    => $this->_('List of regex to check. Separate each regex formats with "|".'),
                                       'default'  => 'acne|adipex|anal|blackjack|cash|casino|cigar|closet|daystore|drugs|erection|fundslender|gambling|hire|hydrocodone|investing|lasik|loan|mattress|mortgage|naproxen|neurontin|payday|penis|pharma|phentermine|poker|porn|rheuma|roulette|sadism|sex|smoking|texas hold|tramadol|uxury|viagra|vioxx|weight loss|xanax|zantac',
                                       'required' => false),
                               'DNSBL' => array(
                                       'type'     => 'yesno',
                                       'label'    => $this->_('Use DNSBL spam checker. Net_DNSBL package required.'),
                                       'default'  => 0,
                                       'required' => true),
                               'DNSBL_hosts' => array(
                                       'type'     => 'input_multi',
                                       'label'    => $this->_('List of blacklist nameservers. Enter each in one line.'),
                                       'default'  => array('bl.spamcop.net', 'zen.spamhaus.org'),
                                       'required' => false),
                               'SURBL' => array(
                                       'type'     => 'yesno',
                                       'label'    => $this->_('Use SURBL spam checker. Net_DNSBL package required.'),
                                       'default'  => 0,
                                       'required' => true),
                               'SURBL_hosts' => array(
                                       'type'     => 'input_multi',
                                       'label'    => $this->_('List of blacklist servers. Enter each in one line.'),
                                       'default'  => array('multi.surbl.org'),
                                       'required' => false),
                         );
        $this->_requiredPHP = '4.3.11'; // Net_DNSBL requires 4.3.11 or later
    }
}