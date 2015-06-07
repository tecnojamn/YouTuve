<?php
if ($videos !== NULL) {
    foreach ($videos->list as $video) {
        ?>
        <div class="col-lg-12" style="border: 1px solid rgb(216, 216, 216);background-color: white;padding: 12px;margin-bottom: 12px;">
            <a href="<?php echo base_url(); ?>video/view/<?php echo $video->id ?>">
                <img src="http://img.youtube.com/vi/<?php echo $video->link ?>/0.jpg" style="width: 100px;height: 100px;float: left;">
            </a>
            <label ><?php echo $video->name ?></label> <br>
            <a href="#" ><?php echo $video->channelName ?></a> <br>
            <label >Publicado el <?php echo $video->date ?></label>
        </div>
        <?php
    }
}?>