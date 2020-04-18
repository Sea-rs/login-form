<?php
  session_start();

  /**
   * TODO
   */

  $_SESSION['token'] = $_SESSION['token'] ?? '';

  if ($_SESSION['token'] != $_POST['post_key']) {
    $_POST['signup_id'] = '';
    $_POST['signup_username'] = '';
    $_POST['signup_password'] = '';
  } elseif (empty($_POST['signup_id']) || empty($_POST['signup_username']) || empty($_POST['signup_password'])) {
    //エラー画面ファイルを作成
  }

  try {
    $mysql = new PDO('mysql:host=localhost;dbname=user', 'root', 'qpJ=R4C7<86v');
    $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch(PDOException $e) {
    //データベースエラー発生時のPHPファイルを作成
    //デバック
    print "error connect" . $e->getMessage();
    exit();
  }

  try {
    $query = $mysql->prepare("INSERT INTO user_info (ID, name, password) VALUE (?, ?, ?)");
    $query->execute(array($_POST['signup_id'], $_POST['signup_username'], password_hash($_POST['signup_username'], PASSWORD_DEFAULT)));
  } catch(PDOException $e) {
    //データベースエラー発生時のPHPファイルを作成
    //デバック
    $e->getMessage();
  }

  $post_key = mt_rand();
  $_SESSION['token'] = $post_key;

?>
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
