<!DOCTYPE html>
<html dir="ltr" lang="<?php echo str_replace('_', '-', osc_current_user_locale()); ?>">
    <head>
        <meta charset="utf-8">
        <title><?php echo meta_title(); ?></title>
        <?php if (meta_description() != '') { ?>
            <meta name="description" content="<?php echo osc_esc_html(meta_description()); ?>" />
        <?php } ?>
        <?php if (meta_keywords() != '') { ?>
            <meta name="keywords" content="<?php echo osc_esc_html(meta_keywords()); ?>" />
        <?php } ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php if (osc_is_ad_page()) { ?>
            <!-- Open Graph Tags -->
            <meta property="og:title" content="<?php echo osc_item_title(); ?>" />
            <meta property="og:image" content="<?php if (osc_count_item_resources()) { ?><?php echo osc_resource_url(); ?><?php } ?>" />
            <meta property="og:description" content="<?php echo osc_highlight(strip_tags(osc_item_description()), 120); ?>" />
            <!-- /Open Graph Tags -->
        <?php } ?>
        <?php if (osc_get_preference('g_webmaster', 'flatter_theme') != null) { ?>
            <meta name="google-site-verification" content="<?php echo osc_get_preference("g_webmaster", "flatter_theme"); ?>" />
        <?php } ?>
        <?php if (osc_get_canonical() != '') { ?><link rel="canonical" href="<?php echo osc_get_canonical(); ?>"/><?php } ?>
        <link rel="icon" href="favicon.ico" />
        <link href="<?php echo osc_current_web_theme_url('css/bootstrap.min.css'); ?>?ver=3.3.5" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('css/style.css'); ?>?ver=<?php echo $info['version']; ?>" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?php echo osc_current_web_theme_url('css/mobilenav.css'); ?>" />
        <?php $getColorScheme = flatter_def_color(); ?>
        <?php osc_enqueue_style('' . $getColorScheme . 'green', osc_current_web_theme_url('css/' . $getColorScheme . '.css')); ?>
        <?php if (osc_get_preference('anim', 'flatter_theme') != '0') { ?>
            <link href="<?php echo osc_current_web_theme_url('css/animate.min.css'); ?>" rel="stylesheet" type="text/css" />
        <?php } ?>
        <link rel="stylesheet" href="<?php echo osc_current_web_theme_url('css/owl.carousel.css'); ?>" type="text/css" media="screen" />
        <link href="<?php echo osc_current_web_theme_url('css/responsivefix.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('dist/css/AdminLTE.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('dist/css/skins/_all-skins.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('plugins/iCheck/flat/blue.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('css/bootstrap-switch.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('plugins/select2/select2.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('css/style2.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo osc_current_web_theme_url('css/jquery.Jcrop.min.css'); ?>" rel="stylesheet" type="text/css" />
        <script src="<?php echo osc_current_web_theme_url('js/jquery/jquery-1.11.2.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('plugins/select2/select2.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/bootstrap-typeahead.min.js'); ?>"></script>
        <script src="<?php echo osc_current_web_theme_url('js/jPushMenu.js'); ?>"></script>
        <?php
        $user_id = osc_logged_user_id();
        $user = get_user_data($user_id);
        if (!empty($user['s_path'])):

        endif;
        ?>
        <script src="<?php echo osc_current_web_theme_url('js/main.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/owl.carousel.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/bootstrap.min.js'); ?>?ver=3.3.5"></script>  
        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/placeholders.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('dist/js/app.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/bootstrap-switch.min.js'); ?>"></script>

        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/jquery-dropdate.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/date.format.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/jquery.Jcrop.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/script.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo osc_base_url() . 'oc-content/plugins/slider/responsiveslides.min.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_js_url('jquery.geocomplete.js') ?>"></script>
        <script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/masonry.pkgd.min.js'); ?>"></script>
        <script src="https://unpkg.com/imagesloaded@4.1/imagesloaded.pkgd.min.js"></script>
        <!-- Header Hook -->
        <?php osc_run_hook('header'); ?>
        <!-- /Header Hook -->

        <!--<script type="text/javascript" src="<?php echo osc_current_web_theme_url('js/jquery.ias.min.js'); ?>"></script>-->

        <?php if (osc_get_preference('custom_css', 'flatter_theme', "UTF-8") != '') { ?>
            <style type="text/css">
    <?php echo osc_get_preference('custom_css', 'flatter_theme', "UTF-8"); ?>
            </style>
        <?php } ?>
            <?php if (!osc_is_web_user_logged_in()) : ?>
        <style>
            .skin-blue .sidebar-menu>li>.treeview-menu {
                background-color: #222d32 !important;
            }
            .sidebar-menu>li.active-menu>a {
                color: #fff;
                background: #222d32 !important;
                border-left-color: #3c8dbc;
            }
            .skin-blue .sidebar-menu>li:hover>a, .skin-blue .sidebar-menu>li.active>a{
                color: #f68935 !important;
                background: #1e282c !important;
                border-left-color: #3c8dbc;
            }
            .sidebar-menu>li.active>a {
                color: #f68935 !important;
                background: #1e282c !important;
                border-left-color: #3c8dbc;
            }
            .sidebar-menu>li>ul>li.active>a {
                color: #f68935;
                background: #222d32 !important;
                border-left-color: #3c8dbc;
            }
            .sidebar-menu>li>ul>li:hover>a {
                color: #f68935;
                background: #222d32 !important;
                border-left-color: #3c8dbc;
            }
            .skin-blue .wrapper, .skin-blue .main-sidebar, .skin-blue .left-side, .sidebar-menu {
                background-color: #222d32 !important;
            }
            .skin-blue .sidebar-form input[type="text"], .skin-blue .sidebar-form .btn {
                background-color:#374850 !important;
            }
        </style>
        <?php endif; ?>
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->


        <!--===========================FreiChat=======START=========================-->
        <!--	For uninstalling ME , first remove/comment all FreiChat related code i.e below code
                 Then remove FreiChat tables frei_session & frei_chat if necessary
                 The best/recommended way is using the module for installation                         -->

        <?php
        $ses = osc_logged_user_id(); //tell freichat the userid of the current user
        if ($ses != 0) {
            setcookie("freichat_user", "LOGGED_IN", time() + 3600, "/"); // *do not change -> freichat code
        } else {
            $ses = null; //tell freichat that the current user is a guest

            setcookie("freichat_user", null, time() + 3600, "/"); // *do not change -> freichat code
        }

        if (!function_exists("freichatx_get_hash")) {

            function freichatx_get_hash($ses) {

                if (is_file(osc_base_path() . "/freichat/hardcode.php")) {

                    require osc_base_path() . "/freichat/hardcode.php";

                    $temp_id = $ses . $uid;

                    return md5($temp_id);
                } else {
                    echo "<script>alert('module freichatx says: hardcode.php file not
found!');</script>";
                }

                return 0;
            }

        }
        ?>
        <script type="text/javascript" language="javascipt" src="<?php echo osc_base_url(); ?>freichat/client/main.php?id=<?php echo $ses; ?>&xhash=<?php echo freichatx_get_hash($ses); ?>"></script>
        <link rel="stylesheet" href="<?php echo osc_base_url(); ?>freichat/client/jquery/freichat_themes/freichatcss.php" type="text/css">
        <!--===========================FreiChatX=======END=========================--> 


    </head>
    <body class="<?php flatter_body_class(); ?> skin-blue sidebar-mini" >
        <div class="wrapper row main_wrapper">
            <div class="col-md-2 sidebar col-sm-0 padding-0">       

                <aside class="main-sidebar" >
                    <!-- sidebar: style can be found in sidebar.less -->
                    <section class="sidebar sidenav  <?php if (!osc_is_web_user_logged_in()) : ?> padding-top-4per <?php endif; ?>" id="mySidenav">
                        <?php if (osc_is_web_user_logged_in()) : osc_user(); ?>
                            <?php
                            $user_id = osc_logged_user_id();
                            $user = get_user_data($user_id);
                            if (!empty($user['s_path'])):
                                $img_path = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
                            else:
                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            endif;
                            ?>

                            <!-- Sidebar user panel -->

                            <div class="user-panel">
                                <div class="pull-left image">
                                    <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>">
                                        <!--<a href="javascript:void(0)">-->
                                        <img src="<?php echo $img_path ?>" class="img-circle user-icon" alt="User Image">
                                        <div class="green-dot"></div>
                                    </a>
                                </div>
                                <div class="col-md-12">
                                    <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>">
                                        <a href="javascript:void(0)">
                                            <p><?php echo $user['user_name'] ?></p>
                                        </a>                                
                                </div>

                                <!--                                <div class="pull-left info">
                                                                    <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>">
                                                                        <a href="javascript:void(0)">
                                                                        <p>
                                                                            <i class="fa fa-circle text-success"></i> 
                                <?php is_user_online($user['user_id']); ?> 
                                                                        </p>
                                                                    </a>
                                                                </div>
                                                                <div class="clearfix"></div>
                                                                <div style="height: 10px;"></div>
                                                                <div class="pull-left">
                                                                    <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>">
                                                                        <a href="javascript:void(0)">
                                                                        <p><?php echo $user['user_name'] ?></p>
                                                                    </a>                                
                                                                </div>-->
                            </div>

                        <?php endif; ?>

                        <!-- search form -->
                        <div class="input-group sidebar-form search-newsfid" >
                            <input type="text"  name="q" class="form-control search-newsfid-text" placeholder="Search...">
                            <span class="input-group-btn">
                                <button type="submit" id="search-btn" class="btn btn-flat search-newsfid-btn"><i class="fa fa-search"></i> </button>
                            </span>
                        </div>
                        <!-- /.search form -->
                        <!-- sidebar menu: : style can be found in sidebar.less -->
                        <ul class="sidebar-menu">
                            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                            <!--<li class="header">MAIN NAVIGATION</li>-->
                            <?php
                            $url = $_SERVER['QUERY_STRING']; //you will get last part of url from there
                            $parts = explode('/', $url, 4);
                            ?>
                            <?php //if(strpos('page=home', $parts)$parts) ?>
                            <?php
                            $active = '';
                            if ($protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] == osc_base_url()):
                                $active = 'active';
                            else:
                                $active = '';
                            endif;
                            ?>
                            <li class="treeview <?php echo $active ?>">
                                <a href="<?php echo osc_base_url() ?>">
                                    <i class="fa fa-th"></i>
                                    News Feed
                                </a>
                            </li>
                            <?php
                            $active = '';
                            if (!empty($parts[0])):
                                if (strpos($parts[0], 'page=page') !== false && strpos($parts[0], 'id=33') !== false):
                                    $active = 'active';
                                else:
                                    $active = '';
                                endif;
                            endif;
                            ?>
                            <?php if (osc_is_web_user_logged_in()): ?>
                                <li class="treeview <?php echo $active ?>">
                                    <a href="<?php echo osc_base_url() . '?page=page&id=33' ?>">
                                        <i class="fa fa-circle-o"></i>
                                        Center of interest
                                    </a>
                                </li>
                                <?php
                                $active = '';
                                if (!empty($parts[0])):
                                    if (strpos($parts[0], 'page=item') !== false && strpos($parts[0], 'action=item_add') !== false):
                                        $active = 'active';
                                    else:
                                        $active = '';
                                    endif;
                                endif;
                                ?>
                                <li class="add-item treeview active-menu" >
                                    <!--<a href="<?php echo osc_base_url() . 'index.php?page=item&action=item_add' ?>">-->
                                    <a href="javascript:void(0)" class="free_account" >
                                        <i class="fa fa-list-ul"></i>
                                        Publish
                                    </a>

                                </li> 
                                <?php
                                $active = '';
