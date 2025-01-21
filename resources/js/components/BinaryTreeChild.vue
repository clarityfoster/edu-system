<template>
  <div class="node">
    <div
      class="node-value mx-auto"
      :class="{ 'highlight-search': isHighlightedSearch, 'highlight-insert': isHighlightedInsert }"
    >
      {{ node.value }}
    </div>

    <div class="children position-relative" v-if="node.left || node.right">
      <BinaryTreeChild
        v-if="node.left"
        :node="node.left"
        :searchKey="searchKey"
        :insertKey="insertKey"
      />
      <BinaryTreeChild
        v-if="node.right"
        :node="node.right"
        :searchKey="searchKey"
        :insertKey="insertKey"
      />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    node: Object,
    searchKey: Number,
    insertKey: Number,
  },
  computed: {
    isHighlightedSearch() {
      return this.node.value === this.searchKey;
    },
    isHighlightedInsert() {
      return this.node.value === this.insertKey;
    },
  },
};
</script>

<style scoped>
.node {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.node-value {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 60px;
  height: 60px;
  background-color: #007bff;
  color: white;
  border-radius: 50%;
  font-size: 16px;
  text-align: center;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: background-color 0.3s ease, transform 0.3s ease;
}

.node-value.highlight-search {
  background-color: #4caf50;
  color: white;
  border-color: #388e3c;
}


.node-value.highlight-insert {
    background-color: #f44336;
    color: white;
    border-color: #d32f2f;
    transform: scale(1.1);
    transition: background-color 0.5s ease, transform 0.5s ease;
}


.children {
  display: flex;
  width: 100%;
  justify-content: space-between;
  margin-top: 16px;
}

.children > * {
  margin: 0 10px;
}
</style>
