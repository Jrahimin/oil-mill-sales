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
                            <label for="sale_price">Sale Price</label>
                            <input type="text" class="form-control" v-model="sale.sale_price">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="no_of_items">No Of Items</label>
                            <input type="text" class="form-control" v-model="sale.no_of_items">
                        </div>

                        <div class="form-group col-md-8">
                            <button type="button" class="btn btn-primary pull-right" @click.prevent="AddToBucket">Add to Bucket</button>
                            <div style="width: 10px;" class="pull-right">&nbsp;</div>
                            <button type="button" class="btn btn-danger pull-right" @click.prevent="sale={sale_price:'',category_id:'',item_id:'',stock_id:'',no_of_items:''}">Clear</button>
                        </div>
                    </form>
                </div>
            </div>
            @include('errors.ajax_error')
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
                            <td>@{{ sale.sale_price }} </td>
                            <td>@{{ sale.no_of_items }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-danger" @click="saleList.splice(index, 1)"><span><i class="fa fa-minus"></i></span></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additionalJS')
    <script>
        Vue.use(Toasted);
        new Vue({
            el: "#sale",

            data:{
                categories: {!! json_encode(__itemCategoryDropdown()) !!},
                items:[],
                stocks:[],
                sale:{
                    sale_price:'',
                    category_id:'',
                    item_id:'',
                    stock_id:'',
                    no_of_items:'',
                    item:'',
                    category_name:'',
                },
                saleList:[],
                errors:[],
            },

            methods:{
                getItems(categoryId) {
                    axios.get('category/'+categoryId+'/items').then(response=> {
                        this.items = response.data;
                        this.sale = {
                            sale_price:'',
                            category_id:categoryId,
                            item_id:'',
                            stock_id:'',
                            no_of_items:'',
                        };
                    })
                },
                getStocks(itemId) {
                    let item = this.items.filter(item=> item.id == itemId);
                    this.sale.item = item[0];
                    console.log(item)

                    axios.get('item/'+itemId+'/stocks').then(response=> {
                        this.stocks = response.data;
                    })
                },
                getSalePrice(stockId) {
                    axios.get('stock/'+ stockId +'/sale-price').then(response=> {
                        this.sale.sale_price = response.data;
                    })
                },
                AddToBucket(){
                    this.saleList.push(this.sale);
                },

                /*sale(){
                    axios.post('{{ route('items.store') }}', this.newItem).then(response=>{
                        this.errors = [];
                        this.getItemList();
                        this.$toasted.success("Successfully added item",{
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
                },*/
            }
        });
    </script>
@endsection
