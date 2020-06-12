<?php
/**
 * Copyright © Karliuka Vitalii(karliuka.vitalii@gmail.com)
 * See COPYING.txt for license details.
 */
namespace Faonni\Price\Model;

use Magento\Framework\Locale\FormatInterface;
use Faonni\Price\Helper\Data as PriceHelper;

/**
 * Price formatter
 */
class Formatter
{
    /**
     * Round price helper
     *
     * @var PriceHelper
     */
    private $helper;

    /**
     * Locale format
     *
     * @var FormatInterface
     */
    private $localeFormat;

    /**
     * Initialize formatter
     *
     * @param FormatInterface $localeFormat
     * @param PriceHelper $helper
     */
    public function __construct(
        FormatInterface $localeFormat,
        PriceHelper $helper
    ) {
        $this->localeFormat = $localeFormat;
        $this->helper = $helper;
    }

    /**
     * Retrieve the formatted price
     *
     * @param callable $proceed
     * @param float $price
     * @param mixed[] $options
     * @return string
     */
    public function format(callable $proceed, $price, $options = [])
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
     * Retrieve the first found number from an string
     *
     * @param float $price
     * @return float
     */
    private function getNumber($price)
    {
        if (!is_numeric($price)) {
            return (float)$this->localeFormat->getNumber($price);
        }
        return $price;
    }
}
