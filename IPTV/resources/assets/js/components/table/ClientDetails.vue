<template>
  <div @click="onClick">
    <div class="pull-right">
      <img :src="rowData.thumbnail" >
    </div>
    <div class="inline field">
      <label>Name: </label>
      <span>{{rowData.name}}</span>
    </div>
    <div class="inline field">
      <label>Email: </label>
      <span>{{rowData.email}}</span>
    </div>
    <div class="inline field">
      <label>Welcome message: </label>
      <span>{{rowData.welcome_message}}</span>
    </div>
    <div class="inline field">
      <label>Credits: </label>
      <span>{{rowData.credit}} Units</span>
    </div>
    <div class="inline field">
      <label>Debit: </label>
      <span>{{rowData.debit}} Units</span>
    </div>
    <div class="inline field">
      <label>Added Client at: </label>
      <span>{{rowData.created_at}}</span>
    </div>
    <div class="inline field">
      <label>Info Updated at: </label>
      <span>{{rowData.updated_at}}</span>
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

