<template>
  <v-container fluid class="d-flex h-100">
    <!-- Sidebar -->
    <SideBar />

    <!-- Main Content Area -->
    <v-container fluid class="flex-grow-1 py-4 bg-light ms-md-5">
     <v-card class="pa-5" max-width="400">
                <v-card-title class="justify-center">
                    Hello
                </v-card-title>
                <v-card-text>
                    This is a simple Vuetify setup.
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary" @click="handleClick">Click Me</v-btn>
                </v-card-actions>
            </v-card>
    </v-container>
  </v-container>
</template>


<script>
import SideBar from "./SideBar.vue";
export default {
     components: {
    SideBar,
  },
    data() {
        return {};
    },
    methods: {
        handleClick() {
            alert("Button clicked!");
        },
    },
};
</script>


