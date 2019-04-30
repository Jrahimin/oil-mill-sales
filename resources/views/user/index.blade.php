@extends('layouts.app_v2')

@section('content')
    <div id="userList">
        <div class="col-md-10 col-md-offset-1">
            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#createUser">
                <i class="fa fa-plus"> Add</i>
            </button>
            @include('user.create')
            <br/><hr>
            <div class="panel panel info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="panel-title col-md-6">User List</div>
                        <span class="panel-title pull-right">Total @{{ total }} user(s) Found &nbsp;</span>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>MobileNo</th>
                            <th>Address</th>
                            <th>Reg. Date</th>
                            <th>Edit</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="user in users" >
                            <td>@{{ user.name }}</td>
                            <td>@{{ user.email }} </td>
                            <td>@{{ user.mobile_no }}</td>
                            <td>@{{ user.address }}</td>
                            <td>@{{ user.created_date }}</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info" data-toggle="modal" data-target="#editModal" @click="editClickAction(user.id, user)">Edit</a>

                                @include('user.edit')

                                <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" @click="user_id=user.id">@lang('Delete')</a>

                                <div id="deleteModal" class="modal fade"  >
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">Confirmation </h4>
                                            </div>
                                            <div class="modal-body">
                                                <p> Are you sure?</p>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"  @click="deleteUser(user_id)">@lang('Yes')</button>
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
                                <a @click.prevent="getUserList(pagination.first_page_url)" href="#">First Page</a>
                            </li>
                            <li :class="[{disabled:!pagination.prev_page_url}]">
                                <a @click.prevent="getUserList(pagination.prev_page_url)" href="#">Previous</a>
                            </li>
                            <li v-for="n in pagination.last_page" :class="{active:pagination.current_page==n}"  v-if="n<=pagination.current_page+3&&n>=pagination.current_page-3">
                                <a @click.prevent="getUserList('users?page='+n)" href="#">@{{ n }}</a>
                            </li>
                            <li :class="[{disabled:!pagination.next_page_url}]">
                                <a @click.prevent="getUserList(pagination.next_page_url)" href="#">Next</a>
                            </li>
                            <li :class="[{disabled:!pagination.next_page_url}]">
                                <a @click.prevent="getUserList(pagination.last_page_url)" href="#">Last Page</a>
                            </li>
                        </ul>
                    </div>
                    <small class="col-md-offset-5">Showing @{{ pagination.from }} to @{{ pagination.to }} of @{{ pagination.total }} entries</small>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('additionalJS')
    <script>
        Vue.use(Toasted);
        new Vue({
            el: "#userList",

            data:{
                total:0,
                users:[],
                aUser:{},
                newUser:{},
                user_id:'',
                pagination:{},
                errors:[],
            },

            created(){
                this.getUserList();
            },

            methods:{
                getUserList(pageUrl) {
                    let that = this;
                    pageUrl = pageUrl == undefined ? `{{route('users.index')}}` : pageUrl;

                    axios.get(pageUrl).then(response=> {
                        that.users = response.data.data;
                        that.pagination = response.data;
                        that.total = that.pagination.total;
                    }).catch(error=>{
                        console.log(error);
                    });
                },

                createUser(){
                    axios.post('{{ route('users.store') }}', this.newUser).then(response=>{
                        this.getUserList();
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
                        this.errors = error.response.data.messages;
                        this.$toasted.error(this.errors[0],{
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
                    });
                },

                editUser(id){
                    axios.put('{{ route('users.index') }}/'+id, this.aUser).then(response=>{
                        this.getUserList();
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
                        this.errors = error.response.data.messages;

                        this.$toasted.error(this.errors[0],{
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
                    });
                },
                editClickAction(id, userObj){
                    this.user_id = id;
                    this.aUser = JSON.parse(JSON.stringify(userObj)); // deep cloning of object avoiding shallow copy of object reference
                },

                deleteUser(id){
                    axios.post('{{ route('users.index') }}/'+id, {_method:'delete'}).then(response=>{
                        this.getUserList();
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
                        this.$toasted.success("Something went wrong",{
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
