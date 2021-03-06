<?php
require '../../../oc-load.php';
require 'functions.php';
$search_name = $_REQUEST['search_name'];
$user_id = $_REQUEST['user_id'];
$follower_users = get_user_follower_data($user_id);
//if ($follower_users):
    $user_search_data = new DAO();
    $user_search_data->dao->select('user.pk_i_id as user_id, user.s_name as user_name, user.s_email, user.fk_i_city_id, user.fk_c_country_code');
    $user_search_data->dao->select('user_resource.pk_i_id, user_resource.fk_i_user_id, user_resource.s_extension, user_resource.s_path');
    $user_search_data->dao->select('user_cover_picture.user_id AS cover_picture_user_id, user_cover_picture.pic_ext');
    $user_search_data->dao->join(sprintf('%st_user_resource AS user_resource', DB_TABLE_PREFIX), 'user.pk_i_id = user_resource.fk_i_user_id', 'LEFT');
    $user_search_data->dao->join(sprintf('%st_profile_picture AS user_cover_picture', DB_TABLE_PREFIX), 'user.pk_i_id = user_cover_picture.user_id', 'LEFT');
    $user_search_data->dao->from(sprintf('%st_user AS user', DB_TABLE_PREFIX));
    $user_search_data->dao->where(sprintf("user.s_name LIKE '%s'", '%' . $search_name . '%'));
    $user_search_data->dao->whereIn("user.pk_i_id", $follower_users);

    $user_search_data->dao->orderBy('user.s_name', 'ASC');
    $user_search_result = $user_search_data->dao->get();
    $user_search_array = $user_search_result->result();

if ($user_search_array):
    ?>
    <div class="col-md-12 padding-0">
        <div class="user_found_text bg-white"><?php echo 'We found <span class="result_count_text blue_text">' . count($user_search_array) . '</span> results'; ?></div>
    </div>
    <div class="col-md-12 padding-0">
        <?php foreach ($user_search_array as $user): ?>
            <div class="col-md-12 user_box padding-0">
                <div class="box box-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->

                    <?php
                    if ($user['cover_picture_user_id']):
                        $cover_image_path = osc_base_url() . 'oc-content/plugins/profile_picture/images/profile' . $user['cover_picture_user_id'] .'.'. $user['pic_ext'];
                    else:
                        $cover_image_path = osc_current_web_theme_url() . "/images/cover-image.png";
                    endif;
                    ?>
                    <div class="widget-user-header bg-black" style="background: url('<?php echo $cover_image_path ?>') center center;">
                        <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>" >
                            <h3 class="widget-user-username">
                                <?php echo $user['user_name'] ?>
                            </h3>
                        </a>
                        <h5 class="widget-user-desc">
                            <?php echo $user['role_name'] ?>
                        </h5>
                    </div>
                    <a href="<?php echo osc_user_public_profile_url($user['user_id']) ?>">
                        <div class="widget-user-image">
                            <?php
                            if (!empty($user['s_path'])):
                                $img_path = osc_base_url() . $user['s_path'] . $user['pk_i_id'] . '.' . $user['s_extension'];
                            else:
                                $img_path = osc_current_web_theme_url() . '/images/user-default.jpg';
                            endif;
                            ?>

                            <img class="img-circle" src="<?php echo $img_path ?>" alt=" <?php echo $user['user_name'] ?>">
                        </div>
                    </a>
                    <div class="box-footer">
                        <div class="row margin-0">
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        <?php
                                        $user_following = get_user_following_data($user['user_id']);
                                        if ($user_following):
                                            echo count($user_following);
                                        else:
                                            echo 0;
                                        endif;
                                        ?>
                                    </h5>
                                    <span class="description-text">
                                        ABONNEMENTS
                                    </span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        <?php
                                        $user_followers = get_user_follower_data($user['user_id']);
                                        if ($user_followers):
                                            echo count($user_followers);
                                        else:
                                            echo 0;
                                        endif;
                                        ?>
                                    </h5>
                                    <span class="description-text">
                                        FOLLOWERS
                                    </span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                                <div class="description-block">
                                    <h5 class="description-header">
                                        <?php
                                        echo get_user_posts_count($user['user_id']);
                                        ?>
                                    </h5>
                                    <span class="description-text">POSTS</span>
                                </div>
                                <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                </div>


            </div>                
        <?php endforeach; ?>
    </div>  

<?php else: ?>
    <div class = "col-md-12 no-of-result">
        <p class = "people-result-text">No follower found</p>
    </div>
<?php endif; ?>