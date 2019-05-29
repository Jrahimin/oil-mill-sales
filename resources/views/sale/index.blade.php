@extends('layouts.app_v2')

@section('content')
    <div id="sale" class="col-md-6 col-md-offset-3">
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
                            <option v-for="(category, index) in categories" :value="index">@{{ category }}</option>
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
                        <select class="form-control" v-model="sale.stock_id">
                            <option value="">-- Select Stock --</option>
                            <option v-for="stock in stocks" :value="stock.id">@{{ stock.remaining }}</option>
                        </select>
                    </div>
                    {{-- <div class="form-group">
                         <label for="no_of_items">Title</label>
                         <input type="text" class="form-control" v-model="newItem.title">
                     </div>
                     <div class="form-group">
                         <label for="price">Model</label>
                         <input type="text" class="form-control" v-model="newItem.model">
                     </div>
                     <div class="form-group">
                         <label for="price">Company</label>
                         <input type="text" class="form-control" v-model="newItem.company">
                     </div>

                     <div class="form-group">
                         <label for="price">Serial No</label>
                         <input type="text" class="form-control" v-model="newItem.serial_no">
                     </div>--}}
                </form>
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
                sale:{},
                errors:[],
            },

            created(){
                console.log(this.categories);
            },

            methods:{
                getItems(categoryId) {
                    axios.get('category/'+categoryId+'/items').then(response=> {
                        this.items = response.data;
                    })
                },
                getStocks(itemId) {
                    axios.get('item/'+itemId+'/stocks').then(response=> {
                        this.stocks = response.data;
                    })
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
