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
<div class="col-md-<?php echo $content_width; ?>">
  <a data-toggle="modal" data-target="#helpSearch" class="badge badge-light text-md-right"><?php echo CLICSHOPPING::getDef('module_advanced_search_help_title'); ?></a></div>
  <div class="modal fade" id="helpSearch" tabindex="-1" role="dialog" aria-labelledby="helpSearchLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span>&times;</span></button>
          <div class="modal-title advancedSearchHelpTitle">
            <span class="advancedSearchHelpTitle"><?php echo CLICSHOPPING::getDef('module_advanced_search_help_title'); ?></span>
          </div>
        </div>
        <div class="modal-body advancedSearchHelpText">
          <span class="advancedSearchHelpText"><?php echo CLICSHOPPING::getDef('module_advanced_search_help_text'); ?></span>
        </div>
      </div>
    </div>
  </div>
</div>