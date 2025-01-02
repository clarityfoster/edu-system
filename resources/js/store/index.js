import { createStore } from 'vuex';
import axios from "axios";


export const store = createStore({
    state: {
        roles: [],
    },
    mutations: {
        setRoles(state, roles) {
            state.roles = roles;
            console.log('Roles', state.roles);
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
        }
    }


});

export default store;


