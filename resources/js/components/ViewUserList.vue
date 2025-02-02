<template>
  <v-container fluid class="d-flex justify-content-around h-100">
    <!-- Sidebar -->
    <SideBar />

    <!-- Main Content Area -->
    <v-card
      class="home-dashboard expanded-card elevation-2"
      elevation="0"
      style="gap: 30px; width: 2300px; max-width: 80%; margin-left: 100px;"
    >
      <div class="input-group" style="max-width: 500px; margin-bottom: 30px; margin-top: 8px;">
        <input
          type="text"
          v-model="searchKey"
          class="form-control rounded-5"
          placeholder="Search..."
          aria-label="Example text with button addon"
          aria-describedby="button-addon1"
          v-on:keyup.enter="search"
        />
        <button
          class="btn btn-primary text-white rounded-circle ms-2 "
          type="button"
          id="button-addon1"
          @click="search"
        >
          <i class="bi bi-search"></i>
        </button>
      </div>

      
      <v-alert
        v-if="errorMessage"
        type="error"
        class="mt-3"
        dense
      >
        {{ errorMessage }}
      </v-alert>

      <v-data-table
        :items="Array.isArray(users) ? users : []"
        :headers="headers"
        class="elevation-1"
        item-value="id"
        dense
        item-class="text-center align-middle"
        >
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title class="text-center ">User Management</v-toolbar-title>
          </v-toolbar>
        </template>

        <template v-slot:item.index="{ index }">
          {{ index + 1 }}
        </template>

        <template v-slot:item.role="{ item }">
          <v-chip
            v-if="item.role"
            color="success"
            text-color="white"
            small
          >
            {{ item.role.name }}
          </v-chip>
          <span v-else class="text-muted">No Role</span>
        </template>

        <template v-slot:item.action="{ item, index }">
          <v-btn
            small
            color="primary"
            :loading="loadingIndex === index"
            :disabled="item.is_approved"
            @click="approveUser(item.id, index)"
          >
            {{
              item.is_approved
                ? "Approved"
                : loadingIndex === index
                ? "Approving..."
                : "Accept"
            }}
          </v-btn>
        </template>
      </v-data-table>
    </v-card>
  </v-container>
</template>

<script>
import SideBar from "./SideBar.vue";
import axios from "axios";
import { mapState, mapActions } from "vuex";

export default {
  name: "ViewUserList",
  components: {
    SideBar,
  },
  data() {
    return {
      searchKey: "",
      errorMessage: "",
      loadingIndex: null,
      headers: [
        { title: "Id", value: "index", align: "center", width: "5%" },
        { title: "Name", value: "name", align: "center", width: "20%" },
        { title: "Phone", value: "phone", align: "center", width: "15%" },
        { title: "Email", value: "email", align: "center", width: "20%" },
        { title: "Roles", value: "role", align: "center", width: "10%" },
        { title: "Action", value: "action", align: "center", width: "10%" },
      ],
    };
  },
  computed: {
    ...mapState(["users", "roles"]),
  },
  methods: {
    ...mapActions(["fetchUsers", "fetchRoles", "Search"]),
    async approveUser(userId, index) {
      this.loadingIndex = index;
      try {
        const response = await axios.post(
          `http://127.0.0.1:8000/api/users/${userId}/approve`,
          {},
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            },
          }
        );

        this.users[index].is_approved = 1;
        console.log(response.data.message);
      } catch (error) {
        console.error("Error approving user:", error.response?.data || error);
        alert("Failed to approve the user. Please try again.");
      } finally {
        this.loadingIndex = null;
      }
    },

    search() {
      if (!this.searchKey.trim()) {
        this.errorMessage = "Please enter a search key to proceed.";
        return;
      }

      this.errorMessage = "";


      this.Search(this.searchKey);

      if (this.users.length === 0) {
        this.errorMessage = "No users found matching the search criteria.";
      }
    },
  },
  mounted() {
    this.fetchUsers();
  },
  watch: {
    searchKey(newSearchKey) {
      if (!newSearchKey.trim()) {
        this.fetchUsers();
      }
    },
  },
};
</script>

<style scoped>
.primary {
  background-color: #1976d2;
}
</style>
