<template>
  <div>
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
      <label>Balance: </label>
      <span>{{rowData.balance}} Units</span>
    </div>
    <div class="inline field">
      <label>Added Client at: </label>
      <span>{{rowData.created_at}}</span>
    </div>
    <div class="inline field">
      <label>Info Updated at: </label>
      <span>{{rowData.updated_at}}</span>
    </div>
     <div class="inline field">
      <label><u>Purchased Items</u>: </label>
      <div v-for="itempurchased in rowData.purchases" :key="itempurchased.id">
        <div v-if="itempurchased.purchasable_type == 'App\\Channel'">
          <label>Channel: </label>
          <span> {{itempurchased.purchasable.name}}</span>
          <label>Price: </label>
          <span>{{itempurchased.purchasable.price}}</span>
          <label>Purchased on: </label>
          <span>{{itempurchased.created_at}}</span>
        </div>
        <div v-else-if="itempurchased.purchasable_type == 'App\\Movie'">
          <label>Movie: </label>
          <span> {{itempurchased.purchasable.title}}</span>
          <label>Price: </label>
          <span>{{itempurchased.purchasable.price}}</span>
          <label>Purchased on: </label>
          <span>{{itempurchased.created_at}}</span>
        </div>
      </div>
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
}
</script>

