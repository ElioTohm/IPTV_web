<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        Devices 
                    </span>

                    <input v-model="search.query" placeholder="Search"/>           

                    <a class="action-link" @click="showAddDeviceForm">
                        Add New Device
                    </a>
                </div>  
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-md-1">ID</th>
                            <th class="col-md-3">Room number</th>
                            <th class="col-md-3">Secret</th>
                            <th class="col-md-1"></th>
                            <th class="col-md-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(device, index) in devices" :key="device.id">
                            <td class="col-md-2">{{device.id}}</td>
                            <td class="col-md-2">{{device.room}}</td>
                            <td class="col-md-2">{{device.o_authclient.secret}}</td>
                            <!-- Edit Button --> 
                            <td  class="col-md-1">
                                <a class="action-link" @click="edit(device)">
                                    Edit
                                </a>
                            </td>

                            <!-- Delete Button -->
                            <td  class="col-md-1">
                                <a class="action-link text-danger" @click="destroy(device)">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Create Device Modal -->
        <div class="modal fade" id="modal-add-device" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Add New Device
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

                        <!-- Create Device Form -->
                        <form class="form-horizontal" role="form">
                            <!-- room -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Room</label>

                                <div class="col-md-7">
                                    <input id="create-device-room" type="text" class="form-control" v-model="createForm.room">
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

         <!-- Edit Device Modal -->
        <div class="modal fade" id="modal-edit-device" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                        <h4 class="modal-title">
                            Edit Device
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

                        <!-- Edit Device Form -->
                        <form class="form-horizontal" role="form">
                                <!-- room -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">Room</label>

                                <div class="col-md-7">
                                    <input id="create-device-room" type="text" class="form-control" v-model="editForm.room">
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
            devices: [],

            createForm: {
                    errors: [],
                    room: '',
                },

            editForm: {
                errors: [],
                room: '',
            },

            search: {
                errors: [],
                model: 'Device',
                query: ''
            }
        }
    },
    mounted () {
        this.getDevice();
    },
    methods: {
        getDevice () {
            axios.get('/device')
                .then(response => {
                        this.devices = response.data.devices;
                        this.token = response.data.token;
                })
                .catch(error => {
                    console.log(error.response.data)
                });
        },
     
        /**
         * Show the form for adding new device.
         */
        showAddDeviceForm() {
            $('#modal-add-device').modal('show');
        },

        /**
         * Create a new OAuth device for the user.
         */
        store() {
            this.persistDevice(
                'post', '/device',
                this.createForm, '#modal-create-device'
            );
        },

        /**
         * Edit the given device.
         */
        edit(device) {
            this.editForm.room = device.room;

            $('#modal-edit-device').modal('show');
        },

        /**
         * Update the device being edited.
         */
        update() {
            this.persistDevice(
                'put', '/device/' + this.editForm.id,
                this.editForm, '#modal-edit-device'
            );
        },

        /**
         * Persist the device to storage using the given form.
         */
        persistDevice(method, uri, form, modal) {
            form.errors = [];

            axios[method](uri, form)
                .then(response => {
                    if (typeof response.data.error != "undefined") {
                        form.errors = [response.data.error];
                    } else {
                        this.getDevice();

                        form.errors = [];
                        form.room = '';
                        
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
        destroy(device) {
            axios.delete('/device/' + device.id)
                    .then(response => {
                        this.getDevice();
                    });
        },
    }
}
</script>
