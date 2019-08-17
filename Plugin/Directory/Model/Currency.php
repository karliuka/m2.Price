<?php
/**
 * Copyright © 2011-2018 Karliuka Vitalii(karliuka.vitalii@gmail.com)
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
     * Locale Format
     *
     * @var FormatInterface
     */
    protected $localeFormat;

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
        $this->math = $math;
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
            $price = $this->round($price);
            $price = $this->subtract($price);
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
            intval($price) == $price) {
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
     * Formats a Number as a Currency String
     *
     * @param float $price
     * @return float
     */
    protected function format($price)
    {
        return (float)sprintf('%0.4F', $price);
    }

    /**
     * Retrieve the Price With a Subtracted Amount
     *
     * @param float $price
     * @return float|string
     */
    protected function subtract($price)
    {
        if ($this->helper->isSubtract()) {
            $price = $price - $this->helper->getAmount();
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
            $this->math->round($price)
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
