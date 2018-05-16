<template>
<div>
    <div class="panel panel-primary" v-for="section in sections" :key="section.id" >
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-10" data-toggle="collapse" :data-target=" '#' + section.id">
                    <p class="text-uppercase"><b>{{section.name}}</b></p>
                </div>
                <div class="col-xs-1">
                    <button v-if="section.active" class="btn btn-success pull-right" @click="activatetoggle(section)">Activate <span class="glyphicon glyphicon-check"></span></button>
                    <button v-else class="btn btn-warning pull-right" @click="activatetoggle(section)">Activate <span class="glyphicon glyphicon-check"></span></button>
                </div>
                <div class="col-xs-1">
                    <button v-if="section.has_sub_sections" class="btn btn-primary pull-right" @click="Add('Add', section)">Add <span class="glyphicon glyphicon-plus"></span></button>
                </div>
            </div>
        </div>
        <div v-if="section.has_sub_sections" class="panel-collapse collapse panel-body" v-bind:id="section.id">
            <div class="container row">
                <div class="col-md-4"  v-for="section_item in section.section_item" :key="section_item.id">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-10">
                                    <p class="text-uppercase"><b>{{section_item.name}}</b></p>
                                </div>
                                <div class="col-xs-1">
                                    <button class="btn btn-primary pull-rights" @click="Edit('Edit', section, section_item)"><span class="glyphicon glyphicon-edit"></span></button>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div>
                                <img :src="section_item.poster" />
                            </div>
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
    <sectionitem-modal/>
</div>
</template>

<script>
import SetionItemModal from './modal/sectionitem_modal.vue'

export default {
    components: {
        'sectionitem-modal': SetionItemModal
    },
    data() {
        return {
            sections:[],
        }
    },
    mounted: function () {
        this.load();
    },
    methods: {
        // Load Items
        load (section) {
            axios.get('/sections')
                .then(response => {
                    this.sections = response.data
                })
                .catch(error => {
                    console.log(error);
                });
        },
        /**  
        * Persist the item to storage using the given form.
        */
        persistItem(method, uri, form) {
        axios[method](uri, form)
            .then(response => {
                this.load()
                form.sections = []            
            })
        },
        Edit(action, section, item) {
            this.$modal.show(
                'sectionitem', 
                {button: {
                    text: action
                }, 
                editForm:{
                    sectionid: section.id,
                    id: item.id,
                    name: item.name,
                    poster: item.poster,
                    reservation: item.reservation,
                    longitutde: item.longitutde,
                    latitude: item.longitutde,
                    description: item.description,
            }})
        },
        Add (action, section) {
            this.$modal.show(
                'sectionitem', 
                {button: {
                    text: action
                }, 
                editForm:{
                    sectionid: section.id,
            }})
        },
        activatetoggle(data, toggle) {
            console.log(data);
            this.persistItem('put', '/sections/' + data.id, null)
        }
    },
};
</script>
<style>
img {
    width: 100%;
    height: 250px;
}
</style>
