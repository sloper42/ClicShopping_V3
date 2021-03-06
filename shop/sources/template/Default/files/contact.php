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
  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;

  if ( $CLICSHOPPING_MessageStack->exists('contact') ) {
     echo $CLICSHOPPING_MessageStack->get('contact');
  }

  require($CLICSHOPPING_Template->getTemplateFiles('breadcrumb'));
?>
<section class="contact" id="contact">
  <div class="contentContainer">
    <div class="contentText">
      <?php echo $CLICSHOPPING_Template->getBlocks('modules_contact_us'); ?>
    </div>
  </div>
</section>
