<template>
  <v-container fluid class="d-flex justify-content-around h-100">
    <!-- Sidebar -->
    <SideBar />

    <!-- Main Content Area -->
   <v-card class="expanded-card elevation-2 mx-3 " width="950">


        <!-- <v-card-text> -->
          <v-data-table
            :items="users"
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
    ...mapActions(["fetchUsers", "fetchRoles"]),
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
    this.fetchUsers();
  },
};
</script>

<style scoped>
.primary {
  background-color: #1976d2;
}
</style>
