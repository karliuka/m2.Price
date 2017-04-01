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
 * @copyright   Copyright (c) 2017 Karliuka Vitalii(karliuka.vitalii@gmail.com) 
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace Faonni\Price\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Faonni Price data helper
 */
class Data extends AbstractHelper
{
    /**
     * Enabled config path
     */
    const XML_ROUND_ENABLED = 'currency/price/enabled';
    
    /**
     * Subtract config path
     */
    const XML_ROUND_SUBTRACT = 'currency/price/subtract';    
    
    /**
     * Rounding base price config path
     */
    const XML_ROUND_BASE_PRICE = 'currency/price/base_price';  
     
    /**
     * Rounding type config path
     */
    const XML_ROUND_TYPE = 'currency/price/type';  
      
    /**
     * Rounding subtract amount config path
     */
    const XML_ROUND_AMOUNT = 'currency/price/amount';  
      
    /**
     * Rounding precision config path
     */
    const XML_ROUND_PRECISION = 'currency/price/precision';  
      
    /**
     * Show decimal zeros config path
     */
    const XML_DECIMAL_ZERO = 'currency/price/show_decimal_zero';
         
    /**
     * Replace zero price config path
     */
    const XML_ZERO_PRICE = 'currency/price/replace_zero_price';
         
    /**
     * Text of replace config path
     */
    const XML_ZERO_PRICE_TEXT = 'currency/price/zero_price_text'; 
                              	
    /**
     * Check round price convert functionality should be enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_getConfig(self::XML_ROUND_ENABLED);
    }
	
    /**
     * Check subtract 0.01 functionality should be enabled
     *
     * @return bool
     */
    public function isSubtract()
    {
        return $this->_getConfig(self::XML_ROUND_SUBTRACT);
    }
    
    /**
     * Check decimal zero functionality should be enabled
     *
     * @return bool
     */
    public function isShowDecimalZero()
    {
        return $this->_getConfig(self::XML_DECIMAL_ZERO);
    }
    
    /**
     * Check replace zero price functionality should be enabled
     *
     * @return bool
     */
    public function isReplaceZeroPrice()
    {
        return $this->_getConfig(self::XML_ZERO_PRICE);
    }
            
    /**
     * Check rounding base price
     *
     * @return string
     */
    public function isRoundingBasePrice()
    {
        return $this->_getConfig(self::XML_ROUND_BASE_PRICE);
    }    
	
    /**
     * Retrieve rounding type
     *
     * @return string
     */
    public function getRoundType()
    {
        return $this->_getConfig(self::XML_ROUND_TYPE);
    }
	
    /**
     * Retrieve subtract amount
     *
     * @return string
     */
    public function getAmount()
    {
        $amount = $this->_getConfig(self::XML_ROUND_AMOUNT);
		return is_numeric($amount) 
			? $amount 
			: 0;
    }
	
    /**
     * Retrieve precision
     *
     * @return int
     */
    public function getPrecision()
    {
        return (int)$this->_getConfig(self::XML_ROUND_PRECISION);
    }
	
    /**
     * Retrieve text of replace
     *
     * @return string
     */
    public function getZeroPriceText()
    {
        return $this->_getConfig(self::XML_ZERO_PRICE_TEXT);
    }
        
    /**
     * Retrieve store configuration data
     *
     * @param string $path
     * @return string|null|bool
     */
    protected function _getConfig($path)
    {
        return $this->scopeConfig
			->getValue(
				$path, 
				ScopeInterface::SCOPE_STORE
			);
    }       	
}
