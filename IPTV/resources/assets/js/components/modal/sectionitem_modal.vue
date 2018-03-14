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
                        <input type="text" class="form-control" v-model="form.name">
                    </div>
                </div>
                <!-- Poster  -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Poster</label>

                    <div class="col-md-7">
                        <input class="form-control" type="text" v-model="form.poster">
                    </div>
                    <div class="col-md-2">
                        <label class="btn btn-primary" for="poster-selector">
                            <input id="poster-selector" type="file" style="display:none;" @change="posterfilename($event)">
                            change
                        </label>
                    </div>
                </div>
                <!-- Description -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Description</label>
                    <div class="col-md-7">
                        <textarea type="text" class="form-control" v-model="form.description"></textarea>
                    </div>
                </div>
                <!-- Reservation -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Reservation</label>
                    <div class="col-md-7">
                        <input type="checkbox" v-model="form.reservation">
                    </div>
                </div>
                <!-- latitude -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Latitude</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="form.latitude">
                    </div>
                </div>
                <!-- longitude -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Longitude</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="form.longitude">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button v-if="button.text == 'Edit'" class="btn btn-danger" @click="removeItem()">Delete</button>
        <button class="btn btn-primary" @click="addItem()">{{button.text}}</button>
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
                sectionid: '',
                id:'',
                name: '',
                poster: '',
                reservation: false,
                longitutde: '',
                latitude: '',
                description: '',
            },
        }
    },
    methods: {
        beforeOpen (event) {
            this.button.text = event.params.button.text
            this.item = event.name
            if (this.button.text == "Add") {
                this.action = 'post'
                this.form.id = ''
                this.form.sectionid = event.params.editForm.sectionid
                this.form.name = ''
                this.form.poster = ''
                this.form.reservation = false
                this.form.longitutde = ''
                this.form.latitude = ''
                this.form.description = ''
            } else {
                this.action = "put"
                this.form.section = event.params.editForm.sectionmodal
                this.form.sectionid = event.params.editForm.sectionid
                this.form.id = event.params.editForm.id
                this.form.name = event.params.editForm.name
                var poster = event.params.editForm.poster.split('/')
                this.form.poster = poster[poster.length - 1]
                this.form.reservation = event.params.editForm.reservation
                this.form.longitutde = event.params.editForm.longitutde
                this.form.latitude = event.params.editForm.latitude
                this.form.description = event.params.editForm.description
            }
        },
        addItem () {
            var route = (this.action == "post") ? '/' + this.item : '/' + this.item  + '/' + this.form.id
            this.$parent.persistItem(this.action, route, this.form)
        },
        removeItem () {
            var route = this.item  + '/' + this.form.id
            this.$parent.persistItem('delete', route, null)
        },
        posterfilename (event) {
            this.form.poster = event.target.files[0].name
        }
    }
}
</script>