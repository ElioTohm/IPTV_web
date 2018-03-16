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
                        <p>{{device.name}}</p>
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
    window.Echo.join('Online')
        .here((users) => {
            this.onlineDevice = _.filter(users, {'role': 4});            
            this.clientcount = this.onlineDevice.length
        })
        .joining((user) => {
            if (user.role = 4) {
                this.onlineDevice.push(user)
                this.clientcount = this.onlineDevice.length
            }
        })
        .leaving((user) => {
            if (user.role = 4) {
                this.onlineDevice.pop(user)
                this.clientcount = this.onlineDevice.length
            }
        });
            
  }
}
</script>
