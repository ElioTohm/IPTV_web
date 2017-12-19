<template>
  <div>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h2>Movies</h2>
      </div>
      <div class="panel-body">
        <filter-bar></filter-bar>
        <vuetable ref="vuetable"
          api-url="/movies"
          :fields="fields"
          pagination-path=""
          :css="css.table"
          :sort-order="sortOrder"
          :multi-sort="true"
          detail-row-component="my-detail-row"
          :append-params="moreParams"
          @vuetable:cell-clicked="onCellClicked"
          @vuetable:pagination-data="onPaginationData"
        ></vuetable>
        <div class="vuetable-pagination">
          <vuetable-pagination-info ref="paginationInfo"
            info-class="pagination-info"
          ></vuetable-pagination-info>
          <vuetable-pagination ref="pagination"
            :css="css.pagination"
            @vuetable-pagination:change-page="onChangePage"
          ></vuetable-pagination>
        </div> 
      </div>
    </div>
    <movie-modal/>
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
import CustomActions from "./table/CustomActions";
import DetailRow from "./table/DetailRow";
import FilterBar from "./table/FilterBar";
import MovieModal from './modal/movie_modal.vue'

Vue.use(VueEvents);
Vue.component("custom-actions", CustomActions);
Vue.component("my-detail-row", DetailRow);
Vue.component("filter-bar", FilterBar);

export default {
  components: {
    Vuetable,
    VuetablePagination,
    VuetablePaginationInfo,
    MovieModal
  },
  data() {
    return {
      error: {},
      fields: [
        {
          name: "title",
          sortField: "title"
        },
        {
          name: "stream.vid_stream",
          title: "Steam"
        },
        {
          name: "stream.type.name",
          title: "Steam Type",
        },
        {
          name: "created_at",
          title: "Created at",
          sortField: 'created_at' 
        },
        {
          name: "__component:custom-actions",
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
      sortOrder: [{ field: "title", direction: "asc" }],
      moreParams: {}
    };
  },
  methods: {
    /**
     * show modal depending on the object being manipulated
     */
    showRepectiveModal() {
      this.$modal.show('movie', {button: {text :'Add'}})
    },
    /**  
    * Persist the item to storage using the given form.
    */
    persistItem(method, uri, form) {
      axios[method](uri, form)
        .then(response => {
            this.$refs.vuetable.reload()
            form.title = ''            
            form.poster = ''
            form.stream = ''
            form.id = ''
            form.stream_type = ''
            form.errors = []
            form.genres = []
        })
        .catch(error => {
          for (var property in error.response.data) {
            this.$toasted.show(error.response.data[property][0],{
                action : {
                  text : 'Ok',
                  onClick : (e, toastObject) => {
                      toastObject.goAway(0);
                  }
                },
            });
          }
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
<style>
.pagination {
  margin: 0;
  float: right;
}
.pagination a.page {
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 10px;
  margin-right: 2px;
}
.pagination a.page.active {
  color: white;
  background-color: #337ab7;
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 10px;
  margin-right: 2px;
}
.pagination a.btn-nav {
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 7px;
  margin-right: 2px;
}
.pagination a.btn-nav.disabled {
  color: lightgray;
  border: 1px solid lightgray;
  border-radius: 3px;
  padding: 5px 7px;
  margin-right: 2px;
  cursor: not-allowed;
}
.pagination-info {
  float: left;
}
</style>
