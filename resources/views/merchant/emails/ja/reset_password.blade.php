<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Password Reset</title>
    <link rel="icon" type="image/x-icon" href="/dashboard/img/favicon.svg">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,403,403i,700&display=fallback">

    <style>
        .email-body {
            font-size: 14px;
        }

        .url-title {
            font-size: 16px;
            font-weight: bold;
            margin-top: 30px;
        }

        .url-link {
            color: #ff6600;
            text-decoration: none;
        }

        .small-text {
            color: #666666;
            font-size: 12px;
        }

        .hr {
            border: none;
            border-top: 1px solid #cccccc;
            margin-top: 30px;
            margin-bottom: 30px;
        }
    </style>

</head>
<body>

<div class="email-body">
    <p>パスワード再設定の申請を受け付けました。</p>
    <p>パスワード再設定をご希望の場合は以下URLをクリックし新しいパスワードをご登録ください。</p>
    <p class="url-title">▼パスワード再設定URL</p>
    <p><a href="{{$url}}" class="url-link">＜パスワード再設定用のURL＞</a></p>
    <p class="small-text">※URLの期限は24時間です。</p>
    <hr class="hr">
    <p>＜以下、会社情報＞</p>
    <p class="small-text">本メールに心当たりが無い場合は破棄をお願いいたします。</p>
    <p class="small-text">送信専用メールアドレスのため、直接の返信はできません。</p>
</div>

</body>
</html>
