<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Application settings
            </div>
            <div class="panel-body">
                <div class="form-horizontal">
                    <!-- number -->
                    <div class="form-group">
                        <label class="col-md-3 control-label">Version</label>

                        <div class="col-md-7">
                            <input type="text" class="form-control" v-model="version">
                        </div>
                    </div>

                    <!-- name -->
                    <div class="form-group">
                        <label class="col-md-3 control-label">apk upload</label>

                        <div class="col-md-7">
                            <input  type="file"
                                    id="apk" name = "apk"
                                    class="form-control" 
                                    @change="filesChange($event.target.name, $event.target.files); fileCount = $event.target.files.length">
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer">
                <button class="btn btn-primary" @click="upload">Update</button>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data () {
        return {
            version: 0,
            fileList: [],
            fieldName: [],
            uploadFieldName: 'apk',
        }
    },
    mounted () {
        axios.get('/admin/launcherapp')
            .then(response => {
                this.version = response.data.version
            });
    },
    methods: {
        filesChange(fieldName, fileList) {
            // handle file changes
            if (!fileList.length) return;

            // append the files to FormData
            Array
                .from(Array(fileList.length).keys())
                .map(x => {
                    this.fileList = fileList[x] 
                    this.fieldName = fileList[x].name
                });
        },

        upload() {    
            // handle file changes
            const formData = new FormData();

            // append the files to FormData
            formData.append(this.uploadFieldName, this.fileList, this.fileList);
            formData.append('version', this.version)
            
            axios.post('/admin/launcherapp', formData)
                .then(response => {
                    console.log(response)
                });
        }
    }
}
</script>
