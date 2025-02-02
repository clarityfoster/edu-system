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
        class="input-group d-flex justify-content-end"
        style="max-width: 100%; margin-bottom: 20px;"
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

         <template v-slot:item.action="{ item }">
          <div style="display: flex; align-items: center; gap: 8px;">
            <v-btn small color="primary" @click="editItem(item)">Edit</v-btn>
            <v-btn small color="error" @click="deleteItem(item)">Delete</v-btn>
          </div>
        </template>

        <template v-slot:item.action2="{ item, index }">
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
     <v-dialog v-model="editDialog" max-width="500px">
      <v-card>
        <v-card-title>Edit Instructor</v-card-title>
        <v-card-text>
          <v-form ref="editForm">
            <v-text-field
              v-model="editInstructor.name"
              label="Name"
              required
            ></v-text-field>
            <v-text-field
              v-model="editInstructor.phone"
              label="Phone"
              required
            ></v-text-field>
            <v-text-field
              v-model="editInstructor.email"
              label="Email"
              required
            ></v-text-field>

          </v-form>
        </v-card-text>
        <v-card-actions>
          <v-btn color="primary" text @click="updateInstructor">Save</v-btn>
          <v-btn color="grey" text @click="editDialog = false">Cancel</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
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
      editDialog: false,
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
          ? [...this.headers,
            { title: "Action", value: "action", align: "center", width: "10%" },
           { title: "Action", value: "action2", align: "center", width: "5%" },]
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
     async deleteItem(item) {
        if (!confirm(`Are you sure you want to delete ${item.name}?`)) {
            return;
        }

        try {
            await axios.delete(`http://127.0.0.1:8000/api/users/${item.id}`, {
            headers: {
                Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            },
            });

            this.filteredInstructors = this.filteredInstructors.filter(
            (instructor) => instructor.id !== item.id
            );

            alert("Instructor deleted successfully.");
        } catch (error) {
            console.error("Error deleting Instructor:", error.response?.data || error);
            alert("Failed to delete the item. Please try again.");
        }
      },
      editItem(item) {
      this.editInstructor = { ...item };
      this.editDialog = true;
    },
    async updateInstructor() {
        try {
            await axios.post(
            `http://127.0.0.1:8000/api/users/${this.editInstructor.id}/update`,
            this.editInstructor,
            {
                headers: {
                Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
                },
            }
            );

            await this.fetchFilterInstructors();
            this.filteredInstructors = this.filterinstructors.filter((instructor) => {
            const nameMatch = this.selectedName ? instructor.name === this.selectedName : true;
            return nameMatch;
            });

            alert("Instructor updated successfully!");
            this.editDialog = false;
        } catch (error) {
            console.error("Error updating instructor:", error.response?.data || error);
            alert("Failed to update the instructor. Please try again.");
        }
        }


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
