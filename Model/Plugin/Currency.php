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
namespace Faonni\Price\Model\Plugin;

use Magento\Framework\Exception\InputException;
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
     * @param Faonni\Price\Helper\Data $helper
     */
    public function __construct(
        PriceHelper $helper
    ) {
        $this->_helper = $helper;
    }
	
    /**
     * Convert and round price to currency format
     *
     * @param object $subject Magento\Directory\Model\Currency
     * @param object $proceed \callable	 
     * @param float $price
     * @param mixed $toCurrency
     * @return float
     */
    public function aroundConvert($subject, $proceed, $price, $toCurrency = null)
    {
        $price = $proceed($price, $toCurrency);
		
		if (!$this->_helper->isEnabled() || is_null($toCurrency) || $this->getCurrencyCode($toCurrency) == $subject->getCode()) {
			return $price;
		}

		switch ($this->_helper->getRoundType()) {
			case self::TYPE_CEIL:
				$price = round($price, $this->_helper->getPrecision(), PHP_ROUND_HALF_UP);
				break;
			case self::TYPE_FLOOR:
				$price = round($price, $this->_helper->getPrecision(), PHP_ROUND_HALF_DOWN);
				break;
		}
			
		if ($this->_helper->isSubtract()) {
			$price = $price - $this->_helper->getAmount();
		}			
		
		$price = (0 < $price) ? $price : 0;
		
		return $price;
    }
	
    /**
     * @param mixed $toCurrency
     * @return string
     * @throws \Magento\Framework\Exception\InputException
     */
    private function getCurrencyCode($toCurrency)
    {
        if (is_string($toCurrency)) {
            $code = $toCurrency;
        } elseif ($toCurrency instanceof \Magento\Directory\Model\Currency) {
            $code = $toCurrency->getCurrencyCode();
        } else {
            throw new InputException(__('Please correct the target currency.'));
        }
        return $code;
    }	
}
