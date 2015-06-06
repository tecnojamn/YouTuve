<ul>
    <?php
    if ($videos !== NULL) {
        foreach ($videos->list as $video) {
            ?>
    <li class="video-list-item">
                <div>
                    <div class="video-img">
                        <a href="<?php echo base_url(); ?>video/view/<?php echo $video->id ?>">
                            <img src="http://img.youtube.com/vi/<?php echo $video->link ?>/0.jpg" >
                        </a>
                    </div>
                    <div id="video-info">
                        <label ><?php echo $video->name ?></label> <br>
                        <a href="#" ><?php echo $video->channelName ?></a> <br>
                        <label >Publicado el <?php echo $video->date ?></label>
                    </div>
                </div>
            </li>  

            <?php
        }
    }
    ?>
</ul>