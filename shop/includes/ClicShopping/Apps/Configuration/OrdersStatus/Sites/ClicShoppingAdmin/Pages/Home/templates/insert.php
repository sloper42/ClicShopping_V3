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
  $CLICSHOPPING_Language = Registry::get('Language');
  $CLICSHOPPING_OrdersStatus = Registry::get('OrdersStatus');
  $CLICSHOPPING_Page = Registry::get('Site')->getPage();

  $orders_status_inputs_string = '';
  $languages = $CLICSHOPPING_Language->getLanguages();
?>
<!-- body //-->
<div class="contentBody">
  <div class="row">
    <div class="col-md-12">
      <div class="card card-block headerCard">
        <div class="row">
          <span class="col-md-1 logoHeading"><?php echo HTML::image($CLICSHOPPING_Template->getImageDirectory() . '/categories/order_status.gif', $CLICSHOPPING_OrdersStatus->getDef('heading_title'), '40', '40'); ?></span>
          <span class="col-md-4 pageHeading"><?php echo '&nbsp;' . $CLICSHOPPING_OrdersStatus->getDef('heading_title'); ?></span>
          <span class="col-md-7 text-md-right">
<?php
  echo HTML::button($CLICSHOPPING_OrdersStatus->getDef('button_cancel'), null, $CLICSHOPPING_OrdersStatus->link('OrdersStatus'), 'warning')  . ' ';
  echo HTML::form('status_orders_status', $CLICSHOPPING_OrdersStatus->link('OrdersStatus&Insert&page=' . $_GET['page']));
  echo HTML::button($CLICSHOPPING_OrdersStatus->getDef('button_insert'), null, null, 'success')
?>
          </span>
        </div>
      </div>
    </div>
  </div>
  <div class="separator"></div>
  <div class="col-md-12 mainTitle"><strong><?php echo $CLICSHOPPING_OrdersStatus->getDef('text_info_heading_new_orders_status'); ?></strong></div>
  <div class="adminformTitle">
    <div class="row">
      <div class="col-md-12">
        <div class="form-group row">
          <label for="<?php echo $CLICSHOPPING_OrdersStatus->getDef('text_info_edit_intro'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_OrdersStatus->getDef('text_info_edit_intro'); ?></label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group row">
          <label for="<?php echo $CLICSHOPPING_OrdersStatus->getDef('text_info_orders_status_name'); ?>" class="col-5 col-form-label"><?php echo $CLICSHOPPING_OrdersStatus->getDef('text_info_orders_status_name'); ?></label>
        </div>
      </div>
    </div>

<?php
  for ($i=0, $n=count($languages); $i<$n; $i++) {
?>
        <div class="row">
          <div class="col-md-5">
            <div class="form-group row">
              <label for="code" class="col-2 col-form-label"><?php echo $CLICSHOPPING_Language->getImage($languages[$i]['code']); ?></label>
              <div class="col-md-5">
                <?php echo HTML::inputField('orders_status_name[' . $languages[$i]['id'] . ']', '', 'required aria-required="true"'); ?>
              </div>
            </div>
          </div>
        </div>

<?php
  }
?>
    <div class="separator"></div>
    <div class="col-md-12">
      <span class="col-md-3"></span>
      <span class="col-md-7"><br /><?php echo HTML::checkboxField('public_flag', '1') . ' ' . $CLICSHOPPING_OrdersStatus->getDef('text_set_public_status'); ?></span>
    </div>
    <div class="col-md-12">
      <span class="col-md-3"></span>
      <span class="col-md-7"><br /><?php echo HTML::checkboxField('downloads_flag', '1')  . ' ' . $CLICSHOPPING_OrdersStatus->getDef('text_set_downloads_status'); ?></span>
    </div>
    <div class="col-md-12">
      <span class="col-md-3"></span>
      <span class="col-md-7"><br /><?php echo HTML::checkboxField('support_orders_flag','1') . ' ' . $CLICSHOPPING_OrdersStatus->getDef('text_set_support_orders_status'); ?></span>
    </div>
    <div class="col-md-12">
      <span class="col-md-3"></span>
      <span class="col-md-7"><br /><?php echo HTML::checkboxField('default') . ' ' . $CLICSHOPPING_OrdersStatus->getDef('text_set_default'); ?></span>
    </div>
  </div>

  </form>
</div>