<template>
    <div>
        <div class="panel panel-primary">
            <div class="panel-heading">
                NFS Storages
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>
                                <p><b>Server URL</b></p>
                            </th>
                            <th>
                                <p><b>Server Directory</b></p>
                            </th>
                            <th>
                                <p><b>Local Mounting Directory</b></p>
                            </th>
                             <th>
                                <button class="btn btn-primary" @click="showmodal('post')"> Add </button>
                            </th>
                        </tr>                         
                    </thead>
                    <tbody>
                        <tr v-for="storage in storages" :key="storage.id">
                            <td>{{ storage.server_url }}</td>
                            <td>{{ storage.server_dir }}</td>
                            <td>{{ storage.local_dir }}</td>
                            <td>
                                <button type="button" class="btn btn-default" @click="showmodal('put', storage)" ><i class="glyphicon glyphicon-pencil"></i></button>
                                <button type="button" class="btn btn-default" @click="deletestorage(storage)" ><i class="glyphicon glyphicon-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal" id="storagemodal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Add storage</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="server_url">Server URl</label>
                                <input v-model="form.server_url" type="text" class="form-control" id="exampleInputEmail1" placeholder="server url">
                                <small id="server_url" class="form-text text-muted">remote server/nas ip</small>
                            </div>
                            <div class="form-group">
                                <label for="server_dir">Server Directory</label>
                                <input v-model="form.server_dir" type="text" class="form-control" id="exampleInputEmail1" placeholder="Server Directory">
                                <small id="server_dir" class="form-text text-muted">directory/folder to mount fromt he server/nas</small>
                            </div>
                            <div class="form-group">
                                <label for="local_dir">Local mounting Directory</label>
                                <input v-model="form.local_dir" type="text" class="form-control" id="exampleInputEmail1" placeholder="Local directory">
                                <small id="local_dir" class="form-text text-muted">the Directory to mount the remote storage to</small>
                            </div>
                            <button type="button" class="btn btn-primary" @click="persistdata(action)">Mount</button>
                        </form>
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
            storages: [],
            action: '',
            form: {
                id: '',
                server_url: '',
                server_dir: '',
                local_dir: ''
            }
        }
    },
    mounted () {
        this.getstorages();
    },
    methods: {
        getstorages() {
            axios.get('/admin/storages')
                .then(response => {
                    this.storages = response.data
                });
        },
        showmodal(action, rowdata) {
            this.action = action
            if (action == 'post') {
                this.form.server_url = ''
                this.form.server_dir = ''
                this.form.local_dir = ''
                $('#storagemodal').modal('show')
            } else {
                this.form.id = rowdata.id
                this.form.server_url = rowdata.server_url
                this.form.server_dir = rowdata.server_dir
                this.form.local_dir = rowdata.local_dir
                $('#storagemodal').modal('show')
            }
        },
        persistdata () {
            axios[this.action](this.action == 'post' ? 'admin/storages' : 'admin/storages/' + this.form.id, this.form)
                .then(response => {
                    this.getstorages();
                })
                .catch(error => {
                    console.log(error);
                    this.$toasted.error("error creating ",{
                        duration:1000
                    });
                });
        },
        addstorage () {
            axios.post('/admin/storages', this.form)
            .then(response => {
                this.getstorages();
            })
        },
        updatestorage () {
            axios.put('/admin/storages/'+this.form.id, this.form)
            .then(response => {
                this.getstorages();
            })
        },
        deletestorage (rowdata) {
            axios.delete('/admin/storages/' + rowdata.id)
            .then(response => {
                this.getstorages();
            })
        }
    }   
}
</script>
