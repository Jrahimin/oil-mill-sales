<div id="createCustomer" class="modal fade" style="margin-top: 5%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Customer </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="quantity">Name</label>
                        <input type="text" class="form-control" v-model="newCustomer.name">
                    </div>
                    <div class="form-group">
                        <label for="price">Mobile Number</label>
                        <input type="text" class="form-control" v-model="newCustomer.mobile_no">
                    </div>
                    <div class="form-group">
                        <label for="price">Address</label>
                        <textarea class="form-control" v-model="newCustomer.address"></textarea>
                    </div>


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"  @click.prevent="createCustomer">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
