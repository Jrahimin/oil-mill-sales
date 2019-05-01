<div v-if="errors">
    <div v-for="error in errors" class="alert alert-danger alert-dismissible fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        @{{ error }}
    </div>
</div>
