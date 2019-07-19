@extends('layouts.app_v2')

@section('content')
    <div id="stockList">

        @include('stock.search')

        @if(auth()->user()->type=='admin')
            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#createStock"
                    @click="newStock={stock_place:'', item_id:'', item_unit_id:'', status:1}">
                <i class="fa fa-plus"> Add</i>
            </button>
        @endif
        @include('stock.create')
        <br/><hr>
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="panel-title col-md-6">Stock List</div>
                    <span class="panel-title pull-right">Total @{{ total }} stock(s) Found &nbsp;</span>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-responsive table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>ItemName</th>
                        <th>Quantity</th>
                        <th>Unit</th>
                        <th>Jar</th>
                        <th>Drum</th>
                        <th>Sold</th>
                        @if(auth()->user()->type=='admin')
                            <th>UnitPrice</th>
                        @endif
                        <th>SalePrice</th>
                        <th>status</th>
                        <th>stockedBy</th>
                        <th>StockAt</th>
                        <th>StockDate</th>
                        @if(auth()->user()->type=='admin')
                            <th>Action</th>
                        @endif
                    </tr>
                    </thead>

                    <tbody>
                    <tr v-for="stock in stocks" >
                        <td>@{{ stock.item.category.name }}</td>
                        <td>@{{ stock.item.title }}</td>
                        <td>@{{ stock.quantity }}</td>
                        <td>@{{ stock.item_unit.name }}</td>
                        <td>@{{ stock.no_of_jar }}</td>
                        <td>@{{ stock.no_of_drum }}</td>
                        <td>@{{ stock.sold }}</td>
                        @if(auth()->user()->type=='admin')
                            <td>@{{ stock.price }} </td>
                        @endif
                        <td>@{{ stock.sale_price }} </td>
                        <td>@{{ stock.stock_status }}</td>
                        <td>@{{ stock.user.name }}</td>
                        <td>
                            <span v-if="stock.stock_place==1">পুরাতন মিল</span>
                            <span v-if="stock.stock_place==2">নতুন মিল</span>
                        </td>
                        <td>@{{ stock.stock_date }}</td>
                        <td>
                            @if(auth()->user()->type=='admin')
                                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal" @click="editClickAction(stock.id, stock)">Edit</a>

                                @include('stock.edit')

                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" @click="stock_id=stock.id">@lang('Delete')</a>
                            @endif

                            <div id="deleteModal" class="modal fade"  >
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: indianred">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Confirmation </h4>
                                        </div>
                                        <div class="modal-body">
                                            <p> Are you sure?</p>

                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal"  @click="deleteStock(stock_id)">@lang('Yes')</button>
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">@lang('No')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
                    </tr>
                    </tbody>
                </table>

                <div v-if="pagination.total > pagination.per_page" class="col-md-offset-4">
                    <ul class="pagination">
                        <li :class="[{disabled:!pagination.prev_page_url}]">
                            <a @click.prevent="getStockList(pagination.first_page_url)" href="#">First Page</a>
                        </li>
                        <li :class="[{disabled:!pagination.prev_page_url}]">
                            <a @click.prevent="getStockList(pagination.prev_page_url)" href="#">Previous</a>
                        </li>
                        <li v-for="n in pagination.last_page" :class="{active:pagination.current_page==n}"  v-if="n<=pagination.current_page+3&&n>=pagination.current_page-3">
                            <a @click.prevent="getStockList('stocks?page='+n)" href="#">@{{ n }}</a>
                        </li>
                        <li :class="[{disabled:!pagination.next_page_url}]">
                            <a @click.prevent="getStockList(pagination.next_page_url)" href="#">Next</a>
                        </li>
                        <li :class="[{disabled:!pagination.next_page_url}]">
                            <a @click.prevent="getStockList(pagination.last_page_url)" href="#">Last Page</a>
                        </li>
                    </ul>
                </div>
                <small class="col-md-offset-5">Showing @{{ pagination.from }} to @{{ pagination.to }} of @{{ pagination.total }} entries</small>
            </div>
        </div>
        @include('errors.ajax_error')
    </div>
@endsection

@section('additionalJS')
    <script>
        Vue.use(Toasted);
        new Vue({
            el: "#stockList",

            data:{
                total:0,
                units: {!! json_encode(__itemUnitDropdown()) !!},
                stocks:[],
                items: {!! json_encode(__itemDropdown()) !!},
                aStock:{},
                newStock:{stock_place:'', item_id:'', item_unit_id:'', status:1},
                stock_id:'',
                pagination:{},
                errors:[],

                searchCategories: {!! json_encode(__itemCategoryDropdown()) !!},
                searchItems: {!! json_encode(__itemDropdown()) !!},
                search:{
                    item_id:'',
                    category_id:'',
                    status:'',
                    stock_place:'',
                    from_date:'',
                    to_date:''
                }
            },

            created(){
                this.getStockList();
            },

            methods:{
                reset(){
                    this.search = {item_id:'', category_id:'', status:'', stock_place:'', from_date:'', to_date:''};
                    this.getStockList();
                },

                getItemsForCategory(){
                    this.search.item_id='';

                    if(this.search.category_id){
                        axios.get('items/category/'+this.search.category_id).then(response=> {
                            this.searchItems = response.data;
                        })
                    }
                    else
                        this.searchItems = {!! json_encode(__itemDropdown()) !!};
                },

                getStockList(pageUrl) {
                    let that = this;
                    pageUrl = !pageUrl ? `{{route('stocks.index')}}` : pageUrl; // in js ! => undefined, false, 0, ''

                    axios.get(pageUrl, {params:that.search}).then(response=> {
                        that.stocks = response.data.stocks.data;
                        that.pagination = response.data.stocks;
                        that.total = that.pagination.total;
                    })
                },

                createStock(){
                    axios.post('{{ route('stocks.store') }}', this.newStock).then(response=>{
                        this.errors = [];
                        this.getStockList();
                        this.$toasted.success("Successfully Registered User",{
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

                editStock(id){
                    axios.put('{{ route('stocks.index') }}/'+id, this.aStock).then(response=>{
                        this.errors = [];
                        this.getStockList();
                        this.$toasted.success("Successfully Updated User",{
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
                editClickAction(id, stockObj){
                    this.stock_id = id;
                    this.aStock = JSON.parse(JSON.stringify(stockObj)); // deep cloning of object avoiding shallow copy of object reference
                },

                deleteStock(id){
                    axios.post('{{ route('stocks.index') }}/'+id, {_method:'delete'}).then(response=>{
                        this.errors = [];
                        this.getStockList();
                        this.$toasted.success("Successfully Deleted User",{
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
                    })
                },
            }
        });
    </script>
@endsection
