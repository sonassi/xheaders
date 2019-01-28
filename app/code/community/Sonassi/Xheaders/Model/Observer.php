<?php

class Sonassi_Xheaders_Model_Observer
{

    const HEADER_NAME = 'X-Magento-Type';

    /**
     * Adds response headers
     *
     * @param Mage_Core_Controller_Front_Action $controllerAction
     * @return $this
     */
    public function controllerActionPostdispatch(Varien_Event_Observer $observer)
    {
        /* @var $controllerAction Mage_Core_Controller_Front_Action */
        $controllerAction = $observer->getControllerAction();

        if ($controllerAction->getResponse()->canSendHeaders()) {

            $fullActionName = Mage::app()->getFrontController()->getAction()->getFullActionName();

            switch ($fullActionName) {

                case 'catalog_category_view' :
                    $type = 'category';
                    break;
                case 'catalog_product_view' :
                    $type = 'product';
                    break;
                case 'cms_index_index' :
                    $type = 'cms';
                    break;
                case 'catalogsearch_result_index' :
                    $type = 'search';
                    break;

                default:
                    $type = $fullActionName;
                    break;

            }

            $controllerAction->getResponse()->setHeader(self::HEADER_NAME, $type, true);
        }

        return $this;
    }
}