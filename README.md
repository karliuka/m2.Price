# Magento2 Rounding Price

[![Total Downloads](https://poser.pugx.org/faonni/module-price/downloads)](https://packagist.org/packages/faonni/module-price)
[![Latest Stable Version](https://poser.pugx.org/faonni/module-price/v/stable)](https://packagist.org/packages/faonni/module-price)

Rounding Price to Prettier Value for Multi-Currency Stores.

## Compatibility

Magento CE(EE) 2.0.x, 2.1.x, 2.2.x, 2.3.x

### Base prices - US Dollar

<img alt="Magento2 Rounding Price" src="https://karliuka.github.io/m2/price/base.png" style="width:100%"/>

### Store prices - Euro

<img alt="Magento2 Rounding Price" src="https://karliuka.github.io/m2/price/store.png" style="width:100%"/>

### Store rounding prices - Round fractions down, precision is 0

<img alt="Magento2 Rounding Price" src="https://karliuka.github.io/m2/price/floor-0.png" style="width:100%"/>

### Store rounding prices - Round fractions down, precision is -1

<img alt="Magento2 Rounding Price" src="https://karliuka.github.io/m2/price/floor-1.png" style="width:100%"/>

### Store rounding prices - Round fractions down, precision is -1 and enabled Subtract Amount

<img alt="Magento2 Rounding Price" src="https://karliuka.github.io/m2/price/floor-s.png" style="width:100%"/>

### Store rounding prices - Round fractions down, precision is -1 and enabled Subtract Amount(negative)

<img alt="Magento2 Rounding Price" src="https://karliuka.github.io/m2/price/floor-sn.png" style="width:100%"/>

### Configuration

<img alt="Magento2 Rounding Price" src="https://karliuka.github.io/m2/price/config.png" style="width:100%"/>

The idea of adding a rounding algorithm 'Swedish rounding' is suggested by [ScIT-Raphael](https://github.com/karliuka/m2.Price/issues/3).


## Install with Composer as you go

1. Go to Magento2 root folder

2. Enter following commands to install module:

    ```bash
    composer require faonni/module-price
    ```
   Wait while dependencies are updated.

3. Enter following commands to enable module:

    ```bash
    php bin/magento setup:upgrade
    php bin/magento setup:static-content:deploy
    ```

* [Rounding Price from Magento](https://github.com/karliuka/m1.Price)
