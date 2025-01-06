<template>
  <v-container fluid class="d-flex h-100">
    <!-- Sidebar -->
    <SideBar />

    <!-- Main Content Area -->
    <v-container fluid class="flex-grow-1 py-4 bg-light ms-md-5">
      <!-- <v-card outlined> -->
        <!-- <v-card-title class="primary text-white text-center">
          <h5 class="mb-0">User List</h5>
        </v-card-title> -->

        <!-- <v-card-text> -->
          <v-data-table
            :items="filterstudents"
             :headers="filteredHeaders"
            class="elevation-1"
            item-value="id"
            dense
            item-class="text-center align-middle"
          >
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title class="text-center">Student Lists</v-toolbar-title>
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
        <!-- </v-card-text>
      </v-card> -->
    </v-container>
  </v-container>
</template>

<script>
import SideBar from "./SideBar.vue";
import axios from "axios";
import { mapState, mapActions } from "vuex";

export default {
  name: "StudentList",
  components: {
    SideBar,
  },
  data() {
    return {
      loadingIndex: null,
      headers: [
        { title: "Id", value: "index", align: "center", width: "5%" },
        { title: "Name", value: "name", align: "center", width: "20%" },
        { title: "Phone", value: "phone", align: "center", width: "15%" },
        { title: "Email", value: "email", align: "center", width: "20%" },
        { title: "Roles", value: "role", align: "center", width: "10%" },

      ],
    };
  },
  computed: {
      ...mapState(["filterstudents", "roles", "authUsers"]),
     filteredHeaders() {
      const isAdmin = this.authUsers?.role?.name === "Admin";
      return isAdmin
        ? [...this.headers, { title: "Action", value: "action", align: "center", width: "10%" }]
        : this.headers;
    },
  },
  methods: {
    ...mapActions(["fetchFilterStudents","fetchRoles", "fetchAuthUsers"]),
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
  },
  mounted() {
      this.fetchFilterStudents();
      this.fetchRoles();
    this.fetchAuthUsers();
  },
};
</script>

<style scoped>
.primary {
  background-color: #1976d2;
}
</style>
