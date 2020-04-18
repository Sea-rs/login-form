<!DOCTYPE html>

<html lang="ja">
  <head>
    <link rel="stylesheet" href="assets/css/login.css">
    <title>ようこそ | Weather*</title>
  </head>
  <body>
    <header></header>
    <main>
      <form class="login-Form" action="/signup.php" method="POST">
        <p>登録する情報を入力してください</p>
        <div class="login-Form_InputArea">
          <div class="login-Form_Input">
            <!--note : name属性を入れなかったら入力候補が表示されないようにできる?-->
            <label><input id="login-Form_IDForm" type="text" name="signup_id" placeholder="ID"></label>
            <label><input id="login-Form_UserNameForm" type="text" name="signup_username" placeholder="User Name"></label>
            <label><input id="login-Form_PasswordForm" type="text" name="signup_password" placeholder="Password"></label>
            <input type="hidden" name="post_key" value="<?php echo $post_key; ?>">
          </div>
        </div>
        <input class="login_Form_Submit" id="login-Form_Submit" type="submit" value="カウントを作成">
      </form>
    </main>
  </body>
</html>