//                                if (strpos($_SERVER['REQUEST_URI'], 'soundpass') !== false):
//                                    $active = 'active';
//                                else:
//                                    $active = '';
//                                endif;
                                if ((strpos($parts[0], 'page=user') !== false && strpos($parts[0], 'action=pub_profile') !== false)):
                                    $active = 'active';
                                else:
                                    $active = '';
                                endif;
                                ?>
                                <li class="treeview <?php echo $active ?>">
                                    <!--<a href="<?php echo osc_current_web_theme_url() . 'soundpass.php' ?>">-->
                                    <a href="<?php echo osc_user_public_profile_url(osc_logged_user_id()) ?>">
                                        <i class="fa fa-copy"></i>
                                        My profile
                                    </a>
                                </li>   
                                <?php
                                $active = '';
                                if (!empty($parts[0])):
                                    if (strpos($parts[0], 'page=page') !== false && strpos($parts[0], 'id=32') !== false):
                                        $active = 'active';
                                    else:
                                        $active = '';
                                    endif;
                                endif;
                                ?>
                                <li class="treeview <?php echo $active ?>">
                                    <a href="<?php echo osc_base_url() . 'index.php?page=page&id=32' ?>">
                                        <i class="fa fa-users"></i>
                                        People
                                    </a>
                                </li>                                 
                                <?php
                                $active = '';

