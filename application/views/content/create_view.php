<!--
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 05.12.2017
 * Time: 12:19
 -->

<?php extract($data); ?>
<form class="form" autocomplete="off" action="" method="post">
    <div id="featured">
        <div class="container">
            <form>
                <div class="article_name_group">
                    <input type="text" name="article_name" pattern="^[\w\d_,.+\-*_!? ]{3,40}$"
                           spellcheck="true" title="Should be, [3-40] symbols!"
                           value="<?php echo @$input['article_name']; ?>" required>
                    <span class="highlight_article_name"></span>
                    <span class="bar"></span>
                    <label>Article Name</label>
                </div>
            </form>
        </div>
        <ul class="style1">
            <input type="hidden" name="article_id" value=<?php echo @$article_id; ?>>
            <textarea name="text_editor"><?php echo @$input['text_editor']; ?></textarea>
            <script>
                CKEDITOR.replace( 'text_editor', {height: 250, toolbar: 'Standard'} );
            </script>
        </ul>
        <button class="buttonGreen" type="submit" name="create_article_button"><?php if($update_article){ echo 'Update';
                                                                                     } else{ echo 'Create'; }?></button>
    </div>
</form>