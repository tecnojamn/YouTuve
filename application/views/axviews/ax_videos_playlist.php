<?php foreach ($playlist->videos->list as $row) { ?>
    <div class="videoInfo col-lg-4 well-violet" style="background-color: white;
         padding: 15px;margin-top: 15px">
        <input id="id" type="hidden" value="<?php echo $row->id ?>">
        <input id="link" type="hidden" value="<?php echo $row->link ?>">
        <div class="col-lg-2" style="width: 138px">
            <a href="#" class="changeVideoImg">
                <img src="http://img.youtube.com/vi/<?php echo $row->link ?>/0.jpg" style="width: 100px;height: 100px;float: left;">
            </a>
        </div>
        <div class="col-lg-2">
            <a href="#" class="changeVideo"><?php echo $row->name ?></a>
        </div>
        <div class="col-lg-1" style="float: right">
            <a href="#" class="delVideo btn btn-danger" style="float: right">X</a>  
        </div>
    </div>
<?php } ?>