@extends('layouts.app')

@section('content')
<style>
@media (min-width: 991px) {
    .col-sm-4 {
        flex: 0 0 50%;
        width: 50%!important;
    }

}
@media (min-width: 576px){
    .col-sm-4 {
        flex: 0 0 50%;
        max-width: 50%!important;
    }
}

@media (min-width: 722px){
    .col-sm-4 {
        flex: 0 0 50%;
        max-width: 50%!important;
    }
}

@media (min-width: 1191px){
    .col-sm-4 {
        flex: 0 0 50%;
        max-width: 33%!important;
    }
}
</style>
<div id="order-form" class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card rounded-0">
                <div class="card-header">Select Menu</div>
                    <div class="card-body">
                        <div v-for="items in menu">
                            <div class="card rounded-0 mb-2">
                                <div class="card-header">
                                    <h5 class="mb-0">
                                        <span class="btn btn-success rounded-0 btn-block">
                                            @{{ items[0].category == null ? 'Others' : items[0].category }}
                                        </span>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-4" v-for="item in items">
                                            <div class="card rounded-0 mt-2">
                                                <div class="card-header">@{{ item.name }} <span class="float-right">@{{ item.price }}</span></div>
                                                    <div class="card-body text-center">
                                                        <img src="https://dummyimage.com/120x140/5c5c5c/ffffff" alt="" v-on:click="addToBasket(item)">
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card rounded-0">
                <div class="card-header">Order Information</div>
                    <div class="card-body">
                        <template v-if="basket.length">
                            <ul class="list-group">
                                <li class="list-group-item">Transaction #: <span class="float-right" style="margin-right: 1.2rem;">@{{ transaction_code }}</span></li>
                                <li class="list-group-item">Total Items: <span class="float-right" style="margin-right: 1.2rem;">@{{ basket.length }}</span></li>
                                <li class="list-group-item">
                                    Discount Coupon:
                                    <div class="col-6 float-right px-0">
                                        <input type="text" v-model="coupon" class="col-10 float-right rounded-0"/>
                                    </div>
                                    <div class="col-12 float-right">
                                        <small id="coupon_error" class="text-danger float-right" style="margin-right: -10px; display:none">Invalid Coupon Code</small>
                                    </div>
                                </li>
                                <li class="list-group-item">Discount: <span class="float-right" style="margin-right: 1.2rem;">@{{ discount }}</span></li>
                                <li class="list-group-item">VAT: <span class="float-right" style="margin-right: 1.2rem;">@{{ vat_incl }}</span></li>
                                <li class="list-group-item list-group-item-dark">Total Amount Due: <span class="float-right" style="margin-right: 1.2rem;">@{{ basketTotal }}</span></li>
                                <li class="list-group-item"><button class="btn btn-primary btn-block rounded-0" v-on:click="placeOrder">Place Order</button></li>
                            </ul>
                        </template>
                        <template v-else>
                            <li class="list-group-item list-group-item-warning rounded-0">Basket empty!</li>
                        </template>
                    </div>
            </div>
            <div class="card rounded-0 mt-2">
                <div class="card-header">Order Summary</div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush" v-for="(item, index) in basket" :key="index">
                            <li class="list-group-item">@{{ item.name }}
                                <span>@{{ item.quantity }}</span> x <span>@{{ item.quantity }}</span>
                                <div class="pull-right">
                                    <span>@{{ item.price }}</span><a href="javascript:void(0);" class="fa fa-remove text-danger ml-2" v-on:click="removeToBasket(index, item)"></a>
                                </div>
                            </li>
                        </ul>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extra_scripts')
<script type="text/javascript">
    new Vue({
        el: '#order-form',
            data () {
                return {
                    menu: [],
                    isLoading: false,
                    searchValue: '',
                    basket: [],
                    discount: 0,
                    discountVal: 0,
                    coupon: '',
                    vat_incl: 0,
                    transaction_code: ''
                }
            },
            mounted () {
                this.fetchMenu();
            },
            created() {
                this.generateTransactionCode()
            },
            methods: {
                fetchMenu() {
                    var app = this
                    app.isLoading = true
                    return axios.get(`/api/v1/menu`)
                    .then((response) => {
                        app.menu = response.data
                    })
                    .catch(() => {})
                    .then(() => {
                        app.isLoading = false
                    })
                },
                addToBasket(menu) {
                    var order = {
                        'transaction_code': this.transaction_code,
                        'name': menu.name,
                        'category': menu.category,
                        'quantity': 1,
                        'price': menu.price
                    }
                    this.basket.push(order);
                },
                setCoupon() {
                    let elemCoupon = document.getElementById('coupon_error')
                    this.discount = 0
                    this.discountVal = 0
                    if(this.coupon == 'GO2018'){
                        this.discount = '10%'
                        this.discountVal = '0.10'
                        elemCoupon.style.display = 'none'
                    } else if (this.coupon == '') {
                        elemCoupon.style.display = 'none'
                    } else {
                        elemCoupon.style.display = 'block'
                    }
                },
                removeToBasket(index, item) {
                    this.basket.splice(index, 1);
                },
                generateTransactionCode() {
                    this.transaction_code = new Date().getTime()
                },
                placeOrder() {
                    var app = this
                    let route = '{{ route('api.orders.store') }}'
                    let params = {
                            orders: app.basket,
                        }
                    axios.post(route, params)
                    .then((response) => {
                        window.location = '/order/'+app.transaction_code
                    })
                }
            },
            watch: {
                coupon() {
                    this.setCoupon()
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
