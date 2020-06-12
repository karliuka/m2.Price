<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Plugin\Directory\Model;

use Magento\Framework\Exception\InputException;
use Magento\Directory\Model\Currency as CurrencyInterface;
use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\Calculator;
use Faonni\Price\Model\Formatter;

/**
 * Currency plugin
 */
class Currency
{
    /**
     * Round price helper
     *
     * @var PriceHelper
     */
    private $helper;

    /**
     * Price calculator
     *
     * @var Calculator
     */
    private $calculator;

    /**
     * Locale format
     *
     * @var Formatter
     */
    private $formatter;

    /**
     * Initialize plugin
     *
     * @param Calculator $calculator
     * @param Formatter $formatter
     * @param PriceHelper $helper
     */
    public function __construct(
        Calculator $calculator,
        Formatter $formatter,
        PriceHelper $helper
    ) {
        $this->calculator = $calculator;
        $this->formatter = $formatter;
        $this->helper = $helper;
    }

    /**
     * Convert and round price to currency format
     *
     * @param CurrencyInterface $subject
     * @param callable $proceed
     * @param float $price
     * @param mixed $toCurrency
     * @return float|string
     */
    public function aroundConvert(
        CurrencyInterface $subject,
        callable $proceed,
        $price,
        $toCurrency = null
    ) {
        $price = $proceed($price, $toCurrency);

        if ($this->isRoundEnabled($subject, $toCurrency)) {
            $price = $this->calculator->calculate($price);
        }
        return $price;
    }

    /**
     * Retrieve the formatted price
     *
     * @param CurrencyInterface $subject
     * @param callable $proceed
     * @param float $price
     * @param mixed[] $options
     * @return string
     */
    public function aroundFormatTxt(
        CurrencyInterface $subject,
        callable $proceed,
        $price,
        $options = []
    ) {
        return ($this->helper->isEnabled())
            ? $this->formatter->format($proceed, $price, $options)
            : $proceed($price, $options);
    }

    /**
     * Check round price convert functionality should be enabled
     *
     * @param CurrencyInterface $currency
     * @param mixed $toCurrency
     * @return bool
     */
    private function isRoundEnabled(CurrencyInterface $currency, $toCurrency)
    {
        if (!$this->helper->isEnabled()) {
            return false;
        }
        if (!$this->helper->isRoundingBasePrice()) {
            if (null === $toCurrency ||
                $this->getCurrencyCode($toCurrency) == $currency->getCode()
            ) {
                return false;
            }
        }
        return true;
    }

    /**
     * Retrieve currency code
     *
     * @param mixed $toCurrency
     * @return string
     * @throws InputException
     */
    private function getCurrencyCode($toCurrency)
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
