<template>
  <v-container
    class="d-flex justify-center align-center"
    style="height: 100vh;"
  >
    <v-card class="pa-5 elevation-12 rounded-lg" width="400">
      <v-card-title class="justify-center text-h5 font-weight-bold">
        Register
      </v-card-title>
      <v-card-text>
        <v-form ref="registerForm" v-model="valid" @submit.prevent="register">
          <!-- Name Input -->
          <v-text-field
            v-model="name"
            label="Full Name"
            :rules="[rules.required, rules.min(3)]"
            outlined
            dense
            clearable
            required
          ></v-text-field>

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
          <!-- Confirm Password Input -->
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


          <!-- Role Select -->
          <v-select
            v-if="roles && Array.isArray(roles)"
            v-model="role"
            :items="roles"
            item-value="id"
            item-title="name"
            label="Select Role"
            :rules="[rules.required]"
            outlined
            dense
            clearable
            required
            ></v-select>

          <!-- Register Button -->

          <v-btn
            :disabled="!valid"
            color="primary"
            block
            class="mt-4 py-3 font-weight-bold"
            type="submit"
          >
            Register
          </v-btn>
        </v-form>
         <div class="card-footer text-center">
              <p class="text-muted mt-3">Already have an account?
                <router-link class="text-success" to="/">Login</router-link>
                 .</p>
            </div>
      </v-card-text>
    </v-card>

  </v-container>
</template>

<script>
import axios from "axios";
import { mapState, mapActions } from "vuex";

export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
      role: "",
      valid: false,
      rules: {
        required: (value) => !!value || "This field is required.",
        email: (value) => /.+@.+\..+/.test(value) || "E-mail must be valid.",
        min: (length) => (value) =>
          (value || "").length >= length || `Minimum ${length} characters.`,
      },
    };
  },
  computed: {
  ...mapState(["roles"]),
},

  methods: {
    ...mapActions(["fetchRoles"]),

      async register() {
        // alert("Registering...");
          if (this.$refs.registerForm.validate()) {
            // alert("Registering...");
            try {
            await axios.post("http://127.0.0.1:8000/api/register", {
                name: this.name,
                email: this.email,
                password: this.password,
                role_id: this.role,
            });
            alert("Registration successful!");
            this.name = "";
            this.email = "";
            this.password = "";
            this.role = null;
            this.$router.push("/login");
            } catch (error) {
            console.error("Error during registration:", error.response.data);
            }
        }
        },

  },
  mounted() {
    this.fetchRoles();
  },
  watch: {
    roles(newRoles) {
      console.log("Roles updated in component:", newRoles);
    },
  },
};
</script>
