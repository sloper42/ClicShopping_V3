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

  namespace ClicShopping\Sites\Shop\Pages\Products\Actions;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class Notify extends \ClicShopping\OM\PagesActionsAbstract {

    public function execute() {
      $CLICSHOPPING_Db = Registry::get('Db');
      $CLICSHOPPING_Language = Registry::get('Language');

      $Qproduct = $CLICSHOPPING_Db->prepare('select p.products_id from :table_products p
                                             and p.products_status = 1
                                             and pd.language_id = :language_id');
      $Qproduct->bindInt(':products_id', (int)$_GET['products_id']);
      $Qproduct->bindInt(':language_id', $CLICSHOPPING_Language->getId());
      $Qproduct->execute();

      $product_exists = ($Qproduct->fetch() !== false);

      $CLICSHOPPING_Customer = Registry::get('Customer');
      $CLICSHOPPING_NavigationHistory = Registry::get('NavigationHistory');

      if ( $product_exists === false ) {
        CLICSHOPPING::redirect('index.php');
      }

// if the customer is not logged on, redirect them to the login page
      if ( !$CLICSHOPPING_Customer->isLoggedOn() ) {
        $CLICSHOPPING_NavigationHistory->setSnapshot();

        CLICSHOPPING::redirect('index.php', 'Account&LogIn');
      }
    }
  }

