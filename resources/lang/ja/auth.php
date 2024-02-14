<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'メールアドレス、又はパスワードが不正です。ご確認ください 。',
    'throttle' => 'ログイン試行回数が多すぎます。 :seconds  秒後に再試行してください。',

    // message common
    'common' => [
        'login' => [
            'remember_me' => 'ログイン状態を保存する',
            'forgot_password' => 'パスワードを忘れた場合',
            'password' => 'パスワード',
            'email_placeholder' => 'example@gmail.com',
            'password_placeholder' => 'パスワードを入力して下さい',
            'login-display' => 'ログイン画面',
            'email' => '登録メールアドレス',
            'register' => '新規登録',
            'forget-home' => 'ホームページへ',
            'forget-store' => '代理店募集中',
            'title1' => 'あなたのビジネスにグローバルな可能性を',
            'title2' => '国際ビジネスでの支払いは',
            'title3' => '・1400種類以上のあらゆるトークンに対応。',
            'title4' => '・決済は銀行振込/現金/仮想通貨など幅広く対応。',
            'title5' => '・24時間365日の充実サーポート。',
            'not_correct' => 'パスワードが間違っています。',
            'email_not_correct' => 'このメールアドレスは登録されていません',
            'login' => 'ログイン',
            'back' => '戻る',
            'invalid_email' => 'アカウントが無効のため、ログインできません。',
            'invalid_email_merchant' => 'アカウントが無効されました、管理者に問い合わせしてください。',
        ],
        'forgot_password' => [
            'title' => 'パスワード再設定',
            'title_done' => 'パスワード再設定完了',
            'label_email' => 'メールアドレス',
            'placeholder_email' => 'メールアドレスを入力して下さい',
            'submit' => '送信',
            'forgot_success_label' => 'パスワードをリセットしました。',
            'forgot_success_button' => 'ログイン画面へ戻る',
            'new_pass' => '新しいパスワード',
            'new_pass_placeholder' => 'パスワードを入力して下さい',
            'pass_confirm' => '新しいパスワード（確認用）',
            'pass_confirm_placeholder' => 'パスワードを再入力して下さい',
            'save_pass' => '設定',
            'password_required' => 'パスワードを入力して下さい',
            'password_min_length' => '半角英字、数字を組み合わせて8文字以上でご入力ください',
            'password_check_string_number' => '英数字で構成されるパスワードを入力して下さい',
            'password_confirm_min_length' => 'パスワードの確認は 8 文字以上である必要があります',
            'password_confirm_equa_to' => '確認パスワードはパスワードと一致する必要があります',
            'password_same' => 'パスワードが一致しません',
            'resetting_password_confirm_0' => 'パスワード再設定申請受付完了',
            'resetting_password_confirm_1' => 'パスワード再設定の受付を行いました。',
            'resetting_password_confirm_2' => '入力情報が一致した場合、入力されたメールアドレス宛にパスワード再設定の案内メールをお送りしますのでメールの案内の通りご対応をお願い致します。',
            'resetting_password_confirm_3' => '※入力情報が一致しない場合は案内メールが送信されません。',
            'resetting_password_confirm_4' => '※メールアドレスは「●●●@●●」より送信されます。',
            'resetting_password_confirm_5' => '迷惑メールなどに除外されないように、ドメイン指定設定や受信設定などをお願いします。',
            'resetting_password_confirm_6' => '※メールは即時送信されておりますが、ネットワークの状況により送受信にお時間がかかる場合が御座います。',
            'resetting_password_success' => 'パスワード変更が完了しました。',
            'title1' => 'epayにご登録のメールアドレスを入力して「送信」ボタンをクリックしてください。パスワード再設定のご案内をメールにてお送り致します。',
            'title2' => '※メールアドレスは「●●●@●●」より送信されます。',
            'title3' => '迷惑メールなどに除外されないように、ドメイン指定設定や受信設定などをお願いします。',
        ],
        'change_password' => [
            'change_password_tittle' => 'パスワードの変更',
            'new_pass' => '新しいパスワード',
            'new_pass_validate' => '大文字と英数字を含んだ、6～15文字以内で設定して下さい。',
            'pass_confirm' => 'パスワード(確認用)',
            'pass_confirm_validate' => 'パスワードとパスワード（確認）が異なっています。',
            'close_button' => 'キャンセル',
            'save_button' => '変更',
        ],
        'two_fa' => [
            'phone_number' => '電話番号',
            'send_sms_token' => '認証メッセージを送信',
            'back_login' => 'ログイン画面へ戻る',
            'phone_placeholder' => '電話番号を入力して下さい',
            'resetting_password' => 'パスワード再設定申請',
            'email_address' => '登録メールアドレス',
            'password_new' => '新しいパスワード',
            'password_confirm' => '新しいパスワード（確認用）',
            'admin_account_registration' => 'アカウント登録',
            'verify_required' => '新しいパスワードを入力して下さい。',
            're_verify_required'=> 'パスワード（確認用）を入力して下さい。',
            're_new_verify_required' => '新しいパスワード（確認用）を入力して下さい。',
            'register_button' => '設定',
            're_enter_password' => 'パスワード確認用',
            're_enter_password_placeholder' => 'パスワードを再入力して下さい',
            'title_verify_success' => '管理者アカウント登録',
            'content_verify_success' => 'アカウントが登録されました',
            'create_account' => 'アカウント登録',
            'send' => '送信',
            'token' => '認証コード',
            'verify_check_string' => 'パスワードのフォーマットが正しくありません。',
            'verify_equal_to' => 'パスワードとパスワード（確認）が異なっています。',
        ],
        'modal' => [
            'confirm_modal_description' => 'パスワードの変更します。よろしいですか?',
            'result_modal_description' => 'パスワードの変更が完了しました。',
            'return_btn' => '戻る',
        ],
        'register' => [
            'title' => '新規登録',
            'terms_of_service' => '利用規約',
            'and' => 'や',
            'privacy_policy' => 'プライパシーポリシー',
            'agree' => 'に同意する',
            'submit' => '登録',
            'confirm_register_title' => '仮登録申請受付完了',
            'confirm_register_des1' => '仮登録申請の受付を行いました。epay側で審査を実施致します。',
            'confirm_register_des2' => '審査完了までに時間を頂戴する場合がありますので予めご了承ください。入力されたメールアドレス宛に仮登録完了の案内メールをお送りしますのでメールの案内の通りご対応をお願い致します。',
            'success_register_title' => '新規登録完了',
            'success_register_des' => '登録が完了しました。',
        ],
    ],
    //  message for admin_epay
    'admin_epay' => [
        'reset_password' => 'epayログインパスワード再設定のご案内',
    ],
    //  message for merchant
    'merchant' => [
        'reset_password' => '加盟店ログインパスワード再設定のご案内',
    ],
    //  message for affiliate
    'affiliate' => [
    ],
];
