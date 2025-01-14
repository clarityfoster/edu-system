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
      <!-- Search Input -->
      <div class="input-group" style="max-width: 500px; margin-bottom: 30px; margin-top: 8px;">
        <input
          type="text"
          class="form-control rounded-5"
          placeholder="Search..."
          aria-label="Example text with button addon"
          aria-describedby="button-addon1"
        />
        <button class="btn btn-primary text-white rounded-circle ms-2" type="button" id="button-addon1">
          <i class="bi bi-search"></i>
        </button>
      </div>

      <!-- Data Table -->
      <v-data-table
        :items="courses"
        :headers="filteredHeaders"
        class="elevation-1"
        item-value="id"
        dense
        item-class="text-center align-middle"
      >
        <!-- Table Header -->
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title class="text-center">Course Lists</v-toolbar-title>
          </v-toolbar>
        </template>

        <!-- Index Column -->
        <template v-slot:item.index="{ index }">
          {{ index + 1 }}
        </template>

        <!-- Course Name Column -->
        <template v-slot:item.name="{ item }">
          {{ item.name }}
        </template>

        <!-- Learning Column -->
        <template v-slot:item.learn="{ index }">
          <v-btn
            v-if="index === 3"
            small
            color="primary"
            class="text-white"
          >
            <a href="/binarytree" class="text-white text-decoration-none">Study</a>
          </v-btn>
          <v-btn
            v-else
            small
            color="error"
            class="text-white"
          >
            Empty
          </v-btn>
        </template>

        <!-- Action Column -->
        <template v-slot:item.action="{ item }">
          <div style="display: flex; align-items: center; gap: 8px;">
            <v-btn small color="primary" @click="editCourse(item)">Edit</v-btn>
            <v-btn small color="error" @click="deleteCourse(item)">Delete</v-btn>
          </div>
        </template>
      </v-data-table>

      <!-- Edit Dialog -->
      <v-dialog v-model="editDialog" persistent max-width="500px">
        <v-card>
          <v-card-title>Edit Course</v-card-title>
          <v-card-text>
            <v-form ref="editForm">
              <v-text-field
                v-model="editItem.name"
                label="Course Name"
                required
              ></v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-btn color="blue darken-1" text @click="closeDialog">Cancel</v-btn>
            <v-btn color="blue darken-1" text @click="saveCourse">Save</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card>
  </v-container>
</template>

<script>
import SideBar from "./SideBar.vue";
import axios from "axios";
import { mapState, mapActions } from "vuex";

export default {
  name: "CourseList",
  components: {
    SideBar,
  },
  data() {
    return {
      editDialog: false,
      editItem: { id: null, name: "" },
      headers: [
        { title: "Id", value: "index", align: "center", width: "5%" },
        { title: "Course Name", value: "name", align: "center", width: "15%" },
        { title: "Learning", value: "learn", align: "center", width: "15%" },
      ],
    };
  },
  computed: {
    ...mapState(["courses", "authUsers"]),
    filteredHeaders() {
      const isAdmin = this.authUsers?.role?.name === "Admin";
      return isAdmin
        ? [
            ...this.headers,
            { title: "Action", value: "action", align: "center", width: "10%" },
          ]
        : this.headers;
    },
  },
  methods: {
    ...mapActions(["fetchCourses", "fetchAuthUsers"]),

    // Open Edit Dialog
    editCourse(item) {
      this.editItem = { id: item.id, name: item.name };
      this.editDialog = true;
    },


    closeDialog() {
      this.editDialog = false;
      this.editItem = { id: null, name: "" };
    },


    async saveCourse() {
      try {
        await axios.post(
          `http://127.0.0.1:8000/api/courses/${this.editItem.id}/update`,
          { name: this.editItem.name },
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            },
          }
        );
        await this.fetchCourses();
        alert("Course updated successfully!");
        this.closeDialog();
      } catch (error) {
        console.error("Error updating course:", error.response?.data || error);
        alert("Failed to update the course. Please try again.");
      }
    },

    // Delete Course
    async deleteCourse(item) {
      if (!confirm(`Are you sure you want to delete ${item.name}?`)) {
        return;
      }

      try {
        await axios.delete(
          `http://127.0.0.1:8000/api/courses/${item.id}/delete`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            },
          }
        );
        await this.fetchCourses();
        alert("Course deleted successfully.");
      } catch (error) {
        console.error("Error deleting course:", error.response?.data || error);
        alert("Failed to delete the course. Please try again.");
      }
    },
  },
  mounted() {
    this.fetchCourses();
    this.fetchAuthUsers();
  },
};
</script>

<style scoped>
.primary {
  background-color: #1976d2;
}

.text-white {
  color: white !important;
}

.text-decoration-none {
  text-decoration: none !important;
}
</style>
