<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model;

use Faonni\Price\Helper\Data as PriceHelper;

/**
 * Math Model
 */
class Math
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
     * Excel Round Fractions Up
     */	
	const TYPE_EXCEL_CEIL = 'excel_ceil';
	
    /**
     * Excel Round Fractions
     */	
	const TYPE_EXCEL_ROUND = 'excel_round';	
	
    /**
     * Excel Round Fractions Down
     */	
	const TYPE_EXCEL_FLOOR = 'excel_floor';	
	
    /**
     * Round Price Helper
     *
     * @var Faonni\Price\Helper\Data
     */
    protected $_helper;    
	
    /**
     * Initialize Model
     * 
     * @param PriceHelper $helper
     */
    public function __construct(
        PriceHelper $helper
    ) {
        $this->_helper = $helper;
    }
	         
    /**
     * Retrieve the Rounded Price
     * 
     * @param float $price
     * @return float
     */
    public function round($price)
    {
		$helper = $this->_helper;
		$fraction = $helper->getSwedishFraction();
		$precision = $helper->getPrecision();
		$multiplier = pow(10, abs($precision));
		switch ($helper->getRoundType()) {
			case self::TYPE_CEIL:
                $price = round($price, $precision, PHP_ROUND_HALF_UP);
                break;
			case self::TYPE_FLOOR:
				$price = round($price, $precision, PHP_ROUND_HALF_DOWN);
				break;
			case self::TYPE_SWEDISH_CEIL:
				$price = ceil($price/$fraction) * $fraction;
				break;
			case self::TYPE_SWEDISH_ROUND:
				$price = round($price/$fraction) * $fraction;
				break;
			case self::TYPE_SWEDISH_FLOOR:
				$price = floor($price/$fraction) * $fraction;
				break;
			case self::TYPE_EXCEL_CEIL:
				$price = $precision < 0 
					? ceil($price/$multiplier) * $multiplier 
					: ceil($price * $multiplier)/$multiplier;
				break;
			case self::TYPE_EXCEL_ROUND:
				$price = $precision < 0 
					? round($price/$multiplier) * $multiplier 
					: round($price * $multiplier)/$multiplier;
				break;
			case self::TYPE_EXCEL_FLOOR:
				$price = $precision < 0 
					? floor($price/$multiplier) * $multiplier 
					: floor($price * $multiplier)/$multiplier;
				break;				
		}
		return $price;
    }
}
