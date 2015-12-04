<!DOCTYPE html>
<html lang="en">
    <?php echo Modules::run('layout_head/layout_head/index');?>
<body>
    <!-- Load sortable libraries -->
    <!-- html/assets/js/libraries/jquery/jquery.mjs.nestedSortable.js -->
    <script src="<?php echo site_url('assets/js/libraries/jquery/jquery-ui.min.js'); ?>"></script>
    <script src="<?php echo site_url('assets/js/libraries/jquery/jquery.mjs.nestedSortable.js'); ?>"></script>
    <link type="text/css" rel="stylesheet" href="<?php echo site_url('assets/css/sortable.custom.css'); ?>"  property=""/>
    <!-- load sortable section -->

    <div class="container">
        <section>
            <h2>Order menu items</h2>
            <div class="well well-sm">Drag items to order, then click <code>Save</code>.</div>
            <div class="row">
                <div class="col-md-4">
                    <div id="orderResult"></div>
                </div>
            </div>
            <div class="row">
                <input type="button" value="Save" class="btn btn-default" id="save"/>
            </div>
        </section>

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
    </div>
</body>
</html>

