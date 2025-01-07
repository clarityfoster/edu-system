<template>
    <v-container fluid class="d-flex justify-content-around h-100">
        <!-- Sidebar -->
        <SideBar />

        <!-- Main Content Area -->
            <v-card
            class="home-dashboard expanded-card elevation-2 mx-3"
                elevation="0"
                style="gap: 30px; width: 2300px;"
            >
                <div class="input-group" style="max-width: 500px; margin-bottom: 30px; margin-top: 8px;">
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
                <div style="margin-bottom: 50px;">
                    <h4 style="font-weight: 600">Analytsics Overview</h4>
                    <div
                        class="bg-primary rounded-4 d-flex align-items-center justify-content-evenly gap-3 mt-4"
                        style=" height: 350px"
                    >
                        <div class="text-content d-flex flex-column gap-4">
                            <div class="title">
                                <h3 style="font-weight: bold; color: #ffc726">
                                    Learn Effectively With Us!
                                </h3>
                                <span style="font-size: 15px">
                                    Loream ipsum dolor sit amet consectetur.
                                </span>
                            </div>
                            <div class="content d-flex gap-5 mt-5">
                                <div
                                    class="content1 d-flex align-items-center gap-2"
                                >
                                    <div
                                        class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px"
                                    >
                                        <i
                                            class="bi bi-mortarboard-fill text-primary fs-4"
                                        ></i>
                                    </div>
                                    <div class="text">
                                        <h5 style="font-size: 17px; margin: 0">
                                            Instructors
                                        </h5>
                                        <span
                                            style="
                                                color: #ffc726;
                                                font-weight: bold;
                                                font-size: 15px;
                                            "
                                        >
                                            30+
                                        </span>
                                    </div>
                                </div>
                                <div
                                    class="content1 d-flex align-items-center gap-2"
                                >
                                    <div
                                        class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px"
                                    >
                                        <i
                                            class="bi bi-people-fill text-primary fs-4"
                                        ></i>
                                    </div>
                                    <div class="text">
                                        <h5 style="font-size: 17px; margin: 0">
                                            Learners
                                        </h5>
                                        <span
                                            style="
                                                font-weight: bold;
                                                font-size: 15px;
                                                color: #ffc726;
                                            "
                                        >
                                            100+
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <img
                            src="../../../public/img/education.svg"
                            alt=""
                            style="width: 35%"
                        />
                    </div>
                </div>
                <div
                    class="d-flex justify-content-between align-items-start gap-5"
                >
                    <div style="width: 480px; height: 400px">
                        <div
                            class="d-flex align-items-center justify-content-between"
                        >
                            <h5 style="font-weight: 600">Popular Courses</h5>
                            <button
                                class="btn btn-secondary btn-sm rounded-5 text-white"
                                style="
                                    width: 95px;
                                    height: 25px;
                                    font-weight: bold;
                                    font-size: 12px;
                                "
                            >
                                All Courses
                            </button>
                        </div>
                        <div
                            class="d-flex flex-column align-items-start gap-2 mt-4"
                        >
                            <div class="card rounded-4 w-100">
                                <div
                                    class="card-body d-flex justify-content-between align-items-center gap-3"
                                >
                                    <div>
                                        <p
                                            style="
                                                font-size: 15px;
                                                margin: 0;
                                                font-weight: bold;
                                            "
                                            class="card-title"
                                        >
                                            Binary Tree Algorithms
                                        </p>
                                        <span
                                            style="font-size: 14px"
                                            class="text-muted"
                                            >Semester 4</span
                                        >
                                    </div>
                                    <button
                                        class="btn btn-sm rounded-5 text-white"
                                        style="
                                            width: 70px;
                                            height: 30px;
                                            background-color: #ffc726;
                                            font-weight: bold;
                                        "
                                    >
                                        View
                                    </button>
                                </div>
                            </div>
                            <div class="card rounded-4 w-100">
                                <div
                                    class="card-body d-flex justify-content-between align-items-center gap-3"
                                >
                                    <div>
                                        <p
                                            style="
                                                font-size: 15px;
                                                margin: 0;
                                                font-weight: bold;
                                            "
                                            class="card-title"
                                        >
                                            Introduction to Programming
                                        </p>
                                        <span
                                            style="font-size: 14px"
                                            class="text-muted"
                                            >Semester 1</span
                                        >
                                    </div>
                                    <button
                                        class="btn btn-sm rounded-5 text-white"
                                        style="
                                            width: 70px;
                                            height: 30px;
                                            background-color: #ffc726;
                                            font-weight: bold;
                                        "
                                    >
                                        View
                                    </button>
                                </div>
                            </div>
                            <div class="card rounded-4 w-100">
                                <div
                                    class="card-body d-flex justify-content-between align-items-center gap-3"
                                >
                                    <div>
                                        <p
                                            style="
                                                font-size: 15px;
                                                margin: 0;
                                                font-weight: bold;
                                            "
                                            class="card-title"
                                        >
                                            Introduction to Web Development
                                        </p>
                                        <span
                                            style="font-size: 14px"
                                            class="text-muted"
                                            >Semester 2</span
                                        >
                                    </div>
                                    <button
                                        class="btn btn-sm rounded-5 text-white"
                                        style="
                                            width: 70px;
                                            height: 30px;
                                            background-color: #ffc726;
                                            font-weight: bold;
                                        "
                                    >
                                        View
                                    </button>
                                </div>
                            </div>
                            <div class="card rounded-4 w-100">
                                <div
                                    class="card-body d-flex justify-content-between align-items-center gap-3"
                                >
                                    <div>
                                        <p
                                            style="
                                                font-size: 15px;
                                                margin: 0;
                                                font-weight: bold;
                                            "
                                            class="card-title"
                                        >
                                            Introduction to Web Development
                                        </p>
                                        <span
                                            style="font-size: 14px"
                                            class="text-muted"
                                            >Semester 2</span
                                        >
                                    </div>
                                    <button
                                        class="btn btn-sm rounded-5 text-white"
                                        style="
                                            width: 70px;
                                            height: 30px;
                                            background-color: #ffc726;
                                            font-weight: bold;
                                        "
                                    >
                                        View
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="width: 400px; height: 400px">
                        <h5 style="font-weight: 600">Current Activity</h5>
                        <div class="mt-4 d-flex flex-column gap-3">
                            <div
                                class="w-100 bg-primary rounded-4"
                                style="height: 170px"
                            >

                            </div>
                            <div class="d-flex gap-3">
                                <div
                                    class="rounded-4 d-flex flex-column gap-3 p-4 align-items-center justify-content-center "
                                    style="
                                        width: 200px;
                                        height: 170px;
                                        background-color: #ffc726;
                                    "
                                >
                                    <div>
                                        <h3 class="text-white" style="font-weight: bold; padding: 0; margin: 0;">7K+</h3>
                                        <span class="text-white" style="padding: 0; font-weight: bold;">Completed Courses</span>
                                    </div>
                                    <router-link class="w-100 text-end">
                                        <i class="bi bi-arrow-up-right-circle-fill fs-3 text-white"></i>
                                    </router-link>
                                </div>
                                <div
                                    class="rounded-4 d-flex flex-column gap-3 p-4 align-items-center justify-content-center "
                                    style="
                                        width: 200px;
                                        height: 170px;
                                        background-color: #455a64;
                                    "
                                >
                                    <div>
                                        <h3 class="text-white" style="font-weight: bold; padding: 0; margin: 0;">2K+</h3>
                                        <span class="text-white" style="padding: 0; font-weight: bold;">Ongoing Semesters</span>
                                    </div>
                                    <router-link class="w-100 text-end">
                                        <i class="bi bi-arrow-up-right-circle-fill fs-3 text-white"></i>
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="width: 400px">
                        <h5 style="font-weight: 600">Best Learners</h5>
                        <div class="d-flex flex-column gap-2 align-items-start justify-content-center mt-4">
                            <div class="card rounded-4 w-100">
                                <div
                                    class="card-body d-flex justify-content-start align-items-start gap-3" style="padding: 14.5px;"
                                >
                                    <div
                                        class="d-flex align-items-center justify-content-center text-white rounded-circle"
                                        style="
                                            width: 50px;
                                            height: 50px;
                                            background-color: #ffc726;
                                            font-weight: bold;
                                            font-size: 20px;
                                        "
                                    >
                                        B
                                    </div>
                                    <div>
                                        <p
                                            style="
                                                font-size: 15px;
                                                margin: 0;
                                                font-weight: bold;
                                            "
                                            class="card-title"
                                        >
                                            Bella Smith
                                        </p>
                                        <span
                                            style="font-size: 14px"
                                            class="text-muted"
                                            >Semester 4</span
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-4 w-100">
                                <div
                                    class="card-body d-flex justify-content-start align-items-start gap-3" style="padding: 14.5px;"
                                >
                                    <div
                                        class="d-flex align-items-center justify-content-center text-white rounded-circle"
                                        style="
                                            width: 50px;
                                            height: 50px;
                                            background-color: #ffc726;
                                            font-weight: bold;
                                            font-size: 20px;
                                        "
                                    >
                                        B
                                    </div>
                                    <div>
                                        <p
                                            style="
                                                font-size: 15px;
                                                margin: 0;
                                                font-weight: bold;
                                            "
                                            class="card-title"
                                        >
                                            Bella Smith
                                        </p>
                                        <span
                                            style="font-size: 14px"
                                            class="text-muted"
                                            >Semester 4</span
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-4 w-100">
                                <div
                                    class="card-body d-flex justify-content-start align-items-start gap-3" style="padding: 14.5px;"
                                >
                                    <div
                                        class="d-flex align-items-center justify-content-center text-white rounded-circle"
                                        style="
                                            width: 50px;
                                            height: 50px;
                                            background-color: #ffc726;
                                            font-weight: bold;
                                            font-size: 20px;
                                        "
                                    >
                                        B
                                    </div>
                                    <div>
                                        <p
                                            style="
                                                font-size: 15px;
                                                margin: 0;
                                                font-weight: bold;
                                            "
                                            class="card-title"
                                        >
                                            Bella Smith
                                        </p>
                                        <span
                                            style="font-size: 14px"
                                            class="text-muted"
                                            >Semester 4</span
                                        >
                                    </div>
                                </div>
                            </div>
                            <div class="card rounded-4 w-100">
                                <div
                                    class="card-body d-flex justify-content-start align-items-start gap-3" style="padding: 14.5px;"
                                >
                                    <div
                                        class="d-flex align-items-center justify-content-center text-white rounded-circle"
                                        style="
                                            width: 50px;
                                            height: 50px;
                                            background-color: #ffc726;
                                            font-weight: bold;
                                            font-size: 20px;
                                        "
                                    >
                                        B
                                    </div>
                                    <div>
                                        <p
                                            style="
                                                font-size: 15px;
                                                margin: 0;
                                                font-weight: bold;
                                            "
                                            class="card-title"
                                        >
                                            Bella Smith
                                        </p>
                                        <span
                                            style="font-size: 14px"
                                            class="text-muted"
                                            >Semester 4</span
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </v-card>
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


<style>
@media (max-width: 1502px) {
    .expanded-card {
        max-width: 1100px;
    }
}
@media (max-width: 1440px) {
    .expanded-card {
        max-width: 1050px;
    }
}
@media (max-width: 13414px) {
    .expanded-card {
        max-width: 950px;
    }
}
</style>
