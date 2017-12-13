<template>
    <div class="filter-bar">
      <form class="form-inline">
        <div class="form-group">
          <label>Search for:</label>
          <input type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter" placeholder="title, stream">
          <button class="btn btn-primary" @click.prevent="doFilter">Go</button>
          <button class="btn" @click.prevent="resetFilter">Reset</button>
        </div>
        <div class="form-group pull-right">
          <button class="btn" @click.prevent="$modal.show('movie', {button: {text :'Add'}})">Add</button>
        </div>
      </form>
      <movie-modal/>
    </div>
</template>

<script>
import MovieModal from '../modal/movie_modal.vue'

  export default {
    components: {
      MovieModal,
    },
    data () {
      return {
        filterText: ''
      }
    },
    methods: {
      doFilter () {
        this.$events.fire('filter-set', this.filterText)
      },
      resetFilter () {
        this.filterText = ''
        this.$events.fire('filter-reset')
      },
      /**  
      * Persist the channel to storage using the given form.
      */
      persistItem(method, uri, form) {
        form.errors = [];
        axios[method](uri, form)
          .then(response => {
              this.$parent.$refs.vuetable.reload()
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
<style>
.filter-bar {
  padding: 10px;
}
</style>
