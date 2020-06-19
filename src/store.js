import Vuex from 'vuex';
import Vue from 'vue';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        isDark: false,
        token: ''
    },
    getters: {
        DARK: state => {
            return state.isDark
        },
        TOKEN: state => {
            return state.token
        }
    },
    mutations: {
        THEME_UPDATE: ((state, isDark) => {
            localStorage.isDark = isDark;
            state.isDark = isDark;
        })
    },
    actions: {
        THEME_UPDATE: ((context, dark) => {
            context.commit('THEME_UPDATE', dark);
        })
    }
});
