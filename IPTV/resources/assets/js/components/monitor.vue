<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <h2><b>Monitoring</b></h2>
                    </div>
                    <div class="col-xs-6">
                        <h3 class="pull-right">Online: {{ clientcount }}</h3>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div v-for="device in onlineDevice" :key="device.id">
                    <div>
                        <p>{{device}}</p>
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
            clientcount: 0,
            onlineDevice: []
        }
    },
    mounted () {
        var self = this
        window.io
            .emit('add user', 'admin')
            .on("new message", function(message) {
                console.log(message)
            })
            .on('login', function (data) {
                self.clientcount = data.userslength
                self.onlineDevice = data.users
            })
            .on('user joined', function (data) {
                self.clientcount = data.userslength
                self.onlineDevice = data.users
            })
            .on('user left', function name(data) {
                self.clientcount = data.userslength
                self.onlineDevice = data.users
            })        
    }
}
</script>
