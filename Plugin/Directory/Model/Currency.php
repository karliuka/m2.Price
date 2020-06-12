<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Plugin\Directory\Model;

use Magento\Framework\Exception\InputException;
use Magento\Framework\Locale\FormatInterface;
use Magento\Directory\Model\Currency as CurrencyInterface;
use Faonni\Price\Helper\Data as PriceHelper;
use Faonni\Price\Model\Calculator;

/**
 * Currency Plugin
 */
class Currency
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
     * Locale Format
     *
     * @var FormatInterface
     */
    protected $localeFormat;

    /**
     * Initialize Plugin
     *
     * @param Calculator $calculator
     * @param FormatInterface $localeFormat
     * @param PriceHelper $helper
     */
    public function __construct(
        Calculator $calculator,
        FormatInterface $localeFormat,
        PriceHelper $helper
    ) {
        $this->calculator = $calculator;
        $this->localeFormat = $localeFormat;
        $this->helper = $helper;
    }

    /**
     * Convert and Round Price to Currency Format
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
     * Retrieve the Formatted Price
     *
     * @param CurrencyInterface $subject
     * @param callable $proceed
     * @param float $price
     * @param array $options
     * @return string
     */
    public function aroundFormatTxt(
        CurrencyInterface $subject,
        callable $proceed,
        $price,
        $options = []
    ) {
        return ($this->helper->isEnabled())
            ? $this->formatTxt($proceed, $price, $options)
            : $proceed($price, $options);
    }

    /**
     * Check Round Price Convert Functionality Should be Enabled
     *
     * @param CurrencyInterface $currency
     * @param mixed $toCurrency
     * @return bool
     */
    public function isRoundEnabled(CurrencyInterface $currency, $toCurrency)
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
     * Retrieve the Formatted Price
     *
     * @param callable $proceed
     * @param float $price
     * @param array $options
     * @return string
     */
    protected function formatTxt(callable $proceed, $price, $options = [])
    {
        $price = $this->getNumber($price);

        if (!$this->helper->isShowDecimalZero() &&
            $price == (int)$price) {
            $options['precision'] = 0;
        }

        if (!$this->helper->isReplaceZeroPrice() || 0 != $price) {
            return $proceed($price, $options);
        }
        return sprintf(
            '<span class="price-free">%s</span>',
            $this->helper->getZeroPriceText()
        );
    }

    /**
     * Retrieve the First Found Number from an String
     *
     * @param float $price
     * @return float
     */
    protected function getNumber($price)
    {
        if (!is_numeric($price)) {
            return (float)$this->localeFormat->getNumber($price);
        }
        return $price;
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
