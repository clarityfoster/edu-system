<template>
    <v-container
        class="d-flex justify-center align-center"
        style="height: 100vh"
    >
        <v-card class="pa-5 elevation-12 rounded-lg" width="400">
            <v-card-title class="justify-center text-h5 font-weight-bold">
                Register
            </v-card-title>
            <v-card-text>
                <v-form
                    ref="registerForm"
                    v-model="valid"
                    @submit.prevent="register"
                >
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

                    <v-text-field
                        v-model="phone"
                        label="Enter Phone No"
                        type="text"
                        :rules="[rules.required, rules.phone]"
                        outlined
                        dense
                        clearable
                        required
                    >
                    </v-text-field>

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
                        :rules="[rules.required, rules.min(8)]"
                        outlined
                        dense
                        clearable
                        required
                    ></v-text-field>

                    <!-- Role Select -->

                    <v-select
                        v-if="role_register && Array.isArray(role_register)"
                        v-model="roles_register"
                        :items="role_register"
                        item-value="id"
                        item-title="name"
                        label="Select Role"
                        :rules="[rules.required]"
                        outlined
                        dense
                        clearable
                        required
                        return-object
                        v-on:keyup.enter="register"
                    ></v-select>

                    <span v-if="roles_register && roles_register.id === 3">
                        <v-select
                            v-model="semester_register"
                            :items="semesters"
                            item-value="id"
                            item-title="name"
                            label="Select Semester"
                            :rules="[rules.required]"
                            outlined
                            dense
                            clearable
                            required
                            return-object
                            v-on:keyup.enter="register"
                        >
                        </v-select>
                    </span>

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
                    <p class="text-muted mt-3">
                        Already have an account?
                        <router-link class="text-primary" to="/"
                            >Login</router-link
                        >.
                    </p>
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
            phone:"",
            email: "",
            password: "",
            roles_register: null,
            semester_register: null,
            semester: null,
            valid: false,
            rules: {
                required: (value) => !!value || "This field is required.",
                email: (value) =>
                    /.+@.+\..+/.test(value) || "E-mail must be valid.",
                min: (length) => (value) =>
                    (value || "").length >= length ||
                    `Minimum ${length} characters.`,
                phone: (value) =>
                    /^[+]*[0-9]{1,3}[ -]?[0-9]{1,4}[ -]?[0-9]{1,4}[ -]?[0-9]{1,4}$/.test(
                        value
                    ) || "Please enter a valid phone number.",
            },
        };
    },
    computed: {
        ...mapState(["role_register", "semesters"]),
    },
    methods: {
        ...mapActions(["fetchRoleRegister", "fetchSemesters"]),
        async register() {
            if (this.$refs.registerForm.validate()) {
                try {
                    await axios.post("http://127.0.0.1:8000/api/register", {
                        name: this.name,
                        phone: this.phone,
                        email: this.email,
                        password: this.password,
                        role_id: this.roles_register.id,
                        semester_id: this.semester_register.id,
                    });
                    alert("Registration successful!");
                    this.name = "";
                    this.phone = "";
                    this.email = "";
                    this.password = "";
                    this.roles_register = null;
                    this.semester_register = null;
                    this.$router.push("/");
                } catch (error) {
                    console.error(
                        "Error during registration:",
                        error.response.data
                    );
                }
            }
        },
    },
    mounted() {
        this.fetchRoleRegister();
        this.fetchSemesters();
    },
    watch: {
        roles_register(newValue) {
            console.log("Selected role:", newValue);
        },
    },
};
</script>
