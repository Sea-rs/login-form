<?php
  session_start();
  require_once('./error.php');
  /**
   * TODO
   */

  //初めてアクセスした際はセッショントークンがnullなので、空文字を入れる
  $_SESSION['token'] = $_SESSION['token'] ?? '';

  $isClickedSubmit = $_SERVER['REQUEST_METHOD'] === 'POST';

  //同じデータが送信された場合
  //POSTの中身を空に設定する
  //または、ID・ユーザ名・パスワードのいずれかが空の場合、エラーとする
  if ($_SESSION['token'] != $_POST['post_key']) {
    $_POST['signup_id'] = '';
    $_POST['signup_username'] = '';
    $_POST['signup_password'] = '';
  } elseif (empty($_POST['signup_id']) || empty($_POST['signup_username']) || empty($_POST['signup_password'])) {
    //エラー画面へリダイレクトする
    //入力データに問題があります。
    invalid_data();
    //header('Location: ./error.html');
    exit();
  } else {
    try {
      $mysql = new PDO('mysql:host=localhost;dbname=user', 'root', 'qpJ=R4C7<86v');
      $mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $query = $mysql->prepare('SELECT ID FROM user_info WHERE ID=?');
      $query->execute(array($_POST['signup_id']));
      $isExistsUserID = $query->fetch();
    } catch(PDOException $e) {
      //データベースエラー発生時のPHPファイルを作成
      invalid_data();
      exit();
    }

    //IDが既に登録されていた場合、サインアップ画面に戻し、IDの部分のみ空にする
    if ($isExistsUserID === false && $isClickedSubmit  === true) {
      try {
        $query = $mysql->prepare("INSERT INTO user_info (ID, name, password) VALUE (?, ?, ?)");
        $query->execute(array($_POST['signup_id'], $_POST['signup_username'], password_hash($_POST['signup_username'], PASSWORD_DEFAULT)));

        header('HTTP/1.0 200 OK');
        header('Location:top.php');
        return;
      } catch(PDOException $e) {
        //データベースエラー発生時のPHPファイルを作成
        invalid_data();
        exit();
      }
    }
  }

  //トークンを生成して、ブラウザリロードによる再送信を防ぐ
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
    <main>
      <form class="login-Form" action="/signup.php" method="POST">
        <p>登録する情報を入力してください</p>
        <div class="login-Form_InputArea">
          <div class="login-Form_Input">
            <!--note : name属性を入れなかったら入力候補が表示されないようにできる?-->

            <?php
              if ($isExistsUserID !== false && $isClickedSubmit === true) {
                ?>

                  <span class="sw-errorMsg">IDが既に存在しています。別のIDを利用して下さい。</span>

                <?php
              }
            ?>

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
