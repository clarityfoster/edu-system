<template>
    <SideBar />

    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="8">
                <v-card class="pa-5" outlined>
                    <v-card-title>
                        <h2 class="text-center">Generate Binary Tree</h2>
                    </v-card-title>
                    <v-card-text>
                        <v-form
                            ref="generateForm"
                            v-model="valid"
                            @submit.prevent="generateTree"
                        >
                            <v-text-field
                                v-model="numberSeries"
                                :rules="[validateNumbers, required]"
                                label="Enter Numbers (comma-separated)"
                                placeholder="e.g., 5,3,8,1,4"
                                outlined
                            ></v-text-field>
                            <v-btn
                                :disabled="!valid"
                                color="primary"
                                type="submit"
                                block
                                >Generate Tree</v-btn
                            >
                        </v-form>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
        <v-row justify="center" v-if="binaryTree">
            <v-col cols="12" md="10">
                <v-card class="pa-5" outlined>
                    <v-card-title>
                        <h2 class="text-center">Tree Operations</h2>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <!-- Search -->
                            <v-col cols="12" sm="4">
                                <v-form
                                    ref="searchForm"
                                    v-model="searchValid"
                                    @submit.prevent="searchValue"
                                >
                                    <v-text-field
                                        v-model="searchKey"
                                        :rules="[required, validateNumber]"
                                        label="Search Key"
                                        type="number"
                                        outlined
                                    ></v-text-field>
                                    <v-btn
                                        :disabled="!searchValid"
                                        color="success"
                                        type="submit"
                                        block
                                        >Search</v-btn
                                    >
                                </v-form>
                                <div
                                    v-if="searchResult !== null"
                                    class="mt-3 text-center"
                                >
                                    <p v-if="searchResult">Value Found!</p>
                                    <p class="text-danger" v-else>
                                        Value Not Found!
                                    </p>
                                </div>
                            </v-col>

                            <!-- Insert -->
                            <v-col cols="12" sm="4">
                                <v-form
                                    ref="insertForm"
                                    v-model="insertValid"
                                    @submit.prevent="insertValue"
                                >
                                    <v-text-field
                                        v-model="insertKey"
                                        :rules="[required, validateNumber]"
                                        label="Insert Key"
                                        type="number"
                                        outlined
                                    ></v-text-field>
                                    <v-btn
                                        :disabled="!insertValid"
                                        color="secondary"
                                        type="submit"
                                        block
                                        >Insert</v-btn
                                    >
                                </v-form>
                                <div
                                    v-if="insertMessage"
                                    class="mt-3 text-center"
                                >
                                    <p>{{ insertMessage }}</p>
                                </div>
                            </v-col>

                            <v-col cols="12" sm="4">
                                <v-form
                                    ref="deleteForm"
                                    v-model="deleteValid"
                                    @submit.prevent="deleteValue"
                                >
                                    <v-text-field
                                        v-model="deleteKey"
                                        :rules="[required, validateNumber]"
                                        label="Delete Key"
                                        type="number"
                                        outlined
                                    ></v-text-field>
                                    <v-btn
                                        :disabled="!deleteValid"
                                        color="error"
                                        type="submit"
                                        block
                                        >Delete</v-btn
                                    >
                                </v-form>
                                <div
                                    v-if="deleteMessage"
                                    class="mt-3 text-center"
                                >
                                    <p>{{ deleteMessage }}</p>
                                </div>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>

        <!-- Display Binary Search Tree -->
        <v-row justify="center" v-if="binaryTree">
            <v-col cols="12" md="10">
                <v-card class="pa-5" outlined>
                    <v-card-title>
                        <h2 class="text-center">Visualize Binary Tree</h2>
                    </v-card-title>
                    <v-card-text>
                        <div class="tree-container">
                            <BinaryTreeChild
                                :node="binaryTree"
                                :searchKey="searchResult ? searchKey : null"
                            />
                        </div>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import BinaryTreeChild from "./BinaryTreeChild.vue";
import SideBar from "./SideBar.vue";

