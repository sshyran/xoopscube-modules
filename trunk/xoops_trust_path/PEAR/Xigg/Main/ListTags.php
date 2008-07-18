<?php
class Xigg_Main_ListTags extends Sabai_Controller
{
    function _doExecute(&$context)
    {
        $cacher =& $context->application->locator->getService('Cacher');
        if ($data = $cacher->get('Xigg_Main_ListTags')) {
            $data = unserialize($data);
        } else {
            $data = $this->_buildCloud($context);
            $cacher->save(serialize($data), 'Xigg_Main_ListTags');
        }
        $context->response->setVar('tags', $data);
    }

    function _buildCloud(&$context)
    {
        $tag_cloud = array();
        $model =& $context->application->locator->getService('Model');
        $tag_gw =& $model->getGateway('Tag');
        if ($tags = $tag_gw->getTagsWithNodeCount(0, 'tag_name')) {
            ksort($tags);
            require_once 'Sabai/Cloud.php';
            $cloud =& new Sabai_Cloud();
            foreach (array_keys($tags) as $i) {
                $cloud->addElement($tags[$i]['tag_name'],
                                   $context->request->createUri(array('base' => '/tag/' . rawurlencode($tags[$i]['tag_name']))),
                                   $tags[$i]['node_count']);
            }
            $tag_cloud = $cloud->build();
        }
        return $tag_cloud;
    }
}