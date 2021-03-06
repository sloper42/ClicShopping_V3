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


  namespace ClicShopping\Apps\Configuration\TaxGeoZones\Sites\ClicShoppingAdmin\Pages\Home\Actions\TaxGeoZones;

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;

  class UpdateGeoZone extends \ClicShopping\OM\PagesActionsAbstract {
    protected $app;

    public function __construct() {
      $this->app = Registry::get('TaxGeoZones');
    }

    public function execute() {

      $sID = HTML::sanitize($_GET['sID']);
      $zID = HTML::sanitize($_GET['zID']);
      $zone_country_id = HTML::sanitize($_POST['zone_country_id']);
      $zone_id = HTML::sanitize($_POST['zone_id']);

      $this->app->db->save('zones_to_geo_zones', [
                                              'geo_zone_id' => (int)$zID,
                                              'zone_country_id' => (int)$zone_country_id,
                                              'zone_id' => (!empty($zone_id) ? (int)$zone_id : 'null'),
                                              'last_modified' => 'now()'
                                              ], [
                                                'association_id' => (int)$sID
                                              ]
                     );

      $this->app->redirect('ListGeo&zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&spage=' . $_GET['spage'] . '&sID=' . $_GET['sID']);
    }
  }