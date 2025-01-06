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
                    <div class="bg-primary rounded-4 d-flex align-items-center justify-content-center gap-3 mt-4" style="max-width: 100%; height: 300px;">
                        <div class="text-content d-flex flex-column gap-4">
                            <div class="title">
                                <h3>Learn With Effectively With Us!</h3>
                                <span style="font-weight: 300; font-size: 15px;">
                                    Loream ipsum dolor sit amet consectetur.
                                </span>
                            </div>
                            <div class="content d-flex gap-4 mt-3">
                                <div class="content1 d-flex  align-items-center gap-2">
                                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-mortarboard-fill text-primary fs-4"></i>
                                    </div>
                                    <div class="text">
                                        <h5 style="font-size: 17px; margin: 0;">Instructors</h5>
                                        <span style="font-weight: bold;font-size: 15px;">
                                            30+
                                        </span>
                                    </div>
                                </div>
                                <div class="content1 d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="bi bi-people-fill text-primary fs-4"></i>
                                    </div>
                                    <div class="text">
                                        <h5 style="font-size: 17px; margin: 0;">Learners</h5>
                                        <span style="font-weight: bold;font-size: 15px;">
                                            100+
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="image-content">
                            <img src="" alt="">
                        </div>
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
        return {
            imageSrc: require()
        };
    },
    methods: {
        handleClick() {
            alert("Button clicked!");
        },
    },
};
</script>
