@extends('layouts.app_v2')

@section('content')
    <div id="vehicleList">
        <div class="col-md-10 col-md-offset-1">
            @if(auth()->user()->type=='admin')
                <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#createVehicle" @click="newVehicle={vehicle_id:''}">
                    <i class="fa fa-plus"> Add</i>
                </button>
            @endif
            @include('vehicle.create')
            <br/><hr>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="panel-title col-md-6">Vehicle List</div>
                        <span class="panel-title pull-right">Total @{{ total }} vehicle(s) Found &nbsp;</span>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-hover table-striped">
                        <thead>
                        <tr>
                            <th>Title</th>
                            <th>Serial No</th>
                            @if(auth()->user()->type=='admin')
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="v in vehicles" >
                            <td>@{{ v.title }}</td>
                            <td>@{{ v.serial_no ? v.serial_no : 'N/A'  }}</td>
                            <td>
                                @if(auth()->user()->type=='admin')
                                    <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editModal" @click="editClickAction(v.id, v)">Edit</a>

                                    @include('vehicle.edit')

                                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" @click="vehicle_id=v.id">@lang('Delete')</a>
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
                                                <button type="button" class="btn btn-danger" data-dismiss="modal"  @click="deleteVehicle(vehicle_id)">@lang('Yes')</button>
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
                                <a @click.prevent="getVehicleList(pagination.first_page_url)" href="#">First Page</a>
                            </li>
                            <li :class="[{disabled:!pagination.prev_page_url}]">
                                <a @click.prevent="getVehicleList(pagination.prev_page_url)" href="#">Previous</a>
                            </li>
                            <li v-for="n in pagination.last_page" :class="{active:pagination.current_page==n}"  v-if="n<=pagination.current_page+3&&n>=pagination.current_page-3">
                                <a @click.prevent="getVehicleList('vehicle?page='+n)" href="#">@{{ n }}</a>
                            </li>
                            <li :class="[{disabled:!pagination.next_page_url}]">
                                <a @click.prevent="getVehicleList(pagination.next_page_url)" href="#">Next</a>
                            </li>
                            <li :class="[{disabled:!pagination.next_page_url}]">
                                <a @click.prevent="getVehicleList(pagination.last_page_url)" href="#">Last Page</a>
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
            el: "#vehicleList",

            data:{
                total:0,
                vehicles:[],
                aVehicle:{},
                newVehicle:{vehicle_id:''},
                vehicle_id:'',
                pagination:{},
                errors:[],
            },

            created(){
                this.getVehicleList();
            },

            methods:{
                getVehicleList(pageUrl) {
                    let that = this;
                    pageUrl = pageUrl == undefined ? `{{route('vehicle.index')}}` : pageUrl;

                    axios.get(pageUrl).then(response=> {
                        console.log(response.data)
                        that.vehicles = response.data.data;
                        that.pagination = response.data;
                        that.total = that.pagination.total;

                    })
                },

                createVehicle(){
                    axios.post('{{ route('vehicle.store') }}', this.newVehicle).then(response=>{
                        this.errors = [];
                        this.getVehicleList();
                        this.$toasted.success("Successfully added customer",{
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

                editVehicle(id){

                    console.log(this.aVehicle);
                    axios.put('{{ route('vehicle.index') }}/'+id, this.aVehicle).then(response=>{
                        this.errors = [];
                        this.getVehicleList();
                        this.$toasted.success("Successfully Updated Vehicle",{
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
                editClickAction(id, itemObj){
                    this.vehicle_id = id;
                    this.aVehicle = JSON.parse(JSON.stringify(itemObj)); // deep cloning of object avoiding shallow copy of object reference
                },

                deleteVehicle(id){
                    axios.post('{{ route('vehicle.index') }}/'+id, {_method:'delete'}).then(response=>{
                        this.errors = [];
                        this.getVehicleList();
                        this.$toasted.success("Successfully Deleted Item",{
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
