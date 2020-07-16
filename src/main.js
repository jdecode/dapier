import Vue from 'vue'
Vue.config.productionTip = false

import VueRouter from 'vue-router';
Vue.use(VueRouter);
import routes from './routes';

import store from './store';

import App from './App.vue'

let dapp = Vue.compile('<App></App>');

import nivedan from 'nivedan';

new Vue({
    el: '#app',
    store,
    data: {
        token: ''
    },
    created ()
    {
    },
    beforeMount() {
        this.setMode();
        this.checkToken();
    },
    methods: {
        checkToken: function() {
            this.setToken();
            this.getUser().then();
            this.clearTokenParam();
        },
        setMode: function () {
            let lightMode = true;
            if(typeof localStorage.isDark !== 'undefined') {
                lightMode = JSON.parse(localStorage.isDark);
            }
            this.$store.dispatch("THEME_UPDATE", lightMode).then();
        },
        setToken: function () {
            let token = '';
            if(typeof this.$route.query.token === 'undefined') {
                if (localStorage.token) {
                    token = localStorage.token;
                }
            } else {
                token = this.$route.query.token;
            }
            if(token === '') {
                this.$store.dispatch("LOGOUT", this.$router).then();
                return;
            }
            this.token = token;
        },
        getUser: async function () {
            if(this.token === '') {
                return;
            }
            let nivedanToken = this.token;
            nivedan.defaultConfig({
                baseURL: '/api',
                headers: {
                    common: {
                        'Bearer': nivedanToken
                    },
                }
            });
            try {
                let user = {};
                const response = await nivedan.get('/me');
                user.name = response.data.name;
                user.photo = response.data.photo;
                this.$store.dispatch("TOKEN_UPDATE", this.token).then();
                this.$store.dispatch("USER_UPDATE", user).then();
                this.$store.dispatch("AUTH_UPDATE", true).then();
            } catch (error) {
                this.$store.dispatch("LOGOUT", this.$router).then();
            }
        },
        clearTokenParam: function () {
            if( typeof this.$route.query.token !== 'undefined' && this.$route.query.token.length > 0) {
                this.$router.replace(this.$router.currentRoute.path).then();
            }
        }
    },
    render: dapp.render,
    components: {
        App
    },
    router: new VueRouter(routes)
});
