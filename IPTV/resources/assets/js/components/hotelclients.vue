<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <!-- Title -->
                    <span>
                        Clients
                    </span>
                    <!-- Search input -->
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="search" v-model="search.query">
                    </div>
                    <!-- Header add new client action -->
                    <a class="action-link" @click="showAddClientForm">
                        Add New Client
                    </a>
                </div>  
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="col-xs-2">Name</th>
                                <th class="col-xs-1">Email</th>
                                <th class="col-xs-1">Room</th>
                                <th class="col-xs-1">Welcome message</th>
                                <th class="col-xs-1">Welcome image</th>
                                <th class="col-xs-2">Credit</th>
                                <th class="col-xs-1">Debit</th>
                                <th class="col-xs-1">Notify</th>
                                <th class="col-xs-1"></th>
                                <th class="col-xs-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="client in clients" :key="client.id">
                                <td class="col-xs-2">{{client.name}}</td>
                                <td class="col-xs-1">{{client.email}}</td>
                                <td class="col-xs-1">{{client.room}}</td>
                                <td class="col-xs-1">{{client.welcome_message}}</td>
                                <td class="col-xs-1">{{client.welcome_image}}</td>
                                <td class="col-xs-2">{{client.credit}}</td>
                                <td class="col-xs-1">{{client.debit}}</td>
                                <!-- Notification button -->
                                <td class="col-xs-1">
                                    <a class="action-link" @click="notificationwindows(client)">Notify</a>
                                </td class="col-xs-1">
                                <!-- Edit Button --> 
                                <td   class="col-xs-1">
                                    <a class="action-link" @click="edit(client)">Edit</a>
                                </td>

                                <!-- Delete Button -->
                                <td   class="col-xs-1">
                                    <a class="action-link text-danger" @click="destroy(client)">Delete</a>
                                </td>
                            </tr>
                        </tbody>
                        <pagination :data="pagedata" v-on:pagination-change-page="getClient"></pagination>
                    </table>
                </div>
            </div>
        </div>
    
        <!-- Create Client Modal -->
        <div class="modal fade" id="modal-add-client" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Add New Client
                        </h4>
                    </div>

                    <div class="modal-body">
                        
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="createForm.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in createForm.errors" :key="error">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Client Form -->
                        <div class="form-horizontal" role="form">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="createForm.name">
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="createForm.email">
                                </div>
                            </div>
                            <!-- Room -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Room</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="createForm.room">
                                </div>
                            </div>
                            <!-- Welcome message -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Welcome message</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="createForm.welcome_message">
                                </div>
                            </div>
                            <!-- Welcome image -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Welcome image</label>
                                <div class="col-md-7">
                                    <input type="file" class="form-control" v-on:change="onFileChange">
                                </div>
                            </div>
                            <!-- Credit -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Credit</label>
                                <div class="col-md-7">
                                    <input type="number" class="form-control" v-model="createForm.credit">
                                </div>
                            </div>
                            <!-- Debit -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Debit</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="createForm.debit">
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

         <!-- Edit Client Modal -->
        <div class="modal fade" id="modal-edit-hotelclient" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Edit Client
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="editForm.errors.length > 0">
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in editForm.errors" :key="error">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Client Form -->
                        <div class="form-horizontal" role="form">
                            <!-- Name -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Name</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="editForm.name">
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Email</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="editForm.email">
                                </div>
                            </div>
                            <!-- Room -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Room</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="editForm.room">
                                </div>
                            </div>
                            <!-- Welcome message -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Welcome message</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="editForm.welcome_message">
                                </div>
                            </div>
                            <!-- Welcome image -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Welcome image</label>
                                <div class="col-md-7">
                                    <input type="file" class="form-control" v-on:change="onFileChange">
                                </div>
                            </div>
                            <!-- Credit -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Credit</label>
                                <div class="col-md-7">
                                    <input type="number" class="form-control" v-model="editForm.credit">
                                </div>
                            </div>
                            <!-- Debit -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Debit</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="editForm.debit">
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

        <!-- Notification prompt to send to specific client -->
        <div class="modal fade" id="modal-notify-hotelclient" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Notify
                        </h4>
                    </div>

                    <div class="modal-body">

                        <!-- Message sent form -->
                        <form class="form-horizontal" role="form">
                            <!-- Message -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Message</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="notification.message">
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                        <button type="button" class="btn btn-primary" @click="sendnotification">
                            Send
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
        data () {
            return {
                pagedata:{},
                clients: [],
                monitor:{
                    count: 0
                },
                notification: {
                    id: 0,
                    message: ''
                },

                createForm: {
                        errors: [],
                        name: '',
                        email : '',
                        room : '',
                        welcome_message : '',
                        welcome_image: '',
                        credit : 0,
                        debit : 0, 
                    },

                editForm: {
                    errors: [],
                    name : '',
                    email : '',
                    room : '',
                    welcome_message : '',
                    welcome_image: '',
                    credit : 0,
                    debit : 0,
                },

                search: {
                    errors: [],
                    model: 'Client',
                    query: ''
                }
            }
        },
        mounted () {
            this.getClient();
        },
        watch: {
                'search.query': function(){
                    if (this.search.query != '') {
                        axios.get('/search', {params : this.search})
                            .then(response => {
                                this.clients = response.data;
                            })
                            .catch(error => {
                                console.log(error.response.data)
                            });
                    } else {
                        this.getClient();
                    }
                    
                }
            },
        methods: {
            /* 
            * assign the image to a model
            */
            createImage(file) {
                let reader = new FileReader();
                let vm = this;
                vm.editForm.welcome_image = '';
                reader.onload = (e) => {
                    vm.createForm.welcome_image = e.target.result;
                    vm.editForm.welcome_image = e.target.result;
                        
                };
                reader.readAsDataURL(file);
            },

            /*
            * create the file 
            */
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                this.createImage(files[0]);
            },
            
            notificationwindows(client) {
                this.notification.id = client.room
                $('#modal-notify-hotelclient').modal('show');
            },
            
            // send notification to client
            sendnotification() {
                axios.get('/clientnotification/'+this.notification.id,{
                        params:{
                            message: this.notification.message
                        }
                    })
                    .then(response => {
                            console.log(response)
                    })
                    .catch(error => {
                        console.log(error.response.data)
                    });
            },

            // return all clients
            getClient (page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/client?page=' + page)
                    .then(response => {
                        this.pagedata = response.data;
                        this.clients = this.pagedata.data;
                    })
                    .catch(error => {
                        console.log(error.response.data)
                    });
            },
        
            /**
             * Show the form for adding new client.
             */
            showAddClientForm() {
                $('#modal-add-client').modal('show');
            },

            /**
             * Create a new OAuth client for the user.
             */
            store() {
                this.persistClient(
                    'post', '/client',
                    this.createForm, '#modal-create-client'
                );
            },

            /**
             * Edit the given client.
             */
            edit(client) {
                this.editForm.id = client.id;
                this.editForm.name = client.name;
                this.editForm.email = client.email
                this.editForm.room = client.room;
                this.editForm.welcome_message = client.welcome_message;
                this.editForm.welcome_image = client.welcome_image;
                this.editForm.credit = client.credit;
                this.editForm.debit = client.debit;

                $('#modal-edit-hotelclient').modal('show');
            },

            /**
             * Update the client being edited.
             */
            update() {
                this.persistClient(
                    'put', '/client/' + this.editForm.id,
                    this.editForm, '#modal-edit-hotelclient'
                );
            },

            /**
             * Persist the client to storage using the given form.
             */
            persistClient(method, uri, form, modal) {
                form.errors = [];

                axios[method](uri, form)
                    .then(response => {
                        if (typeof response.data.error != "undefined") {
                            form.errors = [response.data.error];
                        } else {
                            this.getClient();

                            form.errors = [];
                            form.name = '';
                            form.email = '';
                            form.room = '';
                            form.welcome_message = '';
                            form.welcome_image = '';
                            form.credit = '';
                            form.debit = '';
                            
                            $(modal).modal('hide');
                        }
                        
                    })
                    .catch(error => {
                        if (typeof error.response.data === 'object') {
                            form.errors = _.flatten(_.toArray(error.response.data));
                        } else {
                            form.errors = ['Something went wrong. Please try again.'];
                        }
                        console.log(error.response.data)
                    });
            },

            /**
             * Destroy the given client.
             */
            destroy(client) {
                axios.delete('/client/' + client.id)
                        .then(response => {
                            this.getClient();
                        });
            },
            
        }
    }
</script>
