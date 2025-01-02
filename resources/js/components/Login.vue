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
            @click="handleLogin"
          >
            Login
          </v-btn>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      email: "",
      password: "",
      valid: false,
      rules: {
        required: (value) => !!value || "This field is required.",
        email: (value) => /.+@.+\..+/.test(value) || "E-mail must be valid.",
        min: (length) => (value) =>
          (value || "").length >= length || `Minimum ${length} characters.`,
      },
    };
  },
  methods: {
    handleLogin() {
      if (this.$refs.loginForm.validate()) {
        // Handle login logic here
        alert(`Email: ${this.email}\nPassword: ${this.password}`);
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
