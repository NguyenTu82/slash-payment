<?php

return [
    'messages' => [
        'send_email_successful' => 'A password reset email has been sent.',
        'URL_expired_please_log_in_again' => 'This URL is no longer valid. Please login again.',
        'token_is_invalid' => 'This link is no longer valid.',
        'error_has_occurred' => 'An error has occurred',
        'title_forgot_password_email' => 'epay login password reset guide',
    ],
    'admin' => [
        'title' => 'Account management',
        'list' => 'Account list',
        'list_account' => 'Account list',
        'name' => 'Name',
        'mail' => 'Email',
        'role' => 'Role',
        'created_at' => 'Create date',
        'title_create' => 'Create account',
        'account_id' => 'Account ID',
        'password' => 'Password',
        'profile_info' => 'Profile',
        'account_management' => 'Account',
        'permission_management' => 'Permission',
        'fee_setting' => 'Fee setting',
        'dashboard_title' => 'Dashboard',
    ],
    'setting' => [
        'profile' => [
            'validation' => [
                'name' => [
                    'required' => 'Please enter your account name.',
                ],
                'role' => [
                    'required' => 'Please select a role.',
                ],
                'email' => [
                    'required' => 'Please enter your e-mail address.',
                    'invalid' => 'Invalid email address.',
                ],
                'account_id' => [
                    'required' => 'Please enter your account ID.',
                ]
            ],
        ],
        'account_management' => [
            'list' => [
                'account_info' => 'Account info',
                'accountID' => 'Account ID',
                'name' => 'Name',
                'mail' => 'Email',
                'authority' => 'Permission',
                'status' => 'Status',
                'detail' => 'Detail',
                'search' => 'Search',
                'reset' => 'Reset',
            ],
            'search_name' => 'Account ID, name, email address',
            'create_account' => 'Create new account',
            'default_select' => 'Selection',
            'password_description' => 'Please set within 6 to 15 characters including uppercase letters and alphanumeric characters',
            'confirm_password_description' => 'Please enter the same password as the new password',
            'active' => 'Valid',
            'inactive' => 'Invalid',
            'title_confirm_modal_create' => 'Confirm new account creation',
            'description_confirm_modal_create' => 'Create a new account. Is it OK?',
            'title_result_modal_create' => 'Confirm new account creation',
            'description_result_modal_create' => 'Create a new account. Is it OK?',
            'validation' => [
                'name' => [
                    'required' => 'Please enter your account name.',
                ],
                'role' => [
                    'required' => 'Please select a permission.',
                ],
                'status' => [
                    'required' => 'Please select a status.',
                    'invalid' => 'Invalid email address.',
                ],
                'email' => [
                    'required' => 'Please enter your email address name.',
                ],
                'password' => [
                    'required' => 'Please enter the password.',
                ],
                'password_confirm' => [
                    'required' => 'Please enter the confirmation password.',
                ],
            ],
        ],
        'modal' => [
            'confirm_delete_account_title' => 'Confirm deletion of account information',
            'confirm_delete_account_content' => 'Delete account information. Is it OK?',
            'delete_account_success_content' => 'Your account information has been deleted.',
            'delete_account_success_title' => 'Account information deleted',

        ]
    ],
    'merchant' => [
        'common' => [
            'usage_status' => 'Usage situation',
            'merchant_detail' => 'Merchant detail',
            'total_transaction_amount' => 'Total transaction amount',
            'paid_balance' => 'Paid balance',
            'account_balance' => 'Account balance',
            'merchant_info' => 'Merchant information',
            'merchant_other_info' => 'Other merchant information',
            'contract_payment_info' => 'Contract and payment information',
            'af_info' => 'Affiliate information',
            'select_merchant_store' => 'Merchant selection',
            'create_merchant_success' => 'Completion of new merchant registration',
            'create_merchant_success_description' => 'The registration of the new member store has been completed',
            'update_merchant_success' => 'Edit Merchant',
            'update_merchant_success_description' => 'Merchant edit completed',
            'rewrite' => 'Re-enter',
            'create' => 'Sign up',
            'merchant_store_csv_file_name' => 'Merchant Store List',
            'usage_situation' => 'usage_situation',
            'title_confirm_modal_delete' => 'Delete Merchant',
            'description_confirm_modal_delete' => 'Delete the merchant. Is it OK?',
            'delete_merchant_success_description' => 'Merchant deletion completed. ',
            'delete_confirm_group' => 'Are you sure you want to delete the linked merchants?',
            'merchant_create' => 'Create Merchant',
            'show_payee_information' => 'Display payment information',
            'no_yes' => 'No - Yes',
            'verify_url_error' => 'Merchant ID or token does not exist. ',
            'verify_url_expires' => 'Merchant is primary registration URL has expired. ',
            'merchant_create_success_title' => 'Merchant new registration completed',
            'merchant_create_success_description' => 'Merchant new registration completed. ',
            'email_exist' => 'The registered email address is already registered. ',
            'merchant_name_exist' => 'The registered merchant name is already registered',
            'auth_or_hash_exist' => 'The API key (authentication code) or API key (hash token) already exists.',
            'success_register' => 'Successful registration',
            'can_not_merchant' => 'There are no selectable merchants.',
            'merchant_list' => 'Merchant list'
        ],
        'info' => [
            'id' => 'Merchant ID',
            'name' => 'Merchant name',
            'status' => 'Status',
            'now_status' => 'Now status',
            'service_name' => 'Service name',
            'industry' => 'Industry',
            'representative_name' => "Representative's name",
            'address' => 'Address',
            'phone_number' => 'Phone number',
            'register_email' => 'Registered email address',
            'password' => 'Password',
            'group' => 'Group',
            'contract_wallet1' => 'Contract',
            'contract_wallet2' => 'wallet',
            'received_wallet1' => 'Receiving wallet',
            'received_wallet2' => 'address',
            'virtual_currency_type' => 'Received virtual currency type',
            'auth_token' => 'API key (authentication code)',
            'hash_token' => 'API key (hash token)',
            'payment_url' => 'QR code setting URL',
            'post_code' => 'Post code'
        ],
        'other_info' => [
            'sending_detail' => 'Whether or not to send details',
            'ship_date' => 'Shipping date setting',
            'ship_address' => 'Shipping address',
            'delivery_report' => 'Delivery report selection',
            'delivery_email_address' => 'Delivery email address',
            'guidance_email' => 'Guidance_email',
            'post_code_ship' => 'Shipping destination postal code'
        ],
        'payment_info' => [
            'contract_date' => 'Contract date',
            'termination_date' => 'Termination date',
            'payment_cycle' => 'Payment cycle',
            'payment_currency' => 'Payment info',
            'contract_interest_rate' => 'Contract interest rate',
            'payment_info' => 'Display payment information',
        ],
        'affiliate_info' => [
            'info' => 'Affiliate information',
            'id' => 'Affiliate ID',
            'name' => 'Affiliate name',
            'fee' => 'Affiliate Fee',
        ],
        'status' => [
            'temporarily_registered' => 'Temporarily registered',
            'under_review' => 'Under review',
            'in_use' => 'In use',
            'suspend' => 'Suspending',
            'withdrawal' => 'Withdrawn',
            'forced_withdrawal' => 'Forced withdrawal',
            'agreement' => 'Agreement',
        ],
        'crypto_payment' => [
            'wallet_address' => 'Wallet address',
            'network' => 'Network',
            'note' => 'Note',
            'title' => 'Payment information (virtual currency)'
        ],
        'fiat_payment' => [
            'title' => 'Payment information (banking)',
            'financial_institution_name' => 'Bank name',
            'bank_code' => 'Bank code',
            'bank_code_short' => 'Bank code',
            'branch_name' => 'Branch name',
            'branch_code' => 'Branch code',
            'bank_account_type' => 'Account type',
            'bank_account_number' => 'Account number',
            'bank_account_holder' => 'Account holder',
        ],
        'cash_payment' => [
            'title' => 'Payment information (cash)',
            'total_transaction_amount' => 'Total transaction amount',
            'account_balance' => 'Paid balance',
            'paid_balance' => 'Account balance'
        ],
        "payment_type" => [
            'fiat' => 'Banking',
            'crypto' => 'Crypto Currency',
            'cash' => 'Cash'
        ],
        "bank_account_type" => [
            'usually' => 'Saving',
            'regular' => 'Time Deposit',
            'current' => 'Checking'
        ],
        "delivery_report" => [
            'transaction' => 'Per transaction',
            'day' => 'Daily Report',
            'week' => 'Weekly report',
            'month' => 'Monthly report',
            'cycle' => 'every payment cycle'
        ],
        "payment_cycle" => [
            'end_3_days' => 'End 3 days',
            'end_week' => 'Weekend',
            'end_month' => 'End Month',
        ],
        "ship_date" => [
            'end_month' => 'End month',
            'every_weekend' => 'Every weekend',
            'every_other_weekend' => 'Every other weekend',
        ],
        'validation' => [
            'name' => [
                'required' => 'Please enter merchant name. ',
            ],
            'group' => [
                'required' => 'Please select a group. ',
            ],
            'service_name' => [
                'required' => 'Please enter a service name. ',
            ],
            'industry' => [
                'required' => 'Please enter your industry. ',
            ],
            'representative_name' => [
                'required' => 'Please enter a representative name. ',
            ],
            'post_code_id' => [
                'non_exist' => 'Postal code not exist. ',
                'format' => 'Please enter a number up to 8 numeric characters for postal code'
            ],
            'address' => [
                'required' => 'Please enter your address. ',
            ],
            'phone' => [
                'required' => 'Please enter your phone number. ',
            ],
            'email' => [
                'required' => 'Please enter your registered email address. ',
            ],
            'password' => [
                'required' => 'Please enter your password. ',
                'format' => 'Please set the password within 6 to 15 characters including uppercase letters and alphanumeric characters.'
            ],
            'contract_wallet' => [
                'required' => 'Please enter your contract wallet. ',
            ],
            'receiving_walletaddress' => [
                'required' => 'Please enter a receiving wallet address. ',
            ],
            'received_virtua_type' => [
                'required' => 'Please enter the type of virtual currency you receive. ',
            ],
            'auth_token' => [
                'required' => 'Please enter a API key (auth token). ',
            ],
            'hash_token' => [
                'required' => 'Please enter a API key (hash token). ',
            ],
            'payment_url' => [
                'required' => 'Please enter the QR code setting URL.',
            ],
            'ship_date' => [
                'required' => 'Please select a shipping date setting. ',
            ],
            'ship_post_code_id' => [
                'non_exist' => 'Shipping postal code not exist. ',
                'format' => 'Please enter a number up to 8 numeric characters for shipping postal code'
            ],
            'ship_address' => [
                'required' => 'shipping address',
            ],
            'delivery_email_address' => [
                'required' => 'Please enter a delivery email address. ',
                'notEqualTo' => 'The delivery email address is duplicated.',
            ],
            'delivery_report' => [
                'required' => 'Please select delivery report selection. ',
            ],
            'contract_date' => [
                'required' => 'Please select a contract date. ',
            ],
            'termination_date' => [
                'required' => 'Please select a cancellation date. ',
            ],
            'contract_interest_rate' => [
                'required' => 'Please enter the contract rate. ',
            ],
            'crypto_wallet_address' => [
                'required' => 'Please enter your wallet address. ',
            ],
            'crypto_network' => [
                'required' => 'Please enter a network. ',
            ],
            'bank_code' => [
                'required' => 'Please enter the bank code. ',
                'non_exist' => 'Bank code non exist.'
            ],
            'financial_institution_name' => [
                'required' => 'Please enter the bank name. ',
            ],
            'branch_code' => [
                'required' => 'Please enter the branch code. ',
                'non_exist' => 'Branch code non exist.'
            ],
            'branch_name' => [
                'required' => 'Please enter a branch name. ',
            ],
            'bank_account_number' => [
                'required' => 'Please enter your account number. ',
            ],
            'bank_account_holder' => [
                'required' => 'Please enter the account name. ',
                'checkKatakana' => 'Please enter full-width katakana in the "account holder" field.'
            ],
            'total_transaction_amount' => [
                'required' => 'Please enter the total transaction amount. ',
            ],
            'account_balance' => [
                'required' => 'Please enter the paid balance. ',
            ],
            'paid_balance' => [
                'required' => 'Please enter your account balance. ',
            ],
            'af_id' => [
                'required' => 'Please enter your affiliate ID. ',
            ],
            'af_name' => [
                'required' => 'Please enter your affiliate name. ',
            ],
            'af_rate' => [
                'required' => 'Please enter your affiliate commission. ',
            ]
        ],
    ],
    'notifications' => [
        'type' => 'Type',
        'noti_type' => 'Notification type',
        'status' => 'Status',
        'merchant_id' => 'Merchant ID',
        'merchant_name' => 'Merchant name',
        'title' => 'Title',
        'receive_date' => 'Receive date',
        'receive_date_time' => 'Receive date time',
        'search' => 'Search',
        'reset' => 'Reset',
        'create_noti' => 'Create notification',
        'detail' => 'Detail',
        'list_receive' => 'List receive',
        'list_send' => 'List Send',
        'schedule_send' => 'Sending schedule',
        'send_date' => 'Sent date time',
        'send_date_time' => 'Sent date',
        'receive_noti' => 'Receive',
        'send_noti' => 'Send',
        'receive_noti_detail' => 'Received notification detail',
        'content' => 'Notification content',
        'email' => 'Email',
        'all' => 'All',
        'noti_detail' => 'Notification detail',
        'createNew' => [
            'title' => 'Create New Notification',
            'receiver' => 'Receiver',
            'group' => [
                'title' => 'Group',
                'selectStore' => 'Select store'
            ],
            'time' => [
                'title' => 'Send time',
                'timeSet' => 'Schedule',
                'timeNotSet' => "Unschedule"
            ],
            'notiTitle' => 'Title*',
            'content' => 'Content*'
        ],
        'validation' => [
            'time' => [
                'required' => 'Please choose date and time.',
                'future' => 'Please choose value greater than current time.'
            ],
            'title' => [
                'required' => 'Please enter title of notification.',
            ],
            'content' => [
                'required' => 'Please enter content of notification.',
            ]
        ],
        'type_send' => [
            'all' => 'All merchant',
            'part' => 'Selected merchant',
        ],
        'status_send' => [
            'send' => 'Sent',
            'not_send' => 'Unsent',
        ],
        'type_receive' => [
            'new' => 'New merchant',
            'withdraw' => 'Withdraw',
            'cancel' => 'Cancel',
        ],
        'status_receive' => [
            'read' => 'Read',
            'unread' => 'Unread',
        ],
        'common' => [
            'title_confirm_create_send_noti' => 'New notification sent confirmation',
            'content_confirm_create_send_noti' => 'Send notifications to selected merchants.<br>Are you sure you want to send what you entered?',
            'title_confirm_successfully_send_noti' => 'Sent Notification',
            'content_confirm_successfully_send_noti' => 'Send notification completed.',
            'title_confirm_update_send_noti' => 'Confirm notification edit',
            'content_confirm_update_send_noti' => 'Are you sure you want to edit the content? ',
            'title_confirm_delete_send_noti' => 'delete notification',
            'content_confirm_delete_send_noti' => 'Delete the notification. Is it OK?',
            'title_confirm_update_successfully_send_noti' => 'Notification edited',
            'content_confirm_update_successfully_send_noti' => 'Notification editing completed. ',
            'title_confirm_delete_successfully_send_noti' => 'notification deleted',
            'content_confirm_delete_successfully_send_noti' => 'Notification deletion completed. ',
            'noti_input_password' => 'Set within 6 to 15 characters, including uppercase letters and alphanumeric characters'
        ]
    ],
    'report' => [
        'report_list' => 'Merchant Report List',
        'report_create' => 'Merchant Report Create',
        'report_detail' => 'Merchant Report Detail',
        'report_edit' => 'Merchant Report Edit',
        'report_table_title' => 'Report List',
        'report_code' => 'Report detail ID',
        'merchant' => 'Merchant',
        'merchant_id' => 'Merchant ID',
        'merchant_name' => 'Merchant',
        'email' => 'Email',
        'issue_date' => 'Issue date',
        'status' => 'Status',
        'period' => 'Period',
        'only_yen' => '(Only yen)',
        'note' => 'Memo',
        'total' => 'Total',
        'transaction_number' => 'Number of transactions',
        'transaction_amount' => 'Transaction amount',
        'planned_withdrawal_amount' => 'Planned withdrawal amount',
        'withdraw_fee' => 'Withdraw fee',
        'detail' => 'Detail',
        'send' => 'Send',
        'status_type' => [
            'un_send' => 'Unsent',
            'sent' => 'Sent'
        ],
        'unit' => 'Unit',
        'pdf_preview' => 'Merchant report preview',
        'withdrawable_amount' => 'Withdrawable amount',
        'withdrawn_amount' => 'Withdrawn amount',
        'transaction_info_confirm' => 'Transaction amount information',
        'transaction_info_detail' => 'Transaction amount information detail',
        'transaction_virtual_info_confirm' => 'Received amount information',
        'receive_info_detail' => 'Received amount information detail',
        'withdraw_info_confirm' => 'Withdrew amount information',
        'withdraw_info_detail' => 'Withdrew amount information detail',
        'delete_modal_title' => 'Delete report',
        'delete_modal_description' => 'Report will be deleted. Are you sure?',
        'delete_modal_success' => 'Report has been deleted successfully',
        'update_modal_title' => 'Report detail update',
        'update_modal_description' => 'Report will be updated. Are you sure?',
        'update_modal_success' => 'Report has been updated successfully',
        'withdraw_modal_note' => '※You can withdraw with both Yen and crypto.',
        'send_report_title' => 'About epay report sending',
        'create_modal_title' => 'Create merchant report',
        'create_modal_description' => 'The report will be created base on selected time and merchant.<br> Is it ok?',
        'create_modal_success' => 'Report has been created successfully.',
        'validate' => [
            'merchant_required' => 'Please select merchant',
            'issue_date_from_required' => 'Please select start date.',
            'issue_date_to_required' => 'Please select end date.',
            'max_today' => 'End date cannot exceed today.',
            'max_date' => 'Please choose end date after start date.',
        ],
    ],
];