//                                    if (strpos($parts[0], 'page=user') !== false && strpos($parts[0], 'action=pub_profile') !== false):
//                                if ((strpos($_SERVER['REQUEST_URI'], 'setting') !== false) || (strpos($parts[0], 'page=user') !== false && strpos($parts[0], 'action=pub_profile') !== false)):
                                if ((strpos($_SERVER['REQUEST_URI'], 'setting') !== false)):
                                    $active = 'active';
                                else:
                                    $active = '';
                                endif;
                                ?>   
                                <li class="treeview <?php echo $active ?>">
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-user"></i>
                                        <?php echo __('Account'); ?>
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </a>                                
                                    <ul class="treeview-menu">
                                        <?php
//                                        $active = '';
//
//                                        if ((strpos($parts[0], 'page=user') !== false && strpos($parts[0], 'action=pub_profile') !== false)):
//
//                                            $active = 'active';
//                                        else:
//                                            $active = '';
//                                        endif;
                                        ?>   
    <!--                                        <li class="<?php echo $active ?>">
                                            <a href="<?php echo osc_user_public_profile_url(osc_logged_user_id()) ?>">
                                                <i class="fa fa-user"></i> <?php echo __('Account'); ?>
                                            </a>
                                        </li>-->
                                        <?php
                                        $active = '';
                                        if ((strpos($_SERVER['REQUEST_URI'], 'setting') !== false)):
                                            $active = 'active';
                                        else:
                                            $active = '';
                                        endif;
                                        ?> 
                                        <li class="user_settings treeview <?php echo $active ?>" data-toggle="modal" data-target="#user_confirm_password">
    <!--<a href="<?php echo osc_user_dashboard_url() ?>">-->
                                            <a href="javascript:void(0)">
                                                <i class="fa fa-gear"></i>Center of settings
                                            </a>
                                        </li>
                                    </ul>
                                </li>   



                                <?php
                                $active = '';
