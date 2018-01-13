<!--
 * Created by PhpStorm.
 * User: Vladyslav Malynych
 * Date: 30.11.2017
 * Time: 10:58
 -->

<?php extract($data); ?>
<form class="form" autocomplete="off" action="" method="post">
    <div id="featured">
        <?php if(!empty($input_errors)) { ?>
            <p style="color:red"><?php echo array_shift($input_errors); ?></p>
        <?php } ?>
        <ul class="style1">
            <table>
                <tr>
                    <td><h3>Name</h3></td>
                    <td><input type="text" name="reg_name" pattern="^[A-Za-z]{2,20}$" placeholder="Name" spellcheck="false"
                               title="Only, [2-20] letters" value="<?php echo @$input['reg_name']; ?>" required></td>
                </tr>
                <tr>
                    <td><h3>Surname</h3></td>
                    <td><input type="text" name="reg_surname" pattern="^[A-Za-z]{2,20}$" placeholder="Surname" spellcheck="false"
                               title="Only, [2-20] letters" value="<?php echo @$input['reg_surname']; ?>" required></td>
                </tr>
                <tr>
                    <td><h3>Username</h3></td>
                    <td><input type="text" name="reg_username" pattern="^[\w\d_]{8,20}$" placeholder="Username" spellcheck="false"
                               title="Should be, [8-20] symbols(Aa-Zz,0-9,_)" value="<?php echo @$input['reg_username']; ?>"
                               required></td>
                </tr>
                <tr>
                    <td><h3>Email</h3></td>
                    <td><input type="email" name="reg_email" pattern="^.{3,30}$" placeholder="Email" spellcheck="false"
                               title="Maximum, [30] symbols" value="<?php echo @$input['reg_email']; ?>"
                               required></td>
                </tr>
                <tr>
                    <td><h3>Phone</h3></td>
                    <td><input type="tel" pattern="^[\(][\+]\d{3}[\)]\d{3}\d{3}\d{3}$" name="reg_phone" spellcheck="false"
                               placeholder="Phone number" title="Phone Number (Format: (+333)999999999)"
                               value="<?php echo @$input['reg_phone']; ?>" value=""></td>
                </tr>
            </table>
        </ul>
    </div>
    <div id="featured">
        <form>
            <ul class="style1">
                <table>
                    <tr>
                        <td><h3>Password</h3></td>
                        <td><input type="password" name="reg_password" pattern="^.{8,20}$"
                                   placeholder="Password" title="Should be, [8-20] symbols" required></td>
                    </tr>
                </table>
            </ul>
            <button class="buttonGreen" type="submit" name="reg_button">Register</button>
        </form>
    </div>
</form>