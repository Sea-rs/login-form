<?php
  session_start();

  /**
   * TODO
   * //データベースエラー発生時のPHPファイルを作成
   */

  $_SESSION['token'] = $_SESSION['token'] ?? '';

  if ($_SESSION['token'] != $_POST['post_key']) {
    $_POST['login_id'] = '';
    $_POST['login_password'] = '';
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

  $post_key = mt_rand();
  $_SESSION['token'] = $post_key;

  //SQLインジェクション脆弱性
  //$query = $mysql->query('SELECT ID FROM user_info WHERE ID="'. $_POST['login_id'] .'"');
  //$row = $query->fetch();

  try {
    $query = $mysql->prepare('SELECT ID FROM user_info WHERE ID=?');
    $query->execute(array($_POST['login_id']));
    $row = $query->fetch();
  } catch(PDOException $e) {
    //データベースエラー発生時のPHPファイルを作成
    //デバック
    $e->getMessage();
  }

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
      <form class="login-Form" action="/index.php" method="POST">
        <p>利用する際はログインしてください。</p>
        <div class="login-Form_InputArea">
          <div class="login-Form_Input">
            <label><input id="login-Form_IDForm" type="text" name="login_id" placeholder="ID"></label>
            <label><input id="login-Form_PasswordForm" type="text" name="login_password" placeholder="Password"></label>
            <input type="hidden" name="post_key" value="<?php echo $post_key; ?>">
          </div>
        </div>
        <input class="login_Form_Submit" id="login-Form_Submit" name="login" type="submit" value="ログイン">
        <a class="login_Form_Submit" id="login-Form_Register" href="/signup.php">アカウントを作る</a>
      </form>
    </main>
  </body>
</html>