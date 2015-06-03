<?php
if ($videos !== NULL) {
    foreach ($videos->list as $video) {
        ?>
        <div>
            <a href="<?php echo base_url(); ?>video/view/<?php echo $video->id ?>">
                <img src="http://img.youtube.com/vi/<?php echo $video->link ?>/0.jpg" style="width: 100px;height: 100px;float: left;margin-left: 15px;margin-bottom: 15px;">
            </a>
        </div>
        <?php
    }
}?>