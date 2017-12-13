<template>
<modal name="movie" class="modal-content" transition="pop-out" @before-open="beforeOpen" :adaptive="true" height="auto">
    <div class="modal-header">{{button.text}} Movie</div>
    <div class="modal-body">
    <form>
        <div class="form-horizontal">
            <!-- title -->
            <div class="form-group">
                <label class="col-md-3 control-label">Title</label>

                <div class="col-md-7">
                    <input type="text" class="form-control" v-model="form.title">
                </div>
            </div>

            <!-- stream -->
            <div class="form-group">
                <label class="col-md-3 control-label">Stream</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" v-model="form.stream">
                </div>
            </div>

            <!-- stream type -->
            <div class="form-group">
                <label class="col-md-3 control-label">Stream Type</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" v-model="form.stream_type">
                </div>
            </div>

            <!-- poster -->
            <div class="form-group">
                <label class="col-md-3 control-label">Poster</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" v-model="form.poster">
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
export default {
  name: 'MovieModal',
  data(){
    return {
      action : "",
      item : "",
      button : {
        text : ""
      },
      genres:[],
      stream_types:[],
      form: {
          errors: [],
          id: '',
          title: '',
          stream: '',
          stream_type: 0,
          poster: '',
          genres : []
      },
    }
  },
  methods: {
    beforeOpen (event) {
        this.button.text = event.params.button.text
        if (this.button.text == "Add"){
            this.action = "post"
            this.form.title = ''
            this.form.poster = ''
            this.form.stream = ''
            this.form.id = ''
            this.item = event.name
        }else {
            this.action = "put"
            this.form.title = event.params.button.editForm.title
            this.form.poster = event.params.button.editForm.poster
            this.form.stream = event.params.button.editForm.stream.vid_stream
            this.form.stream_type = event.params.button.editForm.stream.type
            this.form.id = event.params.button.editForm.id
            this.item = event.name + '/' + this.form.id
        }
        
    },
    addItem () {
        this.$parent.persistItem(this.action, '/' + this.item, this.form)
    },
  }
}
</script>