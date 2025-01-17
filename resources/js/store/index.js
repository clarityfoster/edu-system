import { createStore } from 'vuex';
import axios from "axios";


export const store = createStore({
    state: {
        roleId: parseInt(localStorage.getItem("role_id")) || null,
        role_register: [],
        roles: [],
        users: [],
        authUsers: [],
        filterstudents: [],
        filterinstructor: [],
        semesters: [],
        courses: [],
        ongoingsemesters: [],
        completedsemesters:[]
    },
    mutations: {
        setRoleId(state, roleId) {

            state.roleId = roleId;
        },
        fetchRoleRegister(state, role_register) {
            state.role_register = role_register;
            // console.log('RoleRegisters', state.role_register);

        },
        setRoles(state, roles) {
            state.roles = roles;
            // console.log('Roles', state.roles);
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
        fetchSemesters(state, semesters) {
            state.semesters = semesters;
        },
        fetchOngoingSemesters(state, ongoingsemesters) {
            state.ongoingsemesters = ongoingsemesters;
        },
        fetchCompletedSemesters(state, completedsemesters) {
            state.semesters = completedsemesters;
        },
          fetchCourses(state, courses) {
            state.courses = courses;
          },
        SearchUsers(state, users) {
            state.users = users ;
        },


    },
    getters: {
        roles: (state) => state.roles,
    },
    actions: {
        async fetchRoleRegister({ commit }) {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/register-roles");


                if (response.data && Array.isArray(response.data.role_register)) {
                    // console.log('Role_Register', response.data.role_register);
                    commit("fetchRoleRegister", response.data.role_register);
                } else {
                    console.error("Fetched roles are not in the expected array format.");
                }
            } catch (error) {
                console.error("Error fetching roles:", error.response?.data || error);
            }
        },
        async fetchRoles({ commit }) {
            try {
                const response = await axios.get("http://127.0.0.1:8000/api/roles");


                if (response.data && Array.isArray(response.data.roles)) {
                    // console.log('Roles', response.data.roles);
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
        async fetchSemesters({ commit }) {
            try {

                const response = await axios.get("http://127.0.0.1:8000/api/semesters");

                commit('fetchSemesters', response.data.semesters);
                // console.log('Semesters', response.data.semesters);

            } catch (error) {
                console.error("Error fetching semesters:", error);
            }
        },
        async fetchOngoingSemesters({ commit }) {
            try {
                const token = localStorage.getItem("auth_token");
                if (!token) {
                    console.error("No authentication token found.");
                    return;
                }

                const response = await axios.get("http://127.0.0.1:8000/api/semesters/ongoing", {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });

                commit('fetchOngoingSemesters', response.data.ongoingsemesters);
                // console.log('Ongoing Semesters', response.data.ongoingsemesters);
            } catch (error) {
                if (error.response && error.response.status === 401) {
                    console.error("Unauthorized: Please check the token or login again.");
                } else {
                    console.error("Error fetching ongoing semesters:", error.message);
                }
            }
        },

        async fetchCompletedSemesters({ commit }) {
            try {
                const token = localStorage.getItem("auth_token");
                if (!token) {
                    console.error("No authentication token found.");
                    return;
                }

                const response = await axios.get("http://127.0.0.1:8000/api/semesters/completed", {
                    headers: {
                        Authorization: `Bearer ${token}`,
                    },
                });

                commit('fetchCompletedSemesters', response.data.semesters);

            } catch (error) {

                    console.error("Error fetching completed semesters:", error.message);

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
            console.log('Auth Users', response.data.authUser);

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

        async fetchCourses({ commit }) {
            try {

                const response = await axios.get("http://127.0.0.1:8000/api/courses");

                commit('fetchCourses', response.data.courses);

            } catch (error) {
                console.error("Error fetching courses:", error);
            }
        },


        async Search({ commit }, query) {
            try {

                const response = await axios.post('http://127.0.0.1:8000/api/search', {
                     query
                });

                // console.log('SearchUser',response.data.users);

                commit('SearchUsers', response.data.users);

            } catch (error) {
                console.error(error.response.data);
            }
        },
    }


});

export default store;


