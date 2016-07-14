<?php
/**
 * @type SLayout $this
 * @type string $url
 * @type array $categories
 */


$select_relation = $this->render('part.select_relation.php');

?>




<div class="loader_content">
    <span><i class="icon-spin2 animate-spin"></i> In progress ... </span>
</div>

<div id="editor">

    <div id="editor_menu" class="text_right">
        <span class="linker btn_inline_dark" data-id="item-edit-menu" data-type="new"><i class="icon-plus"></i> New Item</span>
        <span class="linker btn_inline_dark" data-id="item-edit-menu" data-type="remove"><i class="icon-cancel"></i> Remove</span>
        <span class="linker btn_inline_dark" data-id="item-edit-menu" data-type="save"><i class="icon-ok"></i> Save</span>
    </div>

    <form name="edit">

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

                    <div class="deep_items">
                        <span class="linker" data-id="item-deep" data-deep="1"> Category </span>
                        <span class="linker" data-id="item-deep" data-deep="2"> SubCategory </span>
                        <span class="linker" data-id="item-deep" data-deep="3"> Record </span>
                    </div>

                    <input hidden="hidden" type="radio" name="deep" value="1">
                    <input hidden="hidden" type="radio" name="deep" value="2">
                    <input hidden="hidden" type="radio" name="deep" value="3">

                </div>



                <!--              <div class="relations">

              <!--
                                  <span class="relation">
                                      <span class="icon_btn"><i class="icon-cancel linker" data-id="relation-remove"></i></span>
                                      <span>PHP</span> > <span>File Operation</span>
                                  </span>

                                  <span class="relation">
                                      <span class="icon_btn"><i class="icon-plus linker" data-id="relation-add"></i></span>
                                      <span>Add new relation</span>
                                  </span>

                </div>  -->
                <?php echo $select_relation; ?>
                <div id="form_error"></div>
            </div>
        </div>



        <label for="ef_title"> <input id="ef_title" type="text" name="title" value="" placeholder="Title"> </label>

        <label for="ef_content"><textarea id="ef_content" name="content" placeholder="Content"></textarea></label>

        <div class="btn_inline_round linker" data-id="item-edit-menu" data-type="save">Save Records</div>

    </form>

</div>