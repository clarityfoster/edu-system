<template>
    <v-container class="d-flex justify-align-center" style="height: 90vh">
        <SideBar />
        <v-card class="pa-5 elevation-12 rounded-lg mx-auto mt-3" width="800">
            <v-card-title
                class="justify-center text-h5 font-weight-bold text-center"
            >
                Add Instructor
            </v-card-title>
            <v-card-text>
                <v-form
                    ref="registerForm"
                    v-model="valid"
                    @submit.prevent="createInstructor"
                >
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
                        v-model="phone"
                        label="Enter Phone No"
                        type="text"
                        :rules="[rules.required, rules.phone]"
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

                    <v-row class="justify-center">
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
                    </v-row>
                </v-form>
            </v-card-text>
        </v-card>
    </v-container>
</template>

<script>
import axios from "axios";
import SideBar from "./SideBar.vue";

export default {
    name: "AddInstructor",
    components: {
        SideBar,
    },
    data() {
        return {
            name: "",
            email: "",
            password: "",
            phone: "",

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

    methods: {
        async createInstructor() {
            const token = localStorage.getItem("auth_token");

            if (!token) {
                console.error("No token found. Redirecting to login...");
                return;
            }
            try {
                await axios.post(
                    "http://127.0.0.1:8000/api/instructors/create",
                    {
                        name: this.name,
                        email: this.email,
                        password: this.password,
                        phone: this.phone,
                    },
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );
                alert("Instructor Create successful!");
                this.$router.push("/instructorlist");
                this.name = '';
                this.email = '';
                this.password = '';
                this.phone = '';
                this.cancel();
            } catch (error) {
                console.error(
                    "Error during create instructor:",
                    error.response.data
                );
            }
        },
        cancel() {
            this.name = "";
        },
    },
};
</script>
