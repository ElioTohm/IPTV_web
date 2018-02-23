<template>
<modal name="client" class="modal-content" @before-open="beforeOpen" transition="nice-modal-fade"
        height="auto"
        :adaptive="true"
        :resizable="true">
    <div class="modal-header">{{button.text}} {{item}}</div>
    <div class="modal-body">
        <form>
            <div class="form-horizontal">
                <!-- name -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Client's Name</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="form.name">
                    </div>
                </div>
                <!-- email -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Email</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="form.email">
                    </div>
                </div>
                <!-- room -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Room</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="form.room">
                    </div>
                </div>
                <!-- credit -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Credit</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="form.credit">
                    </div>
                </div>
                <!-- debit -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Debit</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="form.debit">
                    </div>
                </div>
                <!-- welcome message -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Welcome Message</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="form.welcome_message">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" @click="addItem()">{{button.text}}</button>
    </div>
</modal>
</template>
<script>
import multiselect from 'vue-multiselect';

export default {
    name: 'ChannelModal',
    components: {
        'multiselect': multiselect
    },
    data(){
        return {
            action : "",
            item : "",
            button : {
                text : ""
            },
            stream_types:[],
            genres:[],
            form: {
                id: 0,
                errors: [],
                name: '',
                email: '',
                room: 0,
                welcome_message: '',
                // welcome_image: '',
                credit: 0,
                debit: 0
            },
        }
    },
    methods: {
        createImage(file) {
            let reader = new FileReader();
            reader.onload = (e) => {
                    this.form.image = e.target.result;
                };
                reader.readAsDataURL(file);
        },
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                console.log('wrg length');
            this.createImage(files[0]);
        },
        beforeOpen (event) {
            this.button.text = event.params.button.text
            this.item = event.name
            if (this.button.text == "Add") {
                this.action = 'post'
                this.form.name = ''
                this.form.email = ''
                this.form.room = 0
                this.form.welcome_message = ''
                // this.form.welcome_image = ''
                this.form.credit = 0
                this.form.debit = 0
            } else {
                this.action = "put"
                this.form.name = event.params.editForm.name
                this.form.email = event.params.editForm.email
                this.form.room = event.params.editForm.room
                this.form.welcome_message = event.params.editForm.welcome_message
                // this.form.welcome_image = event.params.editForm.welcome_image
                this.form.credit = event.params.editForm.credit
                this.form.debit = event.params.editForm.debit
                console.log(event.params.editForm)
            }
        axios.get();
    },
    addItem () {
        var route = (this.action == "post") ? '/' + this.item : '/' + this.item  + '/' + this.form.id
        console.log(route)
        this.$parent.persistItem(this.action, route, this.form)
    },
  }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>