import { createRouter, createWebHistory } from 'vue-router';

import Home from './components/Home.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';
import SideBar from './components/SideBar.vue';
import ViewUserList from './components/ViewUserList.vue';
const routes = [
    {
        path: '/',
        name: 'home',
        component: Home
    },
    {
        path: '/login',
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
];
const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;

