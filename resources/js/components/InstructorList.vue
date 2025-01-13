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
      <div
        class="input-group"
        style="max-width: 500px; margin-bottom: 20px; margin-top: 8px; margin-left: 900px;"
      >
        <button
          class="btn btn-primary text-white ms-2 btn-sm"
          type="button"
          id="button-addon1"
          @click="toggleFilter"
        >
          <v-icon left size="small">mdi-filter</v-icon> Filter
        </button>
      </div>

      <div v-if="showFilter" class="mb-3 p-3">
        <div class="row">
          <div class="col-md-6">
            <label for="nameFilter">Name</label>
            <select
              id="nameFilter"
              class="form-control"
              v-model="selectedName"
              @change="filterInstructors"
            >
              <option value="">Select Name</option>
              <option v-for="instructor in filterinstructors" :key="instructor.id" :value="instructor.name">
                {{ instructor.name }}
              </option>
            </select>
          </div>
        </div>
      </div>

      <v-data-table
        :items="filteredInstructors"
        :headers="filteredHeaders"
        class="elevation-1"
        item-value="id"
        dense
        item-class="text-center align-middle"
      >
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title class="text-center">Instructor Lists</v-toolbar-title>
          </v-toolbar>
        </template>

        <template v-slot:item.index="{ index }">
          {{ index + 1 }}
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
  name: "InstructorList",
  components: {
    SideBar,
  },
  data() {
    return {
      showFilter: false,
      selectedName: "",
      loadingIndex: null,
      headers: [
        { title: "Id", value: "index", align: "center", width: "5%" },
        { title: "Name", value: "name", align: "center", width: "20%" },
        { title: "Phone", value: "phone", align: "center", width: "15%" },
        { title: "Email", value: "email", align: "center", width: "20%" },
      ],
      filteredInstructors: [],
    };
  },
  computed: {
    ...mapState(["filterinstructors", "roles", "authUsers"]),
    filteredHeaders() {
      const isAdmin = this.authUsers?.role?.name === "Admin";
      return isAdmin
        ? [...this.headers, { title: "Action", value: "action", align: "center", width: "10%" }]
        : this.headers;
    },
  },
  methods: {
    ...mapActions(["fetchFilterInstructors", "fetchRoles", "fetchAuthUsers"]),
    toggleFilter() {
      this.showFilter = !this.showFilter;
      if (!this.showFilter) {
        this.selectedName = "";
        this.filteredInstructors = [...this.filterinstructors]; 
      }
    },
    filterInstructors() {
      this.filteredInstructors = this.filterinstructors.filter((instructor) => {
        const nameMatch = this.selectedName ? instructor.name === this.selectedName : true;
        return nameMatch;
      });
    },
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
        this.filterinstructors[index].is_approved = 1;
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
    this.fetchFilterInstructors().then(() => {
      this.filteredInstructors = this.filterinstructors;
    });
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
