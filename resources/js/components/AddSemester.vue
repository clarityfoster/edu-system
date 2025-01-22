<template>
    <v-container class="d-flex justify-align-center" style="height: 90vh">
        <SideBar />
        <v-card class="pa-5 elevation-12 rounded-lg mt-3 mx-auto" width="800">
            <v-card-title
                class="justify-center text-h5 font-weight-bold text-center"
            >
                Add Semester
            </v-card-title>
            <v-card-text>
                <v-form
                    ref="registerForm"
                    v-model="valid"
                    @submit.prevent="createSemester"
                >
                    <v-text-field
                        v-model="name"
                        label="Enter Semester Name"
                        :rules="[rules.required, rules.min(3)]"
                        outlined
                        dense
                        clearable
                        required
                    >
                    </v-text-field>

                    <v-select
                        v-model="course"
                        :items="courses"
                        item-value="id"
                        item-title="name"
                        label="Select Course"
                        :rules="[rules.required]"
                        outlined
                        dense
                        clearable
                        multiple
                    >
                    </v-select>

                    <v-row class="d-flex align-center" dense>
                        <v-col cols="6">
                            <v-text-field
                                v-model="startDate"
                                label="Start Date"
                                type="date"
                                :rules="[rules.required]"
                                outlined
                                dense
                                clearable
                                required
                            >
                            </v-text-field>
                        </v-col>
                        <v-col cols="6">
                            <v-text-field
                                v-model="endDate"
                                label="End Date"
                                type="date"
                                :rules="[rules.required]"
                                outlined
                                dense
                                clearable
                                required
                            >
                            </v-text-field>
                        </v-col>
                    </v-row>

                    <!-- Warning Message -->
                    <v-alert
                        v-if="endDate && startDate && new Date(endDate) < new Date(startDate)"
                        type="warning"
                        class="mt-4"
                        :value="true"
                    >
                        The end date cannot be earlier than the start date.
                    </v-alert>

                    <v-row class="justify-center">
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
                        <v-col cols="12" sm="6" class="d-flex justify-center">
                            <v-btn
                                :disabled="!valid || endDate && startDate && new Date(endDate) < new Date(startDate)"
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

                <v-alert
                    v-if="errorMessages.length"
                    type="error"
                    class="mt-4"
                    :value="true"
                >
                    <ul>
                        <li v-for="(error, index) in errorMessages" :key="index">
                            {{ error }}
                        </li>
                    </ul>
                </v-alert>
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
    components: { SideBar },
    data() {
        return {
            name: "",
            course: [],
            startDate: null,
            endDate: null,
            valid: false,
            errorMessages: [],
            rules: {
                required: (value) => !!value || "This field is required.",
                min: (length) => (value) =>
                    (value || "").length >= length ||
                    `Minimum ${length} characters.`,
            },
        };
    },
    computed: {
        ...mapState(["courses"]),
    },
    methods: {
        ...mapActions(["fetchCourses"]),
        async createSemester() {
            const token = localStorage.getItem("auth_token");
            if (!token) {
                console.error("No token found. Redirecting to login...");
                return;
            }

            if (new Date(this.endDate) < new Date(this.startDate)) {
                this.errorMessages = ["The end date cannot be earlier than the start date."];
                return;
            }

            try {
                const response = await axios.post(
                    "http://127.0.0.1:8000/api/semesters/create",
                    {
                        name: this.name,
                        course_id: this.course,
                        start_date: this.startDate,
                        end_date: this.endDate,
                    },
                    {
                        headers: { Authorization: `Bearer ${token}` },
                    }
                );
                if (response.data.status === "success") {
                    alert("Semester created successfully!");
                    this.$router.push("/semesterlist");
                    this.cancel();
                }

            } catch (error) {
                if (error.response && error.response.data.errors) {
                    this.errorMessages = Object.values(error.response.data.errors).flat();
                } else {
                    console.error("Error during semester creation:", error);
                }
            }
        },
        cancel() {
            this.name = "";
            this.course = [];
            this.startDate = null;
            this.endDate = null;
            this.errorMessages = [];
        },
    },
    mounted() {
        this.fetchCourses();
    },
};
</script>
