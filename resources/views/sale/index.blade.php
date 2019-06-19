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
                            <label for="address">Customers</label>
                            <select class="form-control" v-model="customer_id">
                                <option value="">-- Select Customer --</option>
                                <option v-for="(customer, id) in customers" :value="id">@{{ customer }}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="address">Item Category</label>
                            <select class="form-control" v-model="sale.category_id" @change="getItems(sale.category_id)">
                                <option value="">-- Select Item Category --</option>
                                <option v-for="(category, id) in categories" :value="id">@{{ category }}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="address">Items</label>
                            <select class="form-control" v-model="sale.item_id" @change="getStocks(sale.item_id)">
                                <option value="">-- Select Item --</option>
                                <option v-for="item in items" :value="item.id">@{{ item.title }}</option>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="address">Stock</label>
                            <select class="form-control" v-model="sale.stock_id" @change="getSalePrice(sale.stock_id)">
                                <option value="">-- Select Stock --</option>
                                <option v-for="stock in stocks" :value="stock.id">@{{ stock.remaining }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <label for="unit_price">Sale Price</label>
                            <input type="text" class="form-control" v-model="sale.unit_price">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="no_of_items">No Of Items</label>
                            <input type="text" class="form-control" v-model="sale.no_of_items">
                        </div>

                        <div class="form-group col-md-8">
                            <button type="button" class="btn btn-primary pull-right" @click.prevent="AddToBucket">Add to Bucket</button>
                            <div style="width: 10px;" class="pull-right">&nbsp;</div>
                            <button type="button" class="btn btn-danger pull-right" @click.prevent="sale={unit_price:'',category_id:'',item_id:'',stock_id:'',no_of_items:''}">Clear</button>
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
                            <th>NoOfItems</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="(sale, index) in saleList" >
                            <td>@{{ sale.item.title }}</td>
                            <td>@{{ sale.unit_price }} </td>
                            <td>@{{ sale.no_of_items }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-danger" @click="saleList.splice(index, 1)"><span><i class="fa fa-minus"></i></span></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
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
                customer_id:'',
                items:[],
                stocks:[],
                sale:{
                    unit_price:'',
                    category_id:'',
                    item_id:'',
                    stock_id:'',
                    no_of_items:'',
                    item:'',
                    category_name:'',
                },
                stock_remaining:'',
                saleList:[],
                errors:[],
            },

            created(){
                console.log(this.customers)
            },

            methods:{
                getItems(categoryId) {
                    axios.get('category/'+categoryId+'/items').then(response=> {
                        this.items = response.data;
                        this.sale = {
                            unit_price:'',
                            category_id:categoryId,
                            item_id:'',
                            stock_id:'',
                            no_of_items:'',
                        };
                    })
                },
                getStocks(itemId) {
                    let item = this.items.filter(item=> item.id == itemId)[0];
                    this.sale.item = item;

                    axios.get('item/'+itemId+'/stocks').then(response=> {
                        this.stocks = response.data;
                        console.log(response.data);
                    })
                },
                getSalePrice(stockId) {
                    let stock = this.stocks.filter(stock=> stock.id == stockId)[0];
                    this.stock_remaining = stock.no_of_items - stock.sold;

                    axios.get('stock/'+ stockId +'/sale-price').then(response=> {
                        this.sale.unit_price = response.data;
                    })
                },
                AddToBucket(){
                    if(parseInt(this.stock_remaining) < parseInt(this.sale.no_of_items)){
                        alert("Not enough in stock");
                        return;
                    }
                    if(!this.sale.item_id || !this.sale.unit_price || !this.sale.category_id || !this.sale.stock_id || !this.sale.no_of_items){
                        alert("please provide all the sales info");
                        return;
                    }
                    this.saleList.push(JSON.parse(JSON.stringify(this.sale)));
                },

                sellItem(){
                    axios.post('{{ route('sales.store') }}', {"customer_id":this.customer_id, "sale_list":this.saleList}).then(response=>{
                        console.log(response.data);
                        this.errors = [];
                        this.$toasted.success("Successful Sale",{
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
