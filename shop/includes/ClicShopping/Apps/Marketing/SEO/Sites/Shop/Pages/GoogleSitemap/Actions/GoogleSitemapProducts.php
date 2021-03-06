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

  namespace ClicShopping\Apps\Marketing\SEO\Sites\Shop\Pages\GoogleSitemap\Actions;

  use ClicShopping\OM\CLICSHOPPING;
  use ClicShopping\OM\Registry;

  class GoogleSitemapProducts extends \ClicShopping\OM\PagesActionsAbstract {

    protected $use_site_template = false;

    public function execute() {
      $CLICSHOPPING_Db = Registry::get('Db');

      if (MODE_VENTE_PRIVEE == 'false') {

        $xml = new \SimpleXMLElement("<?xml version='1.0' encoding='UTF-8' ?>\n".'<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9" />');

        $product_array = [];

        $Qproducts = $CLICSHOPPING_Db->prepare('select products_id,
                                         coalesce(NULLIF(products_last_modified, :products_last_modified),
                                                         products_date_added) as last_modified
                                          from :table_products
                                          where products_status = 1
                                          and products_view = 1
                                          order by last_modified desc
                                          ');

        $Qproducts->bindValue(':products_last_modified', '');
        $Qproducts->execute();


        while ($Qproducts->fetch() ) {
          $location =  htmlspecialchars(utf8_encode(CLICSHOPPING::link('index.php', 'Products&Description&products_id=' . $Qproducts->valueInt('products_id'))));

          $product_array[$Qproducts->valueInt('products_id')]['loc'] = $location;
          $product_array[$Qproducts->valueInt('products_id')]['lastmod'] = $Qproducts->value('last_modified');
          $product_array[$Qproducts->valueInt('products_id')]['changefreq'] = 'weekly';
          $product_array[$Qproducts->valueInt('products_id')]['priority'] = '0.5';
        }

        foreach ($product_array as $k => $v) {
          $url = $xml->addChild('url');
          $url->addChild('loc', $v['loc']);
          $url->addChild('lastmod', date("Y-m-d", strtotime($v['lastmod'])));
          $url->addChild('changefreq', 'weekly');
          $url->addChild('priority', '0.5');
        }

        header('Content-type: text/xml');
        echo $xml->asXML();
        exit;
      }
    }
  }
