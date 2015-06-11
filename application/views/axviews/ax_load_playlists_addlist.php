<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('date');
if ($playlists !== NULL && $playlists->list !== NULL) {
    foreach ($playlists->list as $p) {
        ?>
        <li>
            <a href="#" onclick="addVideo(this)" name="<?php echo $p->name ?>"> <?php echo $p->name ?></a>
        </li>
        <?php
    }
}
?>
<script>
    function addVideo(btn) {
        var playlistname = $(btn).attr('name');
        $.get("<?php echo base_url() ?>Playlist/addVideoAx", {vid: videoId, plname: playlistname}, function (data) {
            if (data.result) {
                $("body").append(data.html);
                $("#messageBox").delay(1500).animate({opacity: "0.1"}, 500);
                setTimeout(function () {
                    $('#messageBox').remove();
                }, 2001);
            }
        }, "json");
    }
</script>