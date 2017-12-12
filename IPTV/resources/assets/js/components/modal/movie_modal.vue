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
                      <input type="text" class="form-control" v-model="createForm.title">
                  </div>
              </div>

              <!-- stream -->
              <div class="form-group">
                  <label class="col-md-3 control-label">Stream</label>
                  <div class="col-md-7">
                      <input type="text" class="form-control" v-model="createForm.stream">
                  </div>
              </div>

              <!-- stream type -->
              <div class="form-group">
                  <label class="col-md-3 control-label">Stream Type</label>
                  <div class="col-md-7">
                      <input type="text" class="form-control" v-model="createForm.stream_type">
                  </div>
              </div>

              <!-- poster -->
              <div class="form-group">
                  <label class="col-md-3 control-label">Poster</label>
                  <div class="col-md-7">
                      <input type="text" class="form-control" v-model="createForm.poster">
                  </div>
              </div>

          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" @click="persistChannel('post', '/movie', createForm)">{{button.text}}</button>
      </div>
</modal>
</template>
<script>
export default {
  name: 'MovieModal',
  data(){
    return {
      button : {
        text : ""
      },
      genres:[],
      stream_types:[],
      createForm: {
          errors: [],
          title: '',
          stream: '',
          stream_type: 0,
          poster: '',
          genres : []
      },
      editForm: {
          errors: [],
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
    },
    /**  
     * Persist the channel to storage using the given form.
     */
    persistChannel(method, uri, form) {
        form.errors = [];
        axios[method](uri, form)
          .then(response => {
              form.errors = [];
              form.title = '';
              form.stream = '';
              form.stream_type = 1;
              form.thumbnail = '';
              form.poster = '';
              form.number = '';
              this.$parent.$options.methods.resetFilter()
          })
          .catch(error => {
              console.log(error);
              this.$toasted.error("error creating ",{
                  duration:1000
              });
          });
    },
  }
}
</script>