<template>
  <v-container
    class="d-flex justify-center align-center"
    style="height: 100vh; "
  >
    <v-card class="pa-5 elevation-12 rounded-lg" max-width="400">
      <v-card-title class="justify-center text-h5 font-weight-bold">
        Login to Your Account
      </v-card-title>
      <v-card-text>
        <v-form ref="loginForm" v-model="valid">
          <!-- Email Input -->
          <v-text-field
            v-model="email"
            label="Email"
            type="email"
            :rules="[rules.required, rules.email]"
            outlined
            dense
            clearable
            required
          ></v-text-field>

          <!-- Password Input -->
          <v-text-field
            v-model="password"
            label="Password"
            type="password"
            :rules="[rules.required, rules.min(6)]"
            outlined
            dense
            clearable
            required
          ></v-text-field>

          <!-- Login Button -->
          <v-btn
            :disabled="!valid"
            color="primary"
            block
            class="mt-4 py-3 font-weight-bold"
            @click="login"
          >
            Login
          </v-btn>
        </v-form>

        <!-- Display messages -->
        <v-alert
          v-if="message.text"
          :type="message.type"
          class="mt-4"
        >
          {{ message.text }}
        </v-alert>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: "",
      password: "",
      valid: false,
      message: {
        text: "",
        type: ""
      },
      rules: {
        required: (value) => !!value || "This field is required.",
        email: (value) => /.+@.+\..+/.test(value) || "E-mail must be valid.",
        min: (length) => (value) =>
          (value || "").length >= length || `Minimum ${length} characters.`,
      },
      validation: {
        emailStatus: false,
        passwordStatus: false
      },
    };
  },
  methods: {
    async login() {
      this.validation.emailStatus = !this.email;
      this.validation.passwordStatus = !this.password;


      if (this.validation.emailStatus || this.validation.passwordStatus) {
        return;
      }

      try {

        const response = await axios.post("http://127.0.0.1:8000/api/login", {
          email: this.email,
          password: this.password,
        });

         const user = response.data.user;
        localStorage.setItem("role_id", user.role_id);
        this.$store.commit("setRoleId", user.role_id);
        this.$router.push("/sidebar");


        const token = response.data.token;
        localStorage.setItem("auth_token", token);

        const userId = response.data.user.id;

        // Set success message
        this.message.text = "Login successful!";
        this.message.type = "success";

        // Clear email and password fields
        this.email = "";
        this.password = "";



            this.$router.push("/sidebar");

      } catch (error) {
        console.error("Login failed:", error);

        // Display error message if login fails
        this.message.text = "Login failed. Please check your credentials.";
        this.message.type = "error";
      }
      },
     
    },

};
</script>

<style>
body {
  margin: 0;
  font-family: Roboto, sans-serif;
}
</style>
