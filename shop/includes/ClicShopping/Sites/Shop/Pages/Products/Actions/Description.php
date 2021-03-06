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

  namespace ClicShopping\Sites\Shop\Pages\Products\Actions;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;
  use ClicShopping\Service\Shop\WhosOnline;

  class Description extends \ClicShopping\OM\PagesActionsAbstract {

    public function execute() {
      $CLICSHOPPING_Template = Registry::get('Template');
      $CLICSHOPPING_Breadcrumb = Registry::get('Breadcrumb');
      $CLICSHOPPING_Language = Registry::get('Language');
      $CLICSHOPPING_ProductsCommon = Registry::get('ProductsCommon');

      $spider_flag = WhosOnline::getResultSpiderFlag();

      if (!isset($_GET['products_id'])) {
        CLICSHOPPING::redirect('index.php');
      }

      $id = (int)$CLICSHOPPING_ProductsCommon->getID();

      if ( $CLICSHOPPING_ProductsCommon->getProductsGroupView() == 1 ||  $CLICSHOPPING_ProductsCommon->getProductsView() == 1) {

        if ($spider_flag === false) {
          $CLICSHOPPING_ProductsCommon->countUpdateProductsView();
        }
      }// end product group view

// templates
      $this->page->setFile('description.php');
//Content
      $this->page->data['content'] = $CLICSHOPPING_Template->getTemplateFiles('product_info');

//language
      $CLICSHOPPING_Language->loadDefinitions('product_info');

      $CLICSHOPPING_Breadcrumb->add(CLICSHOPPING::getDef('navbar_title'), CLICSHOPPING::link('index.php', 'Products&Description&products_id=' . $id));
      $CLICSHOPPING_Breadcrumb->add($CLICSHOPPING_ProductsCommon->getProductsName(), CLICSHOPPING::link('index.php', 'Products&Description&products_id=' . $id));

    }
  }