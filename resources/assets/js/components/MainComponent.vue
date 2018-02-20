<template>
    <v-app>
        <router-view :key="$route.path"></router-view>
        <waiter :active="activeWaiterMember"></waiter>
    </v-app>
</template>

<script>
    import Waiter from 'ts-vue-dom-waiter/js/Waiter'

    import EventBus, {ACTIVATE_WAITER, DEACTIVATE_WAITER} from '../libraries/event-bus'

    export default {
        components: {
            Waiter
        },
        created(){
            EventBus.$off(ACTIVATE_WAITER, this.activateWaiter)
            EventBus.$on(ACTIVATE_WAITER, this.activateWaiter)

            EventBus.$off(DEACTIVATE_WAITER, this.deactivateWaiter)
            EventBus.$on(DEACTIVATE_WAITER, this.deactivateWaiter)
        },
        data(){
            return {
                activeWaiterMember: false
            }
        },
        methods: {
            activateWaiter(){
                this.activeWaiter = true
            },
            deactivateWaiter(){
                this.activeWaiter = false
            },
        }
    }
</script>
