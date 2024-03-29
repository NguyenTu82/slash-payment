<?php

return [
    'label' => [
        'all' => 'すべて',
        'records' => ' 件数',
    ],
    'change' => '変更',
    'create' => '作成',
    'cancel' => 'キャンセル',
    'return_btn' => '戻る',
    'submit' => '申請',
    'back' => '戻る',
    'delete' => '削除',
    'search' => '検索',
    'detail' => '詳細',
    'reset' => 'リセット',
    'csv' => 'CSV',
    'close' => '戻る',
    'screens' => [
        'notification_list' => '通知一覧',
        'system_notification_list' => 'システム通知管理',
    ],
    'navbar' => [
        'language' => '日本語',
        'logout' => 'ログアウト',
        'username' => 'ユーザー名',
    ],
    'paginate' => [
        'display_per_page' => '表示件数',
        'previous' => '前へ',
        'next' => '次へ',
    ],
    'date_format_label' => [
        'day'=> '日',
        'month'=> '月',
        'year'=> '年',
    ],
    'days' => [
        'mon'=> '月',
        'tue'=> '火',
        'wed'=> '水',
        'thu'=> '木',
        'fri'=> '金',
        'sat'=> '土',
        'sun'=> '日'
    ],
    'status' => [
        'valid' => '有効',
        'invalid' => '無効',
        'stores' => [
            'default' => 'すべて',
            'temporarily_registered' => '仮登録済',
            'under_review' => '審査中',
            'in_use' => '利用中',
            'stopped' => '停止中',
            'withdrawal' => '退会',
            'forced_withdrawal' => '強制退会',
            'agreement' => '契約',
        ],
        'unread' => '未読',
        'already_read' => '既読'
    ],
    'sidebar' => [
        'dashboard' => 'ダッシュボード',
        'merchant' => '加盟店管理',
        'merchant_list' => '加盟店リスト一覧',
        'merchant_regis' => '新規加盟店登録',
        'report' => '加盟店レポート一覧',
        'AF' => 'アフィリエイト管理',
        'AF_list' => 'AFリスト一覧',
        'AF_regis' => '新規AF登録',
        'payment' => '出金管理',
        'payment_request' => '出金リクエスト',
        'payment_history' => '出金履歴',
        'notification' => '通知管理',
        'setting' => '設定',
        'system_notification' => 'システム通知管理',
        'confirm_status' => '利用状況確認',
        'payment_screen' => '決済画面',
    ],
    'error' => [
        'login_failed' => 'login_failed',
        'unauthenticated' => 'unauthenticated',
        'query' => 'cannot_execute_query',
        'not_found' => 'resource_not_found',
        'model_not_found' => 'model_not_found',
        'process_failed' => 'エラーが発生しました。',
        'auth_and_hash_token_not_exist' => '決済するために、加盟店のAPI設定情報が不足です。設定画面 > アカウント初期設定画面にてご確認下さい。',
        'token_expired' => 'パスワード再設定のURLの有効期限が切れています。',
        'token_invalid' => 'トークンが違い',
        'not_exists_email' => 'メールアドレスが間違っています。',
        'no_active_merchant' => '仮登録のため、ログインができません。',
        'email_exists' => 'メールが既に存在しました。',
        'error_has_occurred' => 'エラーが発生しました。',

        'save_error' => 'save_error',
        'save_success' => 'save_success',
        'delete_error' => 'delete_error',
        'delete_success' => 'delete_success',
        'update_success' => 'update_success',
        'can_not_delete' => 'can_not_delete',
    ],
    'messages' => [
        'update_successful' => 'update_successful',
        'update_failed' => 'update_failed',
        'no_data' => 'データがありません',
    ],
    'setting' => [
        'title' => '設定',
        'profile' => [
            'change_pw_title' => 'パスワードの変更',
            'change_pw_confirm' => 'パスワードの変更します。よろしいですか?',
            'change_pw_successful' => 'パスワードの変更が完了しました。',
            'update_profile_title' => 'プロファイル変更の確認',
            'update_profile_title_done' => 'プロファイル変更完了',
            'update_profile_confirm' => 'プロファイルを変更します。よろしいですか?',
            'update_profile_successful' => 'アカウント情報編集が完了しました。',
            'store' => '加盟店',
            'select_merchant_store' => '加盟店選択',
            'placeholder_search' => '加盟店名かIDを検索入力',
            'qr_code' => 'QRコード',
            'profile_info' => 'プロファイル情報',
            'account_management' => 'アカウント管理',
            'account_init_setting' => 'アカウント初期設定',
            'apply_new_merchant' => '新規店舗申請',
            'account_id' => 'アカウントID',
            'name' => 'アカウント名*',
            'note' => '備考欄',
            'account_type' => '権限',
            'login_mail' => '登録メールアドレス',
            'password' => 'パスワード',
            'change_pass_btn' => 'パスワードを変更する',
        ],
        'account' => [
            'account_info' => 'アカウント管理',
            'create_account_title' => '新規アカウント作成',
            'detail_account_title' => 'アカウント情報',
            'accountID' => 'アカウントID',
            'name' => 'アカウント名',
            'name_require' => 'アカウント名*',
            'role' => '権限',
            'role_require' => '権限*',
            'status' => 'ステータス',
            'status_require' => 'ステータス*',
            'note' => '備考欄',
            'mail' => '登録メールアドレス',
            'mail_require' => '登録メールアドレス*',
            'password' => 'パスワード',
            'password_require' => 'パスワード*',
            'confirm_password' => '確認パスワード*',
            'confirm_password_2' => 'パスワード（確認用）',
        ]
    ],
    'account_management' => [
        'default_select' => '選択',
        'placeholder_note' => 'スパーアカウントなので、アカウント追加できる。',
        'password_description' => '大文字と英数字を含んだ、6～15文字以内で設定して下さい',
        'confirm_password_description' => '新しいパスワードと同じパスワードを入力して下さい',
        'active' => 'active',
        'inactive' => 'inactive',
        'title_confirm_modal_create' => '新規アカウント作成',
        'description_confirm_modal_create' => '新規アカウントを作成します。よろしいですか?',
        'title_result_modal_create' => '新規アカウント作成',
        'description_result_modal_create' => '新規アカウント作成が完了しました。',
        'title_result_modal_delete' => 'アカウント情報削除',
        'description_result_modal_delete' => 'アカウント情報削除が完了しました。',
        'title_confirm_modal_delete' => 'アカウント情報削除',
        'description_confirm_modal_delete' => 'アカウント情報を削除します。よろしいですか?',
        'title_result_modal_update' => 'アカウント情報編集',
        'description_confirm_modal_update' => 'アカウント情報を編集します。よろしいですか?',
        'description_result_modal_update' => 'アカウント情報編集が完了しました。',
        'validation' => [
            'name' => [
                'required' => 'アカウント名を入力して下さい。',
            ],
            'role' => [
                'required' => '権限を選んで下さい。',
            ],
            'status' => [
                'required' => 'ステータスを選んで下さい。',
            ],
            'email' => [
                'required' => '登録メールアドレス名を入力して下さい。',
                'invalid' => 'メールアドレスが無効です。',
            ],
            'password' => [
                'required' => 'パスワードを入力して下さい。',
            ],
            'password_confirm' => [
                'required' => '確認パスワードを入力して下さい。',
            ],
            'merchant_store_ids' => [
                'required' => '加盟店を選んで下さい。',
            ],
            'agree_checkbox' => [
                'required' => '利用規約やプライパシーポリシーに同意して下さい。',
            ],
        ],
    ],
    'withdraw_management' => [
        'withdraw_history' => '出金履歴',
        'transaction_id' => '取引ID',
        'order_id' => '申請ID',
        'merchant_store_id' => '加盟店ID',
        'merchant_store_name' => '加盟店名',
        'request_date' => '申請日',
        'request_datetime' => '申請日時',
        'withdraw_name' => '出金先名',
        'publisher' => 'publisher',
        'withdraw_request_method' => '発行元',
        'withdraw_auto' => '自動',
        'withdraw_request_epay' => 'リクエスト(epay)',
        'withdraw_request_merchant' => 'リクエスト(加盟店)',
        'withdraw_method' => '支払先情報',
        'cash' => '現金',
        'banking' => '銀行振込',
        'crypto' => '仮想通貨',
        'withdraw_status' => 'ステータス',
        'waiting_approve' => '承認待ち',
        'tgw_waiting_approve' => 'TG承認待ち',
        'denied' => '失敗・拒否',
        'succeeded' => '完了',
        'approve_time' => '出金処理日',
        'approve_datetime' => '出金処理日時',
        'asset' => '通貨種別',
        'unit' => '単位',
        'amount' => '金額',
        'withdrawal_amount' => '出金額',
        'default_select' => '選択',
        'all' => 'すべて',
        'limit_withdraw' => '申請可能額',
        'max_balance' => '出金可能額',
    ],
    'button' => [
        'back' => '戻る',
        'delete' => '削除',
        'edit' => '編集',
        'create' => '作成',
        'cancel' => 'キャンセル',
        'change' => '変更',
        'confirm' => '確認',
        'detail' => '詳細',
        'search' => '検索',
        'reset' => 'リセット',
        'create_store' => '加盟店追加',
        'csv' => 'CSV',
        'ok' => 'OK',
        'send' => '送信',
        'approve' => '承認',
        'decline' => '拒否',
        'pdf_preview' => 'PDFプレビュー',
        'reenter' => '再入力',
        'print' => '印刷',
        'submit' => '登録',
    ],
    'merchant_stores' => [
        'list' => [
            'title' => '加盟店一覧',
            'table_title' => '加盟店集計データ'
        ],
        'payment_currency' => [
            'default' => 'すべて',
            'fiat' => '銀行振込',
            'crypto' => '仮想通貨',
            'cash' => '現金'
        ],
        'payment_cycle' => [
            'default' => 'すべて',
            'weekend_payment' => '週末払い',
            'month_end_payment' => '月末払い'
        ]
    ],
    'dashboard' => [
        'total_received_amount' => '受取総額',
        'total_withdrawal_amount' => '出金総額',
        'number_of_merchants' => '加盟店数',
        'number_of_AFs' => 'アフェリエイト数',
        'number_of_AFs_detail' => '新規アフェリエイト数',
        'number_of_new_merchants' => '新規加盟店数',
        'number_of_merchant_cancellations' => '加盟店解約数',
        'aggregation_target' => '集計対象',
        'aggregated_merchant' => '集計加盟店',
        'by_time' => '時間別',
        'by_day' => '日別',
        'by_month' => '月別',
        'by_year' => '年別',
        'total' => '集計',
        'description_target' => '※集計対象によりCSVダウンロードできます。',
        'name_tally_transition' => '各集計推移',
        'graph_display' => 'グラフ表示',
        'number_of_times_cases' => '回数／件数',
        'number_of_transactions' => '取引回数',
        'number_of_withdrawals' => '出金件数',
        'payment' => '支払金額',
        'paid' => '支払金額',
        'withdraw_amount' => '出金金額',
        'withdrawal_fee' => '出金手数料',
        'unit' => '円',
        'unit_usdt' => 'USDT',
        'thousand_unit_usdt' => 'K USDT',
        'million_unit_usdt' => 'M USDT',
        'thousand_unit' => '万',
        'million_unit' => '億',
        'thousand_money_unit' => '万円',
        'million_money_unit' => '億円',
        'each_summary_data' => '各集計データ',
        'aggregation_period' => '集計期間',
        'received_amount' => '受取金額',
        'only_yen' => '円のみ',
        'only_USDT' => 'USDTのみ',
        'trans_unpaid_amount' => '未払い額',
        'trans_unpaid_amount_detail' => '未払い額（円）',
        'detail' => '詳細',
        'transaction_summary_data' => '取引集計データ',
        'total_number_of_transactions' => '総取引回数',
        'receipt_amount' => '受取金額',
        'withdrawal_summary_data' => '出金集計データ',
        'payment_summary_data' => '出金集計データ',
        'total_number_of_withdrawals' => '総出金件数',
        'total_withdrawal_amounts' => '総出金額',
        'total_payment_amounts' => '総出金額',
        'JPY' => '日本円',
        'cash_yen' => '現金円',
        'hour' => 'hourJP',
        'default' => 'すべて',

        'total_number_of_transactions_title' => '総取引回数の説明',
        'total_number_of_transactions_description' => '総取引が行われた回数',
        'payment_title' => '支払金額の説明',
        'payment_description' => 'ウォレットで支払った金額',
        'receipt_amount_title' => '支払金額の説明',
        'receipt_amount_description' => 'ウォレットで受け取った金額',
        'outstanding_amount_title' => '未払い額の説明',
        'outstanding_amount_description' => '未払い残高',
        'total_number_of_withdrawals_title' => '総集金件数の説明',
        'total_number_of_withdrawals_description' => '加盟店に支払った件数',
        'total_withdrawal_amounts_title' => '総出金額の説明',
        'total_withdrawal_amounts_description' => '加盟店に支払った金額',
        'withdrawal_fee_title' => '出金手数料の説明',
        'withdrawal_fee_description' => '出金額で得た手数料',
        'number_of_new_merchants_title' => '新規加盟店数の説明',
        'number_of_new_merchants_description' => '新規登録加盟店数',
        'number_of_afs_title' => '新規アフェリエイト数の説明',
        'number_of_afs_description' => '新規登録アフェリエイト数',
        'number_of_cancel_merchants_title' => '加盟店解約数の説明',
        'number_of_cancel_merchants_description' => '加盟店解約数',
    ],
    'notification' => [
        'title' => '通知',
        'list' => [
            'listNotification' => '通知一覧',
            'create' => [
                'title' => '新規通知作成',
                'receiver' => '通知先',
                'group' => 'グループ',
                'time' => '送信時間指定',
                'titleNoti' => 'タイトル*',
                'content' => '通知内容*'
            ]
        ],
        'manage' => [
            'manageTitle' => 'システム通知管理'
        ],
        'title_confirm_modal_save' => '通知未編集確認',
        'description_confirm_modal_save' => '編集した内容はまだ保存されていません。
                                             前の画面に戻ってよろしいですか?',
        'title_confirm_modal_update' => '通知編集確認',
        'description_confirm_modal_update' => '記入した内容で編集してよろしいですか？',
        'title_result_modal_update' => '通知編集完了',
        'description_result_modal_update' => '通知テンプレート編集が完了しました。',
    ],
    'usage_situtation' => [
        'trans_ID' => 'トランザクションID',
        'request_date' => 'リクエスト日',
        'payment_completion_date' => '決済完了日',
        'hash' => 'ハッシュ',
        'network' => 'ネットワーク',
        'request_method' => 'リクエスト方式',
        'end' => 'エンド',
        'amount_money' => '金額',
        'payment_status' => '決済ステータス',
        'unsettled' => '未決済',
        'completion' => '完了',
        'failure' => '失敗',
        'total_payment' => '支払総額',
        'aggregation_trends' => '各集計推移',
        'payment_amount_yen' => '支払金額（円)',
        'received_amount_USDT' => '受取金額（USDT）',
        'usage_situation' => '利用状況',
        'request_datetime' => 'リクエスト日時',
        'payment_datetime' => '決済日時',
        'merchant_usage_status' => '加盟店利用状況',
        'usage_details' => '利用状況詳細',
        'usage_edit' => '利用状況編集',
        'usage_situation_csv_file_name' => '利用状況',
        'validation' => [
            'paymentAmountForm' => [
                'required' => '支払金額を入力して下さい。',
                'number' => '有効な数値を入力してください',
            ],
            'receivedAmountForm' => [
                'required' => '受取金額を入力して下さい。',
                'number' => '有効な数値を入力してください',
            ],
        ],
        'usage_delete_title_confirm' => '利用状況の削除',
        'usage_delete_des_confirm' => '利用状況を削除します。よろしいですか?',
        'usage_delete_des_result' => '利用状況の削除が完了しました。',
        'usage_update_title_confirm' => '利用状況の編集',
        'usage_update_des_confirm' => '利用状況を編集します。よろしいですか?',
        'usage_update_des_result' => '利用状況の編集が完了しました。',
        'network_type' => [
            'ETH' => 'Ethereum (ETH)',
            'BNB' => 'BNB Chain (BNB)',
            'Matic' => 'Polygon (Matic)',
            'AVAX' => 'Avalanche C-Chain (AVAX)',
            'FTM' => 'Fantom (FTM)',
            'ARBITRUM_ETH' => 'Arbitrum One (ETH)',
            'SOL' => 'Solana (SOL)',
        ]
    ],
    'tiger_service_fail' => '出金リクエスト時のLionゲートウェイの送信に失敗しました。',
    'yen_unit' => '日本円',
    'not_connect_tiger_gateway' => 'Lionゲートウェイと連携は失敗しました。',
    'register' => [
        'username' => 'ユーザー名',
        'validation_name_required' => "ユーザー名を入力して下さい。",
    ], 
];
