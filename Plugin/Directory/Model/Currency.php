<?php
/**
 * Copyright © 2011-2017 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Plugin\Directory\Model;

use Magento\Framework\Exception\InputException;
use Magento\Framework\Locale\FormatInterface;
use Magento\Directory\Model\Currency as CurrencyInterface;
use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\Math;

/**
 * Currency Plugin
 */
class Currency
{
    /**
     * Round Fractions Up
     */	
	const TYPE_CEIL = 'ceil';
	
    /**
     * Round Fractions Down
     */	
	const TYPE_FLOOR = 'floor';
	
    /**
     * Swedish Round Fractions Up
     */	
	const TYPE_SWEDISH_CEIL = 'swedish_ceil';
	
    /**
     * Swedish Round Fractions
     */	
	const TYPE_SWEDISH_ROUND = 'swedish_round';
	
    /**
     * Swedish Round Fractions Down
     */	
	const TYPE_SWEDISH_FLOOR = 'swedish_floor';
	
    /**
     * Round Price Helper
     *
     * @var Faonni\Price\Helper\Data
     */
    protected $_helper;
    
    /**
     * Math Processor
     * 
     * @var \Faonni\Price\Model\Math
     */
    protected $_math;     
    
    /**
     * Locale Format
     * 
     * @var \Magento\Framework\Locale\FormatInterface
     */
    protected $_localeFormat;    
	
    /**
     * Initialize Plugin
     *
     * @param Math $math     
     * @param FormatInterface $localeFormat
     * @param PriceHelper $helper
     */
    public function __construct(
        Math $math,
        FormatInterface $localeFormat,
        PriceHelper $helper
    ) {
        $this->_math = $math;
        $this->_localeFormat = $localeFormat;
        $this->_helper = $helper;
    }
	
    /**
     * Convert and Round Price to Currency Format
     *
     * @param object $subject CurrencyInterface
     * @param object $proceed callable	 
     * @param float $price
     * @param mixed $toCurrency
     * @return float
     */
    public function aroundConvert(
		CurrencyInterface $subject, $proceed, $price, $toCurrency = null
	) {
        $price = $proceed($price, $toCurrency);
        
		if ($this->isRoundEnabled($subject, $toCurrency)) {
			$price = $this->round($price);
			$price = $this->subtract($price);
		}
		return $price;
    }

    /**
     * Retrieve the Formatted Price
     * 
     * @param object $subject CurrencyInterface
     * @param object $proceed callable	 
     * @param float $price
     * @param array $options
     * @return string
     */
    public function aroundFormatTxt(
		CurrencyInterface $subject, $proceed, $price, $options = []
	) {
        return ($this->_helper->isEnabled()) 
            ? $this->formatTxt($proceed, $price, $options)
            : $proceed($price, $options);		
    }
    
    /**
     * Check Round Price Convert Functionality Should be Enabled
     *
     * @param object $subject CurrencyInterface
     * @param mixed $toCurrency
     * @return bool
     */
    public function isRoundEnabled(CurrencyInterface $currency, $toCurrency)
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
     * Retrieve the Formatted Price
     * 
     * @param object $proceed callable	 
     * @param float $price
     * @param array $options
     * @return string
     */
    protected function formatTxt($proceed, $price, $options = []) 
    {
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
     * Retrieve the First Found Number from an String
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
     * Formats a Number as a Currency String
     * 
     * @param float $price
     * @return string
     */
    protected function format($price)
    {
		return sprintf('%0.4F', $price);
    }
       
    /**
     * Retrieve the Price With a Subtracted Amount
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
     * Retrieve the Rounded Price
     * 
     * @param float $price
     * @return float
     */
    protected function round($price)
    {
		return $this->format(
			$this->_math->round($price)
		);
    }
    	
    /**
     * Retrieve Currency Code
     * 
     * @param mixed $toCurrency
     * @return string
     * @throws InputException
     */
    protected function getCurrencyCode($toCurrency)
    {
        if (is_string($toCurrency)) {
            $code = $toCurrency;
        } elseif ($toCurrency instanceof CurrencyInterface) {
            $code = $toCurrency->getCurrencyCode();
        } else {
            throw new InputException(
				__('Please correct the target currency.')
			);
        }       
        return $code;
    }	
}
