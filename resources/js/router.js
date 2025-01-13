import { createRouter, createWebHistory } from "vue-router";

import Home from "./components/Home.vue";
import Login from "./components/Login.vue";
import Register from "./components/Register.vue";
import SideBar from "./components/SideBar.vue";
import ViewUserList from "./components/ViewUserList.vue";
import StudentList from "./components/StudentList.vue";
import InstructorList from "./components/InstructorList.vue";
import SemesterList from "./components/SemesterList.vue";
import CourseList from "./components/CourseList.vue";
import AddStudent from "./components/AddStudent.vue";
import AddInstructor from "./components/AddInstructor.vue";
import AddSemester from "./components/AddSemester.vue";
import AddCourse from "./components/AddCourse.vue";
import BinaryTree from "./components/BinaryTree.vue";
import BinaryTreeChild from "./components/BinaryTreeChild.vue";
import Forbidden from "./components/Forbidden.vue";

const routes = [
    {
        path: "/home",
        name: "home",
        component: Home,
        meta: { requiresAuth: true },
    },
    {
        path: "/",
        name: "login",
        component: Login,
        meta: { requiresAuth: false },
    },
    {
        path: "/register",
        name: "register",
        component: Register,
        meta: { requiresAuth: false },
    },
    {
        path: "/sidebar",
        name: "sidebar",
        component: SideBar,
        meta: { requiresAuth: true },
    },
    {
        path: "/viewuserlist",
        name: "ViewUserList",
        component: ViewUserList,
        meta: { requiresAuth: true },
    },
    {
        path: "/studentlist",
        name: "studentlist",
        component: StudentList,
        meta: { requiresAuth: true },
    },
    {
        path: "/instructorlist",
        name: "instructorlist",
        component: InstructorList,
        meta: { requiresAuth: true },
    },
    {
        path: "/semesterlist",
        name: "semesterlist",
        component: SemesterList,
        meta: { requiresAuth: true },
    },
    {
        path: "/courselist",
        name: "courselist",
        component: CourseList,
        meta: { requiresAuth: true },
    },
    {
        path: "/addstudent",
        name: "addstudent",
        component: AddStudent,
        meta: { requiresAuth: true },
    },
    {
        path: "/addinstructor",
        name: "addinstructor",
        component: AddInstructor,
        meta: { requiresAuth: true },
    },
    {
        path: "/addsemester",
        name: "addsemester",
        component: AddSemester,
        meta: { requiresAuth: true },
    },
    {
        path: "/addcourse",
        name: "addcourse",
        component: AddCourse,
        meta: { requiresAuth: true },
    },
    {
        path: "/binarytree",
        name: "binarytree",
        component: BinaryTree,
        meta: { requiresAuth: true },
    },
    {
        path: "/binarytreechild",
        name: "binarytreechild",
        component: BinaryTreeChild,
        meta: { requiresAuth: true },
    },
    {
        path: "/:pathMatch(.*)*",
        name: "forbidden",
        component: Forbidden,
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});
router.beforeEach((to, from, next) => {
    let token = null;
    try {
        token = localStorage.getItem("auth_token");
    } catch (error) {
        console.log(error);
    }
    if (to.meta.requiresAuth && !token) {
        next({ name: "login" });
    } else if ((to.name === "login" || to.name === "register") && token) {
        next({ name: "home" });
    } else {
        next();
    }
});

export default router;
