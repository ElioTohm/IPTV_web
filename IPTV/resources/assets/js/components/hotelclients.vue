<template>
    <div>
    <div class="panel panel-primary">
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
          sortField: "Name"
        },
        {
          name: "email",
          sortField: "Email"
        },
        {
          name: "room",
          title: "Room Number"
        },
        {
          name: "balance",
          title: "Balance"
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
            form.balance = 0
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
</script>
