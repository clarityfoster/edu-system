<template>
    <div id="app" class="d-flex">
        <aside
            id="sidebar"
            class="sidebar bg-primary text-light vh-100 shadow-sm"
            :class="{ collapsed: isCollapsed }"
        >
            <div class="nav flex-column pt-3">
                <div class="d-flex align-items-center mb-4">
                    <img
                        src="https://via.placeholder.com/150"
                        alt="Admin Avatar"
                        class="rounded-circle"
                        width="50"
                        height="50"
                    />
                    <div v-if="!isCollapsed" class="ms-3">
                        <h5>{{ authUsers.name }}</h5>
                        <p class="mb-0">{{ authUsers.role?.name }}</p>
                    </div>
                </div>

                <hr class="text-white" />
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link text-white" href="/home">
                            <i
                                class="mdi mdi-home me-3"
                                style="color: white"
                            ></i>
                            <span>Home</span>
                        </a>
                    </li>
                </ul>
                <ul class="nav flex-column" v-if="roleId == 1">
                    <li class="nav-item">
                        <a
                            class="nav-link text-white"
                            @click="navigateToViewUserList"
                        >
                            <i class="mdi mdi-account-group me-3"></i>
                            <span>Users List</span>
                        </a>
                        <!-- Submenu -->
                    </li>
                </ul>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a
                            class="nav-link text-white d-flex align-items-center collapsed"
                            data-bs-target="#studentListsNav"
                            data-bs-toggle="collapse"
                            href="#"
                        >
                            <i class="mdi mdi-school me-3"></i>
                            <span>Students</span>
                            <i
                                class="bi bi-chevron-down ms-auto"
                                style="color: white"
                            ></i>
                        </a>
                        <ul
                            class="nav ms-3 nav-content collapse"
                            data-bs-parent="#sidebar-nav"
                            id="studentListsNav"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link text-white"
                                    @click="navigateToViewStudents"
                                >
                                    <i class="mdi mdi-account-multiple"></i>
                                    View Student
                                </a>
                            </li>
                            <li class="nav-item" v-if="roleId == 1">
                                <a
                                    class="nav-link text-white"
                                    @click="navigateToAddStudents"
                                >
                                    <i class="mdi mdi-account-plus"></i>
                                    Add Students
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a
                            class="nav-link text-white d-flex align-items-center collapsed"
                            data-bs-target="#instructorListsNav"
                            data-bs-toggle="collapse"
                            href="#"
                        >
                            <i class="mdi mdi-shield-account me-3"></i>
                            <span v-if="!isCollapsed">Instructors</span>
                            <i
                                class="bi bi-chevron-down ms-auto"
                                style="color: white"
                            ></i>
                        </a>
                        <ul
                            class="nav ms-3 nav-content collapse"
                            data-bs-parent="#sidebar-nav"
                            id="instructorListsNav"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link text-white"
                                    @click="navigateToViewInstructors"
                                >
                                    <i class="mdi mdi-account-multiple"></i>
                                    View Instructors
                                </a>
                            </li>
                            <li class="nav-item" v-if="roleId == 1">
                                <a
                                    class="nav-link text-white"
                                    @click="navigateToAddInstructor"
                                >
                                    <i class="mdi mdi-account-plus"></i>
                                    Add Instructor
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a
                            class="nav-link text-white d-flex align-items-center collapsed"
                            data-bs-target="#semesterListsNav"
                            data-bs-toggle="collapse"
                            href="#"
                        >
                            <i class="mdi mdi-calendar-month me-3"></i>
                            <span v-if="!isCollapsed">Semesters</span>
                            <i
                                class="bi bi-chevron-down ms-auto"
                                style="color: white"
                            ></i>
                        </a>
                        <!-- Submenu -->
                        <ul
                            class="nav ms-3 nav-content collapse"
                            data-bs-parent="#sidebar-nav"
                            id="semesterListsNav"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link text-white"
                                    @click="navigateToViewSemesters"
                                >
                                    <i class="mdi mdi-calendar"></i>
                                    View Semesters
                                </a>
                            </li>
                            <li class="nav-item" v-if="roleId == 1">
                                <a
                                    class="nav-link text-white"
                                    @click="navigateToAddSemester"
                                >
                                    <i class="mdi mdi-calendar-plus"></i>
                                    Add Semester
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a
                            class="nav-link text-white d-flex align-items-center collapsed"
                            data-bs-target="#courseListsNav"
                            data-bs-toggle="collapse"
                            href="#"
                        >
                            <i class="mdi mdi-book me-3"></i>
                            <span v-if="!isCollapsed">Courses</span>
                            <i
                                class="bi bi-chevron-down ms-auto"
                                style="color: white"
                            ></i>
                        </a>
                        <ul
                            class="nav ms-3 nav-content collapse"
                            data-bs-parent="#sidebar-nav"
                            id="courseListsNav"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link text-white"
                                    @click="navigateToViewCourses"
                                >
                                    <i class="mdi mdi-book-open"></i>
                                    View Courses
                                </a>
                            </li>
                            <li class="nav-item" v-if="roleId == 1">
                                <a
                                    class="nav-link text-white"
                                    @click="navigateToAddCourse"
                                >
                                    <i class="mdi mdi-book-plus"></i>
                                    Add Course
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <hr class="text-white" />
                <button
                    class="btn btn-link text-white d-flex align-items-center"
                    @click="logout"
                >
                    <i class="mdi mdi-logout me-2"></i>
                    <span v-if="!isCollapsed">Logout</span>
                </button>
            </div>
        </aside>
        <button
            id="toggle-sidebar"
            class="btn btn-primary d-lg-none"
            @click="toggleSidebar"
        >
            <i class="mdi mdi-menu"></i>
        </button>
    </div>
