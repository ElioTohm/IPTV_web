  <template>
    <div class="custom-actions">
      <button class="btn btn-sm" @click="itemAction('edit', rowData, rowIndex)"><i class="glyphicon glyphicon-pencil"></i></button>
      <button class="btn btn-sm" @click="itemAction('delete', rowData, rowIndex)"><i class="glyphicon glyphicon-trash"></i></button>
      <button v-if="rowData.stream.catchup && rowData.stream.catchup_time == 75600" class="btn btn-sm btn-primary">
        Catchup <i class="glyphicon glyphicon-record"></i>
      </button>
      <button v-else class="btn btn-sm" @click="catchup(rowData, 75600)">
        Catchup <i class="glyphicon glyphicon-record">
      </i></button>
      <button v-if="rowData.stream.catchup && rowData.stream.catchup_time < 75600" class="btn btn-sm btn-primary">
        PassThrough <i class="glyphicon glyphicon-hdd"></i>
      </button>
      <button v-else class="btn btn-sm" @click="catchup(rowData, 600)">
        PassThrough <i class="glyphicon glyphicon-hdd"></i>
      </button>
      <button v-if="!rowData.stream.catchup" class="btn btn-sm btn-primary" @click="catchup(rowData, 600)">
        Original <i class="ionicons ion-network"></i>
      </button>
      <button v-else class="btn btn-sm" @click="disableCatchup(rowData)">
        Original <i class="ionicons ion-network"></i>
      </button>
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
       catchup (data, time) {
        axios.get('/catchup/' + data.id + '/' + time)
          .then(response => {
            setTimeout(() => this.$parent.reload(), 2000);
          })
          .catch(error => {
            console.log(error);
          });
      },
      disableCatchup (data) {
        axios.get('/disablecatchup/' + data.id)
          .then(response => {
            setTimeout(() => this.$parent.reload(), 2000);
          })
          .catch(error => {
            console.log(error);
          });
      },
      itemAction (action, data, index) {
        if (action == 'delete') {
          this.$toasted.show("Delete " + data.name + " ?", { 
            theme: "primary", 
            position: "top-center", 
            action : [
              {
                text : 'Delete',
                onClick : (e, toastObject) => {
                    toastObject.goAway(0);
                    axios.delete('/channel/' + data.id)
                    .then(response => {
                      this.$parent.reload();
                    });
                }
              },
              {
                text : 'Cancel',
                onClick : (e, toastObject) => {
                    toastObject.goAway(0);
                }
              }
            ],
          });  
        } else if (action == 'edit') {
          this.$parent.$modal.show(
            'channel', 
            {button: 
              {text :'Edit', 
                editForm:{
                  id: data.id,
                  number: data.number,
                  name: data.name,
                  stream: data.stream,
                  genres: data.genres,
                  thumbnail: data.thumbnail,
                  price: data.price
                }
              }})
        }
      }
    }
  }
  </script>

  <style>
    .custom-actions button.ui.button {
      padding: 8px 8px;
    }
    .custom-actions button.ui.button > i.icon {
      margin: auto !important;
    }
  </style>
