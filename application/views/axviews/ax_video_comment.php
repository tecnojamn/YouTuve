<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('date');
if ($comment !== NULL) {
    ?>
    <div class="videoComment" style="">
        <div class="col-lg-12" style="">
            <div class="col-lg-2" style="">
                <div id="presentation" class="circular1" style="  width: 55px;
                     height: 55px;
                     border-bottom: 8px dotted rgb(228, 111, 97);">
                    <img style="min-height: 100px;min-width: 100px;width: auto;max-width: 200px; max-height: 200px;" src="<?php echo $comment->userthumb; ?>">
                </div></div>
            <div class="col-lg-10" style="padding-left: 0;word-wrap: break-word;word-break: break-word;">
                <div style="width: 100%;height: auto;overflow: hidden;line-height: 15px;">
                    <p style="  font-size: 15px;  margin: 0;
                       font-weight: bold;float: left;"><?php echo $comment->usernick; ?></p>
                    <p style="margin: 0px 10px;
                       float: left;
                       font-size: 12px;
                       color: rgb(77, 191, 217);"><?php echo timespan(strtotime($comment->date), time()); ?></p>
                </div>
                <div style="margin-top: 5px;">
                    <?php echo $comment->comment; ?>
                </div> 
            </div>
        </div>
    </div>
    <?php
}
