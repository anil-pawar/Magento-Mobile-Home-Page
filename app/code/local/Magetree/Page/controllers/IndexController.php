<?php
 
require_once 'Mage/Cms/controllers/IndexController.php';
 
class Magetree_Page_IndexController extends Mage_Cms_IndexController
{
   /**
     * Renders CMS Home page
     *
     * @param string $coreRoute
     */
    public function indexAction($coreRoute = null)
    {
        $pageId = Mage::getStoreConfig(Mage_Cms_Helper_Page::XML_PATH_HOME_PAGE);




 		$configValueSerialized = Mage::getStoreConfig('web/default/cms_home_page_ua_regexp', Mage::app()->getStore()->getId());
        if ($configValueSerialized) {
            $regexps = unserialize($configValueSerialized);

            foreach ($regexps as $key => $value) {
                if (isset($value)) {
                    $regexps = array_values($value);
                    //var_dump($regexps);
                    $regexps1=$regexps[0];
                    if (isset($regexps1)) {
                        $regexp = '/' . trim($regexps1, '/') . '/';
                        if (@preg_match($regexp, $_SERVER['HTTP_USER_AGENT'])) {
                            $pageId=$regexps[1];
                            continue;
                        }
                    }
                }
            }
        }

        if (!Mage::helper('cms/page')->renderPage($this, $pageId)) {
            $this->_forward('defaultIndex');
        }
    }
}