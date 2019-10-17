@extends('layouts.app')

@section('content')
<div id="order-form" class="container">
    <div class="row justify-content-center">
        <template v-if="basket.length">
            <div class="col-md-8">
                <div class="card rounded-0">
                    <div class="card-header">Order Summary</div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush" v-for="(item, index) in basket" :key="index">
                                <li class="list-group-item">@{{ item.name }}
                                    <span>@{{ item.quantity }}</span> x <span>@{{ item.quantity }}</span>
                                    <div class="pull-right">
                                        <span>@{{ item.price }}</span>
                                    </div>
                                </li>
                            </ul>
                            <li class="list-group-item border-right-0 border-left-0">
                                Total
                                <div class="pull-right">
                                    <span>@{{ basketTotal }}</span>
                                </div>
                            </li>
                        </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card rounded-0">
                    <div class="card-header">Order Information</div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item">Transaction #: <span class="float-right" style="margin-right: 1.2rem;">@{{ transaction_code }}</span></li>
                                <li class="list-group-item">Total Items: <span class="float-right" style="margin-right: 1.2rem;">@{{ basket.length }}</span></li>
                                <li class="list-group-item">Discount: <span class="float-right" style="margin-right: 1.2rem;">@{{ discount }}</span></li>
                                <li class="list-group-item">VAT: <span class="float-right" style="margin-right: 1.2rem;">@{{ vat_incl }}</span></li>
                                <li class="list-group-item list-group-item-dark">Total Amount Due: <span class="float-right" style="margin-right: 1.2rem;">@{{ basketTotal }}</span></li>
                            </ul>
                        </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="col-md-8 mb-5">
                <li class="list-group-item list-group-item-warning rounded-0 text-center">Order not found!</li>
            </div>
        </template>
    </div>
</div>
@endsection
@section('extra_scripts')
<script type="text/javascript">
    new Vue({
        el: '#order-form',
            data () {
                return {
                    isLoading: false,
                    basket: [],
                    discount: 0,
                    discountVal: 0,
                    coupon: '',
                    vat_incl: 0,
                    transaction_code: '{{ $transaction_code }}',
                }
            },
            mounted () {
                this.fetchOrder();
            },
            created() {
            },
            methods: {
                fetchOrder() {
                    var app = this
                    app.isLoading = true
                    return axios.get(`/api/v1/order/`+app.transaction_code)
                    .then((response) => {
                        app.basket = response.data
                    })
                    .catch(() => {})
                    .then(() => {
                        app.isLoading = false
                    })
                }
            },
            computed: {
                basketTotal() {
                    let total = 0
                    _each(this.basket, (item) => {
                        total = parseFloat(total) + parseFloat(item.price)
                    })

                    total = total - (total * this.discountVal).toFixed(2)
                    this.vat_incl = -(total - (total * 1.12)).toFixed(2)
                    return total
                }
            },
    })
</script>
@endsection
