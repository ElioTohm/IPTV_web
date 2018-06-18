<template>
    <div class="Message">
        <div :class="messagetype">
            <p class="Message__Author">
                <strong>{{ data.room }}</strong>
            </p>
            <p class="Message__Content">
                {{ data.message }}
            </p>
            <p class="Message__timestamp">
                {{ data.timestamp }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: ['data', 'messagetype'],
}
</script>

<style>
    #ChatBox .Message {
        background: white;
        overflow: hidden;
        padding: 10px;
    }
    #ChatBox .Message p {
        margin: 0;
    }
    #ChatBox .Message p.Message__Author {
        font-style: italic;
        margin-bottom: 5px;
    }
    .Message__timestamp{
        font-style: italic;
        text-align: right;
    }
</style>