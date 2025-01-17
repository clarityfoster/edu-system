<template>
    <v-container fluid class="d-flex justify-content-around h-100">
        <!-- Sidebar -->
        <SideBar />

        <!-- Main Content Area -->
        <v-card
            class="home-dashboard expanded-card elevation-2"
            elevation="0"
            style="
                width: 2300px;
                max-width: 80%;
                margin-left: 100px;
                margin-top: 45px;
            "
        >
            <div style="margin-bottom: 50px">
                <h4 style="font-weight: 600">Analytsics Overview</h4>
                <div
                    class="education-poster bg-primary rounded-4 d-flex align-items-center justify-content-evenly gap-3 mt-4"
                >
                    <div class="text-content d-flex flex-column gap-4">
                        <div class="title">
                            <h3 style="font-weight: bold; color: #ffc726">
                                Learn Effectively With Us!
                            </h3>
                            <span style="font-size: 15px">
                                Urean ilora lordo tis amte seconyort.
                            </span>
                        </div>
                        <div class="content d-flex gap-5 mt-5">
                            <div
                                class="content1 d-flex align-items-center gap-2"
                            >
                                <router-link
                                    to="/instructorlist"
                                    class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px"
                                >
                                    <i
                                        class="bi bi-mortarboard-fill text-primary fs-4"
                                    ></i>
                                </router-link>
                                <div class="text">
                                    <h5 style="font-size: 17px; margin: 0">
                                        Instructors
                                    </h5>
                                    <router-link
                                        to="/instructorlist"
                                        class="text-decoration-none"
                                        style="
                                            color: #ffc726;
                                            font-weight: bold;
                                            font-size: 15px;
                                        "
                                    >
                                        <span v-if="totalInstructors > 1">
                                            {{ totalInstructors - 1 }}+
                                        </span>
                                        <span v-else>
                                            {{ totalInstructors }}
                                        </span>
                                    </router-link>
                                </div>
                            </div>
                            <div
                                class="content1 d-flex align-items-center gap-2"
                            >
                                <router-link
                                    to="/studentlist"
                                    class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                    style="width: 50px; height: 50px"
                                >
                                    <i
                                        class="bi bi-people-fill text-primary fs-4"
                                    ></i>
                                </router-link>
                                <div class="text">
                                    <h5 style="font-size: 17px; margin: 0">
                                        Students
                                    </h5>
                                    <router-link
                                        to="/studentlist"
                                        class="text-decoration-none"
                                        style="
                                            font-weight: bold;
                                            font-size: 15px;
                                            color: #ffc726;
                                        "
                                    >
                                        <span v-if="totalLearners > 1">
                                            {{ totalLearners - 1 }}+
                                        </span>
                                        <span v-else>
                                            {{ totalLearners }}
                                        </span>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <img
                        src="../../../public/img/education.svg"
                        alt=""
                        style="width: 35%"
                    />
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-start gap-5">
                <div style="width: 480px; height: 400px">
                    <div
                        class="d-flex align-items-center justify-content-between"
                    >
                        <h5 style="font-weight: 600">Popular Courses</h5>
                        <button
                            class="btn btn-secondary btn-sm rounded-5 text-white"
                            style="
                                width: 95px;
                                height: 25px;
                                font-weight: bold;
                                font-size: 12px;
                            "
                        >
                            <router-link
                                to="/courselist"
                                class="text-white"
                                style="text-decoration: none"
                            >
                                All Courses
                            </router-link>
                        </button>
                    </div>
                    <div
                        class="d-flex flex-column align-items-start gap-2 mt-4"
                    >
                        <div class="card rounded-4 w-100">
                            <div
                                class="popular-courses card-body d-flex justify-content-between align-items-center gap-3"
                            >
                                <div>
                                    <p
                                        style="
                                            font-size: 15px;
                                            margin: 0;
                                            font-weight: bold;
                                        "
                                        class="card-title"
                                    >
                                        Binary Tree Algorithms
                                    </p>
                                    <span
                                        style="font-size: 14px"
                                        class="text-muted"
                                        >Semester 4</span
                                    >
                                </div>
                                <button
                                    class="btn btn-sm rounded-5 text-white"
                                    style="
                                        width: 70px;
                                        height: 30px;
                                        background-color: #ffc726;
                                        font-weight: bold;
                                    "
                                >
                                    <router-link
                                        to="/binarytree"
                                        class="text-white"
                                        style="text-decoration: none"
                                    >
                                        View
                                    </router-link>
                                </button>
                            </div>
                        </div>
                        <div class="card rounded-4 w-100">
                            <div
                                class="popular-courses card-body d-flex justify-content-between align-items-center gap-3"
                            >
                                <div>
                                    <p
                                        style="
                                            font-size: 15px;
                                            margin: 0;
                                            font-weight: bold;
                                        "
                                        class="card-title"
                                    >
                                        Introduction to Programming
                                    </p>
                                    <span
                                        style="font-size: 14px"
                                        class="text-muted"
                                        >Semester 1</span
                                    >
                                </div>
                                <button
                                    disabled="true"
                                    class="btn btn-sm rounded-5 text-white"
                                    style="
                                        width: 70px;
                                        height: 30px;
                                        background-color: #ffc726;
                                        font-weight: bold;
                                    "
                                >
                                    View
                                </button>
                            </div>
                        </div>
                        <div class="card rounded-4 w-100">
                            <div
                                class="popular-courses card-body d-flex justify-content-between align-items-center gap-3"
                            >
                                <div>
                                    <p
                                        style="
                                            font-size: 15px;
                                            margin: 0;
                                            font-weight: bold;
                                        "
                                        class="card-title"
                                    >
                                        Introduction to Web Development
                                    </p>
                                    <span
                                        style="font-size: 14px"
                                        class="text-muted"
                                        >Semester 2</span
                                    >
                                </div>
                                <button
                                    disabled="true"
                                    class="btn btn-sm rounded-5 text-white"
                                    style="
                                        width: 70px;
                                        height: 30px;
                                        background-color: #ffc726;
                                        font-weight: bold;
                                    "
                                >
                                    View
                                </button>
                            </div>
                        </div>
                        <div class="card rounded-4 w-100">
                            <div
                                class="popular-courses card-body d-flex justify-content-between align-items-center gap-3"
                            >
                                <div>
                                    <p
                                        style="
                                            font-size: 15px;
                                            margin: 0;
                                            font-weight: bold;
                                        "
                                        class="card-title"
                                    >
                                        Introduction to Web Development
                                    </p>
                                    <span
                                        style="font-size: 14px"
                                        class="text-muted"
                                        >Semester 2</span
                                    >
                                </div>
                                <button
                                    disabled="true"
                                    class="btn btn-sm rounded-5 text-white"
                                    style="
                                        width: 70px;
                                        height: 30px;
                                        background-color: #ffc726;
                                        font-weight: bold;
                                    "
                                >
                                    View
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="width: 400px; height: 400px">
                    <h5 style="font-weight: 600">Current Activities</h5>
                    <div class="mt-4 d-flex flex-column gap-3">
                        <div
                            class="w-100 bg-primary rounded-4"
                            style="height: 170px"
                        ></div>
                        <div class="d-flex gap-3">
                            <div
                                class="rounded-4 d-flex flex-column gap-3 p-4 align-items-center justify-content-center"
                                style="
                                    width: 200px;
                                    height: 170px;
                                    background-color: #ffc726;
                                "
                            >
                                <div>
                                    <h3
                                        v-if="totalcompletedSemesters > 1"
                                        class="text-white"
                                        style="
                                            font-weight: bold;
                                            padding: 0;
                                            margin: 0;
                                        "
                                    >
                                        {{ totalcompletedSemesters - 1 }}+
                                    </h3>
                                    <h3
                                        v-else
                                        class="text-white"
                                        style="
                                            font-weight: bold;
                                            padding: 0;
                                            margin: 0;
                                        "
                                    >
                                        {{ totalcompletedSemesters }}
                                    </h3>
                                    <span
                                        class="text-white"
                                        style="padding: 0; font-weight: bold"
                                        >Completed Semesters</span
                                    >
                                </div>
                                <router-link
                                    class="w-100 text-end"
                                    to="/completedsemester"
                                >
                                    <i
                                        class="bi bi-arrow-up-right-circle-fill fs-3 text-white"
                                    ></i>
                                </router-link>
                            </div>
                            <div
                                class="rounded-4 d-flex flex-column gap-3 p-4 align-items-center justify-content-center"
                                style="
                                    width: 200px;
                                    height: 170px;
                                    background-color: #455a64;
                                "
                            >
                                <div>
                                    <h3
                                        v-if="totalOngoingSemesters > 1"
                                        class="text-white"
                                        style="
                                            font-weight: bold;
                                            padding: 0;
                                            margin: 0;
                                        "
                                    >
                                        {{ totalOngoingSemesters - 1 }}+
                                    </h3>
                                    <h3
                                        v-else
                                        class="text-white"
                                        style="
                                            font-weight: bold;
                                            padding: 0;
                                            margin: 0;
                                        "
                                    >
                                        {{ totalOngoingSemesters }}
                                    </h3>
                                    <span
                                        class="text-white"
                                        style="padding: 0; font-weight: bold"
                                        >Ongoing Semesters</span
                                    >
                                </div>
                                <router-link
                                    class="w-100 text-end"
                                    to="/ongoingsemester"
                                >
                                    <i
                                        class="bi bi-arrow-up-right-circle-fill fs-3 text-white"
                                    ></i>
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="width: 400px">
                    <h5 style="font-weight: 600">Best Students</h5>
                    <div
                        class="d-flex flex-column gap-2 align-items-start justify-content-center mt-4"
                    >
                        <div
                            v-for="users in bestLearnersList"
                            :key="users.id"
                            class="card rounded-4 w-100"
                        >
                            <div
                                class="card-body d-flex justify-content-start align-items-start gap-3"
                                style="padding: 14.5px"
                            >
                                <div
                                    class="d-flex align-items-center justify-content-center text-white rounded-circle"
                                    style="
                                        width: 50px;
                                        height: 50px;
                                        background-color: #ffc726;
                                        font-weight: bold;
                                        font-size: 20px;
                                    "
                                >
                                    {{ users.name.charAt(0).toUpperCase() }}
                                </div>
                                <div>
                                    <p
                                        style="
                                            font-size: 15px;
                                            margin: 0;
                                            font-weight: bold;
                                        "
                                        class="card-title"
                                    >
                                        {{ users.name }}
                                    </p>
                                    <span
                                        style="font-size: 14px"
                                        class="text-muted"
                                    >
                                        {{ users.semester.name }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </v-card>
    </v-container>
</template>

<script>
import axios from "axios";
import SideBar from "./SideBar.vue";
export default {
    components: {
        SideBar,
    },
    data() {
        return {
            instructorsList: [],
            totalInstructors: 0,
            learnersList: [],
            totalLearners: 0,
            ongoingSemestersList: [],
            totalOngoingSemesters: 0,
            completedSemestersList: [],
            totalcompletedSemesters: 0,
            usersList: [],
            bestLearnersList: [],
        };
    },
    mounted() {
        this.fetchInstructorsList();
        this.fetchLearnersList();
        this.fetchOngoingSemestersList();
        this.fetchCompletedSemestersList();
        this.fetchBestLearners();
    },
    methods: {
        async fetchInstructorsList() {
            try {
                const { data } = await axios.get(
                    "http://127.0.0.1:8000/api/instructors"
                );
                if (data.success && Array.isArray(data.instructors)) {
                    this.instructursList = data.instructors;
                    this.totalInstructors = data.instructors.length;
                }
            } catch (error) {
                console.error("Error fetching instructors list:", error);
            }
        },
        async fetchLearnersList() {
            try {
                const { data } = await axios.get(
                    "http://127.0.0.1:8000/api/learners"
                );
                if (data.success && Array.isArray(data.learners)) {
                    this.learnersList = data.instructors;
                    this.totalLearners = data.learners.length;
                }
            } catch (error) {
                console.error("Error fetching instructors list:", error);
            }
        },
        async fetchOngoingSemestersList() {
            try {
                const { data } = await axios.get(
                    "http://127.0.0.1:8000/api/semesters/ongoing",
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "auth_token"
                            )}`,
                        },
                    }
                );
                if (
                    data.status === "success" &&
                    Array.isArray(data.ongoingsemesters)
                ) {
                    this.ongoingSemestersList = data.ongoingsemesters;
                    this.totalOngoingSemesters = data.ongoingsemesters.length;
                } else {
                    console.error("Unexpected API response:", data);
                }
            } catch (error) {
                console.error("Error fetching ongoing semesters list:", error);
            }
        },
        async fetchCompletedSemestersList() {
            try {
                const { data } = await axios.get(
                    "http://127.0.0.1:8000/api/semesters/completed",
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "auth_token"
                            )}`,
                        },
                    }
                );

                if (
                    data.status === "success" &&
                    Array.isArray(data.completedSemesters)
                ) {
                    this.completedSemestersList = data.completedSemesters;
                    this.totalcompletedSemesters =
                        data.completedSemesters.length;
                } else {
                    console.error("Unexpected API response:", data);
                }
            } catch (error) {
                console.error(
                    "Error fetching completed semesters list:",
                    error
                );
            }
        },
        async fetchBestLearners() {
            try {
                const token = localStorage.getItem("auth_token");
                if (!token) {
                    console.error("Auth token is missing!");
                    return;
                }
                const { data } = await axios.get(
                    "http://127.0.0.1:8000/api/users",
                    {
                        headers: {
                            Authorization: `Bearer ${token}`,
                        },
                    }
                );

                if (data.users && Array.isArray(data.users)) {
                    this.usersList = data.users;
                    this.bestLearnersList = this.usersList.slice(0, 4);
                } else {
                    console.error(
                        "Unexpected API response: Users array missing."
                    );
                }
            } catch (error) {
                console.error("Error fetching users list:", error);
            }
        },
    },
};
</script>

<style>
.education-poster {
    height: 350px;
}
@media (max-width: 1502px) {
    .expanded-card {
        max-width: 1100px;
    }
}
@media (max-width: 1441px) {
    .education-poster {
        height: 260px;
    }
    .expanded-card {
        max-width: 1050px;
    }
    .popular-courses {
        height: 78px;
    }
}
</style>
