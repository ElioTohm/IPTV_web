<template>
    <div id="ChatBox">
        <div class="col-md-12 ChatBox__Right">
            <chat-message v-for="message in messages" :data="message" :key="message.timestamp" :messagetype="message.type"></chat-message>
            <input @keyup.enter="sendMessage" type="text" v-model="message" placeholder="Enter your message here">
        </div>
    </div>
</template>

<script>
    import ChatMessage from './messages.vue'
    export default {
        components: { ChatMessage },
        data() {
            return {
                message: '',
                room: '',
                timestamp: '',
                messages: [],
            }
        },
        mounted() {
            Notification.requestPermission()
            var self = this
            window.io.on('message_received', function(message) {
                new Notification( message.message.room +": "+message.message.message  );
                message.message.timestamp = new Date(message.message.timestamp).toLocaleString()
                self.messages.push(message.message)
            })
        },
        methods: {
            sendMessage(event) {
                this.room = 'admin'
                this.timestamp = new Date().getTime()
                this.messages.push({ message: this.message, room: this.room, timestamp: this.timestamp})
                var message =  this.message.split(":")
                console.log(message)
                if (message.length > 1) {
                    var room = message[0].split(".")
                    window.io
                    .emit("Notification_", {
                            room: room[1],
                            type:2,
                            message: message[1],
                            image: "http://192.168.0.75/storage/device/test.png"
                        })
                } else {
                    window.io
                    .emit("BroadCastNotification", {
                            type:2,
                            message: this.message,
                            image: "http://192.168.0.75/storage/device/test.png"
                        })
                }
                this.message = ""
                this.room = ""
                this.timestamp = ""
            },
        },
    }
</script>

<style>
    #ChatBox {
        width: 100%;
        height: 100%;
    }
    #Chat__ChatBox ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .ChatBox__Right {
        height: 90vh;
        border-left: 1px solid #eee;
        background: #F7F7F7;
        box-shadow: -10px 0 40px #F1F1F1;
    }
    .ChatBox__Right input {
        width: 100%;
        background: white;
        padding: 10px;
    }
    .ChatBox__Right input:focus {
        outline: none;
    }
  
</style>