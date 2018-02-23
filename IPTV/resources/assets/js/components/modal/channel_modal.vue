<template>
<modal name="channel" class="modal-content" @before-open="beforeOpen" transition="nice-modal-fade"
        height="auto"
        :adaptive="true"
        :resizable="true">
    <div class="modal-header">{{button.text}} {{item}}</div>
    <div class="modal-body">
        <form>
            <div class="form-horizontal">
                <!-- number -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Number</label>

                    <div class="col-md-7">
                        <input id="create-channel-name" type="text" class="form-control" v-model="form.number">
                    </div>
                </div>

                <!-- name -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Name</label>

                    <div class="col-md-7">
                        <input id="create-channel-name" type="text" class="form-control" v-model="form.name">
                    </div>
                </div>

                <!-- stream  -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Stream</label>

                    <div class="col-md-7">
                        <input id="create-channel-name" type="text" class="form-control" v-model="form.stream">
                    </div>
                </div>

                <!-- thumbnail  -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Thumbnail</label>

                    <div class="col-md-7">
                        <input class="form-control" type="file" v-on:change="onFileChange">
                    </div>
                </div>

                <!-- genre -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Genre</label>

                    <div class="col-md-7">
                        <multiselect v-model="form.genres" :options="genres" :custom-label="nameWithLang" 
                                    placeholder="Select genres" label="name" track-by="name" 
                                    :multiple="true" :hide-selected="true" :close-on-select="false">
                            <span class="custom__tag"><span>{{ genres.name }}</span><span class="custom__remove" >❌</span></span>
                        </multiselect>
                    </div>
                </div>
                <!-- Stream Type -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Stream Type</label>
                    <div class="col-md-7">
                        <multiselect v-model="form.stream_type" :options="stream_types" :custom-label="nameWithLang" 
                                placeholder="Select stream types" label="name" track-by="id" 
                                :multiple="false" :hide-selected="false" :close-on-select="true">
                            <span class="custom__tag"><span>{{ stream_types.name }}</span><span class="custom__remove" >❌</span></span>
                        </multiselect>
                    </div>
                </div>
                <!-- Price -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Stream Type</label>
                    <div class="col-md-7">
                        <input type="number" v-model="form.price">
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
                number: 0,
                name: '',
                stream: '',
                stream_type: 0,
                thumbnail: '',
                genres : [],
                image : '',
                price : 0
            },
        }
    },
    mounted: function () {
        axios.get('/genreSTypes')
        .then(response => {
            this.genres = response.data.genres
            this.stream_types = response.data.stream_types
        })
        .catch(error => {
          console.log(error);
        });
    },
    methods: {
        nameWithLang ({ id, name }) {
            return `${name}`
        },
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
                this.form.number = ''
                this.form.name = ''
                this.form.thumbnail = ''
                this.form.stream = ''
                this.form.id = ''
                this.form.stream_type = ''
                this.form.genres = []
                this.form.price = 0
            }else {
                this.action = "put"
                this.form.number = event.params.button.editForm.number
                this.form.name = event.params.button.editForm.name
                this.form.thumbnail = event.params.button.editForm.thumbnail
                this.form.stream = event.params.button.editForm.stream.vid_stream
                this.form.genres = event.params.button.editForm.genres
                this.form.stream_type = event.params.button.editForm.stream.type
                this.form.id = event.params.button.editForm.id
                this.form.price = event.params.button.editForm.price
            }
        axios.get();
    },
    addItem () {
        this.$parent.persistItem(this.action, '/' + this.item  + '/' + this.form.id, this.form)
    },
  }
}
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>