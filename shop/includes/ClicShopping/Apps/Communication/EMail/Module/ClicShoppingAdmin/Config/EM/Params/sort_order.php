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

  namespace ClicShopping\Apps\Communication\EMail\Module\ClicShoppingAdmin\Config\EM\Params;

  class sort_order extends \ClicShopping\Apps\Communication\EMail\Module\ClicShoppingAdmin\Config\ConfigParamAbstract {

    public $default = '30';
    public $sort_order = 300;
    public $app_configured = true;

    protected function init() {
        $this->title = $this->app->getDef('cfg_email_sort_order_title');
        $this->description = $this->app->getDef('cfg_email_sort_order_description');
    }
  }
