import Vue from 'vue'
import store from "../index";

export default{
    // fetch current user object
    namespaced: true,
    state: {
        id: null,
        name: null,
        role: null,
        permissions: false,
        email: null
    },

    mutations: {
        setCurrentUser (state, user) {
            state.id = user.id;
            state.name = user.name;
            state.role = user.role;
            state.email = user.email;
            state.permissions = user.permissions;
        }
    },

    getters: {
        getUser: state => {
            return {
                id: state.id,
                name: state.name,
                role: state.role,
                permissions: state.permissions,
                email: state.email
            }
        },
    },

    actions: {
        /**
        * Get current logged in user
        */
        getCurrentUser({state, commit}) {
            return Vue.$api.getRoute('me', {}, {}).then(function (response) {
                if (response.data.status) {
                    commit('setCurrentUser', response.data.user);
                    return state.user;
                }
                console.log('Not Found User');
                return 'Not found';
            });
        },
    }
}
