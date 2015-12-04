<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 3.11.15.
 * Time: 10.52
 */
echo $menuitems;
?>
<script>
    $(document).ready(function(){

        $('.sortable').nestedSortable({
            handle: 'div',
            items: 'li',
            toleranceElement: '> div',
            maxLevels: 3
        });

    });
</script>