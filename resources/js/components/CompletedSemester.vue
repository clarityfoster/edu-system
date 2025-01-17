<template>
    <v-container fluid class="d-flex justify-content-around h-100">
        <!-- Sidebar -->
        <SideBar />

        <!-- Main Content Area -->
        <v-card
            class="home-dashboard expanded-card elevation-2"
            elevation="0"
            style="gap: 30px; width: 2300px; max-width: 80%; margin-left: 100px"
        >
            <!-- Data Table -->
            <v-data-table
                :items="completedSemesters"
                :headers="headers"
                class="elevation-1"
                item-value="id"
                dense
                item-class="text-center align-middle font-weight-bold"
            >
                <template v-slot:top>
                    <v-toolbar flat>
                        <v-toolbar-title class="text-center"
                            >Completed Semester Lists</v-toolbar-title
                        >
                    </v-toolbar>
                </template>

                <template v-slot:item.index="{ index }">
                    {{ index + 1 }}
                </template>

                <template v-slot:item.sname="{ item }">
                    <div class="text-center">
                        {{ item.name }}
                    </div>
                </template>

                <template v-slot:item.course="{ item }">
                    <div
                        v-for="(course, index) in item.course"
                        :key="index"
                        class="text-start"
                    >
                        {{ index + 1 }}. {{ course.name }}
                    </div>
                </template>

                <template v-slot:item.sdate="{ item }">
                    <div class="text-center">
                        {{ item.start_date }}
                    </div>
                </template>

                <template v-slot:item.edate="{ item }">
                    <div class="text-center">
                        {{ item.end_date }}
                    </div>
                </template>
            </v-data-table>
        </v-card>
    </v-container>
</template>

<script>
import SideBar from "./SideBar.vue";
import axios from "axios";
import { mapState, mapActions } from "vuex";

export default {
    name: "SemesterList",
    components: {
        SideBar,
    },
    data() {
        return {
            headers: [
                { title: "Id", value: "index", align: "center", width: "5%" },
                {
                    title: "Semester Name",
                    value: "sname",
                    align: "center",
                    width: "20%",
                },
                {
                    title: "Course Name",
                    value: "course",
                    align: "center",
                    width: "15%",
                },
                {
                    title: "Start Date",
                    value: "sdate",
                    align: "center",
                    width: "15%",
                },
                {
                    title: "End Date",
                    value: "edate",
                    align: "center",
                    width: "15%",
                },
            ],
        };
    },
    computed: {
        ...mapState(["completedSemesters", "authUsers"]),
    },
    methods: {
        ...mapActions(["fetchCompletedSemesters", "fetchAuthUsers"]),
    },
    mounted() {
        this.fetchCompletedSemesters();
        this.fetchAuthUsers();
    },
};
</script>

<style scoped>
.primary {
    background-color: #1976d2;
}
</style>
