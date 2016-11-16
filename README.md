# Magento2 Rounding Price
Rounding Price to Prettier Value for Multi-Currency Stores.

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

* [Rounding Price from Magento](https://github.com/karliuka/m1.RoundPriceConvert)