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

  $CLICSHOPPING_MessageStack = Registry::get('MessageStack');

  $CLICSHOPPING_Page = Registry::get('Site')->getPage();

  require($CLICSHOPPING_Template->getTemplateHeaderFooter('header'));

  if ( $CLICSHOPPING_MessageStack->exists('contact') ) {
    echo $CLICSHOPPING_MessageStack->get('contact');
  }

  require($CLICSHOPPING_Page->data['content']);

  require($CLICSHOPPING_Template->getTemplateHeaderFooter('footer'));
