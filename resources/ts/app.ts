import './bootstrap.ts';
import Vue from 'vue';
import MainVue from './vue/main.vue';

Vue.component('main-vue', MainVue);

new Vue({
    el: '#app'
})
