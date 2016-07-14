<?php


?>

<div class="loader_content">
    <span><i class="icon-spin2 animate-spin"></i> In progress ... </span>
</div>

<div id="editor">

    <div id="editor_menu">
        <div class="btn_inline_dark action-new-record"><a href="#new_case"><i class="icon-plus"></i> New Item</a></div>
        <div class="btn_inline_dark action-remove-record"><a href="#remove"><i class="icon-cancel"></i> Remove</a></div>
        <div class="btn_inline_dark action-save-record"><a href="#save"><i class="icon-ok"></i> Save</a></div>
    </div>

    <form name="record">

        <div class="tbl">
            <div class="tbl_cell valign_top width_50">

                <label for="ef_link"> <input id="ef_link" type="text" name="link" placeholder="Link" value="">  </label>
                <br>
                <label for="ef_tags"> <input id="ef_tags" type="text" name="tags" placeholder="Search tags" value=""> </label>
                <br>
                <label for="ef_keyword"> <input id="ef_keyword" type="text" name="keyword" placeholder="Keyword" value=""> </label>
                <br>
                <label for="ef_description"> <textarea id="ef_description" name="description" placeholder="Description"></textarea> </label>

            </div>

            <div class="tbl_cell valign_top">

                <div id="item_types">
                    TYPE:
                    <span class="checkbox_type active_type" data-type="item"> Item </span>
                    <span class="checkbox_type" data-type="category"> Category </span>
                    <span class="checkbox_type" data-type="subcategory"> Sub-Category </span>

                    <input hidden type="radio" name="type" value="item" checked>
                    <input hidden type="radio" name="type" value="category">
                    <input hidden type="radio" name="type" value="subcategory">

                </div>

                <div id="relations">
                    <span class="relation"><span class="icon_btn action-remove-relations"><i class="icon-cancel"></i></span> PHP > File Operation  </span>
                    <span class="relation"><span class="icon_btn action-remove-relations"><i class="icon-cancel"></i></span> Javascript > Ajax send file </span>
                    <span class="relation"><span class="icon_btn action-create-relations"><i class="icon-plus"></i></span> add </span>
                </div>

            </div>
        </div>

        <label for="ef_title"> <input id="ef_title" type="text" name="title" value="" placeholder="Title"> </label>

        <label for="ef_content"><textarea id="ef_content" name="content" placeholder="Content"></textarea></label>

        <div class="btn_inline action-save-record">Save Records</div>
        
    </form>

</div>