const SUBMIT_BUTTON_COMMON = $('#submit-form');
const RESULT_SUCCESS_MODEL_COMMON = $("#result-modal");
const CONFIRM_MODAL_COMMON = $("#confirm-modal");
const CHANGE_PASSWORD_FORM_COMMON = $("#change-password-form-common");
const LOADING_PAGE_COMMON = $("#loading-page");
const MIN_WITHDRAW_ELM_COMMON = $("#min-withdraw-elm-common");
const MAX_WITHDRAW_ELM_COMMON = $("#max-withdraw-elm-common");
const BALANCE_YEN_AT_WITHDRAW_PAGE_COMMON = $("#balance-yen-at-withdraw-page-common");
const BALANCE_USDT_AT_WITHDRAW_PAGE_COMMON = $("#balance-usdt-at-withdraw-page-common");
const BALANCE_USDC_AT_WITHDRAW_PAGE_COMMON = $("#balance-usdc-at-withdraw-page-common");
const BALANCE_DAI_AT_WITHDRAW_PAGE_COMMON = $("#balance-dai-at-withdraw-page-common");
const BALANCE_JPYC_AT_WITHDRAW_PAGE_COMMON = $("#balance-jpyc-at-withdraw-page-common");
let assetSelected = '';

const CHANGE_PASSWORD_MODAL_COMMON = $("#change-password-modal-common");
const CONFIRM_CHANGE_PASSWORD_MODAL_COMMON = $("#confirm-change-password-modal-common");
const SUCCESS_CHANGE_PASSWORD_MODAL_COMMON = $("#success-change-password-modal-common");
const COMMON_DATEPICKER = {
    format: 'yyyy/mm/dd',
    todayBtn: 'linked',
    language: $('html')[0].lang,
};

$.fn.datepicker.dates['ja'] = {
    days: ['日', '月', '火', '水', '木', '金', '土'],
    daysShort: ['日', '月', '火', '水', '木', '金', '土'],
    daysMin: ['日', '月', '火', '水', '木', '金', '土'],
    months: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
    monthsShort: ['1月', '2月', '3月', '4月', '5月', '6月', '7月', '8月', '9月', '10月', '11月', '12月'],
    today: "今日",
    clear: "クリア",
    weekStart: 0
};

const showChangePasswordModal = () => {
    clearChangePasswordModal();
    $(CHANGE_PASSWORD_MODAL_COMMON).modal('show');
}

const clearChangePasswordModal = () => {
    $(".error").hide();
    $("#password").removeClass('is-invalid');
    $("#password-confirmation").removeClass('is-invalid');
    $(CHANGE_PASSWORD_FORM_COMMON).trigger("reset");
}

const formatFullNumber = (number, length = 2) => {
    return String(number).padStart(length, '0'); // '0010'
}

const formatNumberInt = (number) => {
    number = Math.floor(parseFloat(number));
    let result = "";
    let numberStr = number.toString();
    for (let i = 0; i < numberStr.length; i++) {
        result += numberStr[i];
        if ((numberStr.length - i - 1) % 3 === 0 && i !== numberStr.length - 1) {
            result += ",";
        }
    }

    return result;
}

const formatNumberDecimal = (number, decimalPlaces = 2) => {
    const factor = 10 ** decimalPlaces;
    const roundedNumber = Math.floor(number * factor) / factor;

    let parts = roundedNumber.toString().split(".");
    let integerPart = parts[0];
    let decimalPart = parts[1] || "";

    let result = "";
    for (let i = integerPart.length - 1, count = 0; i >= 0; i--, count++) {
        result = integerPart.charAt(i) + result;
        if (count !== 0 && count % 3 === 2 && i !== 0) {
            result = "," + result;
        }
    }

    if (decimalPart !== "") {
        result += "." + decimalPart;
    }

    return result;
}

const formatNumberChart = (number, decimalPlaces = 3) => {
    number = (number).toFixed(decimalPlaces).replace(/\.?0+$/, '')
    return number;
}

// function processes other events
const changePassword = (url) => {
    let formData = $(CHANGE_PASSWORD_FORM_COMMON).serializeArray();
    $.ajax({
        url,
        type: 'POST',
        headers: {
            'Accept': 'application/json'
        },
        dataType: 'json',
        data: formData
    }).done(function (response) {
        if (response["status"]) {
            $(SUCCESS_CHANGE_PASSWORD_MODAL_COMMON).modal('show');
        }
    }).fail(function (err) {
        toastr.options.timeOut = 5000;
        toastr.error(PROCESS_FAILED_MSG_COMMON);
    }).always(function (xhr) {
        $(CONFIRM_CHANGE_PASSWORD_MODAL_COMMON).modal('hide');
        console.log("complete");
    });
}

const confirmChangePassword = () => {
    if ($(CHANGE_PASSWORD_FORM_COMMON).valid()) {
        $(CHANGE_PASSWORD_MODAL_COMMON).modal('hide');
        $(CONFIRM_CHANGE_PASSWORD_MODAL_COMMON).modal('show');
    }
}

const showLoadingPage = () => {
    $(LOADING_PAGE_COMMON).addClass('modal-loading');
}

const hideLoadingPage = () => {
    $(LOADING_PAGE_COMMON).removeClass('modal-loading')
}

const getLimitWithdraw = () => {
    let dataCheck = withdrawLimits.find(item => item.asset === assetSelected)

    if (dataCheck)
        return dataCheck;
    return '';
}

const renderLimitWithdraw = () => {
    let limitWithdraw = getLimitWithdraw();
    let min = limitWithdraw?.once_min_withdraw || '';
      min = formatNumberInt(min);
    let max = limitWithdraw?.once_max_withdraw || '';
       max = formatNumberInt(max);

    $(MIN_WITHDRAW_ELM_COMMON).text(min);
    $(MAX_WITHDRAW_ELM_COMMON).text(max);
}

