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

    'failed' => 'Email address or password is invalid. please confirm again.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',

    // message common
    'common' => [
        'login' => [
            'remember_me' => 'Remember me',
            'forgot_password' => 'Forgot password',
            'password' => 'Password',
            'email_placeholder' => 'example@gmail.com',
            'password_placeholder' => 'Please enter your password',
            'login-display' => 'Login screen',
            'email' => 'Registered email address',
            'register' => 'Register',
            'forget-home' => 'Homepage',
            'forget-store' => 'Agencies wanted',
            'title1' => 'GLOBAL POTENTIAL FOR YOUR BUSINESS',
            'title2' => 'International business payments',
            'title3' => '・Compatible with more than 1400 types of tokens.',
            'title4' => '・Payment supports a wide range of methods such as bank banking/cash/virtual currency.',
            'title5' => '・Full support 24 hours a day, 365 days a year.',
            'not_correct' => 'Password is invalid. please confirm again.',
            'email_not_correct' => 'Email address is invalid. please confirm again.',
            'login' => 'Login',
            'back' => 'Go back',
            'invalid_email' => 'You cannot log in because your account is invalid.',
            'invalid_email_merchant' => 'Your account has been disabled, please contact your administrator.',
        ],
        'forgot_password' => [
            'title' => 'Resetting a password',
            'title_done' => 'Password reset completed',
            'label_email' => 'Mail address',
            'placeholder_email' => 'Please enter your email address',
            'submit' => 'Send',
            'forgot_success_label' => 'Password reset.',
            'forgot_success_button' => 'Back to login screen',
            'new_pass' => 'New Password',
            'new_pass_placeholder' => 'Please enter your password',
            'pass_confirm' => 'New password confirmation',
            'pass_confirm_placeholder' => 'Please enter your password again',
            'save_pass' => 'Setting',
            'password_required' => 'Please enter your password',
            'password_min_length' => 'Please enter at least 8 characters including half-width alphabets and numbers',
            'password_check_string_number' => 'Please enter a password consisting of alphanumeric characters',
            'password_confirm_min_length' => 'Password confirmation must be at least 8 characters',
            'password_confirm_equa_to' => 'Confirm password must match password',
            'password_same' => 'Passwords do not match',
            'resetting_password_confirm_0' => 'Password reset application acceptance completed',
            'resetting_password_confirm_1' => 'We have received your password reset request.',
            'resetting_password_confirm_2' => 'If the information you entered matches, an email will be sent to you with instructions on how to reset your password. Please follow the instructions in the email.',
            'resetting_password_confirm_3' => '* If the entered information does not match, the guidance email will not be sent.',
            'resetting_password_confirm_4' => '*The e-mail address will be sent from "●●●@●●".',
            'resetting_password_confirm_5' => 'Please make domain designation settings and reception settings so that it will not be excluded as spam.',
            'resetting_password_confirm_6' => '*Emails are sent immediately, but it may take some time to send and receive depending on the network conditions.',
            'resetting_password_success' => 'Password change completed.',
            'title1' => 'Enter the e-mail address you registered with epay and click the "Send" button. We will send you an email with instructions on how to reset your password.',
            'title2' => '*The e-mail address will be sent from "●●●@●●".',
            'title3' => 'Please make domain designation settings and reception settings so that it will not be excluded as spam.',
        ],
        'change_password' => [
            'change_password_tittle' => 'Password change',
            'new_pass' => 'New Password',
            'new_pass_validate' => 'Please set within 6 to 15 characters including uppercase letters and alphanumeric characters',
            'pass_confirm' => 'Password confirmation',
            'pass_confirm_validate' => 'Password and password (confirm) are different.',
            'close_button' => 'Cancel',
            'save_button' => 'Change',
        ],
        'two_fa' => [
            'phone_number' => 'Phone number',
            'send_sms_token' => 'Send authentication message',
            'back_login' => 'Back to login screen',
            'phone_placeholder' => 'Please enter your phone number',
            'resetting_password' => 'Password reset application',
            'email_address' => 'Registered email address',
            'password_new' => 'New Password',
            'password_confirm' => 'New password confirmation',
            'admin_account_registration' => 'Account registration',
            'verify_required' => 'Please enter your password',
            're_verify_required'=> 'Please confirm your password.',
            're_new_verify_required' => 'Please confirm your new password',
            'register_button' => 'Setting',
            're_enter_password' => 'For password confirmation',
            're_enter_password_placeholder' => 'Please enter your password again',
            'title_verify_success' => 'Admin account registration',
            'content_verify_success' => 'Your account has been registered',
            'create_account' => 'Account registration',
            'send' => 'Send',
            'token' => 'Authentication code',
            'verify_check_string' => 'The password format is incorrect.',
            'verify_equal_to' => 'Password and password (confirm) are different.',
        ],
        'modal' => [
            'confirm_modal_description' => 'Change your password. Is it OK?',
            'result_modal_description' => 'You have successfully changed your password.',
            'return_btn' => 'Go back',
        ],
        'register' => [
            'title' => 'Register',
            'terms_of_service' => ' the terms of service',
            'and' => ' and',
            'privacy_policy' => ' privacy policy',
            'agree' => 'I agree to',
            'submit' => 'Registration',
            'confirm_register_title' => 'Temporary registration application accepted',
            'confirm_register_des1' => 'Applications for temporary registration have been accepted. The epay side will conduct the review.',
            'confirm_register_des2' => 'Please note that it may take some time to complete the review. An email will be sent to the email address you entered to inform you that temporary registration has been completed, so please follow the instructions in the email.',
            'success_register_title' => 'New registration completed',
            'success_register_des' => 'Registration has been completed.',
        ],
    ],
    //  message for admin_epay
    'admin_epay' => [
        'reset_password' => 'epay login password reset guide',
    ],
    //  message for merchant
    'merchant' => [
        'reset_password' => 'how to recover epay login password Merchant',
    ],
    //  message for affiliate
    'affiliate' => [
    ],
];
