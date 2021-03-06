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

  namespace ClicShopping\Apps\Catalog\Manufacturers\Classes\Shop;

  use ClicShopping\OM\Registry;
  use ClicShopping\OM\HTML;

  class Manufacturers {
    protected $db;
    protected $lang;

    public function __construct() {
      $this->db = Registry::get('Db');
      $this->lang = Registry::get('Language');

      if ( isset($_GET['manufacturers_id']) && is_numeric($_GET['manufacturers_id']) && !empty(HTML::sanitize($_GET['manufacturers_id']))) {
        $this->Id = HTML::sanitize($_GET['manufacturers_id']);
      } elseif (isset($_GET['manufacturers_id']) && is_numeric($_POST['manufacturers_id']) && !empty(HTML::sanitize($_POST['manufacturers_id']))) {
        $this->Id = HTML::sanitize($_POST['manufacturers_id']);
      } else {
        $this->Id = null;
      }
    }

     public function getID() {
      $id = $this->Id;

      return $id;
    }

    public function getTitle($id) {
      $Qmanufacturer = $this->db->prepare('select m.manufacturers_name as name
                                            from :table_manufacturers m,
                                                 :table_manufacturers_info mi
                                            where m.manufacturers_id = :manufacturers_id
                                            and m.manufacturers_id = mi.manufacturers_id
                                            and mi.languages_id = :languages_id
                                            and m.manufacturers_status = 0
                                           ');
      $Qmanufacturer->bindInt(':manufacturers_id', $id);
      $Qmanufacturer->bindInt(':languages_id', $this->lang->getID());
      $Qmanufacturer->execute();

      if ($Qmanufacturer->fetch()) {
        $name = $Qmanufacturer->valueInt('name');
      }

      return $name;
    }

    public function getImage($id) {
      $Qmanufacturer = $this->db->prepare('select manufacturers_image as image
                                            from :table_manufacturers
                                            where manufacturers_id = :manufacturers_id
                                            and manufacturers_status = 0
                                           ');
      $Qmanufacturer->bindInt(':manufacturers_id', $id);
      $Qmanufacturer->execute();

      if ($Qmanufacturer->fetch()) {
        $image = $Qmanufacturer->valueInt('image');
      }

      return $image;
    }

    public function getDescription($id) {
      $Qmanufacturer = $this->db->prepare('select  mi.manufacturer_description as description
                                            from :table_manufacturers m,
                                                 :table_manufacturers_info mi
                                            where m.manufacturers_id = :manufacturers_id
                                            and m.manufacturers_id = mi.manufacturers_id
                                            and mi.languages_id = :languages_id
                                            and m.manufacturers_status = 0
                                           ');
      $Qmanufacturer->bindInt(':manufacturers_id', $id);
      $Qmanufacturer->bindInt(':languages_id', $this->lang->getID());
      $Qmanufacturer->execute();

      if ($Qmanufacturer->fetch()) {
        $description = $Qmanufacturer->valueInt('description');
      }

      return $description;
    }

    public function getUrl($id) {
      $Qmanufacturer = $this->db->prepare('select mi.manufacturers_url as url
                                            from :table_manufacturers m,
                                                 :table_manufacturers_info mi
                                            where m.manufacturers_id = :manufacturers_id
                                            and m.manufacturers_id = mi.manufacturers_id
                                            and mi.languages_id = :languages_id
                                            and m.manufacturers_status = 0
                                           ');
      $Qmanufacturer->bindInt(':manufacturers_id', $id);
      $Qmanufacturer->bindInt(':languages_id', $this->lang->getID());
      $Qmanufacturer->execute();

      if ($Qmanufacturer->fetch()) {
        $url = $Qmanufacturer->valueInt('url');
      }

      return $url;
    }

    public function getAll($id = null) {
      if (!is_null($id)) {
        $Qmanufacturer = $this->db->prepare('select m.manufacturers_id as id,
                                                     m.manufacturers_name as name,
                                                     m.manufacturers_image as image,
                                                     mi.languages_id,
                                                     mi.manufacturers_url as url,
                                                     mi.manufacturer_description as description
                                              from :table_manufacturers m,
                                                   :table_manufacturers_info mi
                                              where m.manufacturers_id = :manufacturers_id
                                              and m.manufacturers_id = mi.manufacturers_id
                                              and mi.languages_id = :languages_id
                                              and m.manufacturers_status = 0
                                             ');
        $Qmanufacturer->bindInt(':manufacturers_id', $id);
        $Qmanufacturer->bindInt(':languages_id', $this->lang->getID());
        $Qmanufacturer->execute();
      } else {
        $Qmanufacturer = $this->db->prepare('select m.manufacturers_id as id,
                                                     m.manufacturers_name as name,
                                                     m.manufacturers_image as image,
                                                     mi.languages_id,
                                                     mi.manufacturers_url as url,
                                                     mi.manufacturer_description as description
                                              from :table_manufacturers m,
                                                   :table_manufacturers_info mi
                                              where m.manufacturers_id = mi.manufacturers_id
                                              and mi.languages_id = :languages_id
                                              and m.manufacturers_status = 0
                                             ');
        $Qmanufacturer->bindInt(':languages_id', $this->lang->getID());
        $Qmanufacturer->execute();
      }

      return $Qmanufacturer->fetchAll();
    }

    public function setManufacturersByCategories() {
      $CLICSHOPPING_Category = Registry::get('Category');

      $Qmanufacturer = $this->db->prepare('select distinct  m.manufacturers_id as id,
                                                            m.manufacturers_name as name
                                            from :table_products p,
                                                :table_products_to_categories p2c,
                                                :table_manufacturers m
                                            where p.products_status = 1
                                            and p.products_view = 1
                                            and p.manufacturers_id = m.manufacturers_id
                                            and p.products_id = p2c.products_id
                                            and p.products_archive = 0
                                            and p2c.categories_id = :categories_id
                                            and m.manufacturers_status = 0
                                            group by m.manufacturers_id
                                            order by m.manufacturers_name
                                           ');

      $Qmanufacturer->bindInt(':categories_id', $CLICSHOPPING_Category->getID());
      $Qmanufacturer->execute();

      while ($Qmanufacturer->fetch() !== false) {
        $manufacturer_name_array[] = ['id' => $Qmanufacturer->valueInt('id'),
                                      'text' => $Qmanufacturer->value('name')
                                     ];
      }

      return $manufacturer_name_array;
    }


    public function getManufacturersByCategories() {
      return $this->setManufacturersByCategories();
    }

  }