<?php
if (isset($type) && isset($messageText)) {
    if ($type == "error") {
        ?>
        <div style="position: fixed; background-color: red;top:10px;" id="messageBox">
            <?php
        } else if ($type == "warning") {
            ?>
            <div style="position: fixed; background-color: yellow;top:10px;" id="messageBox">
                <?php
            } else if ($type == "message") {
                ?>
                <div style="position: fixed; background-color: green;top:10px;" id="messageBox">
                    <?php
                }
                ?>
                <label> <?php echo $messageText ?> </label>
            </div>
            <?php
        }