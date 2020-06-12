<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\Calculator;

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
     * Price Calculator
     *
     * @var Calculator
     */
    private $calculator;


    /**
     * Initialize Observer
     *
     * @param Calculator $calculator
     * @param PriceHelper $helper
     */
    public function __construct(
        Calculator $calculator,
        PriceHelper $helper
    ) {
        $this->calculator = $calculator;
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
        if ($this->isRoundEnabled()) {
            $discount = $observer->getEvent()->getResult();
            $discount->setAmount(
                $this->calculator->calculate($discount->getAmount())
            );
        }
    }

    /**
     * Check Round Price Convert Functionality Should be Enabled
     *
     * @return bool
     */
    private function isRoundEnabled()
    {
        return $this->helper->isEnabled() && $this->helper->isRoundingDiscount();
    }
}
