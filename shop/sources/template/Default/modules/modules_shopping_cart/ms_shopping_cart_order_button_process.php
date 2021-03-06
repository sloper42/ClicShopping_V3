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

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;
  use ClicShopping\OM\CLICSHOPPING;

  class ms_shopping_cart_order_button_process {
    public $code;
    public $group;
    public $title;
    public $description;
    public $sort_order;
    public $enabled = false;

    public function __construct() {
      $this->code = get_class($this);
      $this->group = basename(__DIR__);

      $this->title = CLICSHOPPING::getDef('module_shopping_cart_order_button_process_title');
      $this->description = CLICSHOPPING::getDef('module_shopping_cart_show_total_description');

      if (defined('MODULE_SHOPPING_CART_ORDER_BUTTON_PROCESS_STATUS')) {
        $this->sort_order = MODULE_SHOPPING_CART_ORDER_BUTTON_PROCESS_SORT_ORDER;
        $this->enabled = (MODULE_SHOPPING_CART_ORDER_BUTTON_PROCESS_STATUS == 'True');
      }
     }

    public function execute() {

      $CLICSHOPPING_ShoppingCart = Registry::get('ShoppingCart');
      $CLICSHOPPING_Template = Registry::get('Template');
      $CLICSHOPPING_NavigationHistory = Registry::get('NavigationHistory');

      if (isset($_GET['Cart'])  && $CLICSHOPPING_ShoppingCart->getCountContents() > 0) {

        $back = count($CLICSHOPPING_NavigationHistory->path)-2;

        if (isset($CLICSHOPPING_NavigationHistory->path[$back])) {
          $button_navigation_history =  HTML::button(CLICSHOPPING::getDef('button_continue'), null, CLICSHOPPING::link($CLICSHOPPING_NavigationHistory->path[$back]['page'], CLICSHOPPING::ArrayToString($CLICSHOPPING_NavigationHistory->path[$back]['get'], array('action')), $CLICSHOPPING_NavigationHistory->path[$back]['mode']), 'info');
        }

        $button_continue =  HTML::button(CLICSHOPPING::getDef('button_order'), null, CLICSHOPPING::link('index.php', 'Checkout&Shipping'), 'success');

        $content_width = (int)MODULE_SHOPPING_CART_ORDER_BUTTON_PROCESS_CONTENT_WIDTH;

        $shopping_cart_information_customers = '  <!-- start ms_shopping_cart_order_button_process -->'. "\n";

        ob_start();
        require($CLICSHOPPING_Template->getTemplateModules($this->group . '/content/shopping_cart_order_button_process'));
        $shopping_cart_information_customers .= ob_get_clean();

        $shopping_cart_information_customers .= '<!-- end ms_shopping_cart_order_button_process -->' . "\n";

        $CLICSHOPPING_Template->addBlock($shopping_cart_information_customers, $this->group);
      }
    } // function execute

    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return defined('MODULE_SHOPPING_CART_ORDER_BUTTON_PROCESS_STATUS');
    }

    public function install() {
      $CLICSHOPPING_Db = Registry::get('Db');

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Do you want activate this module ?',
          'configuration_key' => 'MODULE_SHOPPING_CART_ORDER_BUTTON_PROCESS_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Do you want activate this module in your shop ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Please select the width of the module ?',
          'configuration_key' => 'MODULE_SHOPPING_CART_ORDER_BUTTON_PROCESS_CONTENT_WIDTH',
          'configuration_value' => '12',
          'configuration_description' => 'Select a number between 1 and 12',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_content_module_width_pull_down',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Sort order',
          'configuration_key' => 'MODULE_SHOPPING_CART_ORDER_BUTTON_PROCESS_SORT_ORDER',
          'configuration_value' => '350',
          'configuration_description' => 'Sort order of display. Lowest is displayed first',
          'configuration_group_id' => '6',
          'sort_order' => '4',
          'set_function' => '',
          'date_added' => 'now()'
        ]
      );

      return $CLICSHOPPING_Db->save('configuration', ['configuration_value' => '1'],
        ['configuration_key' => 'WEBSITE_MODULE_INSTALLED']
      );
    }

    public function remove() {
      return Registry::get('Db')->exec('delete from :table_configuration where configuration_key in ("' . implode('", "', $this->keys()) . '")');
    }

    public function keys() {
      return array (
        'MODULE_SHOPPING_CART_ORDER_BUTTON_PROCESS_STATUS',
        'MODULE_SHOPPING_CART_ORDER_BUTTON_PROCESS_CONTENT_WIDTH',
        'MODULE_SHOPPING_CART_ORDER_BUTTON_PROCESS_SORT_ORDER'
      );
    }
  }
