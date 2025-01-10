<template>
    <SideBar />
    <!-- Main Content -->

    <v-container>
        
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-card class="pa-5" outlined>
                    <v-card-title>
                        <h1 class="text-center">Binary Tree Generator</h1>
                    </v-card-title>
                    <v-card-text>
                        <v-form @submit.prevent="submitNumbers">
                            <v-text-field
                                v-model="numberSeries"
                                label="Enter Number Series (comma-separated)"
                                placeholder="e.g., 5,3,8,1,4"
                                outlined
                            ></v-text-field>
                            <v-btn
                                class="mt-3"
                                color="primary"
                                type="submit"
                                block
                            >
                                Generate Tree
                            </v-btn>
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <!-- Display Binary Tree -->
        <v-row justify="center" v-if="binaryTree">
            <v-col cols="12" md="10">
                <v-card class="pa-5" outlined>
                    <v-card-title>
                        <h2 class="text-center">Binary Tree</h2>
                    </v-card-title>
                    <v-card-text>
                        <div class="tree-container">
                            <BinaryTreeNode :node="binaryTree" />
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import BinaryTreeNode from "./BinaryTreeNode.vue";
import SideBar from "./SideBar.vue";
import axios from "axios";

export default {
    components: {
        BinaryTreeNode,
        SideBar,
    },
    data() {
        return {
            numberSeries: "",
            binaryTree: null,
        };
    },
    methods: {
        async submitNumbers() {
            try {
                const numbers = this.numberSeries
                    .split(",")
                    .map((num) => parseInt(num.trim()))
                    .filter((num) => !isNaN(num));

                const response = await axios.post(
                    "http://127.0.0.1:8000/api/binary-tree",
                    { numbers }
                );
                this.binaryTree = response.data;
            } catch (error) {
                console.error(
                    "Error generating tree:",
                    error.response?.data || error.message
                );
            }
        },
    },
};
</script>

<style scoped>
.tree-container {
    margin-top: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
}

.tree-node {
    text-align: center;
    margin: 0 auto;
    display: inline-block;
    position: relative;
}

.tree-node::before,
.tree-node::after {
    content: "";
    position: absolute;
    border-top: 2px solid #555;
    width: 50%;
    height: 20px;
    top: 0;
}

.tree-node::before {
    left: 0;
    border-right: none;
}

.tree-node::after {
    right: 0;
    border-left: none;
}

.tree-node-value {
    display: inline-block;
    padding: 5px 10px;
    background-color: #1976d2;
    color: white;
    border-radius: 4px;
    border: 1px solid #0d47a1;
}
</style>
