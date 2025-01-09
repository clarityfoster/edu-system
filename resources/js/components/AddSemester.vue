<template>
  <v-container class="d-flex justify-align-center" style="height: 90vh;">
    <SideBar />
   <v-card class="pa-5 elevation-12 rounded-lg  mt-3 mx-auto" width="800">
      <v-card-title class="justify-center text-h5 font-weight-bold text-center">
        Add Semester
      </v-card-title>
      <v-card-text>
        <v-form ref="registerForm" v-model="valid" @submit.prevent="createSemester">
          <!-- Name Input -->
          <v-text-field
            v-model="name"
            label="Enter Semester Name"
            :rules="[rules.required, rules.min(3)]"
            outlined
            dense
            clearable
            required
          ></v-text-field>

          <v-select
            v-model="course"
            :items="courses"
            item-value="id"
            item-title="name"
            label="Select Course"
            :rules="[rules.required, rules.course]"
            outlined
            dense
            clearable
            required
             multiple
            ></v-select>

          <v-menu
    ref="startDateMenu"
    v-model="startDateMenu"
    :close-on-content-click="false"
    transition="scale-transition"
    offset-y
    min-width="290px"
    >
  <template v-slot:activator="{ on, attrs }" >
    <v-text-field
      v-model="formattedStartDate"
      label="Start Date"
      :rules="[rules.required]"
      readonly
      v-bind="attrs"
      v-on="on"
      outlined
      dense
      clearable
    >
      <template v-slot:append>
        <v-icon
          class="mdi mdi-calendar me-2"
          @click.stop="startDateMenu = true"
          style="cursor: pointer;"
        ></v-icon>
      </template>
    </v-text-field>
  </template>


  <v-date-picker
    v-model="startDate"
    @input="updateFormattedStartDate"
    no-title
  ></v-date-picker>
</v-menu>


          <!-- End Date Input -->
          <v-menu
            ref="endDateMenu"
            v-model="endDateMenu"
            class="position-absolute bottom-50 end-50"
            :close-on-content-click="false "
            transition="scale-transition"
            offset-y
            min-width="290px"
          >
            <template v-slot:activator="{ on, attrs }">
              <v-text-field
                v-model="formattedEndDate"
                label="End Date"
                :rules="[rules.required]"
                readonly
                v-bind="attrs"
                v-on="on"
                outlined
                dense
                clearable
              >
                <template v-slot:append>
                  <v-icon
                    class="mdi mdi-calendar me-2 "
                    @click.stop="endDateMenu = true"
                    style="cursor: pointer;"
                  ></v-icon>
                </template>
              </v-text-field>
            </template>
            <v-date-picker
              v-model="endDate"
              @input="updateFormattedEndDate"
              no-title
            ></v-date-picker>
          </v-menu>

          <v-row class="justify-center">
            <v-col cols="12" sm="6" class="d-flex justify-center">
              <v-btn
                :disabled="!valid"
                color="primary"
                class="mt-4 py-3 font-weight-bold"
                type="submit"
                block
              >
                Create
              </v-btn>
            </v-col>

            <v-col cols="12" sm="6" class="d-flex justify-center">
              <v-btn
                color="secondary"
                class="mt-4 py-3 font-weight-bold"
                type="button"
                @click="cancel"
                block
              >
                Cancel
              </v-btn>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import axios from "axios";
import SideBar from "./SideBar.vue";
import { mapState, mapActions } from "vuex";

export default {
  name: "AddSemester",
  components: {
    SideBar,
  },
  data() {
    return {
        name: "",
      course:[],
      startDate: null,
      endDate: null,
      startDateMenu: false,
      endDateMenu: false,
      valid: false,
      rules: {
        required: (value) => !!value || "This field is required.",
        min: (length) => (value) =>
          (value || "").length >= length || `Minimum ${length} characters.`,
      },
    };
  },
    computed: {
        ...mapState(["courses"]),

    formattedStartDate() {
      return this.formatDate(this.startDate);
    },
    formattedEndDate() {
      return this.formatDate(this.endDate);
    },
  },
    methods: {
        ...mapActions(["fetchCourses"]),

    formatDate(date) {
      if (!date) return "";
      const d = new Date(date);
      const year = d.getFullYear();
      const month = String(d.getMonth() + 1).padStart(2, "0");
      const day = String(d.getDate()).padStart(2, "0");
      return `${year}-${month}-${day}`;
    },
    updateFormattedStartDate() {
      this.startDateMenu = false;
    },
    updateFormattedEndDate() {
      this.endDateMenu = false;
    },
    async createSemester() {
      const token = localStorage.getItem("auth_token");

      if (!token) {
        console.error("No token found. Redirecting to login...");
        return;
      }

      try {
        await axios.post(
          "http://127.0.0.1:8000/api/semesters/create",
          {
            name: this.name,
            course_id:this.course,
            start_date: this.formattedStartDate,
            end_date: this.formattedEndDate,

          },
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );
          alert("Semester created successfully!");

        this.cancel();
      } catch (error) {
        console.error("Error during semester creation:", error.response.data);
      }
    },
    cancel() {
        this.name = "";
        this.course = [];
        this.startDate = null;
        this.endDate = null;
    },
    },

    mounted() {
        this.fetchCourses();
    }
};
</script>
