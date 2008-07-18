<?php
class Xigg_Model_Tag extends Xigg_Model_TagBase
{
    function Xigg_Model_Tag(&$model)
    {
        parent::Xigg_Model_TagBase($model);
    }

    function getEncodedName()
    {
        return rawurlencode($this->get('name'));
    }
}

class Xigg_Model_TagRepository extends Xigg_Model_TagRepositoryBase
{
    function Xigg_Model_TagRepository(&$model)
    {
        parent::Xigg_Model_TagRepositoryBase($model);
    }

    function tagExists($tagName)
    {
        return $this->countByCriteria(Sabai_Model_Criteria::createValue('tag_name', $tag_name));
    }

    function &getExistingTags($tagNames)
    {
        $tags =& $this->fetchByCriteria(Sabai_Model_Criteria::createIn('tag_name', $tagNames));
        return $tags;
    }
}