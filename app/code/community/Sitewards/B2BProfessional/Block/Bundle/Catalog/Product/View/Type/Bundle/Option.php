<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Bundle
 * @copyright  Copyright (c) 2006-2014 X.commerce, Inc. (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * Bundle option renderer
 *
 * @category    Mage
 * @package     Mage_Bundle
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Sitewards_B2BProfessional_Block_Bundle_Catalog_Product_View_Type_Bundle_Option extends Mage_Bundle_Block_Catalog_Product_View_Type_Bundle_Option
{

    /**
     * The b2b prof helper class
     *
     * @var Sitewards_B2BProfessional_Helper_Data
     */
    protected $oB2BHelper;

    /**
     * The b2b prof customer helper class
     *
     * @var Sitewards_B2BProfessional_Helper_Customer
     */
    protected $oB2BCustomerHelper;

    public function __construct()
    {
        $this->oB2BHelper = Mage::helper('sitewards_b2bprofessional');
        $this->oB2BCustomerHelper = Mage::helper('sitewards_b2bprofessional/customer');

        parent::__construct();
    }

    /**
     * Checks to see if the price can be shown.
     *
     * @return boolean
     */
    protected function _canShowPrice()
    {
        if(!$this->oB2BHelper->isExtensionActive())
            return true;

        return $this->oB2BCustomerHelper->isCustomerLoggedIn();
    }

    /**
     * Returns the formatted string for the quantity chosen for the given selection
     *
     * @param Mage_Catalog_Model_Proudct $_selection
     * @param bool                       $includeContainer
     * @return string
     */
    public function getSelectionQtyTitlePrice($_selection, $includeContainer = true)
    {
        $price = $this->getProduct()->getPriceModel()->getSelectionPreFinalPrice($this->getProduct(), $_selection);
        $this->setFormatProduct($_selection);
        $priceTitle = $_selection->getSelectionQty() * 1 . ' x ' . $this->escapeHtml($_selection->getName());

        if ($this->_canShowPrice()) {
            $priceTitle .= ' &nbsp; ' . ($includeContainer ? '<span class="price-notice">' : '')
                . '+' . $this->formatPriceString($price, $includeContainer)
                . ($includeContainer ? '</span>' : '');
        }

        return $priceTitle;
    }

    /**
     * Get title price for selection product
     *
     * @param Mage_Catalog_Model_Product $_selection
     * @param bool $includeContainer
     * @return string
     */
    public function getSelectionTitlePrice($_selection, $includeContainer = true)
    {
        $price = $this->getProduct()->getPriceModel()->getSelectionPreFinalPrice($this->getProduct(), $_selection, 1);
        $this->setFormatProduct($_selection);
        $priceTitle = $this->escapeHtml($_selection->getName());

        if ($this->_canShowPrice()) {
            $priceTitle .= ' &nbsp; ' . ($includeContainer ? '<span class="price-notice">' : '')
                . '+' . $this->formatPriceString($price, $includeContainer)
                . ($includeContainer ? '</span>' : '');
        }

        return $priceTitle;
    }
}
