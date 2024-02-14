<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-link rule rule_epay_merchant_detail @if ($route == 'merchant') active @endif" aria-current="page"
           href="{{$route == 'merchant'? '#':route('admin_epay.merchantStore.detail',['id'=>$id])}}">
            {{ __('admin_epay.merchant.common.merchant_detail') }}
        </a>
        <a class="nav-link rule rule_epay_merchant_usage_situation @if ($route == 'usage_situation') active @endif" aria-current="page"
           href="{{$route == 'usage_situation'? '#':route('admin_epay.usageSituation.index.get',['id'=>$id])}}">
            {{ __('common.usage_situtation.usage_situation') }}
        </a>
    </div>
</nav>
