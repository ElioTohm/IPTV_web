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
                <div>
                    <ul class="list-group" v-for="device in onlineDevice" :key="device.id">
                        <li class="list-group-item">{{device.device}} <span class="badge" v-if="device.stream"> watching {{device.stream}}</span></li>
                    </ul> 
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
            onlineDevice: [],
        }
    },
    mounted () {
        var self = this
        window.io
            .emit('Subscribe', 'admin')
            .on('login', function (data) {
                self.clientcount = data.userslength - 1 
                var userlist = _.pull(data.users, 'admin')
                userlist.forEach(element => {
                    self.onlineDevice.push({device: element})
                });

            })
            .on('user joined', function (data) {
                self.clientcount = data.userslength - 1
                var userlist = _.pull(data.users, 'admin')
                userlist.forEach(element => {
                    self.onlineDevice.push({device: element})
                });
            })
            .on('user left', function (data) {
                self.clientcount = data.userslength - 1
                var userlist = _.pull(data.users, 'admin')
                userlist.forEach(element => {
                    self.onlineDevice.push({device: element})
                });
            })
            .on('Monitoring', function (data) {
                // Find item index using _.findIndex (thanks @AJ Richardson for comment)
                var index = _.findIndex(self.onlineDevice, {name: data.device});

                // Replace item at index using native splice
                self.onlineDevice.splice(index, 1, {device: data.device, stream: data.stream});

            })
    }
}
</script>
