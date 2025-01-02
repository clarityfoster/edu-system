<template>
    <v-app>
        <v-container class="d-flex justify-center align-center" style="height: 100vh;">
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
    </v-app>
</template>

<script>
export default {
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


