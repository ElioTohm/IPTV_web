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
                        <li class="list-group-item">{{device.device}} 
                            <span class="badge" v-if="device.stream">
                                watching {{device.stream}}
                            </span>
                            <span class="badge" v-if="device.activity">
                                in {{device.activity}}
                            </span>
                        </li>
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
                var userlist = _.pull(data.users, 'admin')
                self.clientcount = userlist.length  
                userlist.forEach(element => {
                    self.onlineDevice.push({device: element})
                });

            })
            .on('user joined', function (data) {
                self.onlineDevice.push({device: data.username})
                self.clientcount = self.onlineDevice.length                 
            })
            .on('user left', function (data) {
                var index = _.findIndex(self.onlineDevice, {device: data.username});
                self.onlineDevice.splice(index, 1);
                self.clientcount = self.onlineDevice.length
            })
            .on('Monitoring', function (data) {
                // Find item index using _.findIndex (thanks @AJ Richardson for comment)
                var index = _.findIndex(self.onlineDevice, {device: data.device});

                // Replace item at index using native splice
                self.onlineDevice.splice(index, 1, data);

            })
    }
}
</script>
