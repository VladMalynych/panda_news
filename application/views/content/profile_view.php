<!--
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 01.12.2017
 * Time: 16:23
-->

<?php extract($data); ?>
<form class="form" autocomplete="off" action="" method="post">
    <div id="featured">
        <?php if(!empty($update_data_errors)) { ?>
            <p style="color:red"><?php echo array_shift($update_data_errors); ?></p>
        <?php } ?>
        <ul class="style1">
            <table>
                <tr>
                    <td><h3>UserName</h3></td>
                    <td><h4><?php echo $user->getUsername(); ?></h4></td>
                </tr>
                <tr>
                    <td><h3>Name</h3></td>
                    <td><input type="text" name="profile_name" pattern="^[A-Za-z]{2,20}$" spellcheck="false"
                               title="Only, [2-20] letters" value="<?php echo $user->getName(); ?>" required></td>
                </tr>
                <tr>
                    <td><h3>Surname</h3></td>
                    <td><input type="text" name="profile_surname" pattern="^[A-Za-z]{2,20}$" spellcheck="false"
                               title="Only, [2-20] letters" value="<?php echo $user->getSurname(); ?>" required></td>
                </tr>
                <tr>
                    <td><h3>Email</h3></td>
                    <td><input type="email" name="profile_email" pattern="^.{3,30}$" spellcheck="false"
                               title="Maximum, [30] symbols" value="<?php echo $user->getEmail(); ?>"
                               required></td>
                </tr>
                <tr>
                    <td><h3>Phone</h3></td>
                    <td><input type="tel" pattern="^[\(][\+]\d{3}[\)]\d{3}\d{3}\d{3}$" name="profile_phone" spellcheck="false"
                               title="Phone Number (Format: (+333)999999999)"
                               value="<?php echo $user->getPhone(); ?>" value=""></td>
                </tr>
            </table>
        </ul>
        <button class="buttonGreen" type="submit" name="update_data_button">Update data</button>
    </div>
</form>

<form class="form" autocomplete="off" action="" method="post">
    <div id="featured">
        <?php if(!empty($update_password_errors)) { ?>
            <p style="color:red"><?php echo array_shift($update_password_errors); ?></p>
        <?php } ?>
        <ul class="style1">
            <table>
                <tr>
                    <td><h3>Old Password</h3></td>
                    <td><input type="password" name="profile_old_password" pattern="^.{8,20}$"
                               placeholder="Old password" title="Should be, [8-20] symbols" required></td>
                </tr>
                <tr>
                    <td><h3>New  Password</h3></td>
                    <td><input type="password" name="profile_new_password" pattern="^.{8,20}$"
                               placeholder="New password" title="Should be, [8-20] symbols" required></td>
                </tr>
            </table>
        </ul>
        <button class="buttonGreen" type="submit" name="update_password_button">Update password</button>
    </div>
</form>

<form class="form" autocomplete="off" action="" method="post">
    <div id="featured">
        <div>
            <span class="byline">Please, logout when finnish, in order to keep your data in privacy.</span>
        </div>
        <button class="buttonRed" type="submit" name="logout_button">Log Out</button>
    </div>
</form>