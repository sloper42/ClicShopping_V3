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
  namespace ClicShopping\Service\ClicShoppingAdmin;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  use ClicShopping\Sites\Shop\CustomerShop as CustomerShopClass;

  class CustomersShop implements \ClicShopping\OM\ServiceInterface {

    public static function start() {
      if (is_file(CLICSHOPPING::BASE_DIR . 'Sites/Shop/CustomerShop.php')) {
        Registry::set('Customer', new CustomerShopClass());
        return true;
      } else {
        return false;
      }
    }

    public static function stop() {
      return true;
    }
  }
