<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ($channels !== NULL && $channels->list !== NULL) {
    foreach ($channels->list as $c) {
        ?>
        <div class=""col-lg-12 style="  height: auto;
             overflow: hidden;
             padding: 20px;
             margin-bottom: 20px;
             border-left: 5px solid rgb(207, 93, 93);">
            <div style="  padding: 10px;"class="col-lg-10">
                <p style="  font-size: 16px;
                   font-weight: bold;"><a href="<?php echo base_url(); ?>Channel/view/<?php echo $c->id ?>"><?php echo $c->name ?></a></p>
                <p><?php echo $c->description ?></p>
            </div>
            <div class="col-lg-2">
                <a  href="<?php echo base_url(); ?>channel/view/<?php echo $c->id ?>"><img style="width:100%;border: 1px solid rgb(213, 213, 213);" src="<?php //echo $c->frontImgUrl?>"/></a>
            </div>
        </div>

        <?php
    }
}
