import { createStore } from 'vuex';
import axios from "axios";


export const store = createStore({
    state: {
        roleId: parseInt(localStorage.getItem("role_id")) || null,
        roles: [],
        users: [],
        authUsers: [],
        filterstudents: [],
        filterinstructor:[],
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
        fetchAuthUsers(state, authUsers) {
            state.authUsers = authUsers;
        },
         fetchFilterStudents(state, filterstudents) {
            state.filterstudents = filterstudents;
        },
        fetchFilterInstructors(state, filterinstructors) {
            state.filterinstructors = filterinstructors;
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

                const response = await axios.get("http://127.0.0.1:8000/api/users");
                // console.log('API Response:', response);
                commit('fetchUsers', response.data.users);
            } catch (error) {
                console.error("Error fetching users:", error);
            }
        },
        async fetchFilterStudents({ commit }) {
            try {

                const response = await axios.get("http://127.0.0.1:8000/api/learners");

                commit('fetchFilterStudents', response.data.learners);

            } catch (error) {
                console.error("Error fetching filterstudents:", error);
            }
        },
        async fetchFilterInstructors({ commit }) {
            try {

                const response = await axios.get("http://127.0.0.1:8000/api/instructors");

                commit('fetchFilterInstructors', response.data.instructors);

            } catch (error) {
                console.error("Error fetching filterinstructors:", error);
            }
        },
        async fetchAuthUsers({ commit }) {
      try {
        const token = localStorage.getItem("auth_token");

        if (!token) {
          console.error("No token found. Redirecting to login...");
          return;
        }

        const response = await axios.get("http://127.0.0.1:8000/api/auth-users", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        if (response.data && response.data.authUser) {
          commit("fetchAuthUsers", response.data.authUser);
        } else {
          console.error("authUsers key not found in the response.");
        }
      } catch (error) {
        if (error.response && error.response.status === 401) {
          console.error("Unauthorized: Token invalid or expired.");
        } else {
          console.error("Error fetching auth users:", error.message);
        }
      }
    },
    }


});

export default store;


