<?php
/**
 * Faonni
 *  
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade module to newer
 * versions in the future.
 * 
 * @package     Faonni_Price
 * @copyright   Copyright (c) 2016 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Faonni\Price\Helper;

use Magento\Store\Model\ScopeInterface;

/**
 * Faonni Price data helper
 */
class Data 
	extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Check Subtract 0.01 functionality should be enabled
     *
     * @return bool
     */
    public function isSubtract()
    {
        return $this->scopeConfig->getValue('currency/price/subtract', ScopeInterface::SCOPE_STORE);
    }
	
    /**
     * Retrieve Rounding Type
     *
     * @return string
     */
    public function getRoundType()
    {
        return $this->scopeConfig->getValue('currency/price/type', ScopeInterface::SCOPE_STORE);
    }
	
    /**
     * Retrieve Subtract Amount
     *
     * @return string
     */
    public function getAmount()
    {
        $amount = $this->scopeConfig->getValue('currency/price/amount', ScopeInterface::SCOPE_STORE);
		return (is_numeric($amount)) ? $amount : 0;
    }		
}
