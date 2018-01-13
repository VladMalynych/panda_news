<!--
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.12.2017
 * Time: 23:47
 */
 -->

<?php extract($data); ?>
<div id="featured">
    <div class="title">
        <span class="byline">My Reviews</span>
    </div>
    <form class="form-inline" autocomplete="off" action="" method="post">
        <div class="container">
            <div class="col-lg-8">
                <div class="input-group article_search_filter">
                    <select id="review_status_select_option" class="selectpicker" data-size="4" name="review_status_select"
                            title="Select review status" data-container="body" onchange="this.form.submit()">
                        <option value="to_be_reviewed" <?php
                        if (empty($input['review_status_select']) || $input['review_status_select'] == "to_be_reviewed") {
                            echo 'selected';
                        } ?>>Articles to be reviewed</option>
                        <option value="approved" <?php
                        if (!empty($input['review_status_select']) && $input['review_status_select'] == "approved") {
                            echo 'selected';
                        } ?>>Approved Articles</option>
                        <option value="rejected" <?php
                        if (!empty($input['review_status_select']) && $input['review_status_select'] == "rejected") {
                            echo 'selected';
                        } ?>>Rejected Articles</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
</div>

<div id="featured">
    <?php if(!empty($articles)) {
        foreach ($articles as $article) { ?>
            <ul class="style1">
                <li class="first">
                    <p class="date">
                        <a><?php echo $article[0]->getPostTime()->format('d/m'); ?>
                            <b><?php echo $article[0]->getPostTime()->format('Y'); ?></b>
                        </a>
                    </p>
                    <div class="article_title">
                        <a href="article?id=<?php echo $article[0]->getId(); ?>"><?php echo $article[0]->getName();?></a>
                    </div>
                    <div class="article_user">
                        <h5>@<?php echo $article[1]; ?></h5>
                    </div>
                </li>
            </ul>
        <?php }
    }else{ ?>
        <div class="title">
            <span class="byline">Nothing found</span>
        </div>
    <?php }?>
</div>

<div id="featured">
    <div class="title">
        <span class="byline">Review Admin Panel</span>
    </div>
    <form class="form-inline" autocomplete="off" action="" method="post">
        <div class="container">
            <div class="col-lg-7">
                <div class="input-group article_search_filter">
                    <select id="user_select_option" class="selectpicker" data-size="4" name="admin_article_select"
                            data-live-search="true" title="Select article" data-container="body" required>
                        <?php if(!empty($admin_articles)) {
                            foreach ($admin_articles as $admin_article) { ?>
                                <option value="<?php echo $admin_article->getId(); ?>"<?php
                                if (!empty($input['user_select']) && $admin_article->getId() == $input['user_select']) {
                                    echo 'selected';
                                } ?>><?php echo $admin_article->getName(); ?></option>
                            <?php }
                        }?>
                    </select>

                    <select id="user_select_option" class="selectpicker" data-size="4" name="admin_user_select"
                            data-live-search="true" title="Select user" data-container="body" required>
                        <?php if(!empty($admin_users)) {
                            foreach ($admin_users as $admin_user) { ?>
                                <option value="<?php echo $admin_user->getId(); ?>"<?php
                                if (!empty($input['user_select']) && $admin_user->getId() == $input['user_select']) {
                                    echo 'selected';
                                } ?>><?php echo $admin_user->getUserName(); ?></option>
                            <?php }
                        }?>
                    </select>

                </div>
                <button class="buttonGreen" type="submit" name="assign_reviewer_button"
                        style="padding-top: 5px; height: 35px;">Assign</button>
            </div>
        </div>
    </form>
</div>