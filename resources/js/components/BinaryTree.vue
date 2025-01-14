<template>
  <SideBar />

  <v-container>
    <v-row justify="center">
      <v-col cols="12" md="8">
        <v-card class="pa-5" outlined>
          <v-card-title>
            <h1 class="text-center">Binary Search Tree</h1>
          </v-card-title>
          <v-card-text>
            <v-form ref="generateForm" v-model="valid" @submit.prevent="generateTree">
              <v-text-field
                v-model="numberSeries"
                :rules="[validateNumbers, required]"
                label="Enter Numbers (comma-separated)"
                placeholder="e.g., 5,3,8,1,4"
                outlined
              ></v-text-field>
              <v-btn :disabled="!valid" color="primary" type="submit" block>Generate Tree</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Search Section -->
    <v-row justify="center" v-if="binaryTree">
      <v-col cols="12" md="8">
        <v-card class="pa-5" outlined>
          <v-card-title>
            <h2 class="text-center">Search Tree</h2>
          </v-card-title>
          <v-card-text>
            <v-form ref="searchForm" v-model="searchValid" @submit.prevent="searchValue">
              <v-text-field
                v-model="searchKey"
                :rules="[required, validateNumber]"
                label="Enter Value to Search"
                type="number"
                outlined
              ></v-text-field>
              <v-btn :disabled="!searchValid" color="secondary" type="submit" block>Search</v-btn>
            </v-form>
            <div v-if="searchResult !== null" class="mt-3 text-center">
              <p v-if="searchResult">Value Found in the Tree!</p>
              <p v-else>Value Not Found in the Tree.</p>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Insert Section -->
    <v-row justify="center" v-if="binaryTree">
      <v-col cols="12" md="8">
        <v-card class="pa-5" outlined>
          <v-card-title>
            <h2 class="text-center">Insert Key</h2>
          </v-card-title>
          <v-card-text>
            <v-form ref="insertForm" v-model="insertValid" @submit.prevent="insertValue">
              <v-text-field
                v-model="insertKey"
                :rules="[required, validateNumber]"
                label="Enter Value to Insert"
                type="number"
                outlined
              ></v-text-field>
              <v-btn :disabled="!insertValid" color="success" type="submit" block>Insert</v-btn>
            </v-form>
            <div v-if="insertMessage" class="mt-3 text-center">
              <p>{{ insertMessage }}</p>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Delete Section -->
    <v-row justify="center" v-if="binaryTree">
      <v-col cols="12" md="8">
        <v-card class="pa-5" outlined>
          <v-card-title>
            <h2 class="text-center">Delete Key</h2>
          </v-card-title>
          <v-card-text>
            <v-form ref="deleteForm" v-model="deleteValid" @submit.prevent="deleteValue">
              <v-text-field
                v-model="deleteKey"
                :rules="[required, validateNumber]"
                label="Enter Value to Delete"
                type="number"
                outlined
              ></v-text-field>
              <v-btn :disabled="!deleteValid" color="error" type="submit" block>Delete</v-btn>
            </v-form>
            <div v-if="deleteMessage" class="mt-3 text-center">
              <p>{{ deleteMessage }}</p>
            </div>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- Display Binary Search Tree -->
    <v-row justify="center" v-if="binaryTree">
      <v-col cols="12" md="10">
        <v-card class="pa-5" outlined>
          <v-card-title>
            <h2 class="text-center">Binary Search Tree</h2>
          </v-card-title>
          <v-card-text>
            <div class="tree-container">
              <BinaryTreeChild :node="binaryTree" :searchKey="searchResult ? searchKey : null" />
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
          return regex.test(value) || "Enter valid comma-separated numbers.";
        },
        validateNumber: (value) => !isNaN(value) || "Enter a valid number.",
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
        if (value < root.value) root.left = insertNode(root.left, value);
        else if (value > root.value) root.right = insertNode(root.right, value);
        return root;
      };

      let root = null;
      numbers.forEach((num) => {
        root = insertNode(root, num);
      });

      return root;
    },

    // Insert Value into the tree
    insertValue() {
      if (!this.$refs.insertForm.validate()) return;

      const key = parseInt(this.insertKey);
      if (!this.binaryTree) {
        this.binaryTree = this.buildTree([key]);
        this.insertMessage = `Inserted ${key} as the root node.`;
        return;
      }

      const insertNode = (root, value) => {
        if (!root) return { value, left: null, right: null };
        if (value < root.value) root.left = insertNode(root.left, value);
        else if (value > root.value) root.right = insertNode(root.right, value);
        return root;
      };

      this.binaryTree = insertNode(this.binaryTree, key);
      this.insertMessage = `Inserted ${key} successfully.`;
      this.insertKey = null;
    },

    // Search Value in the tree
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
            } else if (value > root.value) {
            const result = deleteNode(root.right, value);
            root.right = result.node;
            return { node: root, found: result.found };
            } else {

            if (!root.left && !root.right) {
                return { node: null, found: true };
            }
            if (!root.left) {
                return { node: root.right, found: true };
            }
            if (!root.right) {
                return { node: root.left, found: true };
            }
            // Case 3: Node has two children
            let minNode = this.findMinNode(root.right);
            root.value = minNode.value;
            const result = deleteNode(root.right, minNode.value);
            root.right = result.node;
            return { node: root, found: true };
            }
        };

        const result = deleteNode(this.binaryTree, key);

        if (result.found) {
            this.binaryTree = result.node;
            this.deleteMessage = `Deleted ${key} successfully.`;
        } else {
            this.deleteMessage = `Error: ${key} not found in the tree.`;
        }

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
