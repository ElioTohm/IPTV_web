<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        Clients 
                    </span>

                    <a class="action-link" @click="showAddClientForm">
                        Add New Client
                    </a>
                </div>  
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Room</th>
                            <th>Welcome message</th>
                            <th>Credit</th>
                            <th>Debit</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="client in clients" :key="client.id">
                            <td>{{client.name}}</td>
                            <td>{{client.email}}</td>
                            <td>{{client.room}}</td>
                            <td>{{client.welcome_message}}</td>
                            <td>{{client.credit}}</td>
                            <td>{{client.debit}}</td>
                            <!-- Edit Button --> 
                            <td  class="col-md-1">
                                <a class="action-link" @click="edit(client)">
                                    Edit
                                </a>
                            </td>

                            <!-- Delete Button -->
                            <td  class="col-md-1">
                                <a class="action-link text-danger" @click="destroy(client)">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
                                <li v-for="error in createForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Create Client Form -->
                        <form class="form-horizontal" role="form">
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
                                <li v-for="error in editForm.errors">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Client Form -->
                        <form class="form-horizontal" role="form">
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
    data () {
        return {
            clients: [],

            createForm: {
                    errors: [],
                    name: '',
                    email : '',
                    room : '',
                    welcome_message : '',
                    credit : 0,
                    debit : 0, 
                },

            editForm: {
                errors: [],
                name : '',
                email : '',
                room : '',
                welcome_message : '',
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
    methods: {
        getClient () {
            axios.get('/client')
                .then(response => {
                        this.clients = response.data.clients;
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
