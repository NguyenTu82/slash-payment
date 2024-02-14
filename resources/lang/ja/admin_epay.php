<?php

return [
    'messages' => [
        'send_email_successful' => 'パスワード再設定のメールを送信しました。',
        'URL_expired_please_log_in_again' => 'このURLは無効になりました。再度ログインしてください。',
        'token_is_invalid' => 'このリンクは無効になりました。',
        'error_has_occurred' => 'エラーが発生しました。',
        'title_forgot_password_email' => 'epayログインパスワード再設定のご案内 ',
    ],
    'admin' => [
        'title' => 'アカウント管理',
        'list' => 'アカウントリスト',
        'list_account' => 'アカウント一覧',
        'name' => 'アカウント名',
        'mail' => 'メールアドレス',
        'role' => 'ロール',
        'created_at' => '作成日',
        'title_create' => 'アカウント登録',
        'account_id' => 'アカウントID',
        'password' => 'パスワード',
        'profile_info' => 'プロファイル情報',
        'account_management' => 'アカウント管理',
        'permission_management' => '権限管理',
        'fee_setting' => '手数料設定',
        'dashboard_title' => 'ダッシュボード',
    ],
    'setting' => [
        'profile' => [
            'validation' => [
                'name' => [
                    'required' => 'アカウント名を入力して下さい。',
                ],
                'role' => [
                    'required' => 'ロールを選択してください。',
                ],
                'email' => [
                    'required' => 'メールアドレスを入力して下さい。',
                    'invalid' => '有効なメールアドレスではありません。',
                ],
                'account_id' => [
                    'required' => 'アカウントIDを入力して下さい。',
                ]
            ],
        ],
        'account_management' => [
            'list' => [
                'account_info' =>'アカウント情報',
                'accountID' => 'アカウントID',
                'name' => 'アカウント名',
                'mail' => 'メールアドレス',
                'authority' => '権限',
                'status' => 'ステータス',
                'detail' => '詳細',
                'search' => '検索',
                'reset' => 'リセット',
            ],
            'search_name' => 'アカウントID、アカウント名、メールアドレス',
            'create_account' => '新規アカウント作成',
            'default_select' => '選択',
            'password_description' => '大文字と英数字を含んだ、6～15文字以内で設定して下さい',
            'confirm_password_description' => '新しいパスワードと同じパスワードを入力して下さい',
            'active' => '有効',
            'inactive' => '無効',
            'title_confirm_modal_create' => '新規アカウント作成確認',
            'description_confirm_modal_create' => '新規アカウントを作成します。よろしいですか?',
            'title_result_modal_create' => '新規アカウント作成確認',
            'description_result_modal_create' => '新規アカウントを作成します。よろしいですか?',

            'validation' => [
                'name' => [
                    'required' => 'アカウント名を入力して下さい。',
                ],
                'role' => [
                    'required' => '権限を選んで下さい。',
                ],
                'status' => [
                    'required' => 'ステータスを選んで下さい。',
                    'invalid' => '無効なメールアドレス。',
                ],
                'email' => [
                    'required' => '登録メールアドレス名を入力して下さい。',
                ],
                'password' => [
                    'required' => 'パスワードを入力して下さい。',
                ],
                'password_confirm' => [
                    'required' => '確認パスワードを入力して下さい。',
                ],
            ],

        ],
        'modal' => [
            'confirm_delete_account_title' => 'アカウント情報削除',
            'confirm_delete_account_content' => 'アカウント情報を削除します。よろしいですか?',
            'delete_account_success_content' => 'アカウント情報削除が完了しました。',
            'delete_account_success_title' => 'アカウント情報削除',

        ]
    ],
    'merchant' => [
        'common' => [
            'usage_status' => '利用状況',
            'merchant_detail' => '加盟店詳細',
            'total_transaction_amount' => '総取引金額',
            'paid_balance' => '支払済残高',
            'account_balance' => '口座残高',
            'merchant_info' => '加盟店情報',
            'merchant_other_info' => '加盟店のその他情報',
            'contract_payment_info' => '契約や支払い情報',
            'af_info' => 'AF情報',
            'select_merchant_store' => '加盟店選択',
            'create_merchant_success' => '新規加盟店の登録完了',
            'create_merchant_success_description' => '新規加盟店の登録が完了しました。',
            'update_merchant_success' => '加盟店の編集',
            'update_merchant_success_description' => '加盟店の編集が完了しました。',
            'rewrite' => '再入力',
            'create' => '新規登録',
            'merchant_store_csv_file_name' => '加盟店一覧',
            'usage_situation'=> '利用状況',
            'title_confirm_modal_delete' => '加盟店の削除',
            'description_confirm_modal_delete' => '加盟店を削除します。よろしいですか?',
            'delete_merchant_success_description' => '加盟店の削除が完了しました。',
            'delete_confirm_group' => '紐付けている加盟店がありますが、本当に削除しますか？',
            'merchant_create' => '加盟店新規登録',
            'show_payee_information' => '支払い先情報表示',
            'no_yes' => '無・有',
            'verify_url_error' => '加盟店ID又は、トークンが存在しません。',
            'verify_url_expires' => '加盟店の本登録のURLの有効期限が切れています。',
            'merchant_create_success_title' => '加盟店新規登録完了',
            'merchant_create_success_description' => '加盟店新規登録が完了しました。',
            'email_exist' => '登録メールアドレスは既に登録済です。',
            'merchant_name_exist' => '登録加盟店名は既に登録済です。',
            'auth_or_hash_exist' => 'APIキー（認証コード）または、APIキー（ハッシュトークン）はすでに存在しました。',
            'success_register' => '加盟店新規登録完了',
            'can_not_merchant' => '選択可能の加盟店がありません。',
            'merchant_list' => '加盟店リスト'
        ],
        'info' => [
            'id' => '加盟店ID',
            'name' => '加盟店名',
            'status' => 'ステータス',
            'now_status' => '現在のステータス',
            'service_name' => 'サービス名',
            'industry' => '業種',
            'representative_name' => '代表者名',
            'address' => '住所',
            'phone_number' => '電話番号',
            'register_email' => 'メールアドレス',
            'password' => 'パスワード',
            'group' => 'グループ',
            'contract_wallet1' => 'コントラクト',
            'contract_wallet2' => 'ウォレット',
            'received_wallet1' => '受取ウォレット',
            'received_wallet2' => 'アドレス',
            'virtual_currency_type' => '受取仮想通貨種類',
            'auth_token' => 'APIキー（認証コード）',
            'hash_token' => 'APIキー（ハッシュトークン）',
            'payment_url' => 'QRコードの設定URL',
            'post_code' => '郵便番号'
        ],
        'other_info' => [
            'sending_detail' => '明細送付の有無',
            'ship_date' => '発送日設定',
            'ship_address' => '発送先住所',
            'delivery_report' => '配信レポート選択',
            'delivery_email_address' => '配信メールアドレス',
            'guidance_email' => 'ご案内メール',
            'post_code_ship' => '発送先郵便番号'
        ],
        'payment_info' => [
            'contract_date' => '契約日',
            'termination_date' => '解約日',
            'payment_cycle' => '支払いサイクル',
            'payment_currency' => '支払い方法',
            'contract_interest_rate' => '契約利率',
            'payment_info' => '支払い先情報表示',
        ],
        'affiliate_info' => [
            'info' => 'アフィリエイト情報',
            'id' => 'アフィリエイトID',
            'name' => 'アフィリエイト名',
            'fee' => 'アフィリエイトの手数料',
        ],
        'status' => [
            'temporarily_registered' => '仮登録済',
            'under_review' => '審査中',
            'in_use' => '利用中',
            'suspend' => '停止中',
            'withdrawal' => '退会',
            'forced_withdrawal' => '強制退会',
            'agreement' => '契約',
        ],
        'crypto_payment' => [
            'wallet_address' => 'ウォレットアドレス',
            'network' => 'ネットワーク',
            'note' => '備考欄',
            'title' => '支払い先情報（仮想通貨）'
        ],
        'fiat_payment' => [
            'title' => '支払い先情報（銀行振込）',
            'financial_institution_name' => '金融機関名',
            'bank_code' => '金融機関コード',
            'bank_code_short' =>'銀行コード',
            'branch_name' => '支店名',
            'branch_code' => '支店コード',
            'bank_account_type' => '口座種別',
            'bank_account_number' => '口座番号',
            'bank_account_holder' => '口座名義',
        ],
        'cash_payment' => [
            'title' => '支払い先情報（現金）',
            'total_transaction_amount' => '総取引金額',
            'account_balance' => '払済残高',
            'paid_balance' => '口座残高'
        ],
        "payment_type" => [
            'fiat' => '銀行振込',
            'crypto' => '仮想通貨',
            'cash' => '現金'
        ],
        "bank_account_type" => [
            'usually' => '普通',
            'regular' => '定期',
            'current' => '当座'
        ],
        "delivery_report" => [
            'transaction' => 'トランザクション毎',
            'day' => 'Dailyレポート',
            'week' => 'Weeklyレポート',
            'month' => 'Monthlyレポート',
            'cycle' => '支払いサイクル毎'
        ],
        "payment_cycle" => [
            'end_3_days' => '3日毎払い',
            'end_week' => '週末払い',
            'end_month' => '月末払い',
        ],
        "ship_date" => [
            'end_month' => '月末',
            'every_weekend' => '毎週末',
            'every_other_weekend' => '隔週末',
        ],
        'validation' => [
            'name' => [
                'required' => '加盟店名を入力して下さい。',
            ],
            'group' => [
                'required' => 'グループを選択して下さい。',
            ],
            'service_name' => [
                'required' => 'サービス名を入力して下さい。',
            ],
            'industry' => [
                'required' => '業種を入力して下さい。',
            ],
            'representative_name' => [
                'required' => '代表者名を入力して下さい。',
            ],
            'post_code_id' => [
                'non_exist' => '郵便番号が存在しません。',
                'format' => '郵便番号が間違っています。'
            ],
            'address' => [
                'required' => '住所を入力して下さい。',
            ],
            'phone' => [
                'required' => '電話番号を入力して下さい。',
            ],
            'email' => [
                'required' => '登録メールアドレスを入力して下さい。',
            ],
            'password' => [
                'required' => 'パスワードを入力して下さい。',
                'format' => 'パスワードが大文字と英数字を含んだ、6～15文字以内で設定して下さい。'
            ],
            'contract_wallet' => [
                'required' => 'コントラクトウォレットを入力して下さい。',
            ],
            'receiving_walletaddress' => [
                'required' => '受取ウォレットアドレスを入力して下さい。',
            ],
            'received_virtua_type' => [
                'required' => '受取仮想通貨種類を入力して下さい。',
            ],
            'auth_token' => [
                'required' => 'APIキー（認証コード）を入力して下さい。',
            ],
            'hash_token' => [
                'required' => 'APIキー（ハッシュトークン）を入力して下さい。',
            ],
            'payment_url' => [
                'required' => 'QRコードの設定URLを入力して下さい。',
            ],
            'ship_date' => [
                'required' => '発送日設定を選択して下さい。',
            ],
            'ship_post_code_id' => [
                'non_exist' => '発送先郵便番号が存在しません。',
                'format' => '発送先郵便番号が間違っています。'
            ],
            'ship_address' => [
                'required' => '発送先住所',
            ],
            'delivery_email_address' => [
                'required' => '配信メールアドレスを入力して下さい。',
                'notEqualTo' => '配信メールアドレスが重複されています。',
            ],
            'delivery_report' => [
                'required' => '配信レポート選択を選択して下さい。',
            ],
            'contract_date' => [
                'required' => '契約日を選択して下さい。',
            ],
            'termination_date' => [
                'required' => '解約日を選択して下さい。',
            ],
            'contract_interest_rate' => [
                'required' => '契約利率を入力して下さい。',
            ],
            'crypto_wallet_address' => [
                'required' => 'ウォレットアドレスを入力して下さい。',
            ],
            'crypto_network' => [
                'required' => 'ネットワークを入力して下さい。',
            ],
            'bank_code' => [
                'required' => '金融機関コードを入力して下さい。',
                'non_exist' => '金融機関コードが存在しません。'
            ],
            'financial_institution_name' => [
                'required' => '金融機関名を入力して下さい。',
            ],
            'branch_code' => [
                'required' => '支店コードを入力して下さい。',
                'non_exist' => '支店コードが存在しません。'
            ],
            'branch_name' => [
                'required' => '支店名を入力して下さい。',
            ],
            'bank_account_number' => [
                'required' => '口座番号を入力して下さい。',
            ],
            'bank_account_holder' => [
                'required' => '口座名義を入力して下さい。',
                'checkKatakana' => '「口座名義」項目に全角カタカナを入力して下さい。'
            ],
            'total_transaction_amount' => [
                'required' => '総取引金額を入力して下さい。',
            ],
            'account_balance' => [
                'required' => '払済残高を入力して下さい。',
            ],
            'paid_balance' => [
                'required' => '口座残高を入力して下さい。',
            ],
            'af_id' => [
                'required' => 'アフィリエイトIDを入力して下さい。',
            ],
            'af_name' => [
                'required' => 'アフィリエイト名を入力して下さい。',
            ],
            'af_rate' => [
                'required' => 'アフィリエイトの手数料を入力して下さい。',
            ]
        ],
    ],
    'notifications' => [
        'type' => 'タイプ',
        'noti_type' => '通知種類',
        'status' => 'ステータス',
        'merchant_id' => '加盟店ID',
        'merchant_name' => '加盟店名',
        'title' => 'タイトル',
        'receive_date' => '受信日',
        'receive_date_time' => '受信日時',
        'search' => '検索',
        'reset' => 'リセット',
        'create_noti' => '通知作成',
        'detail' => '詳細',
        'list_receive' => '受信通知一覧',
        'list_send' => '送信通知一覧',
        'schedule_send' => '送信予定日時',
        'send_date' => '送信済日時',
        'send_date_time' => '送信日',
        'receive_noti' => '受信通知',
        'send_noti' => '送信通知',
        'receive_noti_detail' => '受信通知詳細',
        'content' => '通知内容',
        'email' => 'メールアドレス',
        'all' => 'すべて',
        'createNew' => [
            'title' => '新規通知作成',
            'receiver' => '通知先',
            'group' => [
                'title' => 'グループ',
                'selectStore' => '加盟店選択'
            ],
            'time' => [
                'title' => '送信日時指定',
                'timeSet' => '指定有り',
                'timeNotSet' => '指定無し'
            ],
            'notiTitle' => 'タイトル*',
            'content' => '通知内容*'
        ],
        'validation' => [
            'time' => [
                'required' => '送信日時を選んで下さい。',
                'future' => '現在時刻より後の時間を指定して下さい。'
            ],
            'title' => [
                'required' => 'タイトルを入力して下さい。'
            ],
            'content' => [
                'required' => '通知内容を入力して下さい。',
            ]
        ],
        'noti_detail' => 'システム通知詳細',
        'type_send' => [
            'all' => '加盟店全部通知',
            'part' => '加盟店一部通知',
        ],
        'status_send' => [
            'send' => '送信済',
            'not_send' => '未送信',
        ],
        'type_receive' => [
            'new' => '新規登録通知',
            'withdraw' => '出金通知',
            'cancel' => '解約通知',
        ],
        'status_receive' => [
            'read' => '既読',
            'unread' => '未読',
        ],
        'list' => [
            'create' => [
                'receiver' => [
                    'all' => '加盟店全部通知',
                    'part' => '加盟店一部通知'
                ]
            ]
        ],
        'common' => [
            'title_confirm_create_send_noti' => '新規通知送信確認',
            'content_confirm_create_send_noti' => '選択された加盟店に通知を送信します。<br>入力した内容を送信してよろしいですか？',
            'title_confirm_successfully_send_noti' => '新規通知送信完了',
            'content_confirm_successfully_send_noti' => '通知送信を完了しました。',
            'title_confirm_update_send_noti' => '通知編集確認',
            'content_confirm_update_send_noti' => '記入した内容で編集してよろしいですか？',
            'title_confirm_delete_send_noti' => '通知の削除',
            'content_confirm_delete_send_noti' => '通知を削除します。よろしいですか?',
            'title_confirm_update_successfully_send_noti' => '通知編集済み',
            'content_confirm_update_successfully_send_noti' => '通知の編集が完了しました。',
            'title_confirm_delete_successfully_send_noti' => '通知削除済み',
            'content_confirm_delete_successfully_send_noti' => '通知の削除が完了しました。',
            'noti_input_password' => '大文字と英数字を含んだ、6～15文字以内で設定してください'
        ],
    ],
    'report' =>[
        'report_list' => '加盟店レポート一覧',
        'report_create' => 'レポート作成',
        'report_detail' => '加盟店レポート詳細',
        'report_edit' => '加盟店レポート編集',
        'report_table_title' => '加盟店レポート一覧',
        'report_code' => '利用明細ID',
        'merchant' => '加盟店',
        'merchant_id' => '加盟店ID',
        'merchant_name' => '加盟店名',
        'email' => 'メールアドレス',
        'issue_date' => '発行日',
        'status' => 'ステータス',
        'period' => '期間',
        'only_yen' => '（円のみ）',
        'note' => '備考欄',
        'total' => 'トータル',
        'transaction_number' => '取引回数',
        'transaction_amount' => '取引金額',
        'planned_withdrawal_amount' => '出金予定額',
        'withdraw_fee' => '出金手数料',
        'detail' => '詳細',
        'send' => '送信',
        'status_type' =>[
            'un_send' => '送信前',
            'sent' => '送信済'
        ],
        'unit' => '単位',
        'pdf_preview' => '加盟店報告書プレビュー',
        'withdrawable_amount' => '出金可能額',
        'withdrawn_amount' => '出金済額',
        'transaction_info_confirm' => '取引金額情報確認',
        'transaction_info_detail' => '取引金額情報詳細',
        'transaction_virtual_info_confirm' => '受付金額情報確認',
        'receive_info_detail' => '受付金額情報詳細',
        'withdraw_info_confirm' => '出金済額情報確認',
        'withdraw_info_detail' => '出金額情報詳細',
        'delete_modal_title' => '報告書の削除',
        'delete_modal_description' => '報告書を削除します。よろしいですか?',
        'delete_modal_success' => '報告書の削除が完了しました。',
        'update_modal_title' => '報告書詳細の編集',
        'update_modal_description' => '報告書詳細を編集します。よろしいですか?',
        'update_modal_success' => '報告書詳細の編集が完了しました。',
        'withdraw_modal_note' => '※日本円と仮想通貨のどちらかを出金できます。',
        'send_report_title' => 'epay報告書送付について',
        'create_modal_title' => '加盟店報告書の作成',
        'create_modal_description' => '選択した期間や加盟店により、報告書を作成します。<br>よろしいですか?',
        'create_modal_success' => '報告書作成が完了しました。',
        'send_mail_modal_title' => '加盟店報告書の送信',
        'send_mail_modal_description_before' => '加盟店のメールアドレス（',
        'send_mail_modal_description_after' => '）へ報告書を送信します。よろしいですか?',
        'send_mail_modal_success' => '送信が完了しました。',
        'validate' => [
            'merchant_required' => '加盟店を選んで下さい。',
            'issue_date_from_required' => '開始日を選んで下さい。',
            'issue_date_to_required' => '終了日を選んで下さい。',
            'max_today' => '終了日は本日まで日付で設定して下さい。',
            'max_date' => '開始日は終了日よりも前の日付で設定して下さい。',
        ],
    ],
];
