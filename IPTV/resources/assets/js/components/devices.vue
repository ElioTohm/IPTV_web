<template>
<div>
    {{devices}}
</div>
</template>
<script>
export default {
    data () {
        return {
            devices: []
        }
    },
    mounted () {
        this.getDevice();
    },
    methods: {
        getDevice () {
            axios.get('/device')
                .then(response => {
                    this.devices = response.data.channels;
                });
        }
    }
}
</script>
