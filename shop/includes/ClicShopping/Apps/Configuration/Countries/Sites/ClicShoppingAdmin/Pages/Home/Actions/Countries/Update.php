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

  namespace ClicShopping\Apps\Configuration\Countries\Sites\ClicShoppingAdmin\Pages\Home\Actions\Countries;

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;

  class Update extends \ClicShopping\OM\PagesActionsAbstract {
    protected $app;

    public function __construct() {
      $this->app = Registry::get('Countries');
    }

    public function execute() {

      $countries_id = HTML::sanitize($_GET['cID']);
      $countries_name = HTML::sanitize($_POST['countries_name']);
      $countries_iso_code_2 = HTML::sanitize($_POST['countries_iso_code_2']);
      $countries_iso_code_3 = HTML::sanitize($_POST['countries_iso_code_3']);
      $address_format_id = HTML::sanitize($_POST['address_format_id']);
      $countries_status = HTML::sanitize($_POST['status']);

      $sql_array = ['countries_name' => $countries_name,
                   'countries_iso_code_2' => $countries_iso_code_2,
                   'countries_iso_code_3' => $countries_iso_code_3,
                   'address_format_id' => (int)$address_format_id,
                   'status' => (int)$countries_status
                  ];

      $this->app->db->save('countries', $sql_array, ['countries_id' => (int)$countries_id]);

      $this->app->redirect('Countries&page=' . $_GET['page'] . '&cID=' . $countries_id);
    }
  }