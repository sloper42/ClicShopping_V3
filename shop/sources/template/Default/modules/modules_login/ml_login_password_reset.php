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

  use ClicShopping\OM\HTML;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class ml_login_password_reset {
    public $code;
    public $group;
    public $title;
    public $description;
    public $sort_order;
    public $enabled = false;
    protected $email_address;
    protected $password_key;

    public function __construct() {
      $this->code = get_class($this);
      $this->group = basename(__DIR__);

      $this->title = CLICSHOPPING::getDef('module_login_password_reset_title');
      $this->description = CLICSHOPPING::getDef('module_login_password_reset_description');

      if (defined('MODULE_LOGIN_PASSWORD_RESET_STATUS')) {
        $this->sort_order = MODULE_LOGIN_PASSWORD_RESET_SORT_ORDER;
        $this->enabled = (MODULE_LOGIN_PASSWORD_RESET_STATUS == 'True');
      }
     }

   public function execute() {
      $CLICSHOPPING_Template = Registry::get('Template');

      if (isset($_GET['Account']) && isset($_GET['PasswordReset'])) {

        $content_width = (int)MODULE_LOGIN_PASSWORD_RESET_CONTENT_WIDTH;

        $ml_password = '<!-- ml_login_password_reset start-->' . "\n";

        $email_address= HTML::sanitize(($_GET['account']));
        $password_key = HTML::sanitize($_GET['key']);

        $form = HTML::form('password_reset', CLICSHOPPING::link('index.php', 'Account&PasswordReset&Process&account=' . $email_address . '&key=' . $password_key . '&action=process'), 'post', '', ['tokenize' => true]);
        $endform = '</form>';

        ob_start();
        require($CLICSHOPPING_Template->getTemplateModules($this->group . '/content/login_password_reset'));

        $ml_password .= ob_get_clean();

        $ml_password .= '<!-- ml_login_password_reset  end-->' . "\n";

        $CLICSHOPPING_Template->addBlock($ml_password, $this->group);
      }
    } // function execute

    public function isEnabled() {
      return $this->enabled;
    }

    public function check() {
      return defined('MODULE_LOGIN_PASSWORD_RESET_STATUS');
    }

    public function install() {
      $CLICSHOPPING_Db = Registry::get('Db');

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Do you want activate this module ?',
          'configuration_key' => 'MODULE_LOGIN_PASSWORD_RESET_STATUS',
          'configuration_value' => 'True',
          'configuration_description' => 'Do you want activate this module in your shop ?',
          'configuration_group_id' => '6',
          'sort_order' => '1',
          'set_function' => 'clic_cfg_set_boolean_value(array(\'True\', \'False\'))',
          'date_added' => 'now()'
        ]
      );

      $CLICSHOPPING_Db->save('configuration', [
          'configuration_title' => 'Please select the width of the module',
          'configuration_key' => 'MODULE_LOGIN_PASSWORD_RESET_CONTENT_WIDTH',
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
          'configuration_key' => 'MODULE_LOGIN_PASSWORD_RESET_SORT_ORDER',
          'configuration_value' => '120',
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
        'MODULE_LOGIN_PASSWORD_RESET_STATUS',
        'MODULE_LOGIN_PASSWORD_RESET_CONTENT_WIDTH',
        'MODULE_LOGIN_PASSWORD_RESET_SORT_ORDER'
      );
    }
  }
