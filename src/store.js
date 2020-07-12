import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isDark: false,
        token: '',
        auth: false,
        user: {

        }
    },
    getters: {
        DARK: state => {
            return state.isDark
        },
        TOKEN: state => {
            return state.token
        },
        AUTH: state => {
            return state.auth
        },
        USER: state => {
            return state.user
        },
    },
    mutations: {
        THEME_UPDATE: ((state, isDark) => {
            localStorage.isDark = isDark;
            state.isDark = isDark;
        }),
        AUTH_UPDATE: ((state, auth) => {
            state.auth = auth;
        }),
        TOKEN_UPDATE: ((state, token) => {
            localStorage.token = token;
            state.token = token;
        }),
        LOGOUT: ((state) => {
            localStorage.removeItem('token');
            state.token = '';
            if(this.$router.currentRoute.path !== '/login') {
                this.$router.replace('/login').then();
            }
        }),
        USER_UPDATE: ((state, user) => {
            state.user = user;
        })
    },
    actions: {
        THEME_UPDATE: ((context, dark) => {
            context.commit('THEME_UPDATE', dark);
        }),
        AUTH_UPDATE: ((context, auth) => {
            context.commit('AUTH_UPDATE', auth);
        }),
        USER_UPDATE: ((context, user) => {
            context.commit('USER_UPDATE', user);
        }),
        TOKEN_UPDATE: ((context, token) => {
            context.commit('TOKEN_UPDATE', token);
        }),
        LOGOUT: ((context) => {
            context.commit('LOGOUT');
        })
    }
});
