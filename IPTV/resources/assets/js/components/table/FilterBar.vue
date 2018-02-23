<template>
  <div class="filter-bar">
    <form class="form-inline">
      <div class="form-group">
        <label>Search for:</label>
        <input type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter" placeholder="title, name">
        <button class="btn btn-primary" @click.prevent="doFilter">Go</button>
        <button class="btn" @click.prevent="resetFilter">Reset</button>
      </div>
      <div class="form-group pull-right">
          <button class="btn" @click.prevent="showModal">Add</button>
        </div>
    </form>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        filterText: ''
      }
    },
    props: ['objectype'],
    methods: {
      doFilter () {
        this.$events.fire('filter-set', this.filterText)
      },
      resetFilter () {
        this.filterText = ''
        this.$events.fire('filter-reset')
      },
      showModal () {
        this.$parent.showRepectiveModal(this.objectype);
      }
    }
  }
</script>
<style>
.filter-bar {
  padding: 10px;
}
</style>
