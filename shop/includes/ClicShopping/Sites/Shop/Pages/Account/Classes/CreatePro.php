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

  namespace ClicShopping\Sites\Shop\Pages\Account\Classes;

  use ClicShopping\OM\Registry;

  class CreatePro {

    public static function getCountryPro() {
      $CLICSHOPPING_Db = Registry::get('Db');

      $QcountryPro = $CLICSHOPPING_Db->prepare('select countries_iso_code_2
                                         from :table_countries
                                         where countries_id = :countries_id
                                        ');
      $QcountryPro->bindInt(':countries_id', (int)ACCOUNT_COUNTRY_PRO);
      $QcountryPro->execute();

      $default_country_pro = $QcountryPro->value('countries_iso_code_2');

      return $default_country_pro;
    }


  }