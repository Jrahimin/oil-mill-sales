<div class="panel panel-primary">
    <div class="panel-heading">Search</div>
    <div class="panel-body">
        <form class="form-inline">
            <select class="form-control mb-2 mr-sm-2" v-model="search.category_id" @change="getItemsForCategory">
                <option value="">Select Category</option>
                <option v-for="(category,id) in searchCategories" :value="id">@{{ category }}</option>
            </select>

            <select class="form-control mb-2 mr-sm-2" v-model="search.item_id">
                <option value="">Select Item</option>
                <option v-for="(item,id) in searchItems" :value="id">@{{ item }}</option>
            </select>

            <select class="form-control mb-2 mr-sm-2" v-model="search.stock_place">
                <option value="">Select Place</option>
                <option value="1">পুরাতন মিল</option>
                <option value="2">নতুন মিল</option>
            </select>

            <select class="form-control mb-2 mr-sm-2" v-model="search.status">
                <option value="">Select Status</option>
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>

            <input type="date" class="form-control mb-2 mr-sm-2" v-model="search.from_date" placeholder="From"> To

            <input type="date" class="form-control mb-2 mr-sm-2" v-model="search.to_date" placeholder="To">

            <button type="submit" class="btn btn-primary mb-2" @click.prevent="getStockList('')">Search</button>
            <button type="submit" class="btn btn-danger mb-2" @click.prevent="reset">Reset</button>
        </form>
    </div>
</div>
