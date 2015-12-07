
<form class="form" id="addMenuForm" action="#" method="post">
    <section id="menuItemValidationErrors">
        <p><?php echo validation_errors();?></p>
    </section>
    <fieldset id="form-align" class="fieldset">
        <!-- fieldset label -->
        <legend>Details:</legend>
        <!-- label input -->
        <div class="form-group" id="label-form">
            <label for="menuItemName"></label>
            <?php $label = array(
                'type'          => 'text',
                'name'          => 'label',
                'value'         => $this->input->post('label')?$this->input->post('label') : $menuitem->label,
                'id'            => 'menuItemName',
                'class'         => 'form-control',
                'placeholder'   => 'Item name',
                'tabindex'      => '1',
                'maxlength'     => '20',
                'size'          => '20',
                'required'      => '',
            );
            echo form_input($label);?>
            <!-- TODO HTML 5 hints -->
        </div>
        <!-- description input -->
        <div class="form-group" id="desc-form">
            <label for="menuItemDesc"></label>
            <input type="text" id="menuItemDesc" class="form-control" placeholder="Description" tabindex="2"/>
            <!-- TODO HTML 5 hints -->
        </div>
        <!-- link input -->
        <div class="form-group" id="link-form">
            <label for="menuItemLink"></label>
            <input type="text" id="menuItemDesc" class="form-control" placeholder="Link" tabindex="3" required/>
            <!-- TODO HTML 5 hints -->
        </div>
        <!-- parent input -->
        <div class="form-group" id="desc-form">
            <label for="menuItemParent"></label>
            <select name="parent" id="menuItemParent" class="form-control">
                <option value="menu_item_1" selected>menu1</option>
                <option value="menu_item_2">menu2</option>
                <option value="menu_item_3">menu3</option>
            </select>
            <!-- TODO HTML 5 hints -->
        </div>
    </fieldset>
</form>
