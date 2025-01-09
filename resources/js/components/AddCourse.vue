<template>
  <v-container class="d-flex justify-align-center" style="height: 50vh;">
    <SideBar />
    <v-card class="pa-5 elevation-12 rounded-lg mt-3 mx-auto" width="800">
      <v-card-title class="justify-center text-h5 font-weight-bold text-center">
        Add Course
      </v-card-title>
      <v-card-text>
        <v-form ref="registerForm" v-model="valid" @submit.prevent="createCourse">
          <!-- Name Input -->
          <v-text-field
            v-model="name"
            label="Enter Course Name"
            :rules="[rules.required, rules.min(3)]"
            outlined
            dense
            clearable
            required
          ></v-text-field>

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

      valid: false,
      rules: {
        required: (value) => !!value || "This field is required.",
        min: (length) => (value) =>
          (value || "").length >= length || `Minimum ${length} characters.`,
      },
    };
  },

    methods: {

    async createCourse() {
      const token = localStorage.getItem("auth_token");

      if (!token) {
        console.error("No token found. Redirecting to login...");
        return;
      }

      try {
        await axios.post(
          "http://127.0.0.1:8000/api/courses/create",
          {
            name: this.name,

          },
          {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          }
        );
        alert("Course created successfully!");
        this.cancel();
      } catch (error) {
        console.error("Error during course creation:", error.response.data);
      }
    },
    cancel() {
        this.name = "";
    },
    },
};
</script>
