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

  namespace ClicShopping\Apps\Customers\Groups\Module\Hooks\ClicShoppingAdmin\BannerManager;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;

  use ClicShopping\Apps\Customers\Groups\Groups as GroupsApp;

  class Update implements \ClicShopping\OM\Modules\HooksInterface {
    protected $app;

    public function __construct()   {
      if (!Registry::exists('Groups')) {
        Registry::set('Groups', new GroupsApp());
      }

      $this->app = Registry::get('Groups');
    }

    public function execute() {
      if (isset($_GET['Update'])) {
        if (isset($_POST['banners_id'])) {
          $customers_group_id = HTML::sanitize($_POST['customers_group']);

          $banners_id = HTML::sanitize($_POST['banners_id']);

          $sql_data_array =  ['customers_group_id' => (int)$customers_group_id];

          $this->app->db->save('products_favorites', $sql_data_array,  ['banners_id' => (int)$banners_id]);
        }
      }
    }
  }