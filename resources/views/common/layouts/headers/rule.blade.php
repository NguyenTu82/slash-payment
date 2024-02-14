<style>
    .rule{
        display: none !important;
    }
</style>
<!-- rule_{epay||merchant}_{screen}_{action} -->
@can('epay_all_role')
    <style>
        .rule_epay_dashboard,
        .rule_epay_merchant,.rule_epay_merchant_list,.rule_epay_merchant_create,.rule_epay_merchant_detail, .rule_epay_merchant_edit,.rule_epay_merchant_delete,.rule_epay_merchant_report,.rule_epay_merchant_usage_situation,
        .rule_epay_af,.rule_epay_af_create,.rule_epay_af_list,
        .rule_epay_withdraw,.rule_epay_withdraw_create,.rule_epay_withdraw_detail,.rule_epay_withdraw_edit,.rule_epay_withdraw_delete,.rule_epay_withdraw_list,
        .rule_epay_setting
        {
            display: block !important;
        }
    </style>
@endcan
@can('epay_admin')
    <style>
        .rule_epay_notification,.rule_epay_notification_list,.rule_epay_notification_create,.rule_epay_notification_detail,.rule_epay_notification_edit,.rule_epay_notification_delete, .rule_epay_notification_system,
        .rule_epay_account_list,.rule_epay_account_create,.rule_epay_account_detail,.rule_epay_account_delete,.rule_epay_account_edit{
            display: block !important;
        }
    </style>
@endcan

@can('merchant_all_role')
    <style>
        .rule_merchant_dashboard,
        .rule_merchant_usage_situation,.rule_merchant_usage_situation_list,.rule_merchant_usage_situation_detail,.rule_merchant_usage_situation_delete,
        .rule_merchant_notification,.rule_merchant_notification_list,.rule_merchant_notification_create,.rule_merchant_notification_edit,.rule_merchant_notification_delete, .rule_merchant_notification_detail,
        .rule_merchant_setting,.rule_merchant_profile,.rule_merchant_profile_edit
        {
            display: block !important;
        }
    </style>
@endcan

@can('merchant_admin_operator')
    <style>
        .rule_merchant_withdraw,.rule_merchant_withdraw_create,.rule_merchant_withdraw_list,.rule_merchant_withdraw_detail,.rule_merchant_withdraw_edit,.rule_merchant_withdraw_delete,
        .rule_merchant_account, .rule_merchant_account_list,.rule_merchant_account_create,.rule_merchant_account_detail,.rule_merchant_account_delete,.rule_merchant_account_edit
        {
            display: block !important;
        }
    </style>
@endcan

@can('merchant_admin')
    <style>
        .rule_merchant_account_init_setting_edit
        {
            display: block !important;
        }
    </style>
@endcan