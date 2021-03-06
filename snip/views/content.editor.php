<?php
/**
 * @type SLayout $this
 * @type string $url
 * @type array $categories
 * @type array $item;
 * @type array $relations;
 */


$select_relation = $this->render('part.select_relation.php');

$itemValue = function ($name) use ($item) {
    return isset($item[$name])?$item[$name]:"";
};


?>




<div class="loader_content">
    <span><i class="icon-spin2 animate-spin"></i> In progress ... </span>
</div>

<div id="editor">

    <div id="editor_menu" class="text_right">
        <span class="linker btn_inline_dark" data-id="item-edit-menu" data-type="full"><i class="icon-resize-full-alt"></i> Full page</span>
        <span class="linker btn_inline_dark" data-id="item-edit-menu" data-type="new"><i class="icon-plus"></i> New Item</span>
        <span class="linker btn_inline_dark" data-id="item-edit-menu" data-type="remove"><i class="icon-cancel"></i> Remove</span>
        <span class="linker btn_inline_dark" data-id="item-edit-menu" data-type="save"><i class="icon-ok"></i> Save</span>
    </div>

    <form name="edit">

        <div class="tbl">
            <div class="tbl_cell valign_top width_50">

                <label for="ef_link"> <input id="ef_link" type="text" name="link" placeholder="Link" value="<?php echo $itemValue('link')?>"> </label>
                <br>
                <label for="ef_tags"> <input id="ef_tags" type="text" name="tags" placeholder="Search tags" value="<?php echo $itemValue('tags')?>"></label>
                <br>
                <label for="ef_keyword"> <input id="ef_keyword" type="text" name="keyword" placeholder="Keyword" value="<?php echo $itemValue('keyword')?>"> </label>
                <br>
                <label for="ef_description"> <textarea id="ef_description" name="description" placeholder="Description"><?php echo $itemValue('description')?></textarea> </label>

            </div>

            <div class="tbl_cell valign_top">

                <div id="deeps">

                    <div class="deep_items">
                        <span class="linker <? echo ($itemValue('deep') == '1') ? 'active_deep':''?>" data-id="item-deep" data-deep="1"> Category </span>
                        <span class="linker <? echo ($itemValue('deep') == '2') ? 'active_deep':''?>" data-id="item-deep" data-deep="2"> SubCategory </span>
                        <span class="linker <? echo ($itemValue('deep') == '3') ? 'active_deep':''?>" data-id="item-deep" data-deep="3"> Record </span>
                    </div>

                    <input hidden="hidden" type="radio" name="deep" value="1" <? echo ($itemValue('deep') == '1') ? 'checked':''?>>
                    <input hidden="hidden" type="radio" name="deep" value="2" <? echo ($itemValue('deep') == '2') ? 'checked':''?>>
                    <input hidden="hidden" type="radio" name="deep" value="3" <? echo ($itemValue('deep') == '3') ? 'checked':''?>>

                </div>

<?php
$rel_items = '';
if(!empty($relations)) {
    foreach ($relations as $r) {
        $rid = $r['id'];
        if($r['type'] == 'item')
            $rel_title = $r['itempp_title'] .' &gt; '. $r['itemp_title'];
        else
            $rel_title =  $r['itemp_title'];
        $rel_items .= '<div class="relation_item tbl" data-id="'.$rid.'"><div class="tbl_cell"><i class="icon-cancel"></i></div><div class="tbl_cell">'.$rel_title.'</div></div>';
    }
}
?>

                <div id="relation_items"><?php echo $rel_items?></div>


<?php
echo $select_relation;

?>

                <div id="form_error"></div>

            </div>
        </div>



        <label for="ef_title"> <input id="ef_title" type="text" name="title" value="<?php echo $itemValue('title')?>" placeholder="Title"> </label>

        <label for="ef_content"><textarea id="ef_content" name="content" placeholder="Content"><?php echo $itemValue('content')?></textarea></label>

        <div class="btn_inline_round linker" data-id="item-edit-menu" data-type="save">Save Records</div>

        <input type="text" name="id" hidden="hidden" value="<?php echo $itemValue('id')?>">
    </form>

</div>


<!--                    <div class="relation_item tbl">
                        <div class="tbl_cell"><i class="icon-cancel"></i></div>
                        <div class="tbl_cell">PHP > File Operation</div>
                    </div>-->