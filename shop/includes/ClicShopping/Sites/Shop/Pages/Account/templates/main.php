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
  use ClicShopping\OM\Registry;

  $CLICSHOPPING_Customer = Registry::get('Customer');
  $CLICSHOPPING_Breadcrumb= Registry::get('Breadcrumb');
  $CLICSHOPPING_Template = Registry::get('Template');
  $CLICSHOPPING_NavigationHistory = Registry::get('NavigationHistory');
  $CLICSHOPPING_MessageStack = Registry::get('MessageStack');
  $CLICSHOPPING_Language = Registry::get('Language');

  if (!$CLICSHOPPING_Customer->isLoggedOn()) {
    $CLICSHOPPING_NavigationHistory->setSnapshot();
    CLICSHOPPING::redirect('index.php', 'Account&LogIn');
  }

// templates
  $CLICSHOPPING_Language->loadDefinitions('account');

  $CLICSHOPPING_Breadcrumb->add(CLICSHOPPING::getDef('navbar_title'), CLICSHOPPING::link('index.php', 'Account&Main'));

  require($CLICSHOPPING_Template->getTemplateHeaderFooter('header'));

  require($CLICSHOPPING_Template->getTemplateFiles('account'));

  require($CLICSHOPPING_Template->getTemplateHeaderFooter('footer'));
