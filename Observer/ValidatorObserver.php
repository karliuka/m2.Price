<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
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
     * @var PriceHelper
     */
    protected $helper;

    /**
     * Math Processor
     *
     * @var Math
     */
    protected $math;

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
        $this->math = $math;
        $this->helper = $helper;
    }

    /**
     * Rounding Calculated Discount
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if (!$this->helper->isEnabled() ||
            !$this->helper->isRoundingDiscount()
        ) {
            return;
        }
        $discount = $observer->getEvent()->getResult();
        $discount->setAmount(
            $this->math->round($discount->getAmount())
        );
    }
}
