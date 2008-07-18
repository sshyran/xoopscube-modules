<?php
if (!class_exists('Sabai')) exit();

require_once 'Xigg/PluginInfo.php';

class Xigg_Plugin_dpSyntaxHighlighter_Info extends Xigg_PluginInfo
{
    function Xigg_Plugin_dpSyntaxHighlighter_Info($name, $dir)
    {
        parent::Xigg_PluginInfo($name, $dir);
        $this->_version = '1.0.0b2';
        $this->_summary = $this->_('Makes code snippets look pretty by highlighting syntax. See http://code.google.com/p/syntaxhighlighter/ for details of the javascript library.');
        $this->_params = array('brushes' => array(
                                       'type'     => 'textarea',
                                       'label'    => $this->_('List of brushes to use. Separate each brush with "|". Available brushes are Cpp/CSharp/Css/Delphi/Java/JScript/Php/Python/Ruby/Sql/Vb/Xml.'),
                                       'default'  => 'Css|JScript|Php|Xml',
                                       'required' => true),
                               'showGutters' => array(
                                       'type'     => 'yesno',
                                       'label'    => $this->_('Display gutter?'),
                                       'default'  => 1,
                                       'required' => true),
                               'showControls' => array(
                                       'type'     => 'yesno',
                                       'label'    => $this->_('Display controls at the top?'),
                                       'default'  => 1,
                                       'required' => true),
                              );
    }
}