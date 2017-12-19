<template>
  <div @click="onClick">
    <div class="pull-right">
      <img :src="rowData.thumbnail" >
    </div>
    <div class="inline field">
      <label>Title: </label>
      <span>{{rowData.name}}</span>
    </div>
    <div class="inline field">
      <label>Stream Type: </label>
      <span>{{rowData.stream.type.name}}</span>
    </div>
    <div class="inline field">
      <label>Created at: </label>
      <span>{{rowData.created_at}}</span>
    </div>
    <div class="inline field">
      <label>Updated at: </label>
      <span>{{rowData.updated_at}}</span>
    </div>
    <div class="inline field">
      <label>genres: </label>
      <span v-for="genre in rowData.genres" :key="genre.id">
        {{ genre.name }}
      </span>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    rowData: {
      type: Object,
      required: true
    },
    rowIndex: {
      type: Number
    }
  },
  methods: {
    onClick (event) {
      console.log('my-detail-row: on-click', event.target)
    }
  },
}
</script>

<style>
  img{
    height: 200px;
    width: 150px;
  }
</style>
