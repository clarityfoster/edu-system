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
            :items="courses"
             :headers="headers"
            class="elevation-1"
            item-value="id"
            dense
            item-class="text-center align-middle"
          >
            <template v-slot:top>
              <v-toolbar flat>
                <v-toolbar-title class="text-center">Course Lists</v-toolbar-title>
              </v-toolbar>
            </template>

            <template v-slot:item.index="{ index }">
              {{ index + 1 }}
            </template>

            <template v-slot:item.name="{ item }">
            {{ item.name }}
            </template>


           <!-- <template v-slot:item.name="{ item }">
            <div v-for="index in item" :key="index">
                {{ item.name }}
            </div>
            </template> -->


             <template v-slot:item.action="{ item, index }" >

              <v-btn v-if="index === 3"
                small
                color="primary"

              >
                Study
              </v-btn>
              <v-btn v-else
                small
                color="danger"
              >
                Empty
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
  name: "CourseList",
  components: {
    SideBar,
  },
  data() {
    return {
      loadingIndex: null,
      headers: [
        { title: "Id", value: "index", align: "center", width: "5%" },
        { title: "Course Name", value: "name", align: "center", width: "15%" },
        { title: "Action", value: "action", align: "center", width: "15%" },

      ],
    };
  },
  computed: {
      ...mapState(["courses"]),

  },
  methods: {
    ...mapActions(["fetchCourses"]),

  },
  mounted() {
      this.fetchCourses();

  },
};
</script>

<style scoped>
.primary {
  background-color: #1976d2;
}
</style>
