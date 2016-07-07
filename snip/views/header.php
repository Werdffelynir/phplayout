<?php

/**
 * @type SLayout $this
 * @type string $url
 */

$url = $this->value('url');

?>
<div class="tbl">
    <div class="tbl_cell width_20 text_left">
        &nbsp;
    </div>
    <div class="tbl_cell text_left">
        <form name="search">
            <input type="text" value="" placeholder="What search?" name="">
            <i class="icon-rocket"><input type="submit" value="Find" class="btn_inline_dark"></i>
        </form>
    </div>
    <div class="tbl_cell width_55 text_right topmenu">

        <a href="<?=$url?>editor" class="btn_inline_dark">Create</a>
        <a href="<?=$url?>settings" class="btn_inline_dark">Settings</a>
        <a href="<?=$url?>auth" class="btn_inline_dark">Auth</a>

    </div>
</div>

