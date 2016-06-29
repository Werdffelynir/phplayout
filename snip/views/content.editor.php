<?php


?>

<div class="loader_content">
    <span><i class="icon-spin2 animate-spin"></i> In progress ... </span>
</div>

<div id="editor">

    <div id="editor_menu">
        <div class="btn_inline_dark linker" data-id="item-edit-menu" data-type="new"><a href="#new_case"><i class="icon-plus"></i> New Item</a></div>
        <div class="btn_inline_dark linker" data-id="item-edit-menu" data-type="remove"><a href="#remove"><i class="icon-cancel"></i> Remove</a></div>
        <div class="btn_inline_dark linker" data-id="item-edit-menu" data-type="save"><a href="#save"><i class="icon-ok"></i> Save</a></div>
    </div>

    <form name="edit_item">

        <div class="tbl">
            <div class="tbl_cell valign_top width_50">

                <label for="ef_link"> <input id="ef_link" type="text" name="link" placeholder="Link" value=""> </label>
                <br>
                <label for="ef_tags"> <input id="ef_tags" type="text" name="tags" placeholder="Search tags" value=""></label>
                <br>
                <label for="ef_keyword"> <input id="ef_keyword" type="text" name="keyword" placeholder="Keyword" value=""> </label>
                <br>
                <label for="ef_description"> <textarea id="ef_description" name="description" placeholder="Description"></textarea> </label>

            </div>

            <div class="tbl_cell valign_top">

                <div id="deeps">

                    <span class="linker" data-id="item-deep" data-deep="1"> Category </span>
                    <span class="linker" data-id="item-deep" data-deep="2"> SubCategory </span>
                    <span class="linker active" data-id="item-deep" data-deep="3"> Record </span>

                    <input hidden="hidden" type="radio" name="deep" value="1">
                    <input hidden="hidden" type="radio" name="deep" value="2">
                    <input hidden="hidden" type="radio" name="deep" value="3" checked>

                </div>

                <div id="relations">

                    <span class="relation"><span class="icon_btn"><i class="icon-cancel linker" data-id="relation-remove"></i></span>
                        <span>PHP</span> > <span>File Operation</span>
                    </span>

                    <span class="relation"><span class="icon_btn"><i class="icon-plus linker" data-id="relation-add"></i></span>
                        <span>Add new relation</span>
                    </span>

                </div>

            </div>
        </div>

        <label for="ef_title"> <input id="ef_title" type="text" name="title" value="" placeholder="Title"> </label>

        <label for="ef_content"><textarea id="ef_content" name="content" placeholder="Content"></textarea></label>

        <div class="btn_inline linker" data-id="item-edit-menu" data-type="save">Save Records</div>

    </form>

</div>