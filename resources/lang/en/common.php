<?php

return [
    'label' => [
        'all' => 'All',
        'records' => ' records',
    ],
    'change' => 'change',
    'create' => 'create',
    'cancel' => 'cancel',
    'return_btn' => 'return',
    'submit' => 'submit',
    'back' => 'back',
    'delete' => 'Delete',
    'search' => 'Search',
    'detail' => 'detail',
    'reset' => 'reset',
    'csv' => 'csv',
    'close' => 'close',
    'screens' => [
        'notification_list' => 'Notification List',
        'system_notification_list' => 'System Notification List',
    ],
    'navbar' => [
        'language' => 'English',
        'logout' => 'Logout',
        'username' => 'Username',
    ],
    'paginate' => [
        'display_per_page' => 'Show',
        'previous' => 'Previous',
        'next' => 'Next',
    ],
    'date_format_label' => [
        'day'=> '',
        'month'=> '',
        'year'=> '',
    ],
    'days' => [
        'mon' => 'Mon',
        'tue' => 'Tue',
        'wed' => 'Wed',
        'thu' => 'Thu',
        'fri' => 'Fri',
        'sat' => 'Sat',
        'sun' => 'Sun',
    ],
    'status' => [
        'valid' => 'valid',
        'invalid' => 'invalid',
        'stores' => [
            'default' => 'All',
            'temporarily_registered' => 'Temporarily Registered',
            'under_review' => 'Under Review',
            'in_use' => 'In Use',
            'stopped' => 'Stopped',
            'withdrawal' => 'Withdrawal',
            'forced_withdrawal' => 'Forced Withdrawal',
            'agreement' => 'Agreement',
        ],
        'unread' => 'Unread',
        'already_read' => 'Already read',
    ],
    'sidebar' => [
        'dashboard' => 'Dashboard',
        'merchant' => 'Merchant',
        'merchant_list' => 'Merchant List',
        'merchant_regis' => 'Merchant Register',
        'report' => 'Merchant Report',
        'AF' => 'Affiliate Management',
        'AF_list' => 'Affiliate List',
        'AF_regis' => 'Affiliate Register',
        'payment' => 'Payment',
        'payment_request' => 'Payment Request',
        'payment_history' => 'Payment History',
        'notification' => 'Notification Management',
        'setting' => 'Setting',
        'system_notification' => 'System notification management',
        'payment_screen' => 'Payment screen',
    ],
    'error' => [
        'login_failed' => 'login_failed',
        'unauthenticated' => 'unauthenticated',
        'query' => 'cannot_execute_query',
        'not_found' => 'resource_not_found',
        'model_not_found' => 'model_not_found',
        'process_failed' => 'process_failed',
        'auth_and_hash_token_not_exist' => 'In order to make a payment, the API setting information of the merchant is insufficient. Please check the settings screen > account initial settings screen.',
        'token_expired' => 'This link has expired.',
        'token_invalid' => 'The token is invalid',
        'not_exists_email' => 'Your email address is incorrect.',
        'email_exists' => 'The email already existed.',
        'error_has_occurred' => 'An error has occurred',
        'no_active_merchant' => 'You cannot log in because this is a temporary registration.',
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
        'no_data' => 'No data',
    ],
    'setting' => [
        'title' => 'Setting',
        'profile' => [
            'change_pw_title' => 'Password change',
            'change_pw_confirm' => 'Change your password. Is it OK?',
            'change_pw_successful' => 'You have successfully changed your password.',
            'update_profile_title' => 'Confirm Profile Change',
            'update_profile_title_done' => 'Completed profile change',
            'update_profile_confirm' => 'Change your profile. Is it OK?',
            'update_profile_successful' => 'You have completed editing your profile information.',
            'store' => 'Merchant',
            'select_merchant_store' => 'Select',
            'placeholder_search' => 'Enter for merchant name or ID',
            'qr_code' => 'QR code',
            'profile_info' => 'Profile information',
            'account_management' => 'Account management',
            'account_init_setting' => 'Account initial settings',
            'apply_new_merchant' => 'New store application',
            'account_id' => 'Account ID',
            'name' => 'Account name*',
            'note' => 'Memo',
            'account_type' => 'Authority',
            'login_mail' => 'Email address',
            'password' => 'Password',
            'change_pass_btn' => 'Change password',
        ],
        'account' => [
            'account_info' => 'Account Information',
            'create_account_title' => 'Create new account',
            'detail_account_title' => 'Account information',
            'accountID' => 'Account ID',
            'name' => 'Account Name',
            'name_require' => 'Account Name*',
            'role' => 'Role',
            'role_require' => 'Role*',
            'status' => 'Status',
            'status_require' => 'Status*',
            'note' => 'Memo',
            'mail' => 'Email address',
            'mail_require' => 'Email address*',
            'password' => 'Password',
            'password_require' => 'Password*',
            'confirm_password' => 'Confirm Password',
            'confirm_password_2' => 'Password (for confirmation)',
        ],
    ],
    'account_management' => [
        'default_select' => 'Selection',
        'placeholder_note' => "It's a super account, so you can add an account.",
        'password_description' => 'Please set within 6 to 15 characters including uppercase letters and alphanumeric characters',
        'confirm_password_description' => 'Please enter the same password as the new password',
        'active' => 'active',
        'inactive' => 'inactive',
        'title_confirm_modal_create' => 'New account creation confirmation',
        'description_confirm_modal_create' => 'Create a new account. Is it OK?',
        'title_result_modal_create' => 'Completion of new account creation',
        'description_result_modal_create' => 'You have successfully created a new account.',
        'title_result_modal_delete' => 'Completed deleting account information',
        'description_result_modal_delete' => 'Your account information has been deleted.',
        'title_confirm_modal_delete' => 'Account information deletion confirmation',
        'description_confirm_modal_delete' => 'Delete account information. Is it OK',
        'title_result_modal_update' => 'Edit account information',
        'description_confirm_modal_update' => 'Edit your account information. Is it OK?',
        'description_result_modal_update' => 'You have completed editing your account information.',
        'validation' => [
            'name' => [
                'required' => 'Please enter your name.',
            ],
            'role' => [
                'required' => 'Please select a role.',
            ],
            'status' => [
                'required' => 'Please select a status.',
            ],
            'email' => [
                'required' => 'Please enter your email address name.',
                'invalid' => 'Email address is invalid.',
            ],
            'password' => [
                'required' => 'Please enter the password.',
            ],
            'password_confirm' => [
                'required' => 'Please enter the confirmation password.',
            ],
            'merchant_store_ids' => [
                'required' => 'Please select a member store.',
            ],
            'agree_checkbox' => [
                'required' => 'Please agree to the terms of use and privacy policy.',
            ],
        ],
    ],
    'withdraw_management' => [
        'withdraw_history' => 'Payment history',
        'transaction_id' => 'Transaction ID',
        'order_id' => 'Order id',
        'merchant_store_id' => 'Merchant ID',
        'merchant_store_name' => 'Merchant',
        'request_date' => 'Request date',
        'request_datetime' => 'Request date',
        'withdraw_name' => 'Financial Institution Name',
        'publisher' => 'Publisher',
        'withdraw_request_method' => 'Request method',
        'withdraw_auto' => 'Auto',
        'withdraw_request_epay' => 'Request (epay)',
        'withdraw_request_merchant' => 'Request (Merchant)', 
        'withdraw_method' => 'Withdraw method',
        'cash' => 'Cash',
        'banking' => 'Banking',
        'crypto' => 'Crypto Currency',
        'withdraw_status' => 'Status',
        'waiting_approve' => 'Waiting to approve',
        'tgw_waiting_approve' => 'TGW Waiting to approve',
        'denied' => 'Denied',
        'succeeded' => 'Succeeded',
        'approve_time' => 'Approved date',
        'approve_datetime' => 'Approved date',
        'asset' => 'Currency type',
        'unit' => 'Currency',
        'amount' => 'Amount',
        'withdrawal_amount' => 'Payment amount',
        'default_select' => 'Default select',
        'all' => 'All',
        'limit_withdraw' => 'Limit withdraw',
        'max_balance' => 'Balance',
    ],
    'button' => [
        'back' => 'Go back',
        'delete' => 'Delete',
        'edit' => 'Edit',
        'create' => 'Create',
        'cancel' => 'Cancel',
        'change' => 'Change',
        'confirm' => 'Confirm',
        'detail' => 'Detail',
        'search' => 'Search',
        'reset' => 'Reset',
        'create_store' => 'Create',
        'csv' => 'CSV',
        'send' => 'Send',
        'approve' => 'Approve',
        'decline' => 'Decline',
        'pdf_preview' => 'PDF Preview',
        'print' => 'Print',
        'submit' => 'Submit',
    ],
    'merchant_stores' => [
        'list' => [
            'title' => 'Merchant Store List',
            'table_title' => 'Merchant Aggregation Data',
        ],
        'payment_currency' => [
            'default' => 'All',
            'fiat' => 'Banking',
            'crypto' => 'Crypto Currency',
            'cash' => 'Cash',
        ],
        'payment_cycle' => [
            'default' => 'All',
            'weekend_payment' => 'Weekend',
            'month_end_payment' => 'End Month',
        ],
    ],
    'dashboard' => [
        'total_received_amount' => 'Total received amount',
        'total_withdrawal_amount' => 'Total withdrawal amount',
        'number_of_merchants' => 'Number of merchants',
        'number_of_AFs' => 'Number of affiliates',
        'number_of_AFs_detail' => 'Number of AFs detail',
        'number_of_new_merchants' => 'Number of new merchants',
        'number_of_merchant_cancellations' => 'Number of merchant cancellations',
        'aggregation_target' => 'Aggregation target',
        'aggregated_merchant' => 'Aggregation merchant',
        'by_time' => 'Hourly',
        'by_day' => 'Daily',
        'by_month' => 'Monthly',
        'by_year' => 'Yearly',
        'total' => 'Total',
        'description_target' => '*CSV download is possible depending on the aggregation target.',
        'name_tally_transition' => 'Each Total',
        'graph_display' => 'Graph display',
        'number_of_times_cases' => 'Times/cases',
        'number_of_transactions' => 'Number of transactions',
        'number_of_withdrawals' => 'Number of payment',
        'payment' => 'Payment amount',
        'paid' => 'Paid amount',
        'withdraw_amount' => 'Payment amount',
        'withdrawal_fee' => 'Payment fee',
        'unit' => 'Yen',
        'unit_usdt' => 'USDT',
        'thousand_unit_usdt' => 'K USDT',
        'million_unit_usdt' => 'M USDT',
        'thousand_unit' => 'K',
        'million_unit' => 'M',
        'thousand_money_unit' => 'K Yen',
        'million_money_unit' => 'M Yen',
        'each_summary_data' => 'Each Total date',
        'aggregation_period' => 'Aggregation period',
        'received_amount' => 'Received amount',
        'only_yen' => 'Only yen',
        'only_USDT' => 'Only USDT',
        'trans_unpaid_amount' => 'Unpaid amount',
        'trans_unpaid_amount_detail' => 'Unpaid amount(JPY)',
        'detail' => 'Details',
        'transaction_summary_data' => 'Transaction summary data',
        'total_number_of_transactions' => 'Total number of transactions',
        'receipt_amount' => 'Receipt amount',
        'withdrawal_summary_data' => 'Withdrawal summary data',
        'payment_summary_data' => 'Payment summary data',
        'total_number_of_withdrawals' => 'Total number of payment',
        'total_withdrawal_amounts' => 'Total withdrawal amount',
        'total_payment_amounts' => 'Total payment amount',
        'JPY' => 'JPY',
        'cash_yen' => 'Cash yen',
        'hour' => 'Hour',
        'default' => 'All',

        'total_number_of_transactions_title' => 'Description of total number of transactions',
        'total_number_of_transactions_description' => 'Number of times traded',
        'payment_title' => 'Description of payment amount',
        'payment_description' => 'Number of transactions made',
        'receipt_amount_title' => 'Description of payment amount',
        'receipt_amount_description' => 'Number of times the transaction was made',
        'outstanding_amount_title' => 'Description of outstanding amount',
        'outstanding_amount_description' => 'Outstanding balance',
        'total_number_of_withdrawals_title' => 'Description of total payment',
        'total_number_of_withdrawals_description' => 'Number of payments to merchants',
        'total_withdrawal_amounts_title' => 'Description of total withdrawal amount',
        'total_withdrawal_amounts_description' => 'Amount paid to merchant',
        'withdrawal_fee_title' => 'Description of withdrawal fee',
        'withdrawal_fee_description' => 'Fee earned on withdrawal amount',
        'number_of_new_merchants_title' => 'Description for number of new merchants',
        'number_of_new_merchants_description' => 'Number of newly registered merchants',
        'number_of_afs_title' => 'Description of new affiliate count',
        'number_of_afs_description' => 'Number of newly registered affiliates',
        'number_of_cancel_merchants_title' => 'Number of cancel merchants title',
        'number_of_cancel_merchants_description' => 'Number of cancel merchants description',
    ],
    'notification' => [
        'title' => 'Notification',
        'list' => [
            'listNotification' => 'Notification List',
            'create' => [
                'title' => 'Create New Notification',
                'receiver' => 'Receiver',
                'group' => 'Group',
                'time' => 'Specify Sending Time',
                'titleNoti' => 'Title*',
                'content' => 'Notification Content*'
            ]
        ],
        'manage' => [
            'manageTitle' => 'System Notification Management'
        ],
        'title_confirm_modal_save' => 'Notification Unedited Confirmation',
        'description_confirm_modal_save' => 'The edited content has not been saved yet.
                                             Are you sure you want to go back to the previous screen?',
        'title_confirm_modal_update' => 'Notification Edit Confirmation',
        'description_confirm_modal_update' => 'Are you sure you want to edit with the entered content?',
        'title_result_modal_update' => 'Notification Edit Complete',
        'description_result_modal_update' => 'Notification template editing has been completed.',
    ],
    'usage_situtation' => [
        'trans_ID' => 'Transaction ID',
        'request_date' => 'Request date',
        'payment_completion_date' => 'Payment completed date',
        'hash' => 'Hash',
        'network' => 'Network',
        'request_method' => 'Request method',
        'end' => 'User',
        'amount_money' => 'Amount',
        'payment_status' => 'Payment status',
        'unsettled' => 'Unsettled',
        'completion' => 'Completed',
        'failure' => 'Failed',
        'total_payment' => 'Total payment',
        'aggregation_trends' => 'Each Total',
        'payment_amount_yen' => 'Payment amount (yen)',
        'received_amount_USDT' => 'Received amount (USDT)',
        'usage_situation' => 'Usage situation',
        'request_datetime' => 'Request datetime',
        'payment_datetime' => 'Payment datetime',
        'merchant_usage_status' => 'Merchant usage status',
        'usage_details' => 'Usage details',
        'usage_edit' => 'Usage Edit',
        'usage_situation_csv_file_name' => 'usage_situation',
        'validation' => [
            'paymentAmountForm' => [
                'required' => 'Please enter the payment amount',
                'number' => 'Please enter a valid number',
            ],
            'receivedAmountForm' => [
                'required' => 'Please enter the amount to be received',
                'number' => 'Please enter a valid number',
            ],
        ],
        'usage_delete_title_confirm' => 'Delete usage',
        'usage_delete_des_confirm' => 'Delete usage. Is it OK?',
        'usage_delete_des_result' => 'You have successfully deleted the usage status.',
        'usage_update_title_confirm' => 'Edit usage',
        'usage_update_des_confirm' => 'Edit usage. Is it OK?',
        'usage_update_des_result' => 'You have finished editing your usage.',
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
    'tiger_service_fail' => 'Withdrawal request failed to send to Lion gateway.',
    'yen_unit' => 'Yen',
    'not_connect_tiger_gateway' => 'Cooperation with Lion gateway failed.',
    'register' => [
        'username' => 'Username',
        'validation_name_required' => "Please enter your username.",
    ],
];
