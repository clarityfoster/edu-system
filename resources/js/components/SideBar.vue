<template>
    <div id="app" class="d-flex">
        <!-- Sidebar -->
        <aside
            id="sidebar"
            class="sidebar bg-primary text-light vh-100 shadow-sm d-none d-lg-block"
            :class="{ collapsed: isCollapsed }"
        >
            <!-- Header -->
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

                <!-- Menu Items -->
                 <ul class="nav flex-column">
                    <li class="nav-item">
                    <a class="nav-link text-white" href="/home">
                    <i class="mdi mdi-home  me-3" style="color: white"></i>
                    <span>Home</span>
                    </a>
                    </li>

                 </ul>

                <ul class="nav flex-column" v-if="roleId == 1">
                    <li class="nav-item">
                        <a
                            class="nav-link text-white d-flex align-items-center collapsed"
                            data-bs-target="#userListsNav"
                            data-bs-toggle="collapse"
                            href="#"
                        >
                            <i class="mdi mdi-account-group me-3"></i>
                            <span>User Lists</span>
                            <i
                                class="bi bi-chevron-down ms-auto"
                                style="color: white"
                            ></i>
                        </a>
                        <!-- Submenu -->
                        <!-- <ul  class="nav flex-column ms-3" id="userListsNav"> -->
                        <ul
                            class="nav flex-column ms-3"
                            data-bs-parent="#sidebar-nav"
                            id="userListsNav"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link text-white"
                                    href="/viewuserlist"
                                >
                                    <i class="mdi mdi-account-multiple"></i>
                                    View User
                                </a>
                            </li>
                        </ul>
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
                        <!-- Submenu -->
                        <ul
                            class="nav ms-3 nav-content collapse"
                            data-bs-parent="#sidebar-nav"
                            id="studentListsNav"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link text-white"
                                    href="/studentlist"
                                >
                                    <i class="mdi mdi-account-multiple"></i>
                                    View Student
                                </a>
                            </li>
                            <li class="nav-item" v-if="roleId == 1">
                                <a
                                    class="nav-link text-white"
                                    href="/addstudent"
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
                        <!-- Submenu -->
                        <ul
                            class="nav ms-3 nav-content collapse"
                            data-bs-parent="#sidebar-nav"
                            id="instructorListsNav"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link text-white"
                                    href="/instructorlist"
                                >
                                    <i class="mdi mdi-account-multiple"></i>
                                    View Instructors
                                </a>
                            </li>
                            <li class="nav-item" v-if="roleId == 1">
                                <a
                                    class="nav-link text-white"
                                    href="/addinstructor"
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
                                    href="/semesterlist"
                                >
                                    <i class="mdi mdi-calendar"></i>
                                    View Semesters
                                </a>
                            </li>
                            <li class="nav-item" v-if="roleId == 1">
                                <a
                                    class="nav-link text-white"
                                    href="/addsemester"
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
                        <!-- Submenu -->
                        <ul
                            class="nav ms-3 nav-content collapse"
                            data-bs-parent="#sidebar-nav"
                            id="courseListsNav"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link text-white"
                                    href="/courselist"
                                >
                                    <i class="mdi mdi-book-open"></i>
                                    View Courses
                                </a>
                            </li>
                            <li class="nav-item" v-if="roleId == 1">
                                <a
                                    class="nav-link text-white"
                                    href="/addcourse"
                                >
                                    <i class="mdi mdi-book-plus"></i>
                                    Add Course
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <hr class="text-white" />

                <!-- Logout -->
                <button
                    class="btn btn-link text-white d-flex align-items-center"
                    @click="logout"
                >
                    <i class="mdi mdi-logout me-2"></i>
                    <span v-if="!isCollapsed">Logout</span>
                </button>
            </div>
        </aside>
    </div>
</template>

<script>
import { mapState, mapActions } from "vuex";

export default {
    name: "SideBar",
    data() {
        return {
            isCollapsed: false,
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
                const token =  localStorage.getItem("auth_token");
                localStorage.removeItem("auth_token");
                this.$router.push("/");
            } catch (error) {
                console.error("Logout failed:", error);
            }
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
.toggle-btn {
    position: absolute;
    top: 10px;
    right: -20px;
    z-index: 1000;
}
.nav-link {
    cursor: pointer;
}
.nav-link.active {
    background-color: rgba(255, 255, 255, 0.2);
}
</style>
