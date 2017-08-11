<style scoped>
    .action-link {
        cursor: pointer;
    }

    .m-b-none {
        margin-bottom: 0;
    }
</style>

<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        Channels 
                    </span>

                    <a class="action-link" @click="showAddChannelForm">
                        Add New Channel
                    </a>
                </div>  
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>name</th>
                            <th>stream</th>
                            <th>thumbnail</th>
                            <th>description</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="channel in channels" :key="channel.id">
                            <td>{{channel.id}}</td>
                            <td>{{channel.name}}</td>
                            <td>{{channel.stream}}</td>
                            <td>{{channel.thumbnail}}</td>
                            <td>{{channel.description}}</td>
                            <!-- Edit Button -->
                            <td style="vertical-align: middle;">
                                <a class="action-link" @click="edit(channel)">
                                    Edit
                                </a>
                            </td>

                            <!-- Delete Button -->
                            <td style="vertical-align: middle;">
                                <a class="action-link text-danger" @click="destroy(channel)">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    </tbody>
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
                        <form class="form-horizontal" role="form">
                            <!-- name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="text" class="form-control" v-model="createForm.name">

                                    <span class="help-block">
                                        Chanel name
                                    </span>
                                </div>
                            </div>

                            <!-- stream  -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Stream</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="text" class="form-control" v-model="createForm.stream">

                                    <span class="help-block">
                                        Stream of the channel
                                    </span>
                                </div>
                            </div>

                            <!-- thumbnail  -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Thumbnail</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="text" class="form-control" v-model="createForm.thumbnail">

                                    <span class="help-block">
                                        thumbnail picture to show in list
                                    </span>
                                </div>
                            </div>

                            <!-- description -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Description</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="redirect" v-model="createForm.description">

                                    <span class="help-block">
                                        Description
                                    </span>
                                </div>
                            </div>
                        </form>
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
                        <form class="form-horizontal" role="form">
                            <!-- name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="text" class="form-control" v-model="editForm.name">

                                    <span class="help-block">
                                        Chanel name
                                    </span>
                                </div>
                            </div>

                            <!-- stream  -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Stream</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="text" class="form-control" v-model="editForm.stream">

                                    <span class="help-block">
                                        Stream of the channel
                                    </span>
                                </div>
                            </div>

                            <!-- thumbnail  -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Thumbnail</label>

                                <div class="col-md-7">
                                    <input id="create-channel-name" type="text" class="form-control" v-model="editForm.thumbnail">

                                    <span class="help-block">
                                        thumbnail picture to show in list
                                    </span>
                                </div>
                            </div>

                            <!-- description -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Description</label>

                                <div class="col-md-7">
                                    <input type="text" class="form-control" name="redirect" v-model="editForm.description">

                                    <span class="help-block">
                                        Description
                                    </span>
                                </div>
                            </div>
                        </form>
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
    export default {
        /*
         * The component's data.
         */
        data() {
            return {
                channels: [],

                createForm: {
                    errors: [],
                    name: '',
                    stream: '',
                    thumbnail: '',
                    description: ''
                },

                editForm: {
                    errors: [],
                    name: '',
                    stream: '',
                    thumbnail: '',
                    description: ''
                }
            };
        },

        /**
         * Prepare the component (Vue 2.x).
         */
        mounted() {
            this.getChannel();
        },

        methods: {

            /**
             * Get all of the OAuth channels for the user.
             */
            getChannel() {
                axios.get('/channel')
                        .then(response => {
                            this.channels = response.data;
                        });
            },

            /**
             * Show the form for adding new channel.
             */
            showAddChannelForm() {
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
                this.editForm.description = channel.description;

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
                        form.description = '';


                        $(modal).modal('hide');
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                            console.log(error.response.data)
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
            }

        }
    }
</script>
