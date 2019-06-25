<div id="createVehicle" class="modal fade" style="margin-top: 5%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Vehicle </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="quantity">Title</label>
                        <input type="text" class="form-control" v-model="newVehicle.title">
                    </div>
                    <div class="form-group">
                        <label for="price">Serial Number</label>
                        <input type="text" class="form-control" v-model="newVehicle.serial_no">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"  @click.prevent="createVehicle">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
