<!--
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.11.2017
 * Time: 9:59
 -->

<?php extract($data); ?>
<div id="featured">
    <div class="title">
        <span class="byline">My Articles</span>
    </div>
    <form class="form-inline" autocomplete="off" action="" method="post">
        <div class="container">
            <div class="col-lg-8">
                <div class="input-group article_search_filter">
                    <select id="home_status_select_option" class="selectpicker" data-size="4" name="home_status_select"
                            title="Select articles status" data-container="body" onchange="this.form.submit()" >
                        <option value="all" <?php
                        if (empty($input['home_status_select']) || $input['home_status_select'] == "all") {
                            echo 'selected';
                        } ?>>All</option>
                        <option value="in_progress" <?php
                        if (!empty($input['home_status_select']) && $input['home_status_select'] == "in_progress") {
                            echo 'selected';
                        } ?>>In progress</option>
                        <option value="approved" <?php
                        if (!empty($input['home_status_select']) && $input['home_status_select'] == "approved") {
                            echo 'selected';
                        } ?>>Approved</option>
                        <option value="rejected" <?php
                        if (!empty($input['home_status_select']) && $input['home_status_select'] == "rejected") {
                            echo 'selected';
                        } ?>>Rejected</option>
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

<?php if($_SESSION['role'] == type::Admin){?>
    <div id="featured">
        <div class="title">
            <span class="byline">Article Admin Panel</span>
        </div>

        <form class="form-inline" autocomplete="off" action="" method="post">
            <div class="container">
                <div class="col-lg-8">
                    <div class="input-group article_search_filter">
                        <select id="article_admin_status_select_option" class="selectpicker" data-size="4"
                                name="article_admin_status_select" title="Select articles status" data-container="body"
                                onchange="this.form.submit()">
                            <option value="all" <?php
                            if (empty($input['article_admin_status_select']) || $input['article_admin_status_select'] == "all") {
                                echo 'selected';
                            } ?>>All</option>
                            <option value="in_progress" <?php
                            if (!empty($input['article_admin_status_select']) && $input['article_admin_status_select'] == "in_progress") {
                                echo 'selected';
                            } ?>>In progress</option>
                            <option value="approved" <?php
                            if (!empty($input['article_admin_status_select']) && $input['article_admin_status_select'] == "approved") {
                                echo 'selected';
                            } ?>>Approved</option>
                            <option value="rejected" <?php
                            if (!empty($input['article_admin_status_select']) && $input['article_admin_status_select'] == "rejected") {
                                echo 'selected';
                            } ?>>Rejected</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>

        <?php if(!empty($admin_articles)) {?>
        <form class="form-inline" autocomplete="off" action="" method="post">
            <table class="table table-bordered table-striped table-hover table-condensed table-responsive" style="margin-top: 20px">
                <thead>
                <tr>
                    <th style="text-align: center">Name</th>
                    <th style="text-align: center">Status</th>
                    <th style="text-align: center">Ongoing</th>
                    <th style="text-align: center">Approvers</th>
                    <th style="text-align: center">Rejectors</th>
                    <th style="text-align: center">Set Status</th>
                </tr>
                </thead>
                <?php foreach ($admin_articles as $admin_article) { ?>
                    <tr>
                        <td>
                            <a href="article?id=<?php echo $admin_article[0]->getId(); ?>"><?php echo $admin_article[0]->getName();?></a>
                        </td>

                        <?php if ($admin_article[0]->getStatus() == status::Rejected) {
                            $local_status_selected['color'] = "red";
                            $local_status_selected['text'] = "Rejected";
                        }elseif ($admin_article[0]->getStatus() == status::Approved) {
                            $local_status_selected['color'] = "#00bc00";
                            $local_status_selected['text'] = "Approved";
                        }else{
                            $local_status_selected['color'] = "#f9a806";
                            $local_status_selected['text'] = "None";
                        }?>
                        <td>
                            <span style="color:<?php echo $local_status_selected['color'];?>;"><?php echo $local_status_selected['text'];?></span>
                        </td>
                        <td>
                            <?php if(!empty($admin_article[1])) {
                                foreach ($admin_article[1] as $reviewer_article) {
                                    echo '@'.$reviewer_article.' ';
                                }
                            }else{
                                echo "None";
                            }?>
                        </td>
                        <td>
                            <?php if(!empty($admin_article[2])) {
                                foreach ($admin_article[2] as $reviewer_article) {
                                    echo '@'.$reviewer_article.' ';
                                }
                            }else{
                                echo "None";
                            }?>
                        </td>
                        <td>
                            <?php if(!empty($admin_article[3])) {
                                foreach ($admin_article[3] as $reviewer_article) {
                                    echo '@'.$reviewer_article.' ';
                                }
                            }else{
                                echo "None";
                            }?>
                        </td>
                        <td>
                            <?php if ( in_array($admin_article[0]->getStatus(),array(status::None,status::Rejected) )) {?>
                                <button type="submit" class="btn btn-primary" style="background-color: Transparent; border: none"
                                        name="approve_article_button" value="<?php echo $admin_article[0]->getId();?>">
                                    <img src="images/approve.png">
                                </button>
                            <?php }?>
                            <?php if ( in_array($admin_article[0]->getStatus(),array(status::None,status::Approved) )) {?>
                                <button type="submit" class="btn btn-primary" style="background-color: Transparent; border: none"
                                        name="reject_article_button" value="<?php echo $admin_article[0]->getId();?>">
                                    <img src="images/reject.png">
                                </button>
                            <?php }?>
                        </td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </form>
            <?php }?>
    </div>
<?php }?>