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


  namespace ClicShopping\Sites\Shop;

  use ClicShopping\OM\Apps;
  use ClicShopping\OM\Registry;
  use ClicShopping\OM\CLICSHOPPING;

  class Shipping {
    public $modules;
    public $selected_module;
    protected $lang;

// class constructor
    public function __construct($module = null) {
      $this->lang = Registry::get('Language');

      if (defined('MODULE_SHIPPING_INSTALLED') && !is_null(MODULE_SHIPPING_INSTALLED)) {
        $this->modules = explode(';', MODULE_SHIPPING_INSTALLED);

        $include_modules = [];

        $code = null;

        if (isset($module) && is_array($module) && isset($module['id'])) {
          if (strpos($module['id'], '\\') !== false) {
            list($vendor, $app, $module) = explode('\\', $module['id']);

            $code = $vendor . '\\' . $app . '\\' . $module;
          }
        }

        if (isset($code) && (in_array($code . '.' . substr(CLICSHOPPING::getIndex(), (strrpos(CLICSHOPPING::getIndex(), '.')+1)), $this->modules) || in_array($code, $this->modules))) {
          if (strpos($code, '\\') !== false) {
            $class = Apps::getModuleClass($code, 'Shipping');

            $include_modules[] = ['class' => $code,
                               'file' => $class
                               ];
          }
        } else {
          foreach ($this->modules as $value) {
            if (strpos($value, '\\') !== false) {
              $class = Apps::getModuleClass($value, 'Shipping');

              $include_modules[] = ['class' => $value,
                                 'file' => $class
                                 ];
            }
          }
        }

        for ($i=0, $n=count($include_modules); $i<$n; $i++) {
          if (strpos($include_modules[$i]['class'], '\\') !== false) {
            Registry::set('Shipping_' . str_replace('\\', '_', $include_modules[$i]['class']), new $include_modules[$i]['file']);
          }
        }
      }
    }

/**
 * get the weight
 * @param int $shipping_num_boxes
 * @return float
 */
    public function getShippingWeight($shipping_num_boxes = 1) {
      $CLICSHOPPING_ShoppingCart = Registry::get('ShoppingCart');

      if (is_array($this->modules)) {
        $shipping_weight = $CLICSHOPPING_ShoppingCart->show_weight();

        if (SHIPPING_BOX_WEIGHT >= ($shipping_weight * (SHIPPING_BOX_PADDING / 100))) {
          $shipping_weight = $shipping_weight + SHIPPING_BOX_WEIGHT;
        } else {
          $shipping_weight = $shipping_weight + ($shipping_weight * (SHIPPING_BOX_PADDING / 100));
        }

        if ($shipping_weight > SHIPPING_MAX_WEIGHT) { // Split into many boxes
          $shipping_num_boxes = ceil($shipping_weight / SHIPPING_MAX_WEIGHT);
          $shipping_weight = $shipping_weight / $shipping_num_boxes;
        }
      }
      return $shipping_weight;
    }

/**
 * get shipping module elements id, title ...
 * @param null $method
 * @param null $module
 * @return array
 */
    public function getQuote($method = null, $module = null) {
      $quotes_array = [];

      if (is_array($this->modules)) {
        $shipping_quoted = '';

        $include_quotes = [];

        foreach($this->modules as $value) {
          if (strpos($value, '\\') !== false) {
            $obj = Registry::get('Shipping_' . str_replace('\\', '_', $value));

            if (!is_null($module)) {
              if ( ($module == $value) && ($obj->enabled) ) {
                $include_quotes[] = $value;
              }
            } elseif ($obj->enabled) {
              $include_quotes[] = $value;
            }
          }
        }

        $size = count($include_quotes);

        for ($i=0; $i<$size; $i++) {
          if (strpos($include_quotes[$i], '\\') !== false) {
            $quotes = Registry::get('Shipping_' . str_replace('\\', '_', $include_quotes[$i]))->quote($method);
          }

          if (is_array($quotes)) {
            $quotes_array[] = $quotes;
          }
        }
      }

      return $quotes_array;
    }

// function not include in shipping.php
// can put pb with module like post canada online 94
    public function getFirst() {
      foreach ( $this->modules as $value ) {
        if (strpos($value, '\\') !== false) {
          $obj = Registry::get('Shipping_' . str_replace('\\', '_', $value));
        }
        if ( $obj->enabled ) {
          foreach ( $obj->quotes['methods'] as $method ) {
            if ( isset($method['cost']) && !is_null($method['cost']) ) {
              return [
                      'id' => $obj->quotes['id'] . '_' . $method['id'],
                      'title' => $obj->quotes['module'] . (isset($method['title']) && !empty($method['title']) ? ' (' . $method['title'] . ')' : ''),
                      'cost' => $method['cost']
                     ];
            }
          }
        }
      }
    }

/**
 * get the cheapest shipping
 * @return bool|mixed
 */
    public function getCheapest() {
      if (is_array($this->modules)) {
        $rates = [];

        foreach($this->modules as $value) {
          if (strpos($value, '\\') !== false) {
            $obj = Registry::get('Shipping_' . str_replace('\\', '_', $value));
          }

          if ($obj->enabled) {
            $quotes = $obj->quotes;

            for ($i=0, $n=count( $quotes['methods'] ? : []); $i<$n; $i++) {
              if (isset($quotes['methods'][$i]['cost']) && !is_null($quotes['methods'][$i]['cost'])) {
                $rates[] = ['id' => $quotes['id'] . '_' . $quotes['methods'][$i]['id'],
                          'title' => $quotes['module'] . (isset($quotes['methods'][$i]['title']) && !empty($quotes['methods'][$i]['title']) ? ' (' . $quotes['methods'][$i]['title'] . ')' : ''),
                          'cost' => $quotes['methods'][$i]['cost']
                         ];
              }
            }
          }
        }

        $cheapest = false;

        for ($i=0, $n=count($rates); $i<$n; $i++) {
          if (is_array($cheapest)) {
            if ($rates[$i]['cost'] < $cheapest['cost']) {
              $cheapest = $rates[$i];
            }
          } else {
            $cheapest = $rates[$i];
          }
        }

        return $cheapest;
      }
    }

/**
 * Count shipping modules
 * @return int
 */
    function geCountShippingModules() {
      $count = 0;

      $modules_array = explode(';', MODULE_SHIPPING_INSTALLED);

      for ($i=0, $n=count($modules_array); $i<$n; $i++) {
        $m = $modules_array[$i];

        $CLICSHOPPING_SM = null;

        if (strpos($m, '\\') !== false) {
          list($vendor, $app, $module) = explode('\\', $m);

          $module = $vendor . '\\' . $app . '\\' . $module;

          $code = 'Shipping_' . str_replace('\\', '_', $module);

          if (Registry::exists($code)) {
            $CLICSHOPPING_SM = Registry::get($code);
          }
        }

        if (isset($CLICSHOPPING_SM) && $CLICSHOPPING_SM->enabled) {
          $count++;
        }
      }

      return $count;
    }
  }