<?php $this->load->view('admin/layouts/page_head'); ?>
<body style="background: #555;">
    <div class="container">
        <!-- Modal -->
        <div class="modal show" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content  col-sm-10 col-md-10">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h1 class="modal-title"><?php echo lang('login_heading');?></h1>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal" role="form">
                            <div class="form-group">
                                <div id="infoMessage"><?php echo $message;?></div>
                                <?php echo form_open($login_modal_path);?>
                            </div>
                            <!-- user input box -->
                            <div class="form-group">
                                <label for="identity">
                                    <?php echo lang('login_identity_label', 'identity');?>
                                </label>
                                <div class="inner-addon left-addon">
                                    <span class="glyphicon glyphicon-user"></span>
                                    <?php echo form_input($identity);?>
                                </div>
                            </div>
                            <!-- password input box -->
                            <div class="form-group">
                                <label for="password">
                                    <?php echo lang('login_password_label', 'password');?>
                                </label>
                                <div class="inner-addon left-addon">
                                    <span class="inner-addon left-addon glyphicon glyphicon-log-in"></span>
                                    <?php echo form_input($password);?>
                                </div>
                            </div>
                            <!-- remember me check box -->
                            <div class="form-group">
                                <label for="remember" class="col-sm-4 col-md-4">
                                    <?php echo lang('login_remember_label', 'remember');?>
                                </label>
                                <div  class="col-sm-offset-1 col-md-offset-1">
                                    <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"', 'type="checkbox"');?>
                                </div>
                            </div>
                            <!-- submit button -->
                            <div class="form-group">
                                <div>
                                    <?php echo form_submit('submit', lang('login_submit_btn'), 'class="btn btn-warning"');?>
                                </div>
                            </div>
                                <?php echo form_close();?>
                            <!-- forgot password text -->
                                <p><a href="forgot_password"><?php echo lang('login_forgot_password');?></a></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <!-- close button -->
                            <a href="<?php echo site_url();?> " class="btn btn-warning">
                                <span class="glyphicon glyphicon-remove"></span> Close
                            </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
<?php $this->load->view('admin/layouts/page_tail'); ?>