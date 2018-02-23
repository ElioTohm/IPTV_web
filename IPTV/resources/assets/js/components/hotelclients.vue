<template>
    <div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2>Clients</h2>
      </div>
      <div class="panel-body">
        <filter-bar objectype="client"></filter-bar>
        <vuetable ref="vuetable"
          api-url="/client"
          :fields="fields"
          pagination-path=""
          :css="css.table"
          :sort-order="sortOrder"
          :multi-sort="true"
          detail-row-component="client-detail-row"
          :append-params="moreParams"
          @vuetable:cell-clicked="onCellClicked"
          @vuetable:pagination-data="onPaginationData"></vuetable>
        <div class="vuetable-pagination">
          <vuetable-pagination-info ref="paginationInfo"
            info-class="pagination-info"></vuetable-pagination-info>
          <vuetable-pagination ref="pagination"
            :css="css.pagination"
            @vuetable-pagination:change-page="onChangePage"></vuetable-pagination>
        </div>
      </div>
    </div>
    <client-modal/>
  </div>
</template>
<script>
import accounting from "accounting";
import moment from "moment";
import Vuetable from "vuetable-2/src/components/Vuetable";
import VuetablePagination from "vuetable-2/src/components/VuetablePagination";
import VuetablePaginationInfo from "vuetable-2/src/components/VuetablePaginationInfo";
import Vue from "vue";
import VueEvents from "vue-events";
import CustomActions from "./table/ClientActions";
import DetailRow from "./table/ClientDetails";
import FilterBar from "./table/FilterBar";
import ClientModal from './modal/client_modal.vue'

Vue.use(VueEvents);
Vue.component("client-actions", CustomActions);
Vue.component("client-detail-row", DetailRow);
Vue.component("filter-bar", FilterBar);

