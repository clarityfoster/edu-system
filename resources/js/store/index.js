import { createStore } from 'vuex';
import axios from "axios";


export const store = createStore({
    state: {
        roleId: parseInt(localStorage.getItem("role_id")) || null,
        roles: [],
        users: [],
    },
    mutations: {
        setRoleId(state, roleId) {

            state.roleId = roleId;
        },
        setRoles(state, roles) {
            state.roles = roles;
            console.log('Roles', state.roles);
        },
        fetchUsers(state, users) {
            state.users = users;
        },
        setCurrentUser(state, user) {
            state.currentUser = user;
            console.log('Current User', state.currentUser);
        },
    },
    getters: {
        roles: (state) => state.roles,
    },
    actions: {
        async fetchRoles({ commit }) {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/roles");


                if (response.data && Array.isArray(response.data.roles)) {
                    console.log('Roles', response.data.roles);
                    commit("setRoles", response.data.roles);
                } else {
                    console.error("Fetched roles are not in the expected array format.");
                }
            } catch (error) {
                console.error("Error fetching roles:", error.response?.data || error);
            }
        },
        async fetchUsers({ commit }) {
            try {
                console.log('Fetching Users...');
                const response = await axios.get("http://127.0.0.1:8000/api/users");
                console.log('API Response:', response);
                commit('fetchUsers', response.data.users);
            } catch (error) {
                console.error("Error fetching users:", error);
            }
        }



    }


});

export default store;