</template>

<script>
import { mapState, mapActions } from "vuex";

export default {
    name: "SideBar",
    data() {
        return {
            isCollapsed: false, // Sidebar initially not collapsed
        };
    },
    computed: {
        ...mapState(["roleId", "users", "authUsers"]),
    },
    watch: {
        roleId() {
            this.fetchAuthUsers();
        },
    },
    methods: {
        ...mapActions(["fetchUsers", "fetchAuthUsers"]),
        async logout() {
            try {
                const token = localStorage.getItem("auth_token");
                localStorage.removeItem("auth_token");
                this.$router.push("/");
            } catch (error) {
                console.error("Logout failed:", error);
            }
        },
        navigateToAddCourse() {
            this.$router.push({
                name: "addcourse",
                query: { allowOverride: "true" },
            });
        },
        navigateToAddSemester() {
            this.$router.push({
                name: "addsemester",
                query: { allowOverride: "true" },
            });
        },
        navigateToAddStudents() {
            this.$router.push({
                name: "addstudent",
                query: { allowOverride: "true" },
            });
        },
        navigateToAddInstructor() {
            this.$router.push({
                name: "addinstructor",
                query: { allowOverride: "true" },
            });
        },
        navigateToViewUserList() {
            this.$router.push({
                name: "viewUserList",
            });
        },
        navigateToViewStudents() {
            this.$router.push({ name: "studentlist" });
        },
        navigateToViewInstructors() {
            this.$router.push({ name: "instructorlist" });
        },
        navigateToViewSemesters() {
            this.$router.push({ name: "semesterlist" });
        },
        navigateToViewCourses() {
            this.$router.push({ name: "courselist" });
        },
    },
    mounted() {
        this.fetchUsers();
        this.fetchAuthUsers();
        const roleId = parseInt(localStorage.getItem("role_id"));
        if (roleId) {
            this.$store.commit("setRoleId", roleId);
        }
    },
};
</script>

<style scoped>
#sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100%;
    width: 200px;
    transition: width 0.3s, transform 0.3s ease-in-out;
    background-color: #343a40;
    z-index: 1050;
    overflow-y: auto;
    height: 100%;
    width: 200px;
}

#sidebar.collapsed {
    width: 70px;
}

.sidebar {
    position: sticky;
    top: 0;
    overflow-y: auto;
}

.nav-link {
    cursor: pointer;
}

.nav-link.active {
    background-color: rgba(255, 255, 255, 0.2);
}

#toggle-sidebar {
    position: fixed;
    top: 10px;
    left: 10px;
    z-index: 1100;
}

@media (max-width: 992px) {
    #sidebar {
        transform: translateX(-100%);
    }
    #sidebar.collapsed {
        transform: translateX(0);
    }
    #toggle-sidebar {
        display: block;
    }
}
</style>
