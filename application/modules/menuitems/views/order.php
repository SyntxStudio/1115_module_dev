<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
    <?php echo Modules::run('layout_head/layout_head/index');?>
<body>
    <!-- Load sortable libraries -->
    <!-- html/assets/js/libraries/jquery/jquery.mjs.nestedSortable.js -->

    <!-- load sortable section -->
    <div class="module container">
        <script src="<?php echo site_url('assets/js/libraries/jquery/jquery-ui.min.js'); ?>"></script>
        <script src="<?php echo site_url('assets/js/libraries/jquery/jquery.mjs.nestedSortable.js'); ?>"></script>
        <link type="text/css" rel="stylesheet" href="<?php echo site_url('assets/css/custom.modules.css'); ?>"  property=""/>
        <link type="text/css" rel="stylesheet" href="<?php echo site_url('assets/css/custom.module.sortable.css'); ?>"  property=""/>

        <!-- Default -->
        <fieldset>
            <legend>Order menuitems</legend>
            <section>
                <p>Drag items for reorder. For finish press <span>save (alt-s)</span></p>
            </section>
            <div class="order-result">
                <div id="orderResult"></div>
            </div>
            <div class="btnbar-group">
                <button type="button" value="Save" class="btnbar-btn" id="save" accesskey="S"><b>S</b>ave</button>
                <a href="<?php echo site_url('menuitems/edit');?>" id="btn-add" class="btnbar-btn" title="Adding new item" accesskey="A"><b>A</b>dd</a>
            </div>
        </fieldset>
                        <!-- Bootstrap 3 -->
       <!-- <div class="row">
            <h2>Order menu items</h2>
            <div class="well well-sm">Drag items to order, then click <code>Save</code>.</div>
                <div class="order-result">
                    <div id="orderResult"></div>
                </div>
                <input type="button" value="Save" class="btn btn-default" id="save"/>
        </div>-->
    </div>
    <script>
        $(function(){
            $.post('<?php echo site_url('menuitems/order_by_ajax')?>', {}, function (data) {
                $('#orderResult').html(data);
            })
        });

        $('#save').click(function () {
            $('#orderResult').slideUp(function(){
                var oSortable = $('.sortable').nestedSortable('toArray');
                $.post('<?php echo site_url('menuitems/order_by_ajax')?>', { sortable : oSortable }, function (data) {
                    $('#orderResult').html(data).slideDown();
                });

            })
        });
    </script>
</body>
</html>

