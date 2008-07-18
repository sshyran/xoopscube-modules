<?php
class Xigg_Model_NodeForm extends Xigg_Model_NodeFormBase
{
    function _onInit()
    {
        // set status options
        $status =& $this->getElement('status');
        $status->addOption(XIGG_NODE_STATUS_UPCOMING, _('Upcoming'));
        $status->addOption(XIGG_NODE_STATUS_PUBLISHED, _('Popular'));
        $status->setValue(XIGG_NODE_STATUS_UPCOMING);
        // add some validators
        $this->validatesPresenceOf('title', _('You must enter the title'), _(' '));
        $this->validatesPresenceOf('body', _('You must enter the content'), _(' '));
        $this->validatesURLOf('source', _('Invalid source URL'));
        // following columns should not be changed via form
        $this->removeElements(array('userid'));
        // for auto tagging
        require_once 'Sabai/Form/Element/InputText.php';
        $this->addElement(new Sabai_Form_Element_InputText('tagging', 60, 0), _('Tags (Separate tags with a comma)'));
        // set content_syntax options
        $status =& $this->getElement('content_syntax');
        $status->addOption('HTML', 'HTML');
    }

    function _onEntity(&$entity)
    {
        // fill element with previously submitted tags
        if ($entity->getId() > 0) {
            $tag_names = array();
            $tags =& $entity->get('Tags');
            $tags->rewind();
            while ($tag =& $tags->getNext()) {
                $tag_names[] = $tag->getLabel();
            }
            $this->setValueFor('tagging', implode(', ', $tag_names));
        }
        // only allow modifying the published time for published items
        if (!$entity->isPublished()) {
            $this->removeElements(array('published'));
        }
    }

    function _validate()
    {
    	if ($this->hasElement('source_title')) {
    		if (!$this->getValueFor('source_title')) {
    			if ($source = $this->getValueFor('source')) {
    				require_once 'HTTP/Request.php';
        			$req =& new HTTP_Request($source, array('timeout' => 30, 'allowRedirects' => true));
        			if (true == $res = $req->sendRequest()) {
            			if (200 == $code = $req->getResponseCode()) {
                			$body = $req->getResponseBody();
                			if (preg_match('#<title>([^<]*?)</title>#is', $body, $title)) {
                			    $title[1] = mb_convert_encoding($title[1], SABAI_CHARSET, mb_detect_encoding($title[1]));
                    			$this->setValueFor('source_title', $title[1]);
                			} else {
                				$this->setValueFor('source_title', $source);
                			}
            			} else {

            			    if ($code == false) {
            			        // false means that it failed to retrieve response code but that does not always equals to HTTP 4xx
            			        $this->setValueFor('source_title', $source);
            			    } else {
            			        // probably HTTP 4xx error
            			        $this->addValidationErrorFor('source_title', Sabai_I18N::__('Unable to retrieve data from the source URL. HTTP Response code: %d', $code));
            			    }
            			}
        			} else {
        				$this->addValidationErrorFor('source_title', _('Unable to connect to the source URL. No internet connection present. ') . $res->getMessage());
        			}
        		}
        	} else {
        		if (!trim($this->getValueFor('source'))) {
        			$this->setValueFor('source_title', '');
        		}
        	}
    	}
    }
}