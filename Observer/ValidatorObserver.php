<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Event\Observer;
use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\CalculatorInterface;

/**
 * SalesRule validator observer
 */
class ValidatorObserver implements ObserverInterface
{
    /**
     * Round price helper
     *
     * @var PriceHelper
     */
    protected $helper;

    /**
     * Price calculator
     *
     * @var CalculatorInterface
     */
    private $calculator;

    /**
     * Initialize observer
     *
     * @param CalculatorInterface $calculator
     * @param PriceHelper $helper
     */
    public function __construct(
        CalculatorInterface $calculator,
        PriceHelper $helper
    ) {
        $this->calculator = $calculator;
        $this->helper = $helper;
    }

    /**
     * Rounding calculated discount
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        if ($this->isRoundEnabled()) {
            /** @var \Magento\SalesRule\Model\Rule\Action\Discount\Data $discountData */
            $discountData = $observer->getEvent()->getData('result');
            $discountData->setAmount(
                $this->calculator->calculate($discountData->getAmount())
            );
        }
    }

    /**
     * Check round price convert functionality should be enabled
     *
     * @return bool
     */
    private function isRoundEnabled()
    {
        return $this->helper->isEnabled() && $this->helper->isRoundingDiscount();
    }
}