export default {
    components: {
        SideBar,
        BinaryTreeChild,
    },
    data() {
        return {
            numberSeries: "",
            binaryTree: null,
            searchKey: null,
            searchResult: null,
            insertKey: null,
            insertMessage: null,
            deleteKey: null,
            deleteMessage: null,
            valid: false,
            searchValid: false,
            insertValid: false,
            deleteValid: false,
            rules: {
                required: (value) => !!value || "Field is required.",
                validateNumbers: (value) => {
                    const regex = /^(\s*\d+\s*,)*\s*\d+\s*$/;
                    return (
                        regex.test(value) ||
                        "Enter valid comma-separated numbers."
                    );
                },
                validateNumber: (value) =>
                    !isNaN(value) || "Enter a valid number.",
            },
        };
    },
    computed: {
        required() {
            return this.rules.required;
        },
        validateNumbers() {
            return this.rules.validateNumbers;
        },
        validateNumber() {
            return this.rules.validateNumber;
        },
    },
    methods: {
        generateTree() {
            if (!this.$refs.generateForm.validate()) return;

            const numbers = this.numberSeries
                .split(",")
                .map((num) => parseInt(num.trim()))
                .filter((num) => !isNaN(num));

            this.binaryTree = this.buildTree(numbers);
        },
        buildTree(numbers) {
            class TreeNode {
                constructor(value) {
                    this.value = value;
                    this.left = null;
                    this.right = null;
                }
            }
            const insertNode = (root, value) => {
                if (!root) return new TreeNode(value);
                if (value < root.value)
                    root.left = insertNode(root.left, value);
                else if (value > root.value)
                    root.right = insertNode(root.right, value);
                return root;
            };

            let root = null;
            numbers.forEach((num) => {
                root = insertNode(root, num);
            });

            return root;
        },
        insertValue() {
            if (!this.$refs.insertForm.validate()) return;

            const key = parseInt(this.insertKey);

            const findNode = (root, value) => {
                if (!root) return null;
                if (value === root.value) return root;
                if (value < root.value) return findNode(root.left, value);
                return findNode(root.right, value);
            };

            if (findNode(this.binaryTree, key)) {
                this.insertMessage = `${key} is already in the tree!`;
                this.insertKey = null;
                return;
            }

            if (!this.binaryTree) {
                this.binaryTree = this.buildTree([key]);
                this.insertMessage = `Inserted ${key} as the root node.`;
                return;
            }

            const insertNode = (root, value) => {
                if (!root) return { value, left: null, right: null };
                if (value < root.value)
                    root.left = insertNode(root.left, value);
                else if (value > root.value)
                    root.right = insertNode(root.right, value);
                return root;
            };

            this.binaryTree = insertNode(this.binaryTree, key);
            this.insertMessage = `Inserted ${key} successfully.`;
            this.insertKey = null;
        },
        searchValue() {
            if (!this.$refs.searchForm.validate()) return;

            const searchTree = (node, value) => {
                if (!node) return false;
                if (node.value === value) return true;
                return value < node.value
                    ? searchTree(node.left, value)
                    : searchTree(node.right, value);
            };

            const key = parseInt(this.searchKey);
            this.searchResult = searchTree(this.binaryTree, key);
            if (this.searchResult) {
                this.$nextTick(() => {
                    this.searchKey = key;
                });
            }
        },
        deleteValue() {
            if (!this.$refs.deleteForm.validate()) return;

            const key = parseInt(this.deleteKey);

            const deleteNode = (root, value) => {
                if (!root) return { node: null, found: false };

                if (value < root.value) {
                    const result = deleteNode(root.left, value);
                    root.left = result.node;
                    return { node: root, found: result.found };
                }

                if (value > root.value) {
                    const result = deleteNode(root.right, value);
                    root.right = result.node;
                    return { node: root, found: result.found };
                }

                if (!root.left && !root.right) {
                    return { node: null, found: true };
                }

                if (!root.left || !root.right) {
                    return { node: root.left || root.right, found: true };
                }

                const minNode = this.findMinNode(root.right);
                root.value = minNode.value;
                const result = deleteNode(root.right, minNode.value);
                root.right = result.node;
                return { node: root, found: true };
            };

            const result = deleteNode(this.binaryTree, key);

            this.binaryTree = result.node;

            this.deleteMessage = result.found
                ? `Deleted ${key} successfully.`
                : `Error: ${key} not found in the tree.`;

            this.deleteKey = null;
        },
        findMinNode(root) {
            while (root.left) {
                root = root.left;
            }
            return root;
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
</style>
