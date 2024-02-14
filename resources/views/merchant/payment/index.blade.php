<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="icon" type="image/x-icon" href="/dashboard/img/favicon.svg">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/common/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/themes/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/merchant/css/payment_creen.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    @include('common.layouts.headers.head')
</head>

@php
    $userInfo = auth('merchant')->user();
@endphp

<body>
    <div id="content-wrap">
        <!-- payment index -->
        <div id="payment-index-container">
            @include('merchant.payment.top_navbar')

            <div class="content-container">
                <div class="content-description">
                    <div class="title-payment">
                        <img src="/dashboard/img/payment_logo.svg">
                        <p class="">{{ __('merchant.payment.index.title') }}</p>
                    </div>

                    {{-- box  --}}
                    <div class="box-des d-flex">
                        <p class="number-label c-green">1</p>
                        <div class="box d-flex bc-green">
                            <div class="box-text">
                                <p class="title">{{ __('merchant.payment.index.box1.title') }}</p>
                                <div class="sub">
                                    <p>{{ __('merchant.payment.index.box1.content1') }}</p>
                                    <p class="font-12">{{ __('merchant.payment.index.box1.content2') }}</p>
                                    <p class="font-12">{{ __('merchant.payment.index.box1.content3') }}</p>
                                </div>
                            </div>
                            <div class="icon-box d-flex align-items-end">
                                <img class="" src="/dashboard/img/calculator.svg">
                            </div>
                        </div>

                    </div>

                    <div class="triangle bt-green"></div>

                    <div class="box-des d-flex">
                        <p class="number-label c-yellow">2</p>
                        <div class="box d-flex bc-yellow">
                            <div class="box-text">
                                <p class="title">{{ __('merchant.payment.index.box2.title') }}</p>
                                <div class="sub">
                                    <p>{{ __('merchant.payment.index.box2.content1') }}</p>
                                    <p>{{ __('merchant.payment.index.box2.content2') }}</p>
                                    <p>{{ __('merchant.payment.index.box2.content3') }}</p>
                                </div>
                            </div>
                            <div class="icon-box d-flex align-items-end">
                                <img class="" src="/dashboard/img/qr_code.svg">
                            </div>
                        </div>

                    </div>

                    <div class="triangle bt-yellow "></div>

                    <div class="box-des d-flex">
                        <p class="number-label c-blue">3</p>
                        <div class="box d-flex bc-blue">
                            <div class="box-text speech-custom">
                                <p class="title">{{ __('merchant.payment.index.box3.title') }}</p>
                                <div class="sub">
                                    <p>{{ __('merchant.payment.index.box3.content1') }}</p>
                                    <p class="font-12">{{ __('merchant.payment.index.box3.content2') }}</p>
                                    <p class="font-12">{{ __('merchant.payment.index.box3.content3') }}</p>
                                    <p class="font-12">{{ __('merchant.payment.index.box3.content4') }}</p>
                                    <p class="font-12">{{ __('merchant.payment.index.box3.content5') }}</p>
                                </div>
                            </div>
                            <div class="icon-box d-flex align-items-end">
                                <img class="" src="/dashboard/img/speech_bubble.svg">
                            </div>
                        </div>

                    </div>

                    <div class="d-flex justify-content-around">
                        <a href="{{ route('merchant.dashboard.index.get') }}">
                            <button class="back-btn">{{ __('merchant.payment.index.back') }}</button>
                        </a>
                        <button class="back-btn" id="qr-display">{{ __('merchant.payment.index.QR_display') }}</button>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade common-modal common-modal-confirm" id="showData" aria-hidden="true"
                    aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body confirmm">
                                <h1 class="modal-title title">
                                    {{ __('merchant.payment.index.QR_title') }}
                                </h1>
                                <div class="d-flex justify-content-center mt-20 mb-30" id="qr-code-merchant"></div>
                                <div class="modalFooter btn-confirm">
                                    <button type="button" class="btn btn-secondary btn-yes" data-bs-dismiss="modal"
                                        data-dismiss="modal"
                                        id="return-btn">{{ __('merchant.payment.index.close') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="calculation">
                    <div class="content-cal">
                        <p>{{ __('merchant.payment.index.amont_title') }}</p>
                        <form class="form-submit" id="create-payment">
                            @csrf
                            <div class="d-flex justify-content-center">
                                <span class="lable-yen">¥</span>
                                <input class="form-control number" type="text" name="amount_display" value=''
                                    id="amount_display" />
                                <input type="hidden" name="amount" value='' id="amount" />
                            </div>
                            <div class="keyboard">
                                <div class="row">
                                    <button class="numeric-keyboard" type="button">1</button>
                                    <button type="button" class="ml-20 mr-20 numeric-keyboard">2</button>
                                    <button class="numeric-keyboard" type="button">3</button>
                                </div>
                                <div class="row">
                                    <button class="numeric-keyboard" type="button">4</button>
                                    <button type="button" class="ml-20 mr-20 numeric-keyboard">5</button>
                                    <button class="numeric-keyboard" type="button">6</button>
                                </div>
                                <div class="row">
                                    <button class="numeric-keyboard" type="button">7</button>
                                    <button type="button" class="ml-20 mr-20 numeric-keyboard">8</button>
                                    <button class="numeric-keyboard" type="button">9</button>
                                </div>
                                <div class="row">
                                    <button class="numeric-keyboard" type="button">0</button>
                                    <button type="button" class="ml-20 mr-20 numeric-keyboard">00</button>
                                    <button class="numeric-keyboard" type="button">000</button>
                                </div>
                                <div class="row mb-0">
                                    <button type="button" class="ml-20 mr-20"
                                        onclick="deleteAllAmount()">AC</button>
                                    <button type="button" onclick="deleteANumer()"><img
                                            src="/dashboard/img/keyboard_delete.svg"></button>
                                </div>
                            </div>
                            <button class="submit-btn"
                                type="button">{{ __('merchant.payment.index.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- payment detail -->
        <div id="payment-detail-container" class="d-none">
            <div class="qr-detail-wrapper">
                <div class="qr-detail">
                    <div class="title">
                        <img src="/dashboard/img/payment_logo.svg">
                    </div>
                    <div class="content">
                        <p class="title-content">{{ __('merchant.payment.qr.title') }}</p>
                        <p class="amount-total"></p>
                        <p class="des">{{ __('merchant.payment.qr.description') }}</p>
                        <div id="qr-code-img"></div>
                        <div class="rotate-screen" onclick="getRotateScreen()">
                            <img src="/dashboard/img/rotate_screen.svg">
                        </div>
                    </div>
                </div>
                <div class="qr-footer">
                    <div class="qr-footer-wrapper">
                        <p>{{ __('merchant.payment.qr.note') }}</p>
                        <div class="btn-wrapper">
                            <button class="confirm-btn" type="button"
                                onclick="getBackPaymentScreen()">{{ __('merchant.payment.qr.back') }}</button>
                            <a href="{{ route('merchant.payment.index.get') }}">
                                <button class="return-btn"
                                    type="button">{{ __('merchant.payment.qr.submit') }}</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('common.layouts.footers.copyright')

    <!-- footer -->
    @include('common.layouts.footers.foot')

    <script type="text/javascript">
        const PAYMENT_INDEX_CONTAINER = $('#payment-index-container');
        const PAYMENT_DETAIL_CONTAINER = $('#payment-detail-container');
        const QR_CODE_IMG = $("#qr-code-img");
        const QR_CODE_MERCHANT = $("#qr-code-merchant");
        const AMOUNT_INPUT = $("#amount_display");
        const CREATE_PAYMENT_FORM = $('#create-payment');
        const SUBMIT_BUTTON = $('.submit-btn');

        $('#qr-display').on('click', function() {
            const url = '{{ $userInfo->getMerchantStore->payment_url }}';
            if (url == '') {
                toastr.error("{{ __('merchant.payment.index.not_QR') }}");
            } else {
                $('#showData').modal('show');
            }
        });

        QR_CODE_MERCHANT.empty();
        QR_CODE_MERCHANT.qrcode({
            text: '{{ $userInfo->getMerchantStore->payment_url }}',
            size: 250,
            mode: 0,
            render: 'canvas',
        });

        function getRotateScreen() {
            $('.qr-detail').toggleClass('rotate-wrapper');
            $('.rotate-screen').toggleClass('fix-position');
        };

        $('.numeric-keyboard').on('click', function() {
            var value = AMOUNT_INPUT.val().replace(/,/g, '') + $(this).text();
            AMOUNT_INPUT.val(formatNumber(value));
        });

        function deleteAllAmount() {
            AMOUNT_INPUT.val('');
        };

        function deleteANumer() {
            var value = AMOUNT_INPUT.val().replace(/,/g, '').slice(0, -1);
            AMOUNT_INPUT.val(formatNumber(value));
        };

        function getBackPaymentScreen() {
            PAYMENT_INDEX_CONTAINER.removeClass('d-none')
            PAYMENT_DETAIL_CONTAINER.addClass('d-none');
            SUBMIT_BUTTON.prop("disabled", false);
        };

        SUBMIT_BUTTON.on('click', function() {
            var amount = $('.number').val().replace(/,/g, '');
            $('#amount').val(amount);
            if (amount > 100000000) {
                toastr.error('1億以下を入力して下さい。');
            } else if (amount < 0.000001) {
                toastr.error('0.000001￥以上を入力して下さい');
            } else {
                $(this).prop("disabled", true);
                let formData = CREATE_PAYMENT_FORM.serializeArray();

                $.ajax({
                    url: "{{ route('merchant.payment.create.post') }}",
                    type: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    dataType: 'json',
                    data: formData
                }).done(function(response) {
                    console.log("true");
                    if (response['url']) {
                        PAYMENT_INDEX_CONTAINER.addClass('d-none')
                        PAYMENT_DETAIL_CONTAINER.removeClass('d-none');
                        $('.amount-total').text('¥' + $('.number').val());

                        QR_CODE_IMG.empty();
                        QR_CODE_IMG.qrcode({
                            text: response['url'],
                            size: 250,
                            mode: 0,
                            render: 'canvas',
                        });
                    }
                }).fail(function(err) {
                    SUBMIT_BUTTON.prop("disabled", false);
                    console.log("false");
                    if (err.status == 400) {
                        let msg = err?.responseJSON?.message;
                        toastr.error(msg);
                    } else {
                        toastr.error("{{ __('common.error.process_failed') }}");
                    }
                });
            }
        });
    </script>
</body>

</html>
