<template>
  <v-container
    class="d-flex justify-align-center"
    style="height: 100vh;"
  >
  <SideBar />
   <v-card class="pa-5 elevation-12 rounded-lg mt-3 mx-auto" width="800">
      <v-card-title class="justify-center text-h5 font-weight-bold text-center">
        Add Student
      </v-card-title>
      <v-card-text>
        <v-form ref="registerForm" v-model="valid" @submit.prevent="createStudent">
          <!-- Name Input -->
          <v-text-field
            v-model="name"
            label="Enter Full Name"
            :rules="[rules.required, rules.min(3)]"
            outlined
            dense
            clearable
            required
          ></v-text-field>

          <!-- Email Input -->
          <v-text-field
            v-model="email"
            label="Enter Email"
            type="email"
            :rules="[rules.required, rules.email]"
            outlined
            dense
            clearable
            required
          ></v-text-field>

            <v-text-field
            v-model="password"
            label=" Password"
            type="password"
            :rules="[rules.required, rules.min(8)]"
            outlined
            dense
            clearable
            required
            ></v-text-field>

            <v-text-field
            v-model="phone"
            label="Enter Phone No"
            type="text"
            :rules="[rules.required, rules.phone]"
            outlined
            dense
            clearable
            required
          ></v-text-field>

          <v-select
            v-if="semesters && Array.isArray(semesters)"
            v-model="semester"
            :items="semesters"
            item-value="id"
            item-title="name"
            label="Select Semester"
            :rules="[rules.required, rules.semester]"
            outlined
            dense
            clearable
            required
            ></v-select>

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
            <!-- Cancel Button -->
            <v-btn
            :disabled="!valid"
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
    name: "AddStudent",
     components: {
    SideBar,
  },
  data() {
    return {
      name: "",
      email: "",
        password: "",
        phone: "",
      semester: "",
      valid: false,
      rules: {
        required: (value) => !!value || "This field is required.",
        email: (value) => /.+@.+\..+/.test(value) || "E-mail must be valid.",
        min: (length) => (value) =>
              (value || "").length >= length || `Minimum ${length} characters.`,
        phone: (value) =>
          /^[+]*[0-9]{1,3}[ -]?[0-9]{1,4}[ -]?[0-9]{1,4}[ -]?[0-9]{1,4}$/.test(
            value
          ) || "Please enter a valid phone number.",
      },
    };
  },
  computed: {
  ...mapState(["semesters"]),
},

  methods: {
    ...mapActions(["fetchSemesters"]),

      async createStudent() {
        const token = localStorage.getItem("auth_token");

        if (!token) {
          console.error("No token found. Redirecting to login...");
          return;
        }
            try {
            await axios.post("http://127.0.0.1:8000/api/learners/create", {
                name: this.name,
                email: this.email,
                password: this.password,
                phone: this.phone,
                semester_id: this.semester
            },
            {
            headers: {
            Authorization: `Bearer ${token}`
            }
            }
            );
            alert("Student Create successful!");
           this.cancel();
            } catch (error) {
            console.error("Error during create student:", error.response.data);
            }

        },
        cancel() {
            this.name = "";
            this.email = "";
            this.password = "";
            this.phone = "";
            this.semester= "";
        },

  },
  mounted() {
    this.fetchSemesters();
  },

};
</script>
