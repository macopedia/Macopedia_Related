<?php

class Macopedia_Related_Block_Adminhtml_Catalog_Product_Edit extends Mage_Adminhtml_Block_Catalog_Product_Edit
{
    protected function _prepareLayout()
    {
        $_prepareLayout = parent::_prepareLayout();

        if (!Mage::getSingleton('admin/session')->isAllowed('catalog/products')) {
            $_prepareLayout->unsetChild('back_button');
            $_prepareLayout->unsetChild('reset_button');
            $_prepareLayout->unsetChild('duplicate_button');
            $_prepareLayout->unsetChild('delete_button');
            $_prepareLayout->unsetChild('save_and_edit_button');
        }

        return $_prepareLayout;
    }
}
