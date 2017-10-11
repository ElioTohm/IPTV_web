<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">
                Monitoring
            </div>
            <div class="panel-body">
                <h5>Online: {{ monitor.clientcount }}</h5>
            </div>
        </div>
    </div>
</template>
<script>
export default {
  data() {
      return {
          monitor: {
              clientcount:0
          }
      }
  },
  mounted () {
      window.Echo.join('Online')
            .here((users) => {
                this.monitor.clientcount = users.length;
                console.log(users);
            })
            .joining((user) => {
                this.monitor.clientcount = this.monitor.clientcount + 1;
            })
            .leaving((user) => {
                this.monitor.clientcount = this.monitor.clientcount - 1 ;
            });
            
  }
}
</script>
