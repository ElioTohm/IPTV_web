<template>
    <div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span>
                        IP Cam
                    </span>

                    <button class="btn btn-info" @click="showModal('post')">
                        Add New Cam
                    </button>
                </div>  
            </div>
            <div class="panel-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="col-md-4">IP</th>
                            <th class="col-md-2">User Name</th>
                            <th class="col-md-2">Password</th>
                            <th class="col-md-2">Channel</th>
                            <th class="col-md-1"></th>
                            <th class="col-md-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cam in cams" :key="cam.id">
                            <td class="col-md-2">{{cam.ip}}</td>
                            <td class="col-md-2">{{cam.username}}</td>
                            <td class="col-md-3">{{cam.password}}</td>
                            <td class="col-md-2">{{cam.channel}}</td>
                            <!-- Edit Button --> 
                            <td  class="col-md-1">
                                <a class="action-link" @click="showModal('put', cam)">
                                    Edit
                                </a>
                            </td>

                            <!-- Delete Button -->
                            <td  class="col-md-1">
                                <a class="action-link text-danger" @click="persistCam('delete', '/ipcams/' + cam.id, Form, '#modal')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

         <!-- Edit Cam Modal -->
        <div class="modal fade" tabindex="-1" role="dialog" id="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                   <div class="modal-header">
                        <h4 class="modal-title">
                            {{action_test[action]}} Cam
                        </h4>
                    </div>

                    <div class="modal-body">
                        <!-- Form Errors -->
                        <div class="alert alert-danger" v-if="Form.errors.length" >
                            <p><strong>Whoops!</strong> Something went wrong!</p>
                            <br>
                            <ul>
                                <li v-for="error in Form.errors" :key="error">
                                    {{ error }}
                                </li>
                            </ul>
                        </div>

                        <!-- Edit Cam Form -->
                        <div class="form-horizontal">
                                <!-- ip -->
                            <div class="form-group">
                                <label class="col-md-3 control-label">IP</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="Form.ip">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">User Name</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="Form.username">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Password</label>
                                <div class="col-md-7">
                                    <input type="text" class="form-control" v-model="Form.password">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Channel</label>
                                <div class="col-md-7">
                                    <input type="number" class="form-control" v-model="Form.channel">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button v-if="action == 'post'" type="button" class="btn btn-primary" @click="persistCam(action, '/ipcams', Form, '#modal')">
                            Add
                        </button>
                        <button v-else type="button" class="btn btn-primary" @click="persistCam(action, '/ipcams/' + Form.id, Form, '#modal')">
                            Update
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
            action:'',
            action_test: {
                'post': 'Add',
                'put': 'Edit'
            },
            cams: [],
            Form: {
                errors: [],
                id: '', 
                ip: '',
                username: '',
                password: '',
                channel: ''
            },
        }
    },
    mounted () {
        this.getCam();
    },
    methods: {
        getCam (page) {
            axios.get('/ipcams')
                .then(response => {
                        this.cams = response.data;
                })
                .catch(error => {
                    console.log(error.response.data)
                });
        },
     
        /**
         * Show the form for adding new cam.
         */
        showModal(action, cam) {
            this.action = action
            if (this.action == 'put'){
                this.Form.id = cam.id
                this.Form.ip = cam.ip
                this.Form.username = cam.username
                this.Form.password = cam.password
                this.Form.channel = cam.channel
            } else {
                this.Form.id = ''
                this.Form.ip = ''
                this.Form.username = ''
                this.Form.password = ''
                this.Form.channel = ''
            }
            $('#modal').modal('show')
        },

        /**
         * Persist the cam to storage using the given form.
         */
        persistCam(method, uri, form, modal) {
            form.errors = [];

            axios[method](uri, form)
                .then(response => {
                    if (typeof response.data.error != "undefined") {
                        form.errors = [response.data.error];
                    } else {
                        this.getCam();
                        form.errors = [];
                        form.id = ''
                        form.ip = ''
                        form.username = ''
                        form.password = ''
                        form.channel = ''
                        
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
    }
}
</script>
