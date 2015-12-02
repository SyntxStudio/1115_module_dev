<?php $this->load->view('admin/layouts/page_head');;?>
<!-- /**
 * Created by PhpStorm.
 * User: Petar
 * Date: 24.10.2015
 * Time: 7:24
 */ -->
<body style="">
    <!-- Navbar -->
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo site_url('admin/dashboard'); ?>">
                    <?php echo $meta_title; ?><img alt="" src="">
                </a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="<?php echo site_url('admin/dashboard'); ?>"><?php echo $meta_title; ?></a>
                    </li>
                    <li>
                        <?php echo anchor('admin/pages','Pages');?>
                    </li>
                    <li>
                        <?php echo anchor('admin/users','Users');?>
                    </li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">
        <div class="starter-template">
            <!-- main column -->
            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
                <section>
                    <h2><?php echo $module;?></h2>
                </section>
            </div>
            <!-- Sidebar -->
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <section>
                    <?php echo mailto('pro.sport@prosport.rs', '<span class="glyphicon glyphicon-user" area-hidden="true"></span> pro.sport@prosport.rs');?><br/>
                    <?php echo anchor('admin/page/logout','<span class="glyphicon glyphicon-off" area-hidden="true"></span> logout');?>
                </section>
            </div>
        </div>
    </div>
<?php $this->load->view('admin/layouts/page_tail');;?>
