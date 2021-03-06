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

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\HTML;

// set the level of error reporting
  error_reporting(E_ALL & ~E_DEPRECATED);

  define('CLICSHOPPING_BASE_DIR', realpath(__DIR__ . '/../../includes/') . '/ClicShopping/');

  require(CLICSHOPPING_BASE_DIR . 'OM/CLICSHOPPING.php');
  spl_autoload_register('ClicShopping\OM\CLICSHOPPING::autoload');

  if (isset($_GET['language'])) {
    setcookie('Lor_Language', HTML::sanitize($_GET['language']));

    $language = $_GET['language'];
  } elseif (isset($_COOKIE['Lor_Language'])) {
    $language = $_COOKIE['Lor_Language'];
  } else {
    $language = 'english';
  }

  CLICSHOPPING::initialize();
