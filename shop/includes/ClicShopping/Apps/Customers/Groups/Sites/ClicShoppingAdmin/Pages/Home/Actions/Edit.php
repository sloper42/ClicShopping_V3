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

  namespace ClicShopping\Apps\Customers\Groups\Sites\ClicShoppingAdmin\Pages\Home\Actions;

  use ClicShopping\OM\Registry;

  class Edit extends \ClicShopping\OM\PagesActionsAbstract {
    public function execute() {
      $CLICSHOPPING_Groups = Registry::get('Groups');
      $CLICSHOPPING_CategoriesAdmin = Registry::get('CategoriesAdmin');

      $this->page->setFile('edit.php');

      $CLICSHOPPING_Groups->loadDefinitions('Sites/ClicShoppingAdmin/groups');
    }
  }