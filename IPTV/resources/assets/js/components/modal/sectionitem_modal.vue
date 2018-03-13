<template>
<modal name="sectionitem" class="modal-content" @before-open="beforeOpen" transition="nice-modal-fade"
        height="auto"
        :adaptive="true"
        :resizable="true">
    <div class="modal-header">{{button.text}} {{item}}</div>
    <div class="modal-body">
        <form>
            <div class="form-horizontal">
                <!-- name -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Name</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="form.item.name">
                    </div>
                </div>
                <!-- Description -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Description</label>
                    <div class="col-md-7">
                        <textarea type="text" class="form-control" v-model="form.item.description"></textarea>
                    </div>
                </div>
                <!-- Reservation -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Reservation</label>
                    <div class="col-md-7">
                        <input type="checkbox" v-model="form.item.reservation">
                    </div>
                </div>
                <!-- latitude -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Latitude</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="form.item.latitude">
                    </div>
                </div>
                <!-- longitude -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Longitude</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="form.item.longitude">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button class="btn btn-primary" @click="addItem()">{{button.text}}</button>
        <button v-if="button.text == 'Edit'" class="btn btn-danger" @click="removeItem()">Delete</button>
    </div>
</modal>
</template>
<script>
export default {
    name: 'ChannelModal',
    data(){
        return {
            item: "",
            action : "",
            button : {
                text : ""
            },
            stream_types:[],
            genres:[],
            form: {
                section: {},
                item: {}
            },
        }
    },
    methods: {
        beforeOpen (event) {
            this.button.text = event.params.button.text
            this.item = event.name
            if (this.button.text == "Add") {
                this.action = 'post'
                this.form.section = event.params.editForm.section
                this.form.item = {}
            } else {
                this.action = "put"
                this.form.section = event.params.editForm.section
                this.form.item = event.params.editForm.item
            }
        },
        addItem () {
            var route = (this.action == "post") ? '/' + this.item : '/' + this.item  + '/' + this.form.item.id
            this.$parent.persistItem(this.action, route, this.form)
        },
        removeItem () {
            var route = this.item  + '/' + this.form.item.id
            this.$parent.persistItem('delete', route, null)
        }
    }
}
</script>