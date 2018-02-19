
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import 'vuetify/dist/vuetify.min.css' // Ensure you are using css-loader

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify'

Vue.use(Vuetify)
Vue.use(VueRouter)

const routes = [
    {
        path: '/rooms',
        component: require('./components/RoomsComponent'),
        name: 'rooms'
    },
    {
        path: '/rooms/:id',
        component: require('./components/RoomSelectedComponent'),
        name: 'room-selected'
    },
]

const router = new VueRouter({
    routes
});

Vue.component('datatable', require('ts-vuetify-dom-datatable/js/Datatable'))

const app = new Vue({
    components: {
        'main-element': require('./components/MainComponent')
    },
    router,
    el: '#vue-app',
    template: `<main-element/>`
});
