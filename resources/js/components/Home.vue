<template>
    <v-container fluid class="d-flex h-100">
        <!-- Sidebar -->
        <SideBar />

        <!-- Main Content Area -->
        <v-container fluid class="flex-grow-1 py-4 bg-light ms-md-5">
            <v-card class="pa-5 d-flex flex-column" max-width="100%" height="99%" style="gap: 25px">
                <div class="input-group mb-3" style="max-width: 500px;">
                    <input
                        type="text"
                        class="form-control rounded-5"
                        placeholder="Search..."
                        aria-label="Example text with button addon"
                        aria-describedby="button-addon1"
                    />
                    <button
                        class="btn btn-primary text-white rounded-circle ms-2"
                        type="button"
                        id="button-addon1"
                    >
                    <i class="bi bi-search"></i>
                    </button>
                </div>
                <div>
                    <h4>Analytsics Overview</h4>
                    <div class="bg-primary rounded-4 d-flex align-items-center justify-content-center mt-4" style="max-width: 100%; height: 300px;">
                        <p>Chart goes here</p>
                    </div>
                </div>
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
