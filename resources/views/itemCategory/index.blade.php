@extends('layouts.app_v2')

@section('content')
    <div id="itemCategoryList">
        <div class="col-md-10 col-md-offset-1">
            @if(auth()->user()->type=='admin')
                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#createItemCategory" @click="newItemCategory={}">
                    <i class="fa fa-plus"> Add</i>
                </button>
            @endif
            @include('itemCategory.create')
            <br/><hr>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="panel-title col-md-6">Item Category List</div>
                        <span class="panel-title pull-right">Total @{{ total }} item categories(s) Found &nbsp;</span>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            @if(auth()->user()->type=='admin')
                                <th class="pull-right">Action</th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="itemCategory in itemCategories" >
                            <td>@{{ itemCategory.name }}</td>

                            <td class="pull-right">
                                @if(auth()->user()->type=='admin')
                                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal" @click="editClickAction(itemCategory.id, itemCategory)">Edit</a>

                                    @include('itemCategory.edit')

                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" @click="item_category_id=itemCategory.id">@lang('Delete')</a>
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
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"  @click="deleteUser(item_category_id)">@lang('Yes')</button>
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
                                <a @click.prevent="getItemCategoryList(pagination.first_page_url)" href="#">First Page</a>
                            </li>
                            <li :class="[{disabled:!pagination.prev_page_url}]">
                                <a @click.prevent="getItemCategoryList(pagination.prev_page_url)" href="#">Previous</a>
                            </li>
                            <li v-for="n in pagination.last_page" :class="{active:pagination.current_page==n}"  v-if="n<=pagination.current_page+3&&n>=pagination.current_page-3">
                                <a @click.prevent="getItemCategoryList('item-categories?page='+n)" href="#">@{{ n }}</a>
                            </li>
                            <li :class="[{disabled:!pagination.next_page_url}]">
                                <a @click.prevent="getItemCategoryList(pagination.next_page_url)" href="#">Next</a>
                            </li>
                            <li :class="[{disabled:!pagination.next_page_url}]">
                                <a @click.prevent="getItemCategoryList(pagination.last_page_url)" href="#">Last Page</a>
                            </li>
                        </ul>
                    </div>
                    <small class="col-md-offset-5">Showing @{{ pagination.from }} to @{{ pagination.to }} of @{{ pagination.total }} entries</small>
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
            el: "#itemCategoryList",

            data:{
                total:0,
                itemCategories:[],
                aItemCategory:{},
                newItemCategory:{},
                item_category_id:'',
                pagination:{},
                errors:[],
            },

            created(){
                this.getItemCategoryList();
            },

            methods:{
                getItemCategoryList(pageUrl) {
                    let that = this;
                    pageUrl = pageUrl == undefined ? `{{route('item-categories.index')}}` : pageUrl;

                    axios.get(pageUrl).then(response=> {
                        that.itemCategories = response.data.data;
                        that.pagination = response.data;
                        that.total = that.pagination.total;
                    })
                },

                createItemCategory(){
                    axios.post('{{ route('item-categories.store') }}', this.newItemCategory).then(response=>{
                        this.errors = [];
                        this.newContent ='';
                        this.getItemCategoryList();
                        this.$toasted.success("Successfully Created Item Category",{
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

                editItemCategory(id){
                    console.log(this.aItemCategory)
                    axios.put('{{ route('item-categories.index') }}/'+id, this.aItemCategory).then(response=>{
                        this.errors = [];
                        this.getItemCategoryList();
                        this.$toasted.success("Successfully Updated Item Category",{
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
                editClickAction(id, itemCategoryObj){
                    this.item_category_id = id;
                    this.aItemCategory = JSON.parse(JSON.stringify(itemCategoryObj)); // deep cloning of object avoiding shallow copy of object reference
                },

                deleteUser(id){
                    axios.post('{{ route('item-categories.index') }}/'+id, {_method:'delete'}).then(response=>{
                        this.errors = [];
                        this.getItemCategoryList();
                        this.$toasted.success("Successfully Deleted Item Category",{
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
