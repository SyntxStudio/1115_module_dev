<link rel="stylesheet" href="<?php echo site_url('assets/css/custom.modules.css');?>"/>
<link rel="stylesheet" href="<?php echo site_url('assets/css/custom.module.forms.css');?>"/>
<div class="module">
        <fieldset id="form-align" class="fieldset">
            <!-- fieldset label -->
            <legend class="legend">Details:</legend>
            <!-- div errors -->
<!--            <div class="validation-errors">-->
<!--                <p>--><?php //echo validation_errors();?><!--</p>-->
<!--            </div>-->
            <!-- label input -->
            <!-- TODO uraditi hintove -->
            <?php echo form_open();?>
            <div class="form-group" id="label-form">
                <?php $label = array(
                    'type'          => 'text',
                    'title'         => 'Label represent text displayed on item element',
                    'name'          => 'label',
                    'value'         => $this->input->post('label')?$this->input->post('label') : $menuitem->label,
                    'id'            => 'menuItemName',
                    'class'         => 'form-control',
                    'placeholder'   => 'Item name (* required)',
                    'tabindex'      => '1',
                    'maxlength'     => '20',
                    'required'      => '',
                );
                echo form_label('Label', $label['id']);
                echo form_input($label);
                echo '<span class="form-required-sym">*</span>';
                echo form_error($label['name'], '<div class="form-valid-error">', '</div>');?>
            </div>
            <!-- description input -->
            <div class="form-group" id="desc-form">
                <?php
                $description = array(
                    'type'          => 'text',
                    'name'          => 'description',
                    'title'         => 'Longer description as tooltip for user',
                    'value'         => $this->input->post('description')?$this->input->post('description') : $menuitem->description,
                    'id'            => 'menuItemDesc',
                    'class'         => 'form-control',
                    'placeholder'   => 'Item description',
                    'tabindex'      => '2',
                    'rows'          => '3',
                    'maxlength'     => '100',
                );
                echo form_label('Description', $description['id']);
                echo form_textarea($description);
                echo form_error($description['name'], '<div class="form-valid-error">', '</div>');?>
            </div>
            <!-- link input -->
            <div class="form-group" id="link-form">
                <?php $link = array(
                    'type'          => 'text',
                    'name'          => 'link',
                    'title'         => 'Link represents URI adress reference without site name or any slashes at beggining or end',
                    'value'         => $this->input->post('link')?$this->input->post('link') : $menuitem->link,
                    'id'            => 'menuItemlink',
                    'class'         => 'form-control',
                    'placeholder'   => 'Link (* required)',
                    'tabindex'      => '3',
                    'maxlength'     => '100',
                    'required'      => ''
                );
                echo form_label('Link', $link['id']);
                echo form_input($link);
                echo '<span class="form-required-sym">*</span>';
                echo form_error($link['name'], '<div class="form-valid-error">', '</div>');?>
            </div>
            <!-- parent input -->
            <div class="form-group" id="desc-form">
                <?php $parent = array(
                    'name'          => 'parent',
                    'selected'      => $this->input->post('parent')?$this->input->post('parent'):$menuitem->parent,
                    'attr'          => array(
                        'value'         => 'Parent',
                        'title'         => 'Choose any parent for this element or root for none',
                        'class'         => 'form-control',
                        'tabindex'      => '4',
                        'maxlength'     => '3',
                        'required'      => 'required',
                        'id'            => 'menuParentSelect',
                    ),
                );
                echo form_label('Parent', $parent['attr']['id']);
                echo form_dropdown($parent['name'],$parent_option,$parent['selected'],$parent['attr']);
                echo '<span class="form-required-sym">*</span>';
                echo form_error($parent['name'], '<div class="form-valid-error">', '</div>');?>
            </div>
            <div class="btnbar-group">
                <button type="submit" value="Submit" class="btnbar-btn" id="btn-submit" accesskey="S"><b>S</b>ubmit</button>
                <a href="<?php echo site_url('menuitems/order');?>" id="btn-cancel" class="btnbar-btn" title="Exit without saving" accesskey="C"><b>C</b>ancel</a>
            </div>
        </fieldset>
    <?php echo form_close();?>
</div>
