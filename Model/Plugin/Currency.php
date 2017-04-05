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
namespace Faonni\Price\Model\Plugin;

use Magento\Framework\Exception\InputException;
use Magento\Framework\Locale\FormatInterface;
use Magento\Directory\Model\Currency as CurrencyModel;
use Faonni\Price\Helper\Data as PriceHelper;

/**
 * Class Currency model for convert and round price value
 */
class Currency
{
    /**
     * Round fractions up constant
     */	
	const TYPE_CEIL = 'ceil';
	
    /**
     * Round fractions down constant
     */	
	const TYPE_FLOOR = 'floor';
	
    /**
     * Store Config
     *
     * @var Faonni\Price\Helper\Data
     */
    protected $_helper;
    
    /**
     * Locale Format
     * 
     * @var \Magento\Framework\Locale\FormatInterface
     */
    protected $_localeFormat;    
	
    /**
     * Initialize plugin
     * 
     * @param FormatInterface $localeFormat
     * @param PriceHelper $helper
     */
    public function __construct(
        FormatInterface $localeFormat,
        PriceHelper $helper
    ) {
        $this->_localeFormat = $localeFormat;
        $this->_helper = $helper;
    }
	
    /**
     * Convert and round price to currency format
     *
     * @param object $subject CurrencyModel
     * @param object $proceed callable	 
     * @param float $price
     * @param mixed $toCurrency
     * @return float
     */
    public function aroundConvert(
		CurrencyModel $subject, $proceed, $price, $toCurrency = null
	) {
        $price = $proceed($price, $toCurrency);
        
		if ($this->isRoundEnabled($subject, $toCurrency)) {
			$price = $this->round($price);
			$price = $this->subtract($price);
		}
		return $price;
    }

    /**
     * Retrieve the formatted price
     * 
     * @param object $subject CurrencyModel
     * @param object $proceed callable	 
     * @param float $price
     * @param array $options
     * @return string
     */
    public function aroundFormatTxt(
		CurrencyModel $subject, $proceed, $price, $options = []
	) {
        $price = $this->getNumber($price);

        if (!$this->_helper->isShowDecimalZero() && 
			intval($price) == $price) {
            $options['precision'] = 0;
        }        
        
        if (!$this->_helper->isReplaceZeroPrice() || 0 < $price) {
			return $proceed($price, $options);
		}		
        return sprintf(
			'<span class="price-free">%s</span>', 
			$this->_helper->getZeroPriceText()
		);		
    }
    
    /**
     * Check round price convert functionality should be enabled
     *
     * @param object $subject CurrencyModel
     * @param mixed $toCurrency
     * @return bool
     */
    public function isRoundEnabled(CurrencyModel $currency, $toCurrency)
    {
		if (!$this->_helper->isEnabled()) {
			return false;
		}
		if (!$this->_helper->isRoundingBasePrice()) {
			if (is_null($toCurrency) || 
				$this->getCurrencyCode($toCurrency) == $currency->getCode()
			) {
				return false;
			}
		}		
		return true;
    }
    
    /**
     * Retrieve the first found number from an string
     *
     * @param string|float|int $price
     * @return float|null
     */
    protected function getNumber($price)
    {
        if (!is_numeric($price)) {
            return $this->_localeFormat->getNumber($price);
        }
        return $price;
    }
    
    /**
     * Formats a number as a currency string
     * 
     * @param float $price
     * @return string
     */
    protected function format($price)
    {
		return sprintf('%0.4F', $price);
    }
       
    /**
     * Retrieve the price with a subtracted amount
     * 
     * @param float $price
     * @return float
     */
    protected function subtract($price)
    {
		if ($this->_helper->isSubtract()) {
			$price = $price - $this->_helper->getAmount();
		}					
		return (0 < $price) 
			? $price 
			: $this->format(0);
    }
               
    /**
     * Retrieve the rounded price
     * 
     * @param float $price
     * @return float
     */
    protected function round($price)
    {
		$precision = $this->_helper->getPrecision();
				
		switch ($this->_helper->getRoundType()) {
			case self::TYPE_CEIL:
				$price = round($price, $precision, PHP_ROUND_HALF_UP);
				break;
			case self::TYPE_FLOOR:
				$price = round($price, $precision, PHP_ROUND_HALF_DOWN);
				break;
		}
		return $this->format($price);
    }
    	
    /**
     * Retrieve currency code
     * 
     * @param mixed $toCurrency
     * @return string
     * @throws InputException
     */
    protected function getCurrencyCode($toCurrency)
    {
        if (is_string($toCurrency)) {
            $code = $toCurrency;
        } elseif ($toCurrency instanceof CurrencyModel) {
            $code = $toCurrency->getCurrencyCode();
        } else {
            throw new InputException(
				__('Please correct the target currency.')
			);
        }       
        return $code;
    }	
}
