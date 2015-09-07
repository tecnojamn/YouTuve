<?php foreach ($playlist->videos->list as $row) { ?>
    <div class="col-lg-12 well-violet" style="background-color: white;
         padding: 15px;margin-top: 15px">
        <div class="col-lg-2" style="width: 138px">
            <a href="<?php echo base_url(); ?>video/view/<?php echo $row->id ?>">
                <img src="http://img.youtube.com/vi/<?php echo $row->link ?>/0.jpg" style="width: 100px;height: 100px;float: left;">
            </a>
        </div>
        <div class="col-lg-9">
            <a href="<?php echo base_url(); ?>video/view/<?php echo $row->id ?>"><?php echo $row->name ?></a><br>

        </div>
        <div class="col-lg-1" style="float: right">
            <a href="#" class="delVideo btn btn-danger" style="float: right">X</a>
            <input type="hidden" value="<?php echo $row->id?>">
        </div>
    </div>
<?php } ?>