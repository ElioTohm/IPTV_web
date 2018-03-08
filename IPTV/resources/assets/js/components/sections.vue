<template>
  <div>
    <div class="panel panel-default" v-for="section in sections" :key="section.id" >
        <div class="panel-heading" data-toggle="collapse" :data-target=" '#' + section.id">
            <h2>{{section.name}}</h2>
        </div>
        <div class="panel-collapse collapse" v-bind:id="section.id">
            <div class="row">
                <div class="col-md-4"  v-for="section_item in section.section_item" :key="section_item.id">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>{{section_item.name}}</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <img :src="section_item.poster" />
                            </div>
                            <div class="row">
                                <div>
                                    <h3>Description</h3>
                                    {{section_item.description}}
                                </div>
                                <div>
                                    <h3>Reservation</h3>
                                    {{section_item.reservation}}
                                </div>
                                <div>
                                    <h3>Location</h3>
                                    {{section_item.longitude}},  {{section_item.latitude}}
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    data() {
        return {
            sections:[],
        }
    },
    mounted: function () {
        axios.get('/sections')
        .then(response => {
            this.sections = response.data
        })
        .catch(error => {
            console.log(error);
        });
    },
    methods: {
        /**  
        * Persist the item to storage using the given form.
        */
        persistItem(method, uri, form) {
        axios[method](uri, form)
            .then(response => {
                this.$refs.vuetable.reload()
                form.sections = []            
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
    },
};
</script>
<style>
img {
    width: 100%;
    height: 250px;
}
</style>
