<style>
    body, html {
        background-color: gray;
        height: 100%;
    }

    #videos {
        position: relative;
        width: 100%;
        height: 100%;
        margin-left: auto;
        margin-right: auto;
    }

    #subscriber {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 10;
    }

    #publisher {
        position: absolute;
        width: 360px;
        height: 240px;
        bottom: 10px;
        left: 10px;
        z-index: 100;
        border: 3px solid white;
        border-radius: 3px;
    }
</style>

<template>
    <div style="height: 100%;">
        <div id="videos">
            <div id="subscriber"></div>
            <div id="publisher"></div>
        </div>
    </div>
</template>

<script>
    import Waiter from 'ts-vue-dom-waiter/js/Waiter'

    import EventBus, {ACTIVATE_WAITER, DEACTIVATE_WAITER} from '../libraries/event-bus'
    import axios from 'axios'

    const OT = require('@opentok/client');

    export default {
        mounted(){
            EventBus.$emit(ACTIVATE_WAITER);
            axios.post(`/rooms/join/${this.$route.params.id}`).then((response) => {
                this.token = response.data.token;
                this.session_id = response.data.session_id;
                this.api_key = response.data.api_key;
                this.joinRoom()
            }).catch((err) => {
                console.log(err)
                EventBus.$emit(DEACTIVATE_WAITER);
            })
        },
        data(){
            return {
                token: null,
                session_id: null,
                api_key: null
            }
        },
        methods: {
            joinRoom(){
                let apiKey = this.api_key;
                let sessionId = this.session_id;
                let token = this.token;

                let session = OT.initSession(apiKey, sessionId);

                // Subscribe to a newly created stream
                session.on('streamCreated', (event) => {
                    session.subscribe(event.stream, 'subscriber', {
                        insertMode: 'append',
                        width: '100%',
                        height: '100%'
                    }, this.handleError);
                });

                // Create a publisher
                let publisher = OT.initPublisher('publisher', {
                    insertMode: 'append',
                    width: '100%',
                    height: '100%'
                }, this.handleError);

                // Connect to the session
                session.connect(token, (error) => {
                    // If the connection is successful, initialize a publisher and publish to the session
                    if (error) {
                        this.handleError(error);
                    } else {
                        session.publish(publisher, this.handleError);
                    }
                });
            },
            handleError(error){
                if(error){
                    console.log(error)
                }
            }
        }
    }
</script>
