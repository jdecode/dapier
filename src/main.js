import Vue from 'vue'
Vue.config.productionTip = false

import VueRouter from 'vue-router';
Vue.use(VueRouter);
import routes from './routes';

import Vuex from 'vuex';
Vue.use(Vuex);
import store from './store';

import App from './App.vue'

let dapp = Vue.compile('<App></App>');

new Vue({
    el: '#app',
    store,
    data: {
    },
    created ()
    {
        this.checkToken();
    },
    mounted() {
        this.setMode();
    },
    methods: {
        checkToken: function() {
            let token = '';
            if(typeof this.$route.query.token === 'undefined') {
                if (localStorage.token) {
                    token = localStorage.token;
                }
            } else {
                token = this.$route.query.token;
            }
            if(token === '') {
                localStorage.removeItem('token');
                //window.location.href = '/login';
            }
            localStorage.token = token;
            /*
            this.$store.state.token = token;
            if( typeof this.$route.query.token !== 'undefined' && this.$route.query.token.length > 0) {
                this.$router.replace(this.$router.currentRoute.path).then();
            }
            */
        },
        setMode: function () {
            let lightMode = true;
            if(typeof localStorage.isDark !== 'undefined') {
                lightMode = JSON.parse(localStorage.isDark);
            }
            console.log(lightMode);
            //this.$store.dispatch("THEME_UPDATE", lightMode).then();
        }
    },
    render: dapp.render,
    components: {
        App
    },
    router: new VueRouter(routes)
});
