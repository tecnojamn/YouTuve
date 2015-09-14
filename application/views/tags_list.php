<?php if (isset($tagList) && isset($tagList->list)) { ?>
    <div class="col-lg-3 well well-green">
        <strong>Tags list</strong> <br>
        <?php foreach ($tagList->list as $tag) { ?>
        <a style="margin-right: 5px" href="<?php echo base_url(); ?>video/showList?tag=<?php echo $tag->id; ?>"><?php echo $tag->name; ?></a>
        <?php } ?>
    </div>
<?php } ?>

