@extends('layouts.app_v2')

@section('content')
    <div id="sale">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Sale
                </div>

                <div class="panel-body">
                    <form>
                        <div class="form-group col-md-8">
                            <label class="radio-inline"><input type="radio" value="0" v-model.number="sale_pack.sale_type" checked>সাধারণ বিক্রয়</label>
                            <label class="radio-inline"><input type="radio" value="1" v-model.number="sale_pack.sale_type">ডেলিভারি</label>
                        </div>

                        <div v-if="sale_pack.sale_type==1">
                            <div class="form-group col-md-8">
                                <label for="address">গাড়ি</label>
                                <select class="form-control" v-model.number="sale_pack.vehicle_id">
                                    <option value="">-- সিলেক্ট গাড়ি --</option>
                                    <option v-for="(vehicle, id) in vehicles" :value="id">@{{ vehicle }}</option>
                                </select>
                            </div>
                            <div class="form-group col-md-8">
                                <label for="address">রুট</label>
                                <select class="form-control" v-model.number="sale_pack.route_id">
                                    <option value="">-- সিলেক্ট রুট --</option>
                                    <option v-for="(route, id) in routes" :value="id">@{{ route }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="address">Customers</label>
                            <select class="form-control" v-model.number="sale_pack.customer_id">
                                <option value="">-- Select Customer --</option>
                                <option v-for="(customer, id) in customers" :value="id">@{{ customer }}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="address">Item Category</label>
                            <select class="form-control" v-model.number="sale.category_id" @change="getItems(sale.category_id)">
                                <option value="">-- Select Item Category --</option>
                                <option v-for="(category, id) in categories" :value="id">@{{ category }}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="address">Items</label>
                            <select class="form-control" v-model.number="sale.item_id" @change="getStocks(sale.item_id)">
                                <option value="">-- Select Item --</option>
                                <option v-for="item in items" :value="item.id">@{{ item.title }}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="address">Stock</label>
                            <select class="form-control" v-model.number="sale.stock_id" @change="getSalePrice(sale.stock_id)">
                                <option value="">-- Select Stock --</option>
                                <option v-for="stock in stocks" :value="stock.id">@{{ stock.remaining }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="unit_price">Sale Price</label>
                            <input type="text" class="form-control" v-model="sale.unit_price">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="quantity">Quantity</label>
                            <input type="text" class="form-control" v-model="sale.quantity">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="item_unit_id">Unit</label>
                            <select class="form-control" v-model.number="sale.item_unit_id">
                                <option value="">-- Select Unit --</option>
                                <option v-for="(unit, id) in units" :value="id">@{{ unit }}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="no_of_jar">No of Jar</label>
                            <input type="text" class="form-control" v-model="sale.no_of_jar">
                        </div>

                        <div class="form-group col-md-8">
                            <label for="no_of_drum">No of Drum</label>
                            <input type="text" class="form-control" v-model="sale.no_of_drum">
                        </div>

                        <div v-if="sale_pack.sale_type==1">
                            <div class="form-group col-md-8">
                                <label for="no_of_jar_return">No of Jar Returned</label>
                                <input type="text" class="form-control" v-model="sale.no_of_jar_return">
                            </div>
                            <div class="form-group col-md-8">
                                <label for="no_of_drum_return">No of Drum Returned</label>
                                <input type="text" class="form-control" v-model="sale.no_of_drum_return">
                            </div>
                        </div>

                        <div class="form-group col-md-8">
                            <button type="button" class="btn btn-primary pull-right" @click.prevent="AddToBucket">Add to Bucket</button>
                            <div style="width: 10px;" class="pull-right">&nbsp;</div>
                            <button type="button" class="btn btn-danger pull-right" @click.prevent="sale={unit_price:'',category_id:'',item_id:'',stock_id:'',quantity:''}">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    Bucket List
                </div>

                <div class="panel-body">
                    <table class="table table-responsive table-hover table-striped">
                        <thead>
                        <tr>
                            <th>ItemName</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="(sale, index) in saleList" >
                            <td>@{{ sale.item.title }}</td>
                            <td>@{{ sale.unit_price }} </td>
                            <td>@{{ sale.quantity }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-danger" @click="removeItem(index)"><span><i class="fa fa-minus"></i></span></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="form-group pull-right">
                <label>Total: @{{ total }}</label><br/>
                <label for="paid">Paid</label>
                <input type="text" class="form-control" v-model="sale_pack.paid">
            </div>
            <div class="clearfix"></div>

            <div class="pull-right" v-if="saleList.length">
                <button class="btn btn-primary" @click.prevent="sellItem">Submit</button>
            </div>
            <br/><hr>
            @include('errors.ajax_error')
        </div>
        <div class="clearfix"></div>
    </div>
@endsection

@section('additionalJS')
    <script>
        Vue.use(Toasted);
        new Vue({
            el: "#sale",

            data:{
                categories: {!! json_encode(__itemCategoryDropdown()) !!},
                customers: {!! json_encode(__customerDropdown()) !!},
                units: {!! json_encode(__itemUnitDropdown()) !!},
                vehicles: {!! json_encode(__vehiclesDropdown()) !!},
                routes: {!! json_encode(__routesDropdown()) !!},

                sale_pack:{
                    sale_type:0,
                    customer_id:'',
                    vehicle_id:'',
                    route_id:'',
                    paid:''
                },

                items:[],
                stocks:[],
                sale:{
                    unit_price:'',
                    category_id:'',
                    item_id:'',
                    item_unit_id:'',
                    stock_id:'',
                    quantity:'',
                    no_of_jar:0,
                    no_of_drum:0,
                    no_of_jar_return:0,
                    no_of_drum_return:0,
                    item:'',
                    category_name:'',
                },
                perItemPriceList:[],
                total:0,
                stock_remaining:'',
                saleList:[],
                errors:[],
            },

            methods:{
                resetComponent(){
                    this.sale_pack = {sale_type:0, customer_id:'', vehicle_id:'', route_id:''};
                    this.items = [];
                    this.stocks = [];
                    this.sale = {unit_price:'',category_id:'',item_id:'',item_unit_id:'',stock_id:'',quantity:'',no_of_jar:0,no_of_drum:0,
                        no_of_jar_return:0,no_of_drum_return:0,item:'',category_name:''};
                    this.stock_remaining = '';
                    this.saleList = [];
                    this.errors = [];
                },

                removeItem(index){
                    this.saleList.splice(index, 1);
                    this.total -=this.perItemPriceList[index];
                },

                getItems(categoryId) {
                    axios.get('category/'+categoryId+'/items').then(response=> {
                        this.items = response.data;
                        this.sale = {
                            unit_price:'',
                            category_id:categoryId,
                            item_id:'',
                            item_unit_id:'',
                            stock_id:'',
                            quantity:'',
                            no_of_jar:0,
                            no_of_drum:0,
                            no_of_jar_return:0,
                            no_of_drum_return:0,
                        };
                    })
                },
                getStocks(itemId) {
                    this.sale.item = this.items.filter(item=> item.id == itemId)[0];

                    axios.get('item/'+itemId+'/stocks').then(response=> {
                        this.stocks = response.data;
                    })
                },
                getSalePrice(stockId) {
                    let stock = this.stocks.filter(stock=> stock.id == stockId)[0];
                    this.stock_remaining = stock.quantity - stock.sold;

                    axios.get('stock/'+ stockId +'/sale-price').then(response=> {
                        this.sale.unit_price = response.data;
                    })
                },
                AddToBucket(){
                    if(!this.sale.item_id || !this.sale.unit_price || !this.sale.category_id || !this.sale.stock_id || !this.sale.quantity){
                        alert("please provide all the sales info");
                        return;
                    }
                    this.saleList.push(JSON.parse(JSON.stringify(this.sale)));

                    axios.get('{{ route('sale_quantity') }}', {params:this.sale}).then(response=>{
                        this.total += this.sale.unit_price*response.data;
                        this.perItemPriceList.push(this.sale.unit_price*response.data)
                    }).catch(error=>{
                        this.errors = error.response.data.messages;
                    });
                },

                sellItem(){
                    axios.post('{{ route('sales.store') }}', {"sale_pack":this.sale_pack, "sale_list":this.saleList}).then(response=>{
                        this.resetComponent();

                        window.location = `{!! route('memo') !!}`+'?packId='+response.data;
                    }).catch(error=>{
                        if(error.response.status !== 422){
                            let errorMsg = error.response.data.message;
                            this.$toasted.error(errorMsg,{
                                position: 'top-center',
                                theme: 'bubble',
                                duration: 6000,
                                action : {
                                    text : 'Close',
                                    onClick : (e, toastObject) => {
                                        toastObject.goAway(0);
                                    }
                                },
                            });
                        }
                        else
                            this.errors = error.response.data.messages;
                    });
                },
            }
        });
    </script>
@endsection
