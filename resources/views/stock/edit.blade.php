<div id="editModal" class="modal fade" style="margin-top: 5%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Stock </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control" v-model="aStock.quantity">
                    </div>
                    <div class="form-group">
                        <label for="quantity">Unit</label>
                        <select class="form-control" v-model="aStock.item_unit_id">
                            <option value="">-- Select Unit --</option>
                            <option v-for="(unit, id) in units" :value="id">@{{ unit }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">No of Jar</label>
                        <input type="text" class="form-control" v-model="aStock.no_of_jar">
                    </div>
                    <div class="form-group">
                        <label for="quantity">No of Drum</label>
                        <input type="text" class="form-control" v-model="aStock.no_of_drum">
                    </div>
                    <div class="form-group">
                        <label for="price">Unit Price</label>
                        <input type="text" class="form-control" v-model="aStock.price">
                    </div>
                    <div class="form-group">
                        <label for="price">Sale Price</label>
                        <input type="text" class="form-control" v-model="aStock.sale_price">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" v-model="aStock.status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stock_date">Stock Date</label>
                        <input type="date" class="form-control" v-model="aStock.stock_date">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"  @click.prevent="editStock(stock_id)">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
