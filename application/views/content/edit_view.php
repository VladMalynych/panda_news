<?php
/**
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 12.01.2018
 * Time: 0:40
 */
?>


<?php extract($data); ?>
<form class="form" autocomplete="off" action="" method="post">
    <div id="featured">
        <div class="title commentTitle">
            <span class="byline">Update your Article</span>
        </div>
        <div class="container">
            <form>
                <div class="article_name_group">
                    <input type="text" name="article_name" pattern="^[\w\d_,.+\-*_!? ]{3,40}$"
                           spellcheck="true" title="Should be, [3-40] symbols!"
                           value="<?php echo $article->getName(); ?>" required>
                    <span class="highlight_article_name"></span>
                    <span class="bar"></span>
                    <label>Article Name</label>
                </div>
            </form>
        </div>
        <ul class="style1">
            <textarea name="text_editor"><?php echo $article->getContent(); ?></textarea>
            <script>
                CKEDITOR.replace( 'text_editor', {height: 250, toolbar: 'Standard'} );
            </script>
        </ul>
        <button class="buttonGreen" type="submit" name="edit_article_button">Update</button>
    </div>
</form>
<form class="form" autocomplete="off" action="" method="post">
    <div id="featured">
        <div>
            <span class="byline">Are you sure, you want to delete this article?</span>
        </div>
        <button class="buttonRed" type="submit" name="delete_article_button">Delete</button>
    </div>
</form>