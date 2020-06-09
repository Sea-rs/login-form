<?php

function server_error() {
  header('HTTP/1.0 500 サーバーにエラーが発生しています');
  ?>

  <!DOCTYPE html>

  <html lang="ja">
    <head>
      <link rel="stylesheet" href="assets/css/login.css">
      <title>サーバーに問題があります。 | Weather*</title>
    </head>
    <body>
      <main>
        <div>サーバーに問題があります。</div>
        <div>時間をおいてしばらくお待ちください。</div>
        <div><a href="/">ログイン画面に戻る</a></div>
      </main>
    </body>
  </html>

  <?php
}

function invalid_data() {
  header('HTTP/1.0 502 Bad Gateway');
  ?>

  <!DOCTYPE html>

  <html lang="ja">
    <head>
      <link rel="stylesheet" href="assets/css/login.css">
      <title>入力データに問題があります。 | Weather*</title>
    </head>
    <body>
      <main>
        <div>入力データに問題があります。</div>
        <div>正しいデータをもう一度入力してください。</div>
        <div><a href="/">ログイン画面に戻る</a></div>
      </main>
    </body>
  </html>

  <?php
}

?>
