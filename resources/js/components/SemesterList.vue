<template>
  <v-container fluid class="d-flex justify-content-around  h-100">
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
                </div>
          <v-data-table
            :items="semesters"
             :headers="headers"
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

            <!-- <template v-slot:headers="{ props }">
            <thead>
            <tr>
                <th
                v-for="header in props.headers"
                :key="header.value"
                :style="{ textAlign: header.align, width: header.width }"
                class="bold-header"
                >
                {{ header.title }}
                </th>
            </tr>
            </thead>
        </template> -->


            <template v-slot:item.index="{ index }">
              {{ index + 1 }}
            </template>

            <template v-slot:item.sname="{ item }" >
                <div class="text-center">
                    {{ item.name }}
                </div>

            </template>

            <template v-slot:item.course="{ item }">
            <div v-for="(course, index) in item.course" :key="index" class="text-start">
                {{ index + 1 }}. {{ course.name }}
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
