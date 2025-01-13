<template>
    <div class="d-flex" style="height: 120vh;">
      <SideBar />
      <div class="flex-grow-1 p-4">
        <div class="card shadow-lg h-100">
          <div class="card-header bg-primary text-white text-center">
            <h3>Edit Student</h3>
          </div>
          <div class="card-body d-flex flex-column">
            <div class="container-fluid" style="width:600px; margin:0 auto;">
                <div v-if="loading" class="text-center">
                <p>Loading user data...</p>
                </div>
                <div v-else>
              <form @submit.prevent="updateUser">
                <div class="mb-3">
                  <label for="name" class="form-label">Full Name</label>
                  <input
                    type="text"
                    id="name"
                    class="form-control"
                    v-model="user.name"
                  />
                </div>
                <div class="mb-3">
                  <label for="email" class="form-label">Email Address</label>
                  <input
                    type="email"
                    id="email"
                    class="form-control"
                    v-model="user.email"
                  />
                </div>
                <div class="mb-3">
                  <label for="address" class="form-label">Address</label>
                  <input
                    type="text"
                    id="address"
                    class="form-control"
                    v-model="user.address"
                  />
                </div>
                <div class="mb-3">
                  <label for="phone_no" class="form-label">Mobile Number</label>
                  <input
                    type="text"
                    id="phone_no"
                    class="form-control"
                    v-model="user.phone_no"
                  />
                </div>
                <div class="mb-3">
                  <label for="role_id" class="form-label">Role</label>
                  <select
                    class="form-control"
                    id="role_id"
                    v-model="user.role_id"
                  >
                    <option v-for="role in roles" :key="role.id" :value="role.id">
                      {{ role.name }}
                    </option>
                  </select>
                </div>
                <div class="d-flex justify-content-center gap-3 mt-auto">
                    <router-link to="/userlist" class="btn btn-primary">Back</router-link>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>

              </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

  <script>
  import axios from "axios";
  import SideBar from "../SideBar.vue";

  export default {
  name: "EditUser",
  components: {
    SideBar,
  },
  props: ["userId"],
  data() {
    return {
      user: this.defaultUser(),
      roles: [],
      loading: true,
    };
  },
  methods: {
    defaultUser() {
      return {
        name: "",
        email: "",
        address: "",
        phone_no: "",
        role_id: null,
      };
    },
    async fetchUser() {
      try {
        // console.log("Fetching user for ID:", this.userId);
        const response = await axios.get(
          `http://127.0.0.1:8000/api/users/${this.userId}`
        );
        // console.log("Fetched user:", response.data);
        this.user = response.data.user || this.defaultUser();
      } catch (error) {
        console.error("Error fetching user:", error);
      } finally {
        this.loading = false;
      }
    },
    async fetchRoles() {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/roles");
        this.roles = response.data.roles;
      } catch (error) {
        console.error("Error fetching roles:", error);
      }
    },
    async updateUser() {
  try {
    console.log("User data before update:", this.user);
    console.log("Updating user with ID:", this.userId);
    const response = await axios.put(
      `http://127.0.0.1:8000/api/users/${this.userId}`,
      this.user
    );
    alert("User updated successfully!");
  } catch (error) {
    console.error("Error response:", error.response.data);
    alert("Error updating user: " + error.response.data.message || "An unknown error occurred.");
  }
}


  },
  mounted() {
    this.fetchUser();
    this.fetchRoles();
    const { fromButton, ...restQuery } = this.$route.query;
    if (fromButton) {
      this.$router.replace({ ...this.$route, query: restQuery });
    }
  },

};


  </script>
