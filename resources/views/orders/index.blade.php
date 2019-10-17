@extends('layouts.app')

@section('content')
<div id="order-form" class="container">
    <div class="row justify-content-center">
        <template v-if="orders">
            <div class="col-md-8">
                <div class="card rounded-0">
                    <div class="card-header">All Orders</div>
                        <div class="card-body">
                            <div v-for="items in orders">
                                <div class="card rounded-0 mb-2">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item list-group-item-info rounded-0">Transaction Code: @{{ items[0].transaction_code }}</li>
                                    </ul>
                                    <ul class="list-group list-group-flush" v-for="(item, index) in items" :key="index">
                                        <li class="list-group-item">@{{ item.name }}
                                            <span>@{{ item.quantity }}</span> x <span>@{{ item.quantity }}</span>
                                            <div class="pull-right">
                                                <span>@{{ item.price }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </template>
        <template v-else>
            <div class="col-md-8 mb-5">
                <li class="list-group-item list-group-item-warning rounded-0 text-center">No Orders!</li>
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
                    orders: [],
                    count: 0,
                    discount: 0,
                    discountVal: 0,
                    coupon: '',
                    vat_incl: 0,
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
                    return axios.get(`/api/v1/orders`)
                    .then((response) => {
                        app.orders = response.data
                        console.log(app.orders)
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
