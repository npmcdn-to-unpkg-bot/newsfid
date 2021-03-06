<?php
// meta tag robots
error_reporting(0);
osc_add_hook('header', 'flatter_nofollow_construct');

flatter_add_body_class('register');
osc_enqueue_script('jquery-validate');
osc_current_web_theme_path('header.php');
?>
<?php
if ($_REQUEST['submit']):
    if (count($_REQUEST['cat_id']) >= 4):
        $user_id = $_SESSION['user_id'];
        $conn = getConnection();
        foreach ($_REQUEST['cat_id'] as $k => $v):
            $conn->osc_dbExec("INSERT INTO %st_user_rubrics ( user_id, rubric_id) VALUES (%s,'%s' )", DB_TABLE_PREFIX, $user_id, $v);
        endforeach;
        osc_reset_static_pages();
        header('Location: ' . osc_user_login_url());
        die;
    else:
        osc_add_flash_error_message(_m('You must select at least four rubrics'));
        header("Location: " . $_SERVER['REQUEST_URI']);
    endif;
endif;
?>

<form action="" method="post"  class="user_rubric_form">
    <div class="registerbox">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="titlebox background-white padding-10">
                        <h2>Centre d'intérêt</h2>
                        <h1>
                            Choisissez un ou plusieurs themes
                        </h1>
                        <span>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus imperdiet, justo et auctor posuere, diam enim ultrices libero, ut blandit erat ipsum in orci. Nulla elementum leo ac justo luctus, non vehicula sapien faucibus.
                            <br/>
                            <br/>
                            In viverra arcu vitae laoreet iaculis. Proin justo erat, dictum id molestie sed, commodo non erat.
                        </span>
                    </div>

                    <div class="separate-30"></div>

                    <div class="col-md-12 padding-10 background-white">
                        <div class="pull-right">
                            <input class="btn btn-blue btn-flat add_rubric" type="submit" name="submit" value="Poursuivre" />
                        </div>
                    </div>

                </div>
                <div class="col-md-8 col-sm-8">
                    <div class="row">

                        <?php
                        $rubrics = get_all_rubrics_icon();
                        ?>
                        <?php foreach ($rubrics as $k => $rubric): ?>
                            <div class="col-md-3 col-sm-3 margin-bottom-20">
                                <div class="category_box" data-id="<?php echo $rubric['id'] ?>">
                                    <div class="category_image">
                                        <?php if ($rubric['image']) : ?>
                                            <img src="<?php echo RUBRIC_UPLOAD_DIR_PATH . $rubric['image']; ?>" class="img img-responsive cat-image"/>    
                                        <?php endif; ?>
                                        <div class="add_box">
                                            <span class="add_icon"></span>
                                        </div>
                                        <div class="overlay"></div>
                                        <input type="checkbox" name="cat_id[]" value="<?php echo $rubric['id'] ?>" class="cat_checkbox" style="display: none">
                                    </div>
                                    <div class="category_title">
                                        <?php echo $rubric['name'] ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<style>
    .cat-image{
        height: 100px;
        display: inline-block;
    }
    .category_title {
        padding: 10px;
        color: #000;
        font-weight: bold;
        background-color: #fff;
        text-align: center;
        text-transform: uppercase;
    }
    .category_box {
        border: 1px solid #e3e3e5;
        background-color: #eee;
        cursor: pointer;
    }
    .add_box{
        position: absolute;
        top: 25%;
        left: 35%;
        background-color: rgba(0,0,0,0.5);
        height: 50px;
        width: 50px;
        border-radius: 50%;
        z-index: 2;
    }
    .add_box::after {
        position: absolute;
        left: 25%;
        font-family: FontAwesome;
        content: '\f067';
        font-size: 30px;
        color: #fff;
        z-index: 2;
        top: 7%;
    }
    .category_box.selected  .add_box::after {
        content: "\f00c";
    }
    /*    .add_icon {
            position: absolute;
            top: -25%;
            color: #fff;
            font-weight: bold;
            font-size: 50px;
            left: 25%;
        }*/
    .category_image{
        position: relative;
        text-align: center;
    }
    .category_box{
        transition: all 0.5s 0.5s ease-in-out;        
    }
    .overlay{
        height: 100%;
        width: 100%;
        background-color: rgba(28, 125, 193, 0.8);
        z-index: 1;
        top: 0;
        left: 0;
        position: absolute;
        display: none;
    }
    .category_box.selected .overlay{
        display: block;
    }
</style>
<?php

function new_footer() {
    ?>
    <script>
        $(document).ready(function () {
            $('.category_box').click(function () {
                $(this).toggleClass('selected');
                var checkbox = $(this).find('.cat_checkbox');
                checkbox.attr("checked", !checkbox.attr("checked"));
            });
            $('.add_rubric').click(function (e) {
                var checked_cat = $('.category_box.selected');
                if (checked_cat.length >= 4) {
                    $('.user_rubric_form').submit();
                } else {
                    alert('Please select at least four rubrics');
                   e.preventDefault();
                }
            });
        });
    </script>
    <?php
}

//osc_add_hook('footer', 'ex_load_scripts');
osc_add_hook('footer', 'new_footer');
?>

<?php osc_current_web_theme_path('footer.php'); ?>