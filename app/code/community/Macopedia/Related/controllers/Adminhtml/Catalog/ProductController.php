<?php
require_once(Mage::getModuleDir('controllers', 'Mage_Adminhtml') . DS . 'Catalog' . DS . 'ProductController.php');

class Macopedia_Related_Adminhtml_Catalog_ProductController extends Mage_Adminhtml_Catalog_ProductController
{
    private $relatedActions = array(
        'adminhtml_catalog_product_index',
        'adminhtml_catalog_product_edit',
        'adminhtml_catalog_product_categories',
        'adminhtml_catalog_product_categoriesJson',
        'adminhtml_catalog_product_options',
        'adminhtml_catalog_product_related',
        'adminhtml_catalog_product_relatedGrid',
        'adminhtml_catalog_product_save',
        'adminhtml_catalog_product_validate'
    );

    protected function _isAllowed()
    {
        if (in_array($this->getFullActionName(), $this->relatedActions)) {
            return $this->_canEditAllFields() || $this->_canEditRelatedProducts();
        }

        return $this->_canEditAllFields();
    }

    protected function _initProductSave()
    {
        if ($this->_canEditAllFields()) {
            return parent::_initProductSave();
        }

        if ($this->_canEditRelatedProducts()) {
            return $this->_initRelated();
        }
    }

    protected function _canEditAllFields()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/products');
    }

    protected function _canEditRelatedProducts()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/macopedia_related');
    }

    protected function _initRelated()
    {
        $product = $this->_initProduct();
        $links = $this->getRequest()->getPost('links');

        $product->setRelatedLinkData(Mage::helper('adminhtml/js')->decodeGridSerializedInput($links['related']));

        $this->_getSession()->addNotice($this->__('Only related products has been saved because you do not have permission to edit all product data'));
        return $product;
    }
}