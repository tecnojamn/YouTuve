<ul class="col-lg-12"style="list-style: none;
    padding: 0 40px;
    ">
        <?php
        if ($videos !== NULL && count($videos->list) > 0) {
            foreach ($videos->list as $video) {
                ?>
            <li class=" col-lg-3" style="float:left;">
                <div >
                    <div class="video-img">
                        <a href="<?php echo base_url(); ?>video/view/<?php echo $video->id ?>">
                            <img src="http://img.youtube.com/vi/<?php echo $video->link ?>/0.jpg" >
                        </a>
                    </div>
                    <div id="video-info">
                        <label ><?php echo $video->name ?></label> <br>
                        <a href="<?php echo base_url() ?>channel/view/<?php echo $video->idChannel ?>" ><?php echo $video->channelName ?></a> <br>
                        <label >Publicado el <?php echo $video->date ?></label>
                    </div>
                </div>
            </li>  

            <?php
        }
    } else {
        ?>
        <div class="alert alert-dismissible alert-warning">
            No videos to display</div>

    <?php } ?>
</ul>