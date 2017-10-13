<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <!-- Title -->
                    <span>
                        Channels 
                    </span>
                    <!-- search input -->
                    <div class="form-group">
                        <input class="form-control" v-model="search.query" placeholder="Search"/>
                    </div>
                    <!-- Header action add new item -->
                    <a class="action-link" @click="showAddChannelForm">
                        Add New Channel
                    </a>
                </div>  
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-md-1">number</th>
                            <th class="col-md-3">name</th>
                            <th class="col-md-2">stream</th>
                            <th class="col-md-2">stream type</th>
                            <th class="col-md-2">thumbnail</th>
                            <th class="col-md-2">genre</th>
                            <th class="col-md-1"></th>
                            <th class="col-md-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="channel in channels" :key="channel.id">
                            <td class="col-md-2">{{channel.number}}</td>
                            <td class="col-md-2">{{channel.name}}</td>
                            <td class="col-md-3">{{channel.stream}}</td>
                            <td class="col-md-3">{{channel.streamtype.name}}</td>
                            <td class="col-md-3">{{channel.thumbnail}}</td>
                            <td class="col-md-2">
                                <p v-for="genre in channel.genres" :key="genre.id">
                                    {{ genre.name }}
                                </p>
                            </td>
                            <!-- Edit Button -->
                            <td  class="col-md-1">
                                <a class="action-link" @click="edit(channel)">
                                    Edit
                                </a>
                            </td>

                            <!-- Delete Button -->
                            <td  class="col-md-1">
                                <a class="action-link text-danger" @click="destroy(channel)">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    </tbody>
                    <pagination :data="pagedata" v-on:pagination-change-page="getChannel"></pagination>
                </table>
            </div>
        </div>

        <!-- Create Channel Modal -->
        <div class="modal fade" id="modal-add-channel" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Add New Channel
                        </h4>
                    </div>

                    <div class="modal-body">
                        
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Channel Form -->
                        <div class="form-horizontal">
                            <!-- number -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Number</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="text" class="form-control" v-model="createForm.number">
                                </div>
                            </div>

                            <!-- name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="text" class="form-control" v-model="createForm.name">
                                </div>
                            </div>

                            <!-- stream  -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Stream</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="text" class="form-control" v-model="createForm.stream">
                                </div>
                            </div>

                            <!-- thumbnail  -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Thumbnail</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="file" class="form-control" v-on:change="onFileChange">
                                </div>
                            </div>

                            <!-- genre -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Genre</label>

                                <div class="col-md-7">
                                    <select class="form-control" v-model="createForm.genres" multiple>
                                        <option v-for="genre in genres" :key="genre.id" v-bind:value="genre.id">{{genre.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Stream Type -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Stream Type</label>

                                <div class="col-md-7">
                                    <select class="form-control" v-model="createForm.stream_type" single>
                                        <option v-for="stream_type in stream_types" :key="stream_type.id" v-bind:value="stream_type.id">{{stream_type.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="store">
                            Create
                        </button>
                    </div>
                </div>
            </div>
        </div>

         <!-- Edit Channel Modal -->
        <div class="modal fade" id="modal-edit-channel" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Edit Channel
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Channel Form -->
                        <div class="form-horizontal">
                            <!-- number -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Number</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="text" class="form-control" v-model="editForm.number">
                                </div>
                            </div>

                            <!-- name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="text" class="form-control" v-model="editForm.name">
                                </div>
                            </div>

                            <!-- stream  -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Stream</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="text" class="form-control" v-model="editForm.stream">
                                </div>
                            </div>

                            <!-- thumbnail  -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Thumbnail</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="file" class="form-control" v-on:change="onFileChange">
                                </div>
                            </div>

                            <!-- genre -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Genre</label>

                                <div class="col-md-7">
                                     <select class="form-control" v-model="editForm.genres" multiple>
                                        <option v-for="genre in genres" :key="genre.id" v-bind:value="genre.id">{{genre.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Stream Type -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Stream Type</label>

                                <div class="col-md-7">
                                    <select class="form-control" v-model="editForm.stream_type" single>
                                        <option v-for="stream_type in stream_types" :key="stream_type.id" v-bind:value="stream_type.id">{{stream_type.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="update">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import pagination from 'laravel-vue-pagination';
    export default {
        components: {
            'pagination': pagination
        },
        /*
         * The component's data.
         */
        data() {
            return {
                pagedata:{},
                channels: [],
                
                genres:[],

                stream_types:[],

                thumbnail:'',

                createForm: {
                    errors: [],
                    number: 0,
                    name: '',
                    stream: '',
                    stream_type: 0,
                    thumbnail: '',
                    genres : []
                },

                editForm: {
                    errors: [],
                    number: 0,
                    name: '',
                    stream: '',
                    stream_type: 0,
                    thumbnail: '',
                    genres : []
                },

                search: {
                    errors: [],
                    model: 'Channel',
                    query: ''
                }
            
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.getChannel();
        },

        /**
         * Watcher for search data 
         */
        watch: {
            'search.query': function(){
                if (this.search.query != '') {
                    axios.get('/search', {params : this.search})
                        .then(response => {
                            this.channels = response.data;
                        });
                } else {
                    this.getChannel();
                }
                
            }
        },

        methods: {
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                vm.editForm.thumbnail = '';
                reader.onload = (e) => {
                    vm.createForm.thumbnail = e.target.result;
                    vm.editForm.thumbnail = e.target.result;
                     
                };
                reader.readAsDataURL(file);
            },
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    console.log('wrg length');
                this.createImage(files[0]);
            },
            /**
             * Get all of the OAuth channels for the user.
             */
            getChannel(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/channel?page=' + page)
                        .then(response => {
                            this.pagedata = response.data.channels
                            this.channels = this.pagedata.data;
                            this.stream_types = response.data.stream_types;
                            this.genres = response.data.genres;
                        });
            },

            /**
             * Show the form for adding new channel.
             */
            showAddChannelForm() {
                this.createForm.number = this.channels[this.channels.length - 1].number + 1
                this.createForm.stream_type = 1;
                $('#modal-add-channel').modal('show');
            },

            /**
             * Create a new OAuth channel for the user.
             */
            store() {
                this.persistChannel(
                    'post', '/channel',
                    this.createForm, '#modal-create-channel'
                );
            },

            /**
             * Edit the given channel.
             */
            edit(channel) {
                this.editForm.id = channel.id;
                this.editForm.name = channel.name;
                this.editForm.stream = channel.stream;
                this.editForm.thumbnail = channel.thumbnail;
                this.editForm.genre = channel.genre;
                this.editForm.number = channel.number;
                this.editForm.stream_type = channel.streamtype.id

                $('#modal-edit-channel').modal('show');
            },

            /**
             * Update the channel being edited.
             */
            update() {
                this.persistChannel(
                    'put', '/channel/' + this.editForm.id,
                    this.editForm, '#modal-edit-channel'
                );
            },

             /**
             * Persist the channel to storage using the given form.
             */
            persistChannel(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        this.getChannel();

                        form.errors = [];
                        form.name = '';
                        form.stream = '';
                        form.thumbnail = '';
                        form.genre = '';
                        form.number = '';

                        $(modal).modal('hide');
                    })
                    .catch(error => {
                        console.log(error.response.data)
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                    });
            },

            /**
             * Destroy the given client.
             */
            destroy(channel) {
                axios.delete('/channel/' + channel.id)
                        .then(response => {
                            this.getChannel();
                        });
            },
        }
    }
</script>
