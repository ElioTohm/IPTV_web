  <template>
    <div class="custom-actions">
      <button class="btn btn-sm" @click="itemAction('edit', rowData, rowIndex)"><i class="glyphicon glyphicon-pencil"></i></button>
      <button class="btn btn-sm" @click="itemAction('delete', rowData, rowIndex)"><i class="glyphicon glyphicon-trash"></i></button>
      <button class="btn btn-sm" @click="itemAction('checkout', rowData, rowIndex)"><i class=" glyphicon glyphicon-shopping-cart"></i></button>
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
                    axios.delete('/client/' + data.id)
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
        }else{
          this.$parent.$modal.show(
            'client', 
            {
              button: 
                {text :'Edit'},
              editForm:{
                  id: data.id,
                  name: data.name,
                  email: data.email,
                  room: data.room,
                  welcome_message: data.welcome_message,
                  welcome_image: data.welcome_image,
                  debit: data.balance
                }
            }
          )
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
