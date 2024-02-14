<?php

return [
    'messages' => [
    ],
    'admin' => [
        'title' => 'Account management',
        'list' => 'Account list',
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
            'payment_profile' => 'Payment profile',
            'stores' => 'Merchants',
            'url' => 'Payment URL',
            'choose_store' => 'Select',
            'download_qr' => 'Download',
            'store_detail' => 'Merchant Detail',
            'not_QR' => 'Not configured',
            'merchant_detail_popup_title' => 'Profile screen > Member store details information',
            'validation' => [
                'name' => [
                    'required' => 'Please enter your account name',
                ],
                'role' => [
                    'required' => 'Please select a role',
                ],
                'email' => [
                    'required' => 'Please enter your email address',
                    'invalid' => 'Email address is invalid.',
                ],
                'account_id' => [
                    'required' => 'Please enter your account ID',
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
            'search_name' => 'Account id, name, email',
            'create_account' => 'Create account',
            'default_select' => 'Select',

        ],
        'account_init_setting' => [
            'payment_cycle' => [
                'des1' => 'Regarding the payment cycle',
                'des2' => 'The default payment cycle is month-end payment.',
                'des3' => 'Other cycles available include weekly payments and 3-day payments. Please contact us if you wish to do so.',
            ],
            'withdraw_method' => [
                'des1' => 'Regarding payment methods',
                'des2' => "As for the payment method to your company, you can usually choose ``bank transfer'' or ``virtual currency transmission''.",
                'des3' => 'Please register in advance.',
                'des4' => 'In the case of virtual currency, please be especially careful not to enter the wrong address.',
            ],
            'delivery_report' => [
                'des1' => 'Regarding delivery reports',
                'des2' => 'You can register up to 3 email addresses in the delivery report.',
            ],
            'guidance_email' => [
                'des1' => 'Regarding information emails',
                'des2' => 'Unlike distribution reports, this is a function that sends campaign information, etc.',
            ],
            'ship_post_code_id' => [
                'des1' => 'Regarding sending details',
                'des2' => 'If you wish to receive a statement, the default is the end of the month.',
                'des3' => 'The account name will also be used to address the shipping address.',
            ],
        ],
    ],
    'notification' => [
        'title' => 'Notification Management',
        'title_page' => 'Notification list',
        'title_noti_detail' => 'Notification detail',
        'title_confirm_modal_delete' => 'Confirm delete notification',
        'title_modal_delete_success' => 'Notification deletion',
        'description_confirm_modal_delete' => 'This notification will be deleted. Is it OK?',
        'description_delete_success' => 'Notification has been deleted successfully',
        'noti' => [
            'noti_type' => 'Notification type',
            'merchant' => 'Merchant',
            'status' => 'Status',
            'title' => 'Title',
            'content' => 'Content',
            'select_all' => 'Select all',
            'read' => 'Read',
            'unread' => 'Unread',
            'type_withdraw' => 'Payment notification',
            'send_date' => 'Received date',
            'send_day' => 'Received date',
            'type_other_noti' => 'Notification from epay',
            'detail' => 'Detail',
            'search' => 'Search',
            'reset' => 'Reset',

        ],
    ],
    'withdraw' => [
        'withdrawal_history_detail' => 'Payment history Detail',
        'withdrawal_history_edit' => 'Payment history Edit',
        'transaction_id' => 'Transaction ID',
        'request_id' => 'Request ID',
        'merchant' => 'Merchant ',
        'financial_institution_name' => 'Financial Institution Name',
        'member_id_code' => 'Member ID code',
        'request_date' => 'Request date',
        'content' => 'Content',
        'publisher' => 'Publisher',
        'status' => 'Status',
        'payment_information' => 'Payment information',
        'currency_type' => 'Currency type',
        'withdrawal_amount' => 'Payment amount',
        'withdrawal_processing_date' => 'Payment processing date',
        'payee_information_display' => 'Display payment information',
        'payment_request' => 'Payment request',
        'create_request' => 'Create request',
        'store' => 'Merchant',
        'date' => 'Date',
        'member_code' => 'Member code',
        'note' => 'Memo',
        'payment_info' => 'Payment info',
        'amount' => 'Amount',
        'payment_info_banking' => 'Payment info banking',
        'payment_info_crypto' => 'Payment info crypto',
        'finance_name' => 'Bank name',
        'branch' => 'Branch',
        'account_type' => 'Account type',
        'account_holder' => 'Account holder',
        'bank_code' => 'Bank code',
        'branch_code' => 'Branch code',
        'account_number' => 'Account number',
        'wallet_address' => 'Wallet address',
        'network' => 'network',
        'create_request_title_confirm' => 'Submit a payment request',
        'create_request_des_confirm' => 'Submit a payment request. Is it OK?',
        'create_request_title_success' => 'Create request title success',
        'create_request_des_success' => 'Create request des success',

        'update_title_confirm' => 'Update title confirm',
        'update_des_confirm' => 'Update des confirm',
        'update_title_success' => 'Update title success',
        'update_des_success' => 'Update des success',

        'delete_title_confirm' => 'Delete title confirm',
        'delete_des_confirm' => 'Delete des confirm',
        'delete_title_success' => 'Delete title success',
        'delete_des_success' => 'Delete des success',

        'payment_crypto' => [
            'title' => 'Payment Information（Crypto）',
            'network' => 'Network',
            'wallet_address' => 'Wallet address',
            'note' => 'Note',
        ],
        'request_method' => [
            'auto' => 'auto',
            'manual' => 'manual',
        ],
        'withdraw_status' => [
            'waiting_approve' => 'waiting to approve',
            'tgw_waiting_approve' => 'TGW waiting to approve',
            'denied' => 'denied',
            'succeeded' => 'succeeded',
        ],
        'withdraw_method' => [
            'cash' => 'Cash',
            'banking' => 'Banking',
            'crypto' => 'Crypto Currency',
        ],
        "bank_account_type" => [
            'usually' => 'Saving',
            'regular' => 'Time Deposit',
            'current' => 'Checking'
        ],
        'withdraw_request_method' => [
            'manual' => 'manual',
            'auto' => 'auto',
        ],

        'validation' => [
            'bank_code' => [
                'non_exist' => 'Bank code code not exist. ',
                'required' => 'bank_code required',
            ],
            'financial_institution_name' => [
                'required' => 'financial_institution_name required',
            ],
            'branch_code' => [
                'non_exist' => 'Branch code code not exist. ',
                'required' => 'branch_code required',
            ],
            'branch_name' => [
                'required' => 'branch_name required',
            ],
            'bank_account_type' => [
            ],
            'bank_account_number' => [
                'required' => 'bank_account_number required',
            ],
            'bank_account_holder' => [
                'required' => 'bank_account_holder required',
            ],
            'amount' => [
                'required' => 'amount required',
                'max' => 'If the amount exceeds {10}JPY, please divide it into multiple payment.'
            ],
            'wallet_address' => [
                'required' => 'wallet address required',
            ],
            'network' => [
                'required' => 'wallet address required',
            ],
            'merchant_select' => [
                'required' => 'Please select a member store',
            ],
        ],
        'title_approve' => 'Approve withdrawal request',
        'description_approve_bank' => 'If you approve the withdrawal request, the withdrawal request will be sent to the Lion gateway. Is it OK?',
        'description_approve_cash_crypto' => 'If you approve a withdrawal request, we will acknowledge the withdrawal request to completion. Is it OK?',
        'title_update' => 'Edit withdrawal details',
        'description_update' => 'Edit withdrawal request. Is it OK?',
        'description_approve_success' => 'Your withdrawal request has been approved. Withdrawal request sent to Lion gateway. Please check with Lion Gateway. ',
        'description_update_success' => 'You have successfully edited your withdrawal request. ',
        'description_approve_cash_crypto_success' => 'Withdrawal request completed.',
        'title_delete' => 'Delete withdrawal details',
        'description_delete' => 'Delete withdrawal data. Is it OK?',
        'description_delete_success' => 'Deletion of withdrawal data completed. ',
        'over_amount' => 'Your current balance is insufficient. Please try again.',
        'title_decline' => 'Decline withdrawal request',
        'description_decline' => 'Decline the withdrawal request. Is it OK?',
        'description_decline_success' => 'The withdrawal request has been declined successfully.',
    ],
    'status' => [
        'title' => 'Usage status confirmation',
        'print' => 'Print',
        'title_PDF' => 'Usage details preview',
    ],
    'payment' => [
        'index' => [
            'title' => 'Flow of payment from member stores',
            'box1' => [
                'title' => 'Input and confirm billing amount',
                'content1' => '【Notes】',
                'content2' => '・Consumption tax etc. are not automatically calculated.',
                'content3' => '・Only Japanese yen is accepted.',
            ],
            'box2' => [
                'title' => 'Show QR code',
                'content1' => 'The billed amount and QR code will be displayed.',
                'content2' => 'After confirming that the billed amount is correct, please present the QR code to the customer.',
                'content3' => 'If the amount is different, click the "Back" button and enter it again.',
            ],
            'box3' => [
                'title' => 'Confirm payment',
                'content1' => 'After confirming that the customer has made the payment, click "Confirmed" to complete the payment.',
                'content2' => '【Notes】',
                'content3' => '・Please be sure to confirm that "Transaction Submitted" is displayed on the payment screen.',
                'content4' => '・It may take several seconds to several minutes to complete the payment.',
                'content5' => '・If your internet environment is poor, it may take longer than usual to complete.',
            ],
            'back' => 'Return to main menu',
            'amont_title' => 'Billed amount',
            'submit' => 'Confirm',
            'QR_display' => 'QR code display',
            'QR_title' => 'QR code for payment',
            'close' => 'Close',
            'not_QR' => "The member store's QR payment URL has not been set yet. Please contact your epay administrator.",
        ],
        'qr' => [
            'title' => 'Billed amount',
            'description' => 'Scan the QR code and complete the payment.',
            'note' => 'After confirming the payment is complete, please press the button.',
            'back' => 'Go back',
            'submit' => 'Confirmed',
        ],
    ]
];
