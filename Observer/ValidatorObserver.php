<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * 
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\Math;

/**
 * SalesRule Validator Observer
 */
class ValidatorObserver implements ObserverInterface
{
    /**
	 * Round Price Helper
	 *
     * @var \Faonni\Price\Helper\Data
     */
    protected $_helper;
    
    /**
     * Math Processor
     * 
     * @var \Faonni\Price\Model\Math
     */
    protected $_math;     
	
    /**
     * Initialize Observer
	 *
     * @param Math $math	 
     * @param PriceHelper $helper
     */
    public function __construct(
        Math $math,    
        PriceHelper $helper
    ) {
        $this->_math = $math;        
        $this->_helper = $helper;
    }

    /**
     * Rounding Calculated Discount
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if (!$this->_helper->isEnabled() || 
			!$this->_helper->isRoundingDiscount()
		) {
            return;
        }
        $discount = $observer->getEvent()->getResult();
		$discount->setAmount(
			$this->_math->round($discount->getAmount())
		);
    }
}
