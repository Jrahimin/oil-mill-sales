@extends('layouts.app_v2')

@section('content')
    <div id="memoList">
        <div class="col-md-10 col-md-offset-1">
            @include('reports.memo.search')

            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="row">
                        <div class="panel-title col-md-6">Memo List</div>
                        <span class="panel-title pull-right">Total @{{ total }} memo(s) Found &nbsp;</span>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-responsive table-hover table-striped">
                        <thead>
                        <tr>
                            <th>CustomerName</th>
                            <th>Route</th>
                            <th>Total</th>
                            <th>Unpaid</th>
                            <th>User</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        <tr v-for="salePack in salePackages" >
                            <td>
                                <p><i class="fa fa-user">&nbsp;@{{ salePack.customer.name }}</i></p>
                                <span class="small"><i class="fa-mobile">&nbsp;@{{ salePack.customer.mobile_no }}</i></span>
                            </td>
                            <td>@{{ salePack.route ? salePack.route.journey_from+' থেকে '+salePack.route.journey_to : 'N/A'  }}</td>
                            <td>@{{ salePack.total_price }}</td>
                            <td>@{{ salePack.unpaid }}</td>
                            <td>@{{ salePack.user.name }}</td>
                            <td>@{{ salePack.sale_date }}</td>
                            <td>
                                <a :href="'{{ route('memo') }}?packId='+ salePack.id" class="btn btn-sm btn-primary">Generate Memo</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    <div v-if="pagination.total > pagination.per_page" class="col-md-offset-4">
                        <ul class="pagination">
                            <li :class="[{disabled:!pagination.prev_page_url}]">
                                <a @click.prevent="getMemoList(pagination.first_page_url)" href="#">First Page</a>
                            </li>
                            <li :class="[{disabled:!pagination.prev_page_url}]">
                                <a @click.prevent="getMemoList(pagination.prev_page_url)" href="#">Previous</a>
                            </li>
                            <li v-for="n in pagination.last_page" :class="{active:pagination.current_page==n}"  v-if="n<=pagination.current_page+3&&n>=pagination.current_page-3">
                                <a @click.prevent="getMemoList('memo-list?page='+n)" href="#">@{{ n }}</a>
                            </li>
                            <li :class="[{disabled:!pagination.next_page_url}]">
                                <a @click.prevent="getMemoList(pagination.next_page_url)" href="#">Next</a>
                            </li>
                            <li :class="[{disabled:!pagination.next_page_url}]">
                                <a @click.prevent="getMemoList(pagination.last_page_url)" href="#">Last Page</a>
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
            el: "#memoList",

            data:{
                total:0,
                salePackages:[],
                pagination:{},
                errors:[],
                
                customers:{!! json_encode(__customerDropdown()) !!},
                routes:{!! json_encode(__routesDropdown()) !!},
                users:{!! json_encode(__userDropdown()) !!},
                
                search:{
                    customer_id:'',
                    route_id:'',
                    payment_status:'',
                    user_id:'',
                    from_date:'',
                    to_date:'',
                }
            },

            created(){
                this.getMemoList();
            },

            methods:{
                reset(){
                    this.search = {customer_id:'',route_id:'',payment_status:'',user_id:'',from_date:'',to_date:''};
                    this.getMemoList();
                },

                getMemoList(pageUrl) {
                    let that = this;
                    pageUrl = pageUrl == undefined ? `{{route('memo_list')}}` : pageUrl;

                    axios.get(pageUrl, {params:this.search}).then(response=> {
                        that.salePackages = response.data.data;
                        that.pagination = response.data;
                        that.total = that.pagination.total;
                    })
                },
            }
        });
    </script>
@endsection
