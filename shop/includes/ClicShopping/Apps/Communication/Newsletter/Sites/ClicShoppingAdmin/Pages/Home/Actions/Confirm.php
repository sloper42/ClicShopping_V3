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

  namespace ClicShopping\Apps\Communication\Newsletter\Sites\ClicShoppingAdmin\Pages\Home\Actions;


  use ClicShopping\OM\Registry;

  class Confirm extends \ClicShopping\OM\PagesActionsAbstract {
    public function execute() {
      $CLICSHOPPING_Newsletter = Registry::get('Newsletter');

      $this->page->setFile('confirm.php');

      $CLICSHOPPING_Newsletter->loadDefinitions('Sites/ClicShoppingAdmin/Newsletter');
    }
  }