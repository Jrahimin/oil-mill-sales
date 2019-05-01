<div id="editModal" class="modal fade" style="margin-top: 5%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit User </h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" v-model="aUser.name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" v-model="aUser.email">
                    </div>
                    <div class="form-group">
                        <label for="mobile_no">Mobile No</label>
                        <input type="text" class="form-control" v-model="aUser.mobile_no">
                    </div>
                    <div class="form-group">
                        <label for="address">Type</label>
                        <select class="form-control" v-model="aUser.type">
                            <option value="user" :selected="aUser.type=='user'">User</option>
                            <option value="admin" :selected="aUser.type=='admin'">Admin</option>
                        </select>
                        <div class="form-group">
                            <label for="address">Mobile No</label>
                            <input type="text" class="form-control" v-model="aUser.address">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"  @click.prevent="editUser(user_id)">Save</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
