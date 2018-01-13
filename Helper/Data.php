<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Round Price Helper
 */
class Data extends AbstractHelper
{
    /**
     * Enabled Config Path
     */
    const XML_ROUND_ENABLED = 'currency/price/enabled';
    
    /**
     * Subtract Config Path
     */
    const XML_ROUND_SUBTRACT = 'currency/price/subtract';    
    
    /**
     * Rounding Base Price Config Path
     */
    const XML_ROUND_BASE_PRICE = 'currency/price/base_price';  
     
    /**
     * Rounding Type Config Path
     */
    const XML_ROUND_TYPE = 'currency/price/type';  
      
    /**
     * Rounding Subtract Amount Config Path
     */
    const XML_ROUND_AMOUNT = 'currency/price/amount';  
      
    /**
     * Rounding Precision Config Path
     */
    const XML_ROUND_PRECISION = 'currency/price/precision';  
      
    /**
     * Show Decimal Zeros Config Path
     */
    const XML_DECIMAL_ZERO = 'currency/price/show_decimal_zero';
         
    /**
     * Replace Zero Price Config Path
     */
    const XML_ZERO_PRICE = 'currency/price/replace_zero_price';
         
    /**
     * Text of Replace Config Path
     */
    const XML_ZERO_PRICE_TEXT = 'currency/price/zero_price_text'; 
	
    /**
     * Swedish Rounding Fraction Config Path
     */
    const XML_SWEDISH_ROUND_FRACTION = 'currency/price/swedish_fraction'; 
    
    /**
     * Rounding Discount Config Path
     */
    const XML_ROUND_DISCOUNT = 'currency/price/discount';  
    
    /**
     * Check Round Price Convert Functionality Should be Enabled
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_getConfig(self::XML_ROUND_ENABLED);
    }
	
    /**
     * Check Subtract 0.01 Functionality Should be Enabled
     *
     * @return bool
     */
    public function isSubtract()
    {
        return $this->_getConfig(self::XML_ROUND_SUBTRACT);
    }
    
    /**
     * Check Decimal Zero Functionality Should be Enabled
     *
     * @return bool
     */
    public function isShowDecimalZero()
    {
        return $this->_getConfig(self::XML_DECIMAL_ZERO);
    }
    
    /**
     * Check Replace Zero Price Functionality Should be Enabled
     *
     * @return bool
     */
    public function isReplaceZeroPrice()
    {
        return $this->_getConfig(self::XML_ZERO_PRICE);
    }
            
    /**
     * Check Rounding Base Price
     *
     * @return string
     */
    public function isRoundingBasePrice()
    {
        return $this->_getConfig(self::XML_ROUND_BASE_PRICE);
    }
    
    /**
     * Check Rounding Discount
     *
     * @return string
     */
    public function isRoundingDiscount()
    {
        return $this->_getConfig(self::XML_ROUND_DISCOUNT);
    } 
    
    /**
     * Retrieve Rounding Type
     *
     * @return string
     */
    public function getRoundType()
    {
        return $this->_getConfig(self::XML_ROUND_TYPE);
    }
	
    /**
     * Retrieve Subtract Amount
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
     * Retrieve Precision
     *
     * @return int
     */
    public function getPrecision()
    {
        return (int)$this->_getConfig(self::XML_ROUND_PRECISION);
    }
	
    /**
     * Retrieve Text of Replace
     *
     * @return string
     */
    public function getZeroPriceText()
    {
        return $this->_getConfig(self::XML_ZERO_PRICE_TEXT);
    }
	
    /**
     * Retrieve Swedish Round Fraction
     *
     * @return float
     */
    public function getSwedishFraction()
    {
        $fraction = $this->_getConfig(self::XML_SWEDISH_ROUND_FRACTION);
		return ($fraction > 0)
			? $fraction 
			: 0.05;        
    }
	
    /**
     * Retrieve Store Configuration Data
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