export default {
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
    ClientModal
  },
  data() {
    return {
      fields: [
        {
          name: "name",
          sortField: "name"
        },
        {
          name: "email",
          sortField: "email"
        },
        {
          name: "room",
          title: "room"
        },
        {
          name: "credit",
          title: "credit"
        },
        {
          name: "debit",
          title: "debit"
        },
        {
          name: "created_at",
          title: "Created at",
          sortField: 'created_at' 
        },
        {
          name: "__component:client-actions",
          title: "Actions",
          titleClass: "text-center",
          dataClass: "text-center"
        },
      ],
      css: {
        table: {
          tableClass: "table table-bordered table-striped table-hover",
          ascendingIcon: "glyphicon glyphicon-chevron-up",
          descendingIcon: "glyphicon glyphicon-chevron-down"
        },
        pagination: {
          wrapperClass: "pagination",
          activeClass: "active",
          disabledClass: "disabled",
          pageClass: "page",
          linkClass: "link",
          icons: {
            first: "",
            prev: "",
            next: "",
            last: ""
          }
        },
        icons: {
          first: "glyphicon glyphicon-step-backward",
          prev: "glyphicon glyphicon-chevron-left",
          next: "glyphicon glyphicon-chevron-right",
          last: "glyphicon glyphicon-step-forward"
        }
      },
      sortOrder: [{ field: "name", direction: "asc" }],
      moreParams: {}
    };
  },
  methods: {
    /**
     * show modal depending on the object being manipulated
     */
    showRepectiveModal(modalname) {
      this.$modal.show(modalname, {button: {text :'Add'}})
    },
    /**  
    * Persist the item to storage using the given form.
    */
    persistItem(method, uri, form) {
      form.errors = [];
      axios[method](uri, form)
        .then(response => {
            this.$refs.vuetable.reload()
            form.number = ''
            form.name = ''
            form.email = ''
            form.room = 0
            form.welcome_message = ''
            form.welcome_image = ''
            form.credit = 0
            form.debit = 0
        })
        .catch(error => {
          console.log(error);
          this.$toasted.error("error creating ",{
              duration:1000
          });
        });
    },
    onPaginationData(paginationData) {
      this.$refs.pagination.setPaginationData(paginationData);
      this.$refs.paginationInfo.setPaginationData(paginationData);
    },
    onChangePage(page) {
      this.$refs.vuetable.changePage(page);
    },
    onCellClicked(data, field, event) {
      console.log("cellClicked: ", field.name);
      this.$refs.vuetable.toggleDetailRow(data.id);
    }
  },
  events: {
    "filter-set"(filterText) {
      this.$toasted.info("Searching ...", {
        theme: "primary",
        position: "bottom-center",
        duration: 1000
      });
      this.moreParams = {
        filter: filterText
      };
      Vue.nextTick(() => this.$refs.vuetable.refresh());
    },
    "filter-reset"() {
      this.moreParams = {};
      Vue.nextTick(() => this.$refs.vuetable.refresh());
    }
  }
};
    // import pagination from 'laravel-vue-pagination';
    // export default {
    //     components: {
    //         'pagination': pagination
    //     },
    //     data () {
    //         return {
    //             pagedata:{},
    //             clients: [],
    //             monitor:{
    //                 count: 0
    //             },
    //             notification: {
    //                 id: 0,
    //                 message: ''
    //             },

    //             createForm: {
    //                     errors: [],
    //                     name: '',
    //                     email : '',
    //                     room : '',
    //                     welcome_message : '',
    //                     welcome_image: '',
    //                     credit : 0,
    //                     debit : 0, 
    //                 },

    //             editForm: {
    //                 errors: [],
    //                 name : '',
    //                 email : '',
    //                 room : '',
    //                 welcome_message : '',
    //                 welcome_image: '',
    //                 credit : 0,
    //                 debit : 0,
    //             },

    //             search: {
    //                 errors: [],
    //                 model: 'Client',
    //                 query: ''
    //             }
    //         }
    //     },
    //     mounted () {
    //         this.getClient();
    //     },
    //     watch: {
    //             'search.query': function(){
    //                 if (this.search.query != '') {
    //                     axios.get('/search', {params : this.search})
    //                         .then(response => {
    //                             this.clients = response.data;
    //                         })
    //                         .catch(error => {
    //                             console.log(error.response.data)
    //                         });
    //                 } else {
    //                     this.getClient();
    //                 }
                    
    //             }
    //         },
    //     methods: {
    //         /* 
    //         * assign the image to a model
    //         */
    //         createImage(file) {
    //             let reader = new FileReader();
    //             let vm = this;
    //             vm.editForm.welcome_image = '';
    //             reader.onload = (e) => {
    //                 vm.createForm.welcome_image = e.target.result;
    //                 vm.editForm.welcome_image = e.target.result;
                        
    //             };
    //             reader.readAsDataURL(file);
    //         },

    //         /*
    //         * create the file 
    //         */
    //         onFileChange(e) {
    //             let files = e.target.files || e.dataTransfer.files;
    //             if (!files.length)
    //             this.createImage(files[0]);
    //         },
            
    //         notificationwindows(client) {
    //             this.notification.id = client.room
    //             $('#modal-notify-hotelclient').modal('show');
    //         },
            
    //         // send notification to client
    //         sendnotification() {
    //             axios.get('/clientnotification/'+this.notification.id,{
    //                     params:{
    //                         message: this.notification.message
    //                     }
    //                 })
    //                 .then(response => {
    //                         console.log(response)
    //                 })
    //                 .catch(error => {
    //                     console.log(error.response.data)
    //                 });
    //         },

    //         // return all clients
    //         getClient (page) {
    //             if (typeof page === 'undefined') {
    //                 page = 1;
    //             }
    //             axios.get('/client?page=' + page)
    //                 .then(response => {
    //                     this.pagedata = response.data;
    //                     this.clients = this.pagedata.data;
    //                 })
    //                 .catch(error => {
    //                     console.log(error.response.data)
    //                 });
    //         },
        
    //         /**
    //          * Show the form for adding new client.
    //          */
    //         showAddClientForm() {
    //             $('#modal-add-client').modal('show');
    //         },

    //         /**
    //          * Create a new OAuth client for the user.
    //          */
    //         store() {
    //             this.persistClient(
    //                 'post', '/client',
    //                 this.createForm, '#modal-create-client'
    //             );
    //         },

    //         /**
    //          * Edit the given client.
    //          */
    //         edit(client) {
    //             this.editForm.id = client.id;
    //             this.editForm.name = client.name;
    //             this.editForm.email = client.email
    //             this.editForm.room = client.room;
    //             this.editForm.welcome_message = client.welcome_message;
    //             this.editForm.welcome_image = client.welcome_image;
    //             this.editForm.credit = client.credit;
    //             this.editForm.debit = client.debit;

    //             $('#modal-edit-hotelclient').modal('show');
    //         },

    //         /**
    //          * Update the client being edited.
    //          */
    //         update() {
    //             this.persistClient(
    //                 'put', '/client/' + this.editForm.id,
    //                 this.editForm, '#modal-edit-hotelclient'
    //             );
    //         },

    //         /**
    //          * Persist the client to storage using the given form.
    //          */
    //         persistClient(method, uri, form, modal) {
    //             form.errors = [];

    //             axios[method](uri, form)
    //                 .then(response => {
    //                     if (typeof response.data.error != "undefined") {
    //                         form.errors = [response.data.error];
    //                     } else {
    //                         this.getClient();

    //                         form.errors = [];
    //                         form.name = '';
    //                         form.email = '';
    //                         form.room = '';
    //                         form.welcome_message = '';
    //                         form.welcome_image = '';
    //                         form.credit = '';
    //                         form.debit = '';
                            
    //                         $(modal).modal('hide');
    //                     }
                        
    //                 })
    //                 .catch(error => {
    //                     if (typeof error.response.data === 'object') {
    //                         form.errors = _.flatten(_.toArray(error.response.data));
    //                     } else {
    //                         form.errors = ['Something went wrong. Please try again.'];
    //                     }
    //                     console.log(error.response.data)
    //                 });
    //         },

    //         /**
    //          * Destroy the given client.
    //          */
    //         destroy(client) {
    //             this.$toasted.error("Remove "+client.name+"?", { 
    //                 theme: "primary", 
    //                 position: "top-center", 
    //                 action : [{
    //                             text : 'Delete',
    //                             onClick : (e, toastObject) => {
    //                                 toastObject.goAway(0);
    //                                 axios.delete('/client/' + client.id)
    //                                         .then(response => {
    //                                             this.getClient();
    //                                         });
    //                             }
    //                         },
    //                         {
    //                             text : 'Cancel',
    //                             onClick : (e, toastObject) => {
    //                                 toastObject.goAway(0);
    //                             }
    //                         }],
    //             });
    //         },
            
    //     }
    // }
</script>
