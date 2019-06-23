<div id="editModal" class="modal fade" style="margin-top: 5%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Customer </h4>
            </div>
            <div class="modal-body">
                <form>

                    <div class="form-group">
                        <label for="quantity">Name</label>
                        <input type="text" class="form-control" v-model="aCustomer.name">
                    </div>
                    <div class="form-group">
                        <label for="price">Mbile Number</label>
                        <input type="text" class="form-control" v-model="aCustomer.mobile_no">
                    </div>

                    <div class="form-group">
                        <label for="price">Address</label>
                        <input type="text" class="form-control" v-model="aCustomer.address">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"  @click.prevent="editCustomer(customer_id)">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
