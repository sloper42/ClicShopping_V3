<?php
/**
 *
 *  @copyright 2008 - https://www.clicshopping.org
 *  @Brand : ClicShopping(Tm) at Inpi all right Reserved
 *  @Licence GPL 2 & MIT
 *  @licence MIT - Portion of osCommerce 2.4
 *
 *
 */

  namespace ClicShopping\Service\Shop;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  use ClicShopping\Apps\Configuration\Currency\Classes\Shop\Currencies as CurrenciesClass;

  class Currencies implements \ClicShopping\OM\ServiceInterface {

    public static function start() {
      if (is_file(CLICSHOPPING::BASE_DIR . 'Apps/Configuration/Currency/Classes/Shop/Currencies.php')) {
        Registry::set('Currencies', new CurrenciesClass());
        $CLICSHOPPING_Currencies = Registry::get('Currencies');

        if (!isset($_SESSION['currency']) || isset($_GET['currency']) || ((USE_DEFAULT_LANGUAGE_CURRENCY == 'true') && (CLICSHOPPING::getDef('language_currency') != $_SESSION['currency']))) {
          if (isset($_GET['currency']) && $CLICSHOPPING_Currencies->is_set($_GET['currency'])) {
            $_SESSION['currency'] = $_GET['currency'];
          } else {
            $_SESSION['currency'] = ((USE_DEFAULT_LANGUAGE_CURRENCY == 'true') && $CLICSHOPPING_Currencies->is_set(CLICSHOPPING::getDef('language_currency'))) ? CLICSHOPPING::getDef('language_currency') : DEFAULT_CURRENCY;
          }
        }
        return true;
      } else {
        return false;
      }
    }

    public static function stop() {
      return true;
    }
  }
