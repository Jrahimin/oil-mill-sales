<div class="panel panel-primary">
    <div class="panel-heading">Search</div>
    <div class="panel-body">
        <form class="form-inline">
            <select class="form-control mb-2 mr-sm-2" v-model.number="search.customer_id">
                <option value="">Select Customer</option>
                <option v-for="(customer,id) in customers" :value="id">@{{ customer }}</option>
            </select>

            <select class="form-control mb-2 mr-sm-2" v-model.number="search.route_id">
                <option value="">Select Route</option>
                <option v-for="(route,id) in routes" :value="id">@{{ route }}</option>
            </select>

            <select class="form-control mb-2 mr-sm-2" v-model.number="search.payment_status">
                <option value="">Select Payment Status</option>
                <option value="0">Paid</option>
                <option value="1">Unpaid</option>
            </select>

            <select class="form-control mb-2 mr-sm-2" v-model.number="search.user_id">
                <option value="">Sold By</option>
                <option v-for="(user,id) in users" :value="id">@{{ user }}</option>
            </select>

            <input type="date" class="form-control mb-2 mr-sm-2" v-model="search.from_date" placeholder="From"> To

            <input type="date" class="form-control mb-2 mr-sm-2" v-model="search.to_date" placeholder="To">

            <button type="submit" class="btn btn-primary mb-2" @click.prevent="getMemoList('')">Search</button>
            <button type="submit" class="btn btn-danger mb-2" @click.prevent="reset">Reset</button>
        </form>
    </div>
</div>
