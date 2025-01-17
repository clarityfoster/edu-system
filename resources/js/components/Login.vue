<template>
    <v-container
        class="d-flex justify-center align-center"
        style="height: 100vh"
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
                        v-on:keyup.enter="login"
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
                 <div class="card-footer text-center">
                <p class="text-muted mt-3">
                    Don't have an account?
                    <router-link class="text-primary" to="/register">Register</router-link>.
                </p>
            </div>
                <!-- Display messages -->
                <v-alert v-if="message.text" :type="message.type" class="mt-4">
                    {{ message.text }}
                </v-alert>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            email: "",
            password: "",
            valid: false,
            message: {
                text: "",
                type: "",
            },
            rules: {
                required: (value) => !!value || "This field is required.",
                email: (value) =>
                    /.+@.+\..+/.test(value) || "E-mail must be valid.",
                min: (length) => (value) =>
                    (value || "").length >= length ||
                    `Minimum ${length} characters.`,
            },
            validation: {
                emailStatus: false,
                passwordStatus: false,
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
                const response = await axios.post(
                    "http://127.0.0.1:8000/api/login",
                    {
                        email: this.email,
                        password: this.password,
                    }
                );

                const user = response.data.user;
                const token = response.data.token;

                if (user.is_approved !== 1) {
                    this.message.text =
                        "Your account has not been approved yet.";
                    this.message.type = "error";
                    return;
                }

                localStorage.setItem("auth_token", token);
                localStorage.setItem("role_id", user.role_id);

                this.$store.commit("setRoleId", user.role_id);

                if (user.role_id == 1) {
                    this.message.text = "Login successful!";
                    this.message.type = "success";

                    this.email = "";
                    this.password = "";

                    this.$router.push("/home");
                } else {
                    console.log("User");
                    this.message.text = "Login successful!";
                    this.message.type = "success";

                    this.email = "";
                    this.password = "";

                    this.$router.push("/home");
                }
            } catch (error) {
                console.error("Login failed:", error);

                if (error.response && error.response.data) {
                    const errorMessage =
                        error.response.data.message ||
                        "Login failed. Please try again.";
                    this.message.text = errorMessage;
                    this.message.type = "error";
                } else {
                    this.message.text =
                        "Unable to connect to the server. Check your internet connection.";
                    this.message.type = "error";
                }
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
