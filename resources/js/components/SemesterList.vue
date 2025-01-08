<template>
  <v-container fluid class="d-flex justify-content-around  h-100">
    <!-- Sidebar -->
    <SideBar />

    <!-- Main Content Area -->

        <v-card class="expanded-card elevation-2 mx-3 " width="950">
          <v-data-table
            :items="semesters"
             :headers="headers"
            class="elevation-1"
            item-value="id"
            dense
            item-class="text-center align-middle"
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
              {{ item.name }}
            </template>

             <template v-slot:item.course="{ item }">
            <div v-for="(course, index) in item.course" :key="index">
                {{ course.name }}
            </div>
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
  name: "SemesterList",
  components: {
    SideBar,
  },
  data() {
    return {
      loadingIndex: null,
      headers: [
        { title: "Id", value: "index", align: "center", width: "5%" },
        { title: "Semester Name", value: "sname", align: "center", width: "20%" },
        { title: "Course Name", value: "course", align: "center", width: "15%" },

      ],
    };
  },
  computed: {
      ...mapState(["semesters"]),

  },
  methods: {
    ...mapActions(["fetchSemesters"]),

  },
  mounted() {
      this.fetchSemesters();

  },
};
</script>

<style scoped>
.primary {
  background-color: #1976d2;
}
</style>
