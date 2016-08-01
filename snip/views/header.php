<?php

/**
 * @type SLayout $this
 * @type string $url
 */

$url = $this->value('url');
$is_admin = $this->isAdmin;
$actions = $this->currentAction;

$editor_uri = !empty($actions[2]) ? $actions[2] : (!empty($actions[1]) ? $actions[1] : $actions[0] );

?>
<div class="tbl">
    <div class="tbl_cell text_left">
        <form name="search">
            <input type="text" value="" placeholder="What search?" name="">
            <i class="icon-database"><input type="submit" value="Find" class="btn_inline_dark"></i>
        </form>
    </div>
    <div class="tbl_cell width_40 text_right topmenu">
        <?php
        if($is_admin) {
            echo '<a href="'.$url.'editor/'.$editor_uri.'" class="btn_inline_dark">Update</a>';
            echo '<a href="'.$url.'editor" class="btn_inline_dark">Create</a>';
            echo '<a href="'.$url.'settings" class="btn_inline_dark">Settings</a>';
            echo '<a href="'.$url.'auth/logout" class="btn_inline_dark">Logout</a>';
        } else {
            echo '<a href="'.$url.'auth" class="btn_inline_dark">Auth</a>';
        }
        ?>
    </div>
</div>