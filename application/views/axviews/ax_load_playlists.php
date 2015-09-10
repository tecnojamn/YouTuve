<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('date');
if ($playlists !== NULL && $playlists->list !== NULL) {
    foreach ($playlists->list as $p) {
        ?>
        <div class="col-lg-12" style="  height: auto;
             overflow: hidden;
             padding: 20px;
             margin-bottom: 20px;
             border-left: 5px solid rgb(207, 93, 93);">
            <div class="col-lg-1">
                <a  href="<?php echo base_url(); ?>playlist/get/<?php echo $p->id ?>"><img style="width:70px;border: 1px solid rgb(213, 213, 213);" src="<?php echo $playlist_image ?>"/></a>
            </div>
            <div style="  padding: 10px;"class="col-lg-10">
                <p style="  font-size: 16px;
                   font-weight: bold;"><a href="<?php echo base_url(); ?>playlist/get/<?php echo $p->id ?>"><?php echo $p->name ?></a></p>
                <p><?php echo timespan(strtotime($p->created_date), time()); ?></p>
            </div>
            <div class="col-lg-1" >
                <a href="#" class="delPlaylist btn btn-danger" >X</a>
                <input id="idPlaylist" type="hidden" value="<?php echo $p->id ?>">
            </div>
        </div>

        <?php
    }
}
