<!--
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 11.12.2017
 * Time: 9:41
-->

<?php extract($data); ?>
<div id="featured">
    <h3><?php echo $article->getName(); ?></h3>
</div>

<div id="article">
    <?php echo $article->getContent(); ?>
</div>

<?php if (!empty($status)) {?>
<form class="form" autocomplete="off" action="" method="post">
    <?php } ?>

    <div id="featured">
        <div class="title commentTitle">
            <span class="byline">Article Comments</span>
        </div>
        <?php if(!empty($comments)) {?>
            <?php foreach ($comments as $comment) { ?>
                <div class="detailBox">
                    <div class="commentBox">
                        <?php echo $comment[0]->getContent(); ?>
                    </div>
                    <div class="footBox">
                        <label class="comment_username">
                            @<?php echo $comment[1]; ?>
                            &nbsp&nbsp&nbsp
                            <?php echo $comment[0]->getPostTime()->format('Y/d/m h:i:sa'); ?>
                        </label>
                    </div>
                </div>
            <?php }
        }?>

        <?php if (!empty($status)) {?>
        <ul class="style1">
            <textarea name="text_editor"></textarea>
            <script>
                CKEDITOR.replace( 'text_editor', {height: 100, toolbar: 'Limited'} );
            </script>
        </ul>
        <button class="buttonGreen" type="submit" name="create_comment_button">Comment</button>
        <?php }?>
    </div>

    <?php if (!empty($status)) {?>
    <?php if(!empty(array_intersect(array("reviewer"),$status))){?>
        <div id="featured">
            <div class="title commentTitle">
                <span class="byline">Review Status: </span>
                <?php if (isset($review_status_selected) && $review_status_selected == status::Rejected) { ?>
                    <span class="byline" style="color:red;font-weight: 400;">Rejected</span>
                <?php }elseif (isset($review_status_selected) && $review_status_selected == status::Approved) { ?>
                    <span class="byline" style="color:#00bc00;font-weight: 400;">Approved</span>
                <?php }else{ ?>
                    <span class="byline" style="color:#f9a806;font-weight: 400;">Not Arranged</span>
                <?php }?>
            </div>
            <div>
                <span class="byline">Please, review the article, and choose one of available options.</span>
            </div>
            <div class="container">
                <div class="col-lg-6">
                    <div class="input-group article_approve_filter">
                        <select id="status_select_option" class="selectpicker" data-size="4" name="review_status_select"
                                title="Change review status" data-container="body">
                            <option value="approved" <?php
                            if (isset($review_status_selected) && $review_status_selected == status::Approved) {
                                echo 'disabled';
                            } ?>>Approve</option>
                            <option value="rejected" <?php
                            if (isset($review_status_selected) && $review_status_selected == status::Rejected) {
                                echo 'disabled';
                            } ?>>Reject</option>
                        </select>
                    </div>
                    <button class="buttonGreen" type="submit" name="set_review_button"
                            style="padding-top: 5px; height: 35px;">Set</button>
                </div>
            </div>
        </div>
    <?php }?>
    <?php if(!empty(array_intersect(array("admin","creator"),$status))){?>
        <div id="featured">
            <div>
                <span class="byline">If you want to manage this article, use button below.</span>
            </div>
            <button class="buttonGreen" type="submit" name="edit_article_button">Manage Article</button>
        </div>
    <?php }?>
</form>
<?php } ?>