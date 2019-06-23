<div id="createStock" class="modal fade" style="margin-top: 5%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Stock </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="address">Item</label>
                        <select class="form-control" v-model="newStock.item_id">
                            <option value="">-- Select Item --</option>
                            <option v-for="(item, index) in items" :value="index">@{{ item }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Unit</label>
                        <select class="form-control" v-model="newStock.item_unit_id">
                            <option value="">-- Select Unit --</option>
                            <option v-for="(unit, id) in units" :value="id">@{{ unit }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="text" class="form-control" v-model="newStock.quantity">
                    </div>
                    <div class="form-group">
                        <label for="quantity">No of Jar</label>
                        <input type="text" class="form-control" v-model="newStock.no_of_jar">
                    </div>
                    <div class="form-group">
                        <label for="quantity">No of Drum</label>
                        <input type="text" class="form-control" v-model="newStock.no_of_drum">
                    </div>
                    <div class="form-group">
                        <label for="price">Unit Price</label>
                        <input type="text" class="form-control" v-model="newStock.price">
                    </div>
                    <div class="form-group">
                        <label for="price">Sale Price</label>
                        <input type="text" class="form-control" v-model="newStock.sale_price">
                    </div>
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" v-model="newStock.status">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="stock_date">Stock Date</label>
                        <input type="date" class="form-control" v-model="newStock.stock_date">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"  @click.prevent="createStock">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
