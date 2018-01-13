<!--
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.11.2017
 * Time: 10:59
 -->

<div id="featured">
    <?php extract($data); ?>
    <?php if($login_status=="access_denied") { ?>
        <p style="color:red">Username or/and password are wrong.</p>
    <?php } ?>
    <form class="form" autocomplete="off" autocorrect="off" action="" method="post">
        <ul class="style1">
            <table>
                <tr>
                    <td><h3>Username</h3></td>
                    <td><input type="text" name="login_username" pattern="^.{0,20}$"
                               title="Maximum, [20] symbols" placeholder="Username" "></td>
                </tr>
                <tr>
                    <td><h3>Password</h3></td>
                    <td><input type="password" name="login_password" pattern="^.{0,20}$"
                               title="Maximum, [20] symbols" placeholder="Password"></td>
                </tr>
            </table>
        </ul>
        <button class="buttonGreen" type="submit" name="login_button">Sign In</button>
    </form>
</div>