const getBalanceSummary = (url) => {
    let formData = {}
    $.ajax({
        url: url,
        type: 'GET',
        headers: {
            'Accept': 'application/json'
        },
        dataType: 'json',
        data: formData
    }).done(function (response) {
        let data = response?.data ?? '';
        $(BALANCE_YEN_AT_WITHDRAW_PAGE_COMMON).text(data?.balanceYen || 0);
        $(BALANCE_USDT_AT_WITHDRAW_PAGE_COMMON).text(data?.balanceUSDT || 0);
        $(BALANCE_USDC_AT_WITHDRAW_PAGE_COMMON).text(data?.balanceUSDC || 0);
        $(BALANCE_DAI_AT_WITHDRAW_PAGE_COMMON).text(data?.balanceDAI || 0);
        $(BALANCE_JPYC_AT_WITHDRAW_PAGE_COMMON).text(data?.balanceJPYC || 0);
    }).fail(function (err) {
        toastr.error(PROCESS_FAILED_MSG_COMMON);
    }).always(function (xhr) {
        console.log('done');
    });
}

const formatNumber = (number) => {
    // Chuyển đổi số thành số thực
    const parsedNumber = number.toString();

    // Định dạng số theo mong muốn
    if (parsedNumber.indexOf('.') !== -1) {
        const parts = parsedNumber.split('.');
        parts[1]= parts[1].replace(/0+$/, '');
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        return parts.join('.');
    }

    // Trả về chuỗi đã được định dạng
    // 111111.111000 -> 111,111.111
    // 111111.1.11 -> 111,111,111
    return parsedNumber.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
}

$(function () {
    $('.number').on('keyup', function (event) {
        if (event.which >= 37 && event.which <= 40) return;
        if (event.which === 190)
        {
            const parts = event.target.value.split('.')
            if (parts.length > 2) $(this).val(event.target.value.slice(0, -1))
        }

        // format number
        $(this).val(function (index, value) {
            let valueChange = value.replace(/[^0-9.]/g, '');
            if (valueChange.indexOf('.') !== valueChange.lastIndexOf('.')) {
                valueChange = valueChange.replace(/\./g, '');
              }
            return formatNumber(valueChange);
        });
    });

    $.validator.addMethod("checkStringNumber", function (value) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,15}$/.test(value);
    });

    $.validator.addMethod("checkKatakana", function(value) {
        return /^[\u30A0-\u30FF]+$/.test(value);
    });

    $.validator.addMethod("checkAmount", function(value, element, options) {
        if(value.includes(","))
            value = value.replace(/,/g, '');

        let dataCheck = withdrawLimits.find(value => value.asset === assetSelected)
        if (!dataCheck) {
            $.validator.messages.checkAmount = options.db_not_found;
            return false;
        }
        if (parseFloat(dataCheck.once_min_withdraw) > parseFloat(value)) {
            $.validator.messages.checkAmount = options.min;
            return false
        }
        if (parseFloat(dataCheck.once_max_withdraw) < parseFloat(value)) {
            $.validator.messages.checkAmount = options.max;
            return false
        }
        return true;
    });

    $(document).on("click", ".nav-hover", function () {
        $(".nav-hover").removeClass('active');
        $(".nav-item").removeClass('active');
        let checkCollapsed = $(this).find("a.nav-link").hasClass("collapsed");
        if (checkCollapsed) {
            $(this).removeClass('active');
            $(this).parent().removeClass('active');
        } else {
            $(this).addClass('active');
            $(this).parent().addClass('active');
        }
    });

    if ($(window).width() <= 758) {
        $(".collapse-custom").removeClass("show")
    }
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$("#return-btn").click(function () {
    RESULT_SUCCESS_MODEL_COMMON.modal('hide')
});

const displayPDF = (pdfBase64) => {
    const pdfData = atob(pdfBase64); // Decode Base64 data
    // Load the PDF document
    const loadingTask = pdfjsLib.getDocument({ data: pdfData });

    loadingTask.promise.then((pdf) => {
        const numPages = pdf.numPages; // Get the total number of pages in the PDF
        const container = document.createElement('div');
        container.id = 'pdfContainer';

        // Function to render a page and append it to the container
        const renderPage = (pageNumber) => {
            pdf.getPage(pageNumber).then((page) => {
                const scale = 0.89;
                const viewport = page.getViewport({ scale });
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');
                canvas.height = 716;
                canvas.width = 510;

                const renderContext = {
                    canvasContext: context,
                    viewport: viewport,
                };

                // Render the page onto the canvas
                page.render(renderContext).promise.then(() => {
                    container.appendChild(canvas);
                    $('#pdfContainer').replaceWith(container);
                });
            });
        };

        // Start rendering the first page
        renderPage(1);
    });
};


// Sidebar display handle
const getToggle = localStorage.getItem("toggle");
const pageTop = document.getElementById("page-top");
const accordionSidebar = document.getElementById("accordionSidebar");
const iconToggleSideBar = document.getElementById("sidebarToggleTop");
let width = $(document).width();

if (getToggle === "sidebar-toggled" && width <= 1440) {
    pageTop.classList.add("sidebar-toggled")
    accordionSidebar.classList.add("toggled")
}
$("#page-top").removeClass('d-none');

iconToggleSideBar.onclick = function () {
    if (pageTop.classList.contains('sidebar-toggled'))
        localStorage.setItem("toggle", 'sidebar-toggled');
    else
        localStorage.setItem("toggle", '');
}
// End sidebar display handle
