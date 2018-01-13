<!--
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 07.12.2017
 * Time: 11:00
-->

<?php extract($data); ?>
<div id="featured">
    <div class="title">
        <span class="byline">Search Articles</span>
    </div>
    <form class="form-inline" autocomplete="off" action="" method="post">
        <div class="container">
            <div class="col-lg-6">
                <div class="input-group article_search_filter">
                    <select id="user_select_option" class="selectpicker" data-size="10" name="user_select"
                            data-live-search="true" title="Select user" data-container="body" required>
                        <?php if(!empty($users)) {
                            foreach ($users as $user) { ?>
                                <option value="<?php echo $user->getId(); ?>"<?php
                                if (!empty($input['user_select']) && $user->getId() == $input['user_select']) {
                                    echo 'selected';
                                } ?>><?php echo $user->getUserName(); ?></option>
                            <?php }
                        }?>
                    </select>

                    <select id="status_select_option" class="selectpicker" data-size="4" name="status_select"
                            title="Select articles status" data-container="body">
                        <option value="all" <?php
                        if (empty($input['status_select']) || $input['status_select'] == "all") {
                            echo 'selected';
                        } ?>>All</option>
                        <option value="in_progress" <?php
                        if (!empty($input['status_select']) && $input['status_select'] == "in_progress") {
                            echo 'selected';
                        } ?>>In progress</option>
                        <option value="approved" <?php
                        if (!empty($input['status_select']) && $input['status_select'] == "approved") {
                            echo 'selected';
                        } ?>>Approved</option>
                        <option value="rejected" <?php
                        if (!empty($input['status_select']) && $input['status_select'] == "rejected") {
                            echo 'selected';
                        } ?>>Rejected</option>
                    </select>
                </div>
                <button class="buttonGreen" type="submit" name="find_button"
                        style="padding-top: 5px; height: 35px;">Find</button>
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
                        <a href="#"><?php echo $article[0]->getPostTime()->format('d/m'); ?>
                            <b><?php echo $article[0]->getPostTime()->format('Y'); ?></b>
                        </a>
                    </p>
                    <div class="article_title">
                        <a href="article?id=<?php echo $article[0]->getId(); ?>"><?php echo $article[0]->getName(); ?></a>
                    </div>
                    <div class="article_user">
                        <h5>@<?php echo $article[1]; ?></h5>
                    </div>
                </li>
            </ul>
        <?php }
    } else{ ?>
        <div class="title">
            <span class="byline">Nothing found</span>
        </div>
    <?php }?>
</div>
