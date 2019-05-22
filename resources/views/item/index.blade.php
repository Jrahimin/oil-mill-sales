@extends('layouts.app_v2')

@section('content')
    <div id="itemList">
        <div class="col-md-10 col-md-offset-1">
            @if(auth()->user()->type=='admin')
                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#createItem" @click="newItem={item_id:''}">
                    <i class="fa fa-plus"> Add</i>
                </button>
            @endif
            @include('item.create')
            <br/><hr>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="panel-title col-md-6">Item List</div>
                        <span class="panel-title pull-right">Total @{{ total }} item(s) Found &nbsp;</span>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Model</th>
                            <th>Company</th>
                            <th>Category</th>
                            <th>Serial No</th>
                            @if(auth()->user()->type=='admin')
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="item in items" >
                            <td>@{{ item.title }}</td>
                            <td>@{{ item.model ? item.model : 'N/A'  }}</td>
                            <td>@{{ item.company ? item.company : 'N/A' }}</td>
                            <td>@{{ item.category ? item.category.name : 'N/A' }}</td>
                            <td>@{{ item.serial_no ? item.serial_no : 'N/A'  }}</td>
                            <td>
                                {{--@if(auth()->user()->type=='admin')--}}
                                    {{--<a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal" @click="editClickAction(stock.id, stock)">Edit</a>--}}

                                    {{--@include('stock.edit')--}}

                                    {{--<a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" @click="stock_id=stock.id">@lang('Delete')</a>--}}
                                {{--@endif--}}

                                {{--<div id="deleteModal" class="modal fade"  >--}}
                                    {{--<div class="modal-dialog">--}}
                                        {{--<div class="modal-content">--}}
                                            {{--<div class="modal-header" style="background-color: indianred">--}}
                                                {{--<button type="button" class="close" data-dismiss="modal">&times;</button>--}}
                                                {{--<h4 class="modal-title">Confirmation </h4>--}}
                                            {{--</div>--}}
                                            {{--<div class="modal-body">--}}
                                                {{--<p> Are you sure?</p>--}}

                                            {{--</div>--}}
                                            {{--<div class="modal-footer">--}}
                                                {{--<button type="button" class="btn btn-danger" data-dismiss="modal"  @click="deleteStock(stock_id)">@lang('Yes')</button>--}}
                                                {{--<button type="button" class="btn btn-primary" data-dismiss="modal">@lang('No')</button>--}}
                                            {{--</div>--}}
                                        {{--</div>--}}
                                    {{--</div>--}}
                                {{--</div>--}}

                            </td>
                        </tr>
                        </tbody>
                    </table>

                    {{--<div v-if="pagination.total > pagination.per_page" class="col-md-offset-4">--}}
                        {{--<ul class="pagination">--}}
                            {{--<li :class="[{disabled:!pagination.prev_page_url}]">--}}
                                {{--<a @click.prevent="getStockList(pagination.first_page_url)" href="#">First Page</a>--}}
                            {{--</li>--}}
                            {{--<li :class="[{disabled:!pagination.prev_page_url}]">--}}
                                {{--<a @click.prevent="getStockList(pagination.prev_page_url)" href="#">Previous</a>--}}
                            {{--</li>--}}
                            {{--<li v-for="n in pagination.last_page" :class="{active:pagination.current_page==n}"  v-if="n<=pagination.current_page+3&&n>=pagination.current_page-3">--}}
                                {{--<a @click.prevent="getStockList('stocks?page='+n)" href="#">@{{ n }}</a>--}}
                            {{--</li>--}}
                            {{--<li :class="[{disabled:!pagination.next_page_url}]">--}}
                                {{--<a @click.prevent="getStockList(pagination.next_page_url)" href="#">Next</a>--}}
                            {{--</li>--}}
                            {{--<li :class="[{disabled:!pagination.next_page_url}]">--}}
                                {{--<a @click.prevent="getStockList(pagination.last_page_url)" href="#">Last Page</a>--}}
                            {{--</li>--}}
                        {{--</ul>--}}
                    {{--</div>--}}
                    {{--<small class="col-md-offset-5">Showing @{{ pagination.from }} to @{{ pagination.to }} of @{{ pagination.total }} entries</small>--}}
                </div>
            </div>
            @include('errors.ajax_error')
        </div>
    </div>
@endsection

@section('additionalJS')
    <script>
        Vue.use(Toasted);
        new Vue({
            el: "#itemList",

            data:{
                total:0,
                items:[],
                categories :[],
                anItem:{},
                newItem:{item_id:'', status:1},
                item_id:'',
                pagination:{},
                errors:[],
            },

            created(){
                this.getItemList();
            },

            methods:{
                getItemList(pageUrl) {
                    let that = this;
                    pageUrl = pageUrl == undefined ? `{{route('items.index')}}` : pageUrl;

                    axios.get(pageUrl).then(response=> {
                        console.log(response.data)
                        that.items = response.data.items.data;
                        that.categories = response.data.itemCategories ;
                        that.pagination = response.data.items;
                        that.total = that.pagination.total;

                        console.log(that.pagination);
                    })
                },

                createItem(){
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
