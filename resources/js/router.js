import { createRouter, createWebHistory } from 'vue-router';

import Home from './components/Home.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import SideBar from './components/SideBar.vue';
import ViewUserList from './components/ViewUserList.vue';
import StudentList from './components/StudentList.vue';
import InstructorList from './components/InstructorList.vue';
import SemesterList from './components/SemesterList.vue';
const routes = [
    {
        path: '/home',
        name: 'home',
        component: Home
    },
    {
        path: '/',
        name: 'login',
        component: Login
    },
    {
        path: '/register',
        name: 'register',
        component: Register
    },
    {
        path: '/sidebar',
        name: 'sidebar',
        component: SideBar
    },
    {
        path: '/viewuserlist',
        name: 'ViewUserList',
        component: ViewUserList
    },
    {
        path: '/studentlist',
        name: 'studentlist',
        component: StudentList
    },
    {
        path: '/instructorlist',
        name: 'instructorlist',
        component: InstructorList
    },
    {
        path: '/semesterlist',
        name: 'semesterlist',
        component: SemesterList
    },
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

