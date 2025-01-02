import { createApp } from 'vue';
import store from "./store";
import "bootstrap/dist/css/bootstrap.min.css";
import 'bootstrap-icons/font/bootstrap-icons.css';
import 'bootstrap/dist/js/bootstrap.bundle.js';


import App from './App.vue';
import router from './router';

import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import "@mdi/font/css/materialdesignicons.css";

const vuetify = createVuetify({
    components,
    directives,
})

// Create the Vue app and use the router
createApp(App).use(router).use(store).use(vuetify).mount('#app');

