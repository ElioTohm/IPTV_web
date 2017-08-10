<template>
    <div>
        <div class="panel panel-default">
            <div class="panel-heading">List channels</div>
            <div class="panel-body">
                {{ channels }}
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                channels: []
            }
        },
        mounted() {
            console.log('component mounted')
            axios.get('/channels')
                        .then(response => {
                            this.channels = response.data;
                        });
        }
    }
</script>
