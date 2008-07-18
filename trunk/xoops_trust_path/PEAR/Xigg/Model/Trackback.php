<?php
class Xigg_Model_Trackback extends Xigg_Model_TrackbackBase
{
    function Xigg_Model_Trackback(&$model)
    {
        parent::Xigg_Model_TrackbackBase($model);
    }

    function getHTMLLink($target = '_blank')
    {
        return sprintf('<a href="%s" target="%s">%s</a>', $this->get('url'), h($target), h($this->getLabel()));
    }

    function getLabel()
    {
        return ($title = $this->get('title')) ? $title : $this->get('url');
    }
}

class Xigg_Model_TrackbackRepository extends Xigg_Model_TrackbackRepositoryBase
{
    function Xigg_Model_TrackbackRepository(&$model)
    {
        parent::Xigg_Model_TrackbackRepositoryBase($model);
    }
}