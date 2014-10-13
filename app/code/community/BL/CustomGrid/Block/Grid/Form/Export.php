<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   BL
 * @package    BL_CustomGrid
 * @copyright  Copyright (c) 2014 Benoît Leulliette <benoit.leulliette@gmail.com>
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class BL_CustomGrid_Block_Grid_Form_Export extends BL_CustomGrid_Block_Grid_Form_Abstract
{
    public function getUseFieldValueForUrl()
    {
        return $this->getFormatFieldHtmlId();
    }
    
    public function getUseAjaxSubmit()
    {
        return false;
    }
    
    protected function _getExportTypesHash()
    {
        $exportTypes = array();
        
        foreach ($this->getGridModel()->getExportTypes() as $exportType) {
            $exportTypes[$exportType->getUrl()] = $exportType->getLabel();
        }
        
        return $exportTypes;
    }
    
    protected function _getExportSizesHash()
    {
        $exportSizes = array();
        
        if ($totalSize = $this->getTotalSize()) {
            $exportSizes[$totalSize] = $this->__('Total (%s)', $totalSize);
        }
        
        foreach ($this->getGridModel()->getAppliablePaginationValues() as $paginationValue) {
            $exportSizes[$paginationValue] = $paginationValue;
        }
        
        $exportSizes[''] = $this->__('Other');
        return $exportSizes;
    }
    
    protected function _prepareDependenceBlock($sizeFieldId, $customSizeFieldId)
    {
        return $this->setChild(
            'form_after',
            $this->getLayout()
                ->createBlock('customgrid/widget_form_element_dependence')
                ->addFieldMap($sizeFieldId, 'size')
                ->addFieldMap($customSizeFieldId, 'custom_size')
                ->addFieldDependence('custom_size', 'size', '')
        );
    }
    
    protected function _addFieldsToForm(Varien_Data_Form $form)
    {
        parent::_addFieldsToForm($form);
        
        $fieldset = $form->addFieldset(
            'configuration',
            array(
                'legend' => $this->__('Configuration'),
                'class'  => 'fielset-wide',
            )
        );
        
        $formatField = $fieldset->addField(
            'format',
            'select',
            array(
                'name'     => 'export[format]',
                'label'    => $this->__('Format'),
                'required' => true,
                'values'   => $this->_getExportTypesHash(),
            )
        );
        
        $this->setFormatFieldHtmlId($formatField->getHtmlId());
        
        $exportSizes = $this->_getExportSizesHash();
        reset($exportSizes);
        $defaultExportSize = key($exportSizes);
        
        $sizeField = $fieldset->addField(
            'size',
            'select',
            array(
                'name'     => 'export[size]',
                'label'    => $this->__('Size'),
                'required' => true,
                'values'   => $exportSizes,
                'value'    => $defaultExportSize,
            )
        );
        
        $customSizeField = $fieldset->addField(
            'custom_size',
            'text',
            array(
                'name'     => 'export[custom_size]',
                'label'    => $this->__('Custom Size'),
                'required' => true,
                'class'    => 'validate-greater-than-zero',
            )
        );
        
        $fieldset->addField(
            'from_result',
            'text',
            array(
                'name'     => 'export[from_result]',
                'label'    => $this->__('From Result'),
                'required' => true,
                'class'    => 'validate-greater-than-zero',
                'value'    => (int) $this->getDataSetDefault('first_index', 1),
            )
        );
        
        $this->_prepareDependenceBlock($sizeField->getHtmlId(), $customSizeField->getHtmlId());
        return $this;
    }
}
