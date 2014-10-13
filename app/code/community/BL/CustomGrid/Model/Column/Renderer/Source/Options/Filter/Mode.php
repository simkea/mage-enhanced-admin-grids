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

class BL_CustomGrid_Model_Column_Renderer_Source_Options_Filter_Mode
{
    public function toOptionArray()
    {
        return array(
            array(
                'value' => BL_CustomGrid_Block_Widget_Grid_Column_Filter_Select::MODE_SINGLE,
                'label' => Mage::helper('customgrid')->__('Single Value'),
            ),
            array(
                'value' => BL_CustomGrid_Block_Widget_Grid_Column_Filter_Select::MODE_MULTIPLE,
                'label' => Mage::helper('customgrid')->__('Multiple Values'),
            ),
            array(
                'value' => BL_CustomGrid_Block_Widget_Grid_Column_Filter_Select::MODE_WITH_WITHOUT,
                'label' => Mage::helper('customgrid')->__('With/Without Value'),
            ),
        );
    }
}
