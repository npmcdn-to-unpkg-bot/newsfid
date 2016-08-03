<?php
require '../../../oc-load.php';
require 'functions.php';

$comment_user_id = osc_logged_user_id();
$comment_item_id = $_REQUEST['item_id'];
$comment_text = $_REQUEST['comment_text'];
$new_comment = new DAO();

$user = get_user_data($comment_user_id);
if (isset($_REQUEST['comment_id']) && !empty($_REQUEST['comment_id'])):
    $comment_comment_id = $_REQUEST['comment_id'];
    $comments_data = new DAO();
    if(isset($_REQUEST['delete']) && $_REQUEST['delete'] == '1'):
        $comments_result = $comments_data->dao->delete("oc_t_item_comment", array('pk_i_id' => $comment_comment_id));    
    else:
        $text = $_REQUEST['comment_text'];
        $comments_result = $comments_data->dao->update("oc_t_item_comment", array('s_body' => $text), array('pk_i_id' => $comment_comment_id));
        if ($comments_result):
            echo 1;
        else:
            echo 0;
        endif;
    endif;
else :
    $comment_array = array();
    $comment_array['fk_i_item_id'] = $comment_item_id;
    $comment_array['s_body'] = $comment_text;
    $comment_array['fk_i_user_id'] = $user['user_id'];
    $comment_array['s_author_name'] = $user['user_name'];
    $comment_array['s_author_email'] = $user['s_email'];
    $comment_array['b_enabled'] = 1;
    $comment_array['b_active'] = 1;
    $comment_array['dt_pub_date'] = date("Y-m-d H:i:s");
    $comment_data = $new_comment->dao->insert(DB_TABLE_PREFIX . 't_item_comment', $comment_array);
endif;
$c_data;
$comments_data = new DAO();
$comments_data->dao->select(sprintf('%st_item_comment.*', DB_TABLE_PREFIX));
$comments_data->dao->from(sprintf('%st_item_comment', DB_TABLE_PREFIX));
$conditions = array('fk_i_item_id' => $comment_item_id,
    'b_active' => 1,
    'b_enabled' => 1);
//$comments_data->dao->limit(3);
$comments_data->dao->where($conditions);
$comments_data->dao->orderBy('dt_pub_date', 'DESC');
$comments_result = $comments_data->dao->get();
$c_data = $comments_result->result();?>
<div class="comments_container_<?php echo $comment_item_id; ?>"> 
    <?php
    if ($c_data):
        ?>
        <?php if (count($c_data) > 3): ?>
            <div class="box-body">
                <span class="load_more_comment"> <i class="fa fa-plus-square-o"></i> Display <?php echo count($c_data) - 3 ?> comments more </span>
                <span class="comment_count"><?php echo count($c_data) - 3 ?></span>
            </div>
        <?php endif; ?>
        <?php
        foreach ($c_data as $k => $comment_data):
            ?>
            <?php
            $comment_user = get_user_data($comment_data['fk_i_user_id']);

            if ($k > 2 && !$load_more && count($c_data) > 3):
                $load_more = 'load more';
                ?>                
                <div class="load_more">
                    <?php
                endif;
                ?>
                <div class="box-footer box-comments">
                    <div class="box-comment">
                        <!-- User image -->

                        <div class="comment_user_image">
                            <?php get_user_profile_picture($comment_user['user_id']) ?>
                        </div>
                        <div class="comment-area">
                            <span class="username">
                                <?php echo $comment_user['user_name'] ?>
                                <div class="dropdown  pull-right">
                                    <i class="fa fa-angle-down  dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-hidden="true"></i>
                                    <ul class="dropdown-menu edit-arrow" aria-labelledby="dropdownMenu1">
                                        <li class="delete_cmnt" onclick="deleteComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $comment_item_id; ?>)"><a>Supprimer la publication</a></li>
                                        <li class="edit_cmnt comment_text_<?php echo $comment_data['pk_i_id']; ?>" data-item-id='<?php echo $comment_item_id; ?>' data_text="<?php echo $comment_data['s_body']; ?>" data_id="<?php echo $comment_data['pk_i_id']; ?>" onclick="editComment(<?php echo $comment_data['pk_i_id']; ?>,<?php echo $comment_item_id; ?>)" ><a>Modifier</a></li>
                                        <li><a></a></li>
                                        <li><a>Sponsoriser</a></li>
                                        <li><a>Remonter en tête de liste</a></li>
                                        <li><a></a></li>
                                        <li><a>Signaler la publication</a></li>

                                    </ul>
                                </div>
                            </span>
                            <span class="comment_text comment_edt_<?php echo $comment_data['pk_i_id']; ?>" data-text="<?php echo $comment_data['s_body']; ?>">
                                <?php echo $comment_data['s_body']; ?>
                            </span>
                            <span class="text-muted pull-right"><?php echo time_elapsed_string(strtotime($comment_data['dt_pub_date'])) ?></span>                            
                        </div>
                        <!-- /.comment-text -->
                    </div>                       
                </div>
                <?php
                if ($k > 2 && $k == (count($c_data) - 1)):
                    unset($load_more);
                    ?>
                </div>                                
                <?php
            endif;
            ?>       
            <?php
        endforeach;
    endif;
    ?>
</div>
