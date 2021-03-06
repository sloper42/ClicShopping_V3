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
?>
<section class="boxe_manufacturer_info" id="boxe_manufacturer_info">
  <div class="card boxeContainerManufacturerInfo">
    <div class="card-img-top boxeBannerContentsManufacturerInfo"><?php echo $manufacturer_infos_banner; ?></div>
    <div class="card-header boxeHeadingManufacturerInfo">
      <span class="card-title boxeTitleManufacturerInfo"><?php echo CLICSHOPPING::getDef('module_boxes_manufacturer_info_box_title'); ?></span>
    </div>
    <div class="card-block boxeContentArroundManufacturerInfo">
      <div class="card-text boxeContentsManufacturerInfo"><?php echo $manufacturer_info_string; ?></div>
    </div>
    <div class="card-footer boxeBottomManufacturerInfo"></div>
  </div>
</section>