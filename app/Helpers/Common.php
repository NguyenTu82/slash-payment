<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Enums\WithdrawRequestMethod;
use App\Enums\WithdrawMethod;
use App\Enums\WithdrawStatus;
use App\Enums\EpayReportStatus;

if (!function_exists('activeMenuSidebar')) {
    /**
     * @param $route
     * @return string|void
     */
    function activeMenuSidebar($route)
    {
        $currentRoute = Route::currentRouteName();
        $class = '';
        if ($route === $currentRoute) {
            $class = 'active';
        }

        return $class;
    }
}

if (!function_exists('convertTimeJapan')) {
    /**
     * @param $route
     * @return string|void
     */
    function convertTimeJapan($dateString)
    {
        if (is_null($dateString))
            return '';

        $dateTime = new DateTime($dateString);
        return $dateTime->format('Y/m/d H:i');
    }
}

if (!function_exists('getPopupInfo')) {
    function getPopupInfo($key): array
    {
        $lists = [
            'create_merchant_user_success' => [
                'title' => __('common.account_management.title_result_modal_create'),
                'description' => __('common.account_management.description_result_modal_create'),
            ],
            'delete_merchant_user_success' => [
                'title' => __('common.account_management.title_result_modal_delete'),
                'description' => __('common.account_management.description_result_modal_delete')
            ],
            'update_merchant_user_success' => [
                'title' => __('common.account_management.title_result_modal_update'),
                'description' => __('common.account_management.description_result_modal_update')
            ],
            'change_password_account_success' => [
                'title' => __('common.setting.profile.change_pw_title'),
                'description' => __('common.setting.profile.change_pw_successful')
            ],
            'delete_merchant_notification_success' => [
                'title' => __('merchant.notification.title_modal_delete_success'),
                'description' => __('merchant.notification.description_delete_success')
            ],
            'create_merchant_success' => [
                'title' => __('admin_epay.merchant.common.create_merchant_success'),
                'description' => __('admin_epay.merchant.common.create_merchant_success_description')
            ],
            'update_merchant_success' => [
                'title' => __('admin_epay.merchant.common.update_merchant_success'),
                'description' => __('admin_epay.merchant.common.update_merchant_success_description')
            ],
            'delete_merchant_success' => [
                'title' => __('admin_epay.merchant.common.title_confirm_modal_delete'),
                'description' => __('admin_epay.merchant.common.delete_merchant_success_description')
            ],
            'create_notification_to_merchant_success' => [
                'title' => __('admin_epay.notifications.common.title_confirm_successfully_send_noti'),
                'description' => __('admin_epay.notifications.common.content_confirm_successfully_send_noti')
            ],
            'update_notification_to_merchant_success' => [
                'title' => __('admin_epay.notifications.common.title_confirm_update_successfully_send_noti'),
                'description' => __('admin_epay.notifications.common.content_confirm_update_successfully_send_noti')
            ],
            'delete_notification_to_merchant_success' => [
                'title' => __('admin_epay.notifications.common.title_confirm_delete_successfully_send_noti'),
                'description' => __('admin_epay.notifications.common.content_confirm_delete_successfully_send_noti')
            ],
            'update_notification_template_success' => [
                'title' => __('common.notification.title_result_modal_update'),
                'description' => __('common.notification.description_result_modal_update')
            ],
            'merchant_create_request_withdraw_success' => [
                'title' => __('merchant.withdraw.create_request_title_success'),
                'description' => __('merchant.withdraw.create_request_des_success')
            ],
            'merchant_update_withdraw_success' => [
                'title' => __('merchant.withdraw.update_title_success'),
                'description' => __('merchant.withdraw.update_des_success')
            ],
            'merchant_delete_withdraw_success' => [
                'title' => __('merchant.withdraw.delete_title_success'),
                'description' => __('merchant.withdraw.delete_des_success')
            ],
            'update_withdraw_success' => [
                'title' => __('merchant.withdraw.title_update'),
                'description' => __('merchant.withdraw.description_update_success')
            ],
            'approve_withdraw_bank_success' => [
                'title' => __('merchant.withdraw.title_approve'),
                'description' => __('merchant.withdraw.description_approve_success')
            ],
            'approve_withdraw_cash_crypto_success' => [
                'title' => __('merchant.withdraw.title_approve'),
                'description' => __('merchant.withdraw.description_approve_cash_crypto_success')
            ],
            'delete_withdraw_success' => [
                'title' => __('merchant.withdraw.title_delete'),
                'description' => __('merchant.withdraw.description_delete_success')
            ],
            'delete_report_success' => [
                'title' => __('admin_epay.report.delete_modal_title'),
                'description' => __('admin_epay.report.delete_modal_success')
            ],
            'update_report_success' => [
                'title' => __('admin_epay.report.update_modal_title'),
                'description' => __('admin_epay.report.update_modal_success')
            ],
            'withdraw_decline_success' => [
                'title' => __('merchant.withdraw.title_decline'),
                'description' => __('merchant.withdraw.description_decline_success')
            ],
            'create_report_success' => [
                'title' => __('admin_epay.report.create_modal_title'),
                'description' => __('admin_epay.report.create_modal_success')
            ],
            'send_report_success' => [
                'title' => __('admin_epay.report.send_mail_modal_title'),
                'description' => __('admin_epay.report.send_mail_modal_success')
            ],
        ];

        return $lists[$key];
    }
}

