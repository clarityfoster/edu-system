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
      <!-- <div class="input-group" style="max-width: 500px; margin-bottom: 30px; margin-top: 8px;">
        <input
          type="text"
          class="form-control rounded-5"
          placeholder="Search..."
          aria-label="Example text with button addon"
          aria-describedby="button-addon1"
        />
        <button
          class="btn btn-primary text-white rounded-circle ms-2"
          type="button"
          id="button-addon1"
        >
          <i class="bi bi-search"></i>
        </button>
      </div> -->

      <!-- Data Table -->
      <v-data-table
        :items="semesters"
        :headers="filteredHeaders"
        class="elevation-1"
        item-value="id"
        dense
        item-class="text-center align-middle font-weight-bold"
      >
        <template v-slot:top>
          <v-toolbar flat>
            <v-toolbar-title class="text-center">Semester Lists</v-toolbar-title>
          </v-toolbar>
        </template>

        <template v-slot:item.index="{ index }">
          {{ index + 1 }}
        </template>

        <template v-slot:item.sname="{ item }">
          <div class="text-center">
            {{ item.name }}
          </div>
        </template>

        <template v-slot:item.course="{ item }">
          <div v-for="(course, index) in item.course" :key="index" class="text-start">
            {{ index + 1 }}. {{ course.name }}
          </div>
        </template>

        <template v-slot:item.action="{ item }">
          <div style="display: flex; align-items: center; gap: 8px;">
            <v-btn small color="primary" @click="editSemester(item)">Edit</v-btn>
            <v-btn small color="error" @click="deleteSemester(item)">Delete</v-btn>
          </div>
        </template>

        <template v-slot:item.sdate="{ item }">
           <div class="text-center">
            {{ item.start_date }}
          </div>
        </template>

        <template v-slot:item.edate="{ item }">
           <div class="text-center">
            {{ item.end_date }}
          </div>
        </template>
      </v-data-table>

      <!-- Edit Dialog -->
      <v-dialog v-model="editDialog" persistent max-width="500px">
        <v-card>
          <v-card-title>Edit Semester</v-card-title>
          <v-card-text>
            <v-form ref="editForm">
              <v-text-field
                v-model="editItem.name"
                label="Semester Name"
                required
              ></v-text-field>
              <v-select
                v-model="editItem.course_id"
                :items="courses"
                item-value="id"
                item-title="name"
                label="Courses"
                multiple
                required
                ></v-select>
               <v-text-field
                v-model="editItem.start_date"
                label="Start Date"
                type="date"
                required
                ></v-text-field>

            <v-text-field
            v-model="editItem.end_date"
            label="End Date"
            type="date"
            required
            ></v-text-field>



            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-btn color="blue darken-1" text @click="closeDialog">Cancel</v-btn>
            <v-btn color="blue darken-1" text @click="saveSemester">Save</v-btn>
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
  name: "SemesterList",
  components: {
    SideBar,
  },
  data() {
      return {
        course_id: null,
        loadingIndex: null,
        editDialog: false,

          editItem: { name: "", course_id: null, start_date: null, end_date:null, },
          headers: [
        { title: "Id", value: "index", align: "center", width: "5%" },
        { title: "Semester Name", value: "sname", align: "center", width: "20%" },
         { title: "Course Name", value: "course", align: "center", width: "15%" },
        { title: "Start Date", value: "sdate", align: "center", width: "15%" },
          { title: "End Date", value: "edate", align: "center", width: "15%" },
      ],
    };
  },
  computed: {
    ...mapState(["semesters", "authUsers", "courses"]),
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
    ...mapActions(["fetchSemesters", "fetchAuthUsers","fetchCourses"]),

    editSemester(item) {
    this.editItem = {
        id: item.id,
        name: item.name,
        course_id: item.course.map((course) => course.id),
         start_date: item.start_date,
        end_date: item.end_date,
    };
    this.editDialog = true;
    },




    closeDialog() {
    this.editDialog = false;
    this.editItem = { name: "", course_id: null };
    },


      async saveSemester() {
        // console.log("Payload being sent:", this.editItem);
      try {
        await axios.post(
          `http://127.0.0.1:8000/api/semesters/${this.editItem.id}/update`,
          this.editItem,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            },
          }
        );
        await this.fetchSemesters();
        alert("Semester updated successfully!");
        this.closeDialog();
      } catch (error) {
        console.error("Error updating semester:", error.response?.data || error);
        alert("Failed to update the semester. Please try again.");
      }
    },

    // Delete Semester
    async deleteSemester(item) {
      if (!confirm(`Are you sure you want to delete ${item.name}?`)) {
        return;
      }

      try {
        await axios.delete(
          `http://127.0.0.1:8000/api/semesters/${item.id}/delete`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("auth_token")}`,
            },
          }
        );
        await this.fetchSemesters();
        alert("Semester deleted successfully.");
      } catch (error) {
        console.error("Error deleting semester:", error.response?.data || error);
        alert("Failed to delete the semester. Please try again.");
      }
    },
  },
  mounted() {
    this.fetchSemesters();
      this.fetchAuthUsers();
      this.fetchCourses();
  },
};
</script>

<style scoped>
.primary {
  background-color: #1976d2;
}
</style>
