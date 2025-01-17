<template>
    <v-container fluid class="d-flex justify-content-around h-100">
        <SideBar />

        <v-card
            class="home-dashboard expanded-card elevation-2"
            elevation="0"
            style="gap: 30px; width: 2300px; max-width: 80%; margin-left: 100px"
        >
            <div
                class="input-group d-flex justify-content-end"
                style="max-width: 100%; margin-bottom: 20px; margin-top: 8px"
            >
                <button
                    class="btn btn-primary btn-sm text-white"
                    type="button"
                    id="button-addon1"
                    @click="toggleFilter"
                >
                    <v-icon size="small">mdi-filter</v-icon> Filter
                </button>
            </div>

            <div v-if="showFilter" class="card mb-3 p-3">
                <div class="row">
                    <div class="col-md-6">
                        <label for="nameFilter">Name</label>
                        <select
                            id="nameFilter"
                            class="form-control"
                            v-model="selectedName"
                            @change="filterStudents"
                        >
                            <option value="">Select Name</option>
                            <option
                                v-for="student in filterstudents"
                                :key="student.id"
                                :value="student.name"
                            >
                                {{ student.name }}
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="semesterFilter">Semester</label>
                        <select
                            id="semesterFilter"
                            class="form-control"
                            v-model="selectedSemester"
                            @change="filterStudents"
                        >
                            <option value="">Select Semester</option>
                            <option
                                v-for="semester in semesters"
                                :key="semester.id"
                                :value="semester.name"
                            >
                                {{ semester.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <v-data-table
                :items="filteredStudents"
                :headers="filteredHeaders"
                class="elevation-1"
                item-value="id"
                dense
                item-class="text-center align-middle"
            >
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-toolbar-title class="text-center"
                            >Student Lists</v-toolbar-title
                        >
                    </v-toolbar>
                </template>

                <template v-slot:item.index="{ index }">
                    {{ index + 1 }}
                </template>

                <template v-slot:item.semester="{ item }">
                    {{ item.semester ? item.semester.name : "N/A" }}
                </template>

                <template v-slot:item.action="{ item }">
                    <div style="display: flex; align-items: center; gap: 8px">
                        <v-btn small color="primary" @click="editItem(item)"
                            >Edit</v-btn
                        >
                        <v-btn small color="error" @click="deleteItem(item)"
                            >Delete</v-btn
                        >
                    </div>
                </template>

                <template v-slot:item.action2="{ item, index }">
                    <v-btn
                        small
                        color="primary"
                        :loading="loadingIndex === index"
                        :disabled="item.is_approved"
                        @click="approveUser(item.id, index)"
                    >
                        {{
                            item.is_approved
                                ? "Approved"
                                : loadingIndex === index
                                ? "Approving..."
                                : "Accept"
                        }}
                    </v-btn>
                </template>
            </v-data-table>
        </v-card>
        <v-dialog v-model="editDialog" max-width="500px">
            <v-card>
                <v-card-title>Edit Student</v-card-title>
                <v-card-text>
                    <v-form ref="editForm">
                        <v-text-field
                            v-model="editStudent.name"
                            label="Name"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="editStudent.phone"
                            label="Phone"
                            required
                        ></v-text-field>
                        <v-text-field
                            v-model="editStudent.email"
                            label="Email"
                            required
                        ></v-text-field>
                        <v-select
                            v-model="editStudent.semester_id"
                            :items="semesters"
                            item-value="id"
                            item-title="name"
                            label="Semester"
                            required
                        ></v-select>
                    </v-form>
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary" text @click="updateStudent"
                        >Save</v-btn
                    >
                    <v-btn color="grey" text @click="editDialog = false"
                        >Cancel</v-btn
                    >
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
import SideBar from "./SideBar.vue";
import axios from "axios";
import { mapState, mapActions } from "vuex";

export default {
    name: "StudentList",
    components: {
        SideBar,
    },
    data() {
        return {
            showFilter: false,
            loadingIndex: null,
            editDialog: false,
            editStudent: {
                id: null,
                name: "",
                phone: "",
                email: "",
                semester_id: null,
            },
            selectedName: "",
            selectedSemester: "",
            headers: [
                { title: "Id", value: "index", align: "center", width: "5%" },
                { title: "Name", value: "name", align: "center", width: "20%" },
                {
                    title: "Phone",
                    value: "phone",
                    align: "center",
                    width: "15%",
                },
                {
                    title: "Email",
                    value: "email",
                    align: "center",
                    width: "20%",
                },
                {
                    title: "Semester",
                    value: "semester",
                    align: "center",
                    width: "15%",
                },
            ],
            filteredStudents: [],
        };
    },
    computed: {
        ...mapState(["filterstudents", "roles", "authUsers", "semesters"]),
        filteredHeaders() {
            const isAdmin = this.authUsers?.role?.name === "Admin";
            return isAdmin
                ? [
                      ...this.headers,
                      {
                          title: "Action",
                          value: "action",
                          align: "center",
                          width: "10%",
                      },
                      {
                          title: "Action",
                          value: "action2",
                          align: "center",
                          width: "5%",
                      },
                  ]
                : this.headers;
        },
    },
    methods: {
        ...mapActions([
            "fetchFilterStudents",
            "fetchRoles",
            "fetchAuthUsers",
            "fetchSemesters",
        ]),
        toggleFilter() {
            this.showFilter = !this.showFilter;
        },
        filterStudents() {
            this.filteredStudents = this.filterstudents.filter((student) => {
                const nameMatch = this.selectedName
                    ? student.name === this.selectedName
                    : true;
                const semesterMatch = this.selectedSemester
                    ? student.semester &&
                      student.semester.name === this.selectedSemester
                    : true;

                return nameMatch && semesterMatch;
            });
        },
        async approveUser(userId, index) {
            this.loadingIndex = index;
            try {
                await axios.post(
                    `http://127.0.0.1:8000/api/users/${userId}/approve`,
                    {},
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "auth_token"
                            )}`,
                        },
                    }
                );

                this.filteredStudents[index].is_approved = 1;
            } catch (error) {
                console.error(
                    "Error approving user:",
                    error.response?.data || error
                );
                alert("Failed to approve the user. Please try again.");
            } finally {
                this.loadingIndex = null;
            }
        },

        async deleteItem(item) {
            if (!confirm(`Are you sure you want to delete ${item.name}?`)) {
                return;
            }

            try {
                await axios.delete(
                    `http://127.0.0.1:8000/api/users/${item.id}`,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "auth_token"
                            )}`,
                        },
                    }
                );

                this.filteredStudents = this.filteredStudents.filter(
                    (student) => student.id !== item.id
                );

                alert("Student deleted successfully.");
            } catch (error) {
                console.error(
                    "Error deleting student:",
                    error.response?.data || error
                );
                alert("Failed to delete the student. Please try again.");
            }
        },

        editItem(item) {
            this.editStudent = { ...item };
            this.editDialog = true;
        },
        async updateStudent() {
            try {
                await axios.post(
                    `http://127.0.0.1:8000/api/users/${this.editStudent.id}/update`,
                    this.editStudent,
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "auth_token"
                            )}`,
                        },
                    }
                );

                await this.fetchFilterStudents();
                this.filteredStudents = this.filterstudents;

                alert("Student updated successfully!");
                this.editDialog = false;
            } catch (error) {
                console.error(
                    "Error updating student:",
                    error.response?.data || error
                );
                alert("Failed to update the student. Please try again.");
            }
        },
    },
    mounted() {
        this.fetchFilterStudents().then(() => {
            this.filteredStudents = this.filterstudents;
            this.semesters = [
                ...new Set(
                    this.filterstudents.map((student) => student.semester)
                ),
            ];
        });
        this.fetchRoles();
        this.fetchAuthUsers();
        this.fetchSemesters();
    },
};
</script>

<style scoped>
.primary {
    background-color: #1976d2;
}
</style>