if (!function_exists('formatAccountId')) {
    function formatAccountId($id): string
    {
        return str_pad($id, 6, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('subString')) {
    function subString($content, $length): string
    {
        if ($content === null) {
            return '';
        }

        return Str::limit($content, $length, '...');
    }
}

if (! function_exists('formatDateHour')) {
    function formatDateHour($date): string
    {
        if($date)
            return Carbon::parse($date)->format('Y年m月d日 H:i');
        return "-";
    }
}

if (! function_exists('formatDateSimple')) {
    function formatDateSimple($date): string
    {
        return Carbon::parse($date)->format('Y-m-d');
    }
}

if (! function_exists('getWithdrawMethod')) {
    function getWithdrawMethod($method): string
    {
        return match ($method) {
            WithdrawMethod::CASH->value => __('common.withdraw_management.cash'),
            WithdrawMethod::BANKING->value => __('common.withdraw_management.banking'),
            WithdrawMethod::CRYPTO->value => __('common.withdraw_management.crypto'),
            default => '-',
        };
    }
}

if (! function_exists('getWithdrawRequestMethod')) {
    function getWithdrawRequestMethod($method): string
    {
        return match ($method) {
            WithdrawRequestMethod::AUTO->value => __('common.withdraw_management.withdraw_auto'),
            WithdrawRequestMethod::REQUEST_EPAY->value => __('common.withdraw_management.withdraw_request_epay'),
            WithdrawRequestMethod::REQUEST_MERCHANT->value => __('common.withdraw_management.withdraw_request_merchant'),
            default => '-',
        };
    }
}

if (! function_exists('getWithdrawStatus')) {
    function getWithdrawStatus($status): array
    {
        $segment = request()->segment(1);

        return match ($status) {
            WithdrawStatus::WAITING_APPROVE->value => [
                'label' => __('common.withdraw_management.waiting_approve'), 'class' => 'unsettled',
            ],
            WithdrawStatus::DENIED->value => [
                'label' => __('common.withdraw_management.denied'), 'class' => 'fail',
            ],
            WithdrawStatus::SUCCEEDED->value => [
                'label' => __('common.withdraw_management.succeeded'), 'class' => 'completion',
            ],
            default => [
                'label' => '-', 'class' => '',
            ],
        };
    }
}

if (! function_exists('getReportStatus')) {
    function getReportStatus($status): array
    {
        return match ($status) {
            EpayReportStatus::UNSEND->value => [
                'label' => __('admin_epay.report.status_type.un_send'), 'class' => 'fail',
            ],
            EpayReportStatus::SENT->value => [
                'label' => __('admin_epay.report.status_type.sent'), 'class' => 'completion',
            ],
            default => [
                'label' => '-', 'class' => '',
            ],
        };
    }
}

if (!function_exists('formatNumber')) {
    function formatNumber($number, $decimal = 2): string
    {
        return number_format((float) $number, $decimal, '.', ',');
    }
}


if (!function_exists('formatNumberInt')) {
    function formatNumberInt($number): string
    {
        $roundedNumber = floor($number);
        return number_format($roundedNumber, 0, '.', ',');
    }
}

if (!function_exists('formatNumberDecimal')) {
    function formatNumberDecimal($number, $decimal = 2): string
    {
        $roundedNumber = floor($number * pow(10, $decimal)) / pow(10, $decimal);
        $formattedNumber = number_format($roundedNumber, $decimal, '.', ',');
        $trimmedNumber = rtrim($formattedNumber, '0');

        if (str_ends_with($trimmedNumber, '.')) {
            $trimmedNumber = rtrim($trimmedNumber, '.');
        }

        return $trimmedNumber;
    }
}


if (!function_exists('formatFullNumber')) {
    function formatFullNumber($number, $length = 2): string
    {
        return str_pad($number, $length, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('getDayName')) {
    function getDayName($day): string
    {
        return match ($day) {
            'Mon' => __('common.days.mon'),
            'Tue' => __('common.days.tue'),
            'Wed' => __('common.days.wed'),
            'Thu' => __('common.days.thu'),
            'Fri' => __('common.days.fri'),
            'Sat' => __('common.days.sat'),
            'Sun' => __('common.days.sun'),
            default => '',
        };
    }
}

if (!function_exists('getPlaceholderOfDate')) {
    function getPlaceholderOfDate(): string
    {
        if (app()->getLocale() == 'ja')
            return '年/月/日';
        return 'Y/m/d';
    }
}

if (!function_exists('getColumnTableOfDatetime')) {
    function getColumnTableOfDatetime(): string
    {
        if (app()->getLocale() == 'ja')
            return 'Y年n月j日 H:i';
        return 'Y/m/d  H:i';
    }
}


if (!function_exists('isLangJapanese')) {
    function isLangJapanese(): string
    {
        if (app()->getLocale() == 'ja') {
            return true;
        }

        return false;
    }
}

if (!function_exists('formatContent')) {
    function formatContent($valueReplace, $content)
    {
        foreach ($valueReplace as $key => $value) {
            $content = str_replace('{{'.$key.'}}', $value, $content);
        }

        return $content;
    }
}

if (!function_exists('formatDateTimeJapan')) {
    function formatDateTimeJapan($date): string
    {
        if (is_null($date))
            return '';

        return Carbon::parse($date)->format('Y年m月d日 H時i分');
    }
}