//                                if (empty($parts[0])):
                                if (strpos($_SERVER['REQUEST_URI'], 'subscribe') !== false):
                                    $active = 'active';
                                else:
                                    $active = '';
                                endif;
//                                endif;
                                ?>

                                <?php if ($user['user_type'] == 0 || $user['user_type'] == 2): ?>
                                    <li class="treeview <?php echo $active ?>">
                                        <a href="<?php echo osc_current_web_theme_url() . 'subscribe.php' ?>">
                                            <i class="fa fa-money"></i>Subscribe now
                                        </a>
                                    </li>   
                                <?php endif; ?>
                                <?php
                                $active = '';
                                if (!empty($parts[0])):
                                    if ((strpos($parts[0], 'page=page') !== false && strpos($parts[0], 'id=34') !== false) || (strpos($parts[0], 'page=contact') !== false)):
                                        $active = 'active';
                                    else:
                                        $active = '';
                                    endif;
                                endif;
                                ?>
                                <li class="treeview <?php echo $active ?>">
                                    <a href="javascript:void(0)">
                                        <i class="fa fa-info"></i>Informations<i class="fa fa-angle-left pull-right"></i>
                                    </a>

                                    <ul class="treeview-menu">
                                        <?php
                                        $active = '';
                                        if (!empty($parts[0])):
                                            if (strpos($parts[0], 'page=page') !== false && strpos($parts[0], 'id=34') !== false):
                                                $active = 'active';
                                            else:
                                                $active = '';
                                            endif;
                                        endif;
                                        ?>
                                        <li class="treeview <?php echo $active ?>">
                                            <a href="<?php echo osc_base_url() . '?page=page&id=34' ?>">
                                                <i class="fa fa-book"></i>Terms
                                            </a>
                                        </li>

                                        <?php
                                        $active = '';
                                        if (!empty($parts[0])):
                                            if (strpos($parts[0], 'page=contact') !== false):
                                                $active = 'active';
                                            else:
                                                $active = '';
                                            endif;
                                        endif;
                                        ?>
                                        <li class="treeview <?php echo $active ?>">                          
                                            <a href="<?php echo osc_contact_url(); ?>">
                                                <i class="fa fa-phone"></i>Contact
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                            <?php endif; ?>
                            <?php if (!osc_is_web_user_logged_in()): ?>

                                
                                    <?php
                                    $active = '';
                                    if (!empty($parts[0])):
                                        if (strpos($parts[0], 'page=login') !== false):
                                            $active = 'active';
                                        else:
                                            $active = '';
                                        endif;
                                    endif;
                                    ?>
                                <li class="treeview <?php echo $active ?>">
                                    <a href="<?php echo osc_user_login_url() ?>">
                                        <i class="fa fa-sign-in"></i>Login
                                    </a>
                                </li>

                                <?php
                                $active = '';
                                if (!empty($parts[0])):
                                    if (strpos($parts[0], 'page=register') !== false):
                                        $active = 'active';
                                    else:
                                        $active = '';
                                    endif;
                                endif;
                                ?>

                                <li class="treeview <?php echo $active ?>">
                                    <a href="<?php echo osc_register_account_url() ?>">
                                        <i class="fa fa-user-plus"></i>Register
                                    </a>
                                </li>
                            <?php endif; ?>
                            <?php if (osc_is_web_user_logged_in()) : osc_user(); ?>                                           

                                <li class="treeview">
                                    <a href="<?php echo osc_user_logout_url() ?>">
                                        <i class="fa fa-sign-out"></i>Logout
                                    </a>
                                </li>

                            <?php endif; ?>

                        </ul>

                    </section>
                    <!-- /.sidebar -->
                </aside>
            </div>
            <div class="free-user-post"></div>
            <div class="search-newsfid-popup">                
                <div id="newsfid-search" class="modal fade" role="dialog">
                    <div class="modal-dialog search-popup">
                        <div class="modal-content">

                        </div>
                    </div>
                </div>                
            </div>
            <span class="menu-button" onclick="openNav()">&#9776;</span>
            <div class="user_passwor_popup_container">
                <div id="user_confirm_password" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="blue_text modal-title bold">
                                    Identification
                                </h4>
                            </div>
                            <div class="modal-body">
                                <div class="">
                                    Cette page contient des informations personelles,<br/>
                                    <span class="bold">confirmer votre mot de passe pour y accéder.</span>
                                </div>
                                <div class="input-text-area margin-top-20 left-border box-shadow-none">
                                    <input class="border-bottom-0 user_password_field width-60" type="password" placeholder="Mot de passe">
                                    <image src="<?php echo osc_current_web_theme_url() . '/images/loader.gif' ?>" id="setting_loader" class="hidden">
                                </div>
                                <div class="red_text alert_text"></div>
                            </div>
                            <div class="modal-footer text-left">
                                <button type="button" class="btn btn-blue border-radius-0 user_password_check_btn">Confirmer</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <?php (osc_is_web_user_logged_in()) ? $class = "col-md-7  main_content" : $class = "col-md-10 after_logging  " ?>
            <div class="<?php echo $class ?> padding-0 " id="main">
                <div class="content-wrapper">
                    <div class="content">
                        <?php if (!isset($_COOKIE["cookie_banner"])) { ?>
                            <div id="cookie_banner">
                                <span>
                                    By continuing the navigation you accept the use of cookies to deliver adapted content with your center of interest.
                                    <span class="cookie_btn" title="close_cookie">Accept</span>
                                </span>
                            </div>
                        <?php } ?>
                        <?php
                        osc_show_flash_message();
                        if (!osc_is_web_user_logged_in()):
                            ?>
                            <a href="#" class="scrollToTop"><span class="fa fa-chevron-up fa-2x"></span></a>

                            <?php
                        endif;
                        if (osc_show_flash_message()) {
                            ?>
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12 notification">
                                        <?php osc_show_flash_message(); ?>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>


                        <script>
                            (function (i, s, o, g, r, a, m) {
                                i['GoogleAnalyticsObject'] = r;
                                i[r] = i[r] || function () {
                                    (i[r].q = i[r].q || []).push(arguments)
                                }, i[r].l = 1 * new Date();
                                a = s.createElement(o),
                                        m = s.getElementsByTagName(o)[0];
                                a.async = 1;
                                a.src = g;
                                m.parentNode.insertBefore(a, m)
                            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

                            ga('create', 'UA-76423510-1', 'auto');
                            ga('send', 'pageview');

                        </script>

                        <script>

                            $(document).on('click', '.closebtn', function () {
                                $('#mySidenav').css("width", "0px");
                                $('#mySidenav').css("height", "0px");
                                $('.sidenav').css("transition", "0.9s");
                                $('.menu-button').show();
                                $('.closebtn').hide();
                            });
                            $(document).on('click', '.menu-button', function () {
                                $('.closebtn').show();
                                $('.menu-button').hide();
                                $('#mySidenav').css("width", "250px");
                                $('#mySidenav').css("height", "720px");
                                $('.sidenav').css("transition", "0.9s");
                                $('#mySidenav').css("display", "block");
                            });
                            /* Set the width of the side navigation to 0 */

                            $(document).ready(function () {

                                $('.cookie_btn').click(function () { //on click event
                                    days = 182; //number of days to keep the cookie
                                    myDate = new Date();
                                    myDate.setTime(myDate.getTime() + (days * 24 * 60 * 60 * 1000));
                                    document.cookie = "cookie_banner = yes; expires = " + myDate.toGMTString(); //creates the cookie: name|value|expiry
                                    $("#cookie_banner").slideUp("slow"); //jquery to slide it up
                                });

                                $(document).on('click', '.free_account', function () {
                                    $.ajax({
                                        url: '<?php echo osc_current_web_theme_url() . 'popup_free_account_post.php' ?>',
                                        success: function (data) {
                                            $('.free-user-post').html(data);
//                                            $('#popup-free-user-post').appendTo("body");
                                            $('#popup-free-user-post').modal('show');
                                        }
                                    });
                                });
//                                $(document).on('click', '.user_settings', function () {
//                                    $.ajax({
//                                        url: '<?php echo osc_current_web_theme_url() . 'user_confirm_password_popup.php' ?>',
//                                        success: function (data) {
//                                            $('.user_passwor_popup_container').html(data);
//                                            $('#user_confirm_password').modal('show');
//                                        }
//                                    });
//                                });
                                $('.user_password_field').keypress(function (e) {
                                    if (e.which == 13) {//Enter key pressed
                                        $('.user_password_check_btn').click();
                                    }
                                });
                                $(document).on('click', '.user_password_check_btn', function () {
                                    var password = $('.user_password_field').val();
                                    $('#setting_loader').removeClass();
                                    $.ajax({
                                        url: '<?php echo osc_current_web_theme_url() . 'password_check_ajax.php' ?>',
                                        data: {
                                            password: password
                                        },
                                        success: function (data) {
                                            if (data == 1) {
                                                window.location.href = '<?php echo osc_current_web_theme_url() . 'setting.php' ?>'
                                            } else {
                                                $('#setting_loader').addClass('hidden');
                                                $('.alert_text').html('password is not correct');
                                            }
                                        }
                                    });
                                });
                            });</script>
                        <script>
                            $(document).ready(function () {
                                var a = $(document).on('keyup', '.search-newsfid-text', function () {
                                    var search_newsfid_text = $('.search-newsfid-text').val();
                                    if (search_newsfid_text != '') {
                                        $.ajax({
                                            url: '<?php echo osc_current_web_theme_url() . 'search-newsfid.php' ?>',
                                            data: {
                                                search_newsfid_text: search_newsfid_text
                                            },
                                            success: function (data, textStatus, jqXHR) {
                                                $('.search-newsfid-popup .modal-content').empty().append(data);
                                                $('#newsfid-search').modal('show');
                                            }
                                        })
                                    }
                                });

                                $(document).on('keyup', '.search_newsfid_text', function () {
                                    var search_newsfid_text = $('.search_newsfid_text').val();
                                    if (search_newsfid_text != '') {
                                        $.ajax({
                                            url: '<?php echo osc_current_web_theme_url() . 'search-newsfid.php' ?>',
                                            data: {
                                                search_newsfid_text: search_newsfid_text
                                            },
                                            success: function (data) {
                                                $('.search-newsfid-popup .modal-content').empty().append(data);
                                            }
                                        })
                                    }
                                });
                            });
                        </script>
