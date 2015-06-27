<?php
if ($chanels !== NULL && count($chanels->list) > 0) {
    foreach ($chanels->list as $c) {
        ?>
        <div class="col-lg-12 well well-green" style="  height: auto;
             overflow: hidden;
             padding: 20px;
             margin-bottom: 20px;">
            <div style="  padding: 10px;"class="col-lg-10">
                <p style="  font-size: 16px;
                   font-weight: bold;"><a href="<?php echo base_url(); ?>Channel/view/<?php echo $c->id ?>"><?php echo $c->name ?></a></p>
                <p><?php echo $c->description ?></p>
            </div>
            <div class="col-lg-2">
                <a  href="<?php echo base_url(); ?>channel/view/<?php echo $c->id ?>">
                    <img style="width:100%;border: 1px solid rgb(213, 213, 213);" src="<?php echo $c->frontImgUrl ?>"/></a>
            </div>
        </div>
        <?php
    }
}