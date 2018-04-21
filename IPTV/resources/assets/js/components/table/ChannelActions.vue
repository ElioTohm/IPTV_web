  <template>
    <div class="custom-actions">
      <button class="btn btn-sm" @click="itemAction('edit', rowData, rowIndex)"><i class="glyphicon glyphicon-pencil"></i></button>
      <button class="btn btn-sm" @click="itemAction('delete', rowData, rowIndex)"><i class="glyphicon glyphicon-trash"></i></button>
      <button class="btn btn-sm" @click="itemAction('record', rowData, rowIndex)"><i class="glyphicon glyphicon-record"></i></button>
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
        } else {
          axios.get('/record/' + data.id)
          .then(response => {
            console.log(response);
          })
          .catch(error => {
            console.log(error);
          });
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
