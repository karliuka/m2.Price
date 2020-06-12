<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Round Price Helper
 */
class Data extends AbstractHelper
{
    /**
     * Enabled Config Path
     */
    const XML_ROUND_ENABLED = 'currency/price/enabled';

    /**
     * Subtract Config Path
     */
    const XML_ROUND_SUBTRACT = 'currency/price/subtract';

    /**
     * Rounding Base Price Config Path
     */
    const XML_ROUND_BASE_PRICE = 'currency/price/base_price';

    /**
     * Rounding Type Config Path
     */
    const XML_ROUND_TYPE = 'currency/price/type';

    /**
     * Rounding Subtract Amount Config Path
     */
    const XML_ROUND_AMOUNT = 'currency/price/amount';

    /**
     * Rounding Precision Config Path
     */
    const XML_ROUND_PRECISION = 'currency/price/precision';

    /**
     * Show Decimal Zeros Config Path
     */
    const XML_DECIMAL_ZERO = 'currency/price/show_decimal_zero';

    /**
     * Replace Zero Price Config Path
     */
    const XML_ZERO_PRICE = 'currency/price/replace_zero_price';

    /**
     * Text of Replace Config Path
     */
    const XML_ZERO_PRICE_TEXT = 'currency/price/zero_price_text';

    /**
     * Swedish Rounding Fraction Config Path
     */
    const XML_SWEDISH_ROUND_FRACTION = 'currency/price/swedish_fraction';

    /**
     * Rounding Discount Config Path
     */
    const XML_ROUND_DISCOUNT = 'currency/price/discount';

    /**
     * Check Round Price Convert Functionality Should be Enabled
     *
     * @param string $storeId
     * @return bool
     */
    public function isEnabled($storeId = null)
    {
        return $this->isSetFlag(self::XML_ROUND_ENABLED, $storeId);
    }

    /**
     * Check Subtract 0.01 Functionality Should be Enabled
     *
     * @param string $storeId
     * @return bool
     */
    public function isSubtract($storeId = null)
    {
        return $this->isSetFlag(self::XML_ROUND_SUBTRACT, $storeId);
    }

    /**
     * Check Decimal Zero Functionality Should be Enabled
     *
     * @param string $storeId
     * @return bool
     */
    public function isShowDecimalZero($storeId = null)
    {
        return $this->isSetFlag(self::XML_DECIMAL_ZERO, $storeId);
    }

    /**
     * Check Replace Zero Price Functionality Should be Enabled
     *
     * @param string $storeId
     * @return bool
     */
    public function isReplaceZeroPrice($storeId = null)
    {
        return $this->isSetFlag(self::XML_ZERO_PRICE, $storeId);
    }

    /**
     * Check Rounding Base Price
     *
     * @param string $storeId
     * @return bool
     */
    public function isRoundingBasePrice($storeId = null)
    {
        return $this->isSetFlag(self::XML_ROUND_BASE_PRICE, $storeId);
    }

    /**
     * Check Rounding Discount
     *
     * @param string $storeId
     * @return bool
     */
    public function isRoundingDiscount($storeId = null)
    {
        return $this->isSetFlag(self::XML_ROUND_DISCOUNT, $storeId);
    }

    /**
     * Retrieve Rounding Type
     *
     * @param string $storeId
     * @return string
     */
    public function getRoundType($storeId = null)
    {
        return $this->getValue(self::XML_ROUND_TYPE, $storeId);
    }

    /**
     * Retrieve Subtract Amount
     *
     * @param string $storeId
     * @return float|int
     */
    public function getAmount($storeId = null)
    {
        $amount = $this->getValue(self::XML_ROUND_AMOUNT, $storeId);
        return is_numeric($amount)
            ? (float)$amount
            : 0;
    }

    /**
     * Retrieve Precision
     *
     * @param string $storeId
     * @return int
     */
    public function getPrecision($storeId = null)
    {
        return (int)$this->getValue(self::XML_ROUND_PRECISION, $storeId);
    }

    /**
     * Retrieve Text of Replace
     *
     * @param string $storeId
     * @return string
     */
    public function getZeroPriceText($storeId = null)
    {
        return $this->getValue(self::XML_ZERO_PRICE_TEXT, $storeId);
    }

    /**
     * Retrieve Swedish Round Fraction
     *
     * @param string $storeId
     * @return float
     */
    public function getSwedishFraction($storeId = null)
    {
        $fraction = (float)$this->getValue(self::XML_SWEDISH_ROUND_FRACTION, $storeId);
        return ($fraction > 0)
            ? $fraction
            : 0.05;
    }

    /**
     * Retrieve config value by path and scope
     *
     * @param string $path
     * @param string $storeId
     * @return mixed
     */
    protected function getValue($path, $storeId = null)
    {
        return $this->scopeConfig->getValue($path, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Retrieve config flag
     *
     * @param string $path
     * @param string $storeId
     * @return bool
     */
    protected function isSetFlag($path, $storeId = null)
    {
        return $this->scopeConfig->isSetFlag($path, ScopeInterface::SCOPE_STORE, $storeId);
    }
}
