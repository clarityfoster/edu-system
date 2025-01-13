<template>
  <div class="node">
    <div
      class="node-value mx-auto"
      :class="{ 'highlight': isHighlighted }"
    >
      {{ node.value }}
    </div>
    <div class="children position-relative" v-if="node.left || node.right">
      <BinaryTreeChild v-if="node.left" :node="node.left" :searchKey="searchKey" />
      <BinaryTreeChild v-if="node.right" :node="node.right" :searchKey="searchKey" />
    </div>
  </div>
</template>

<script>
export default {
  props: {
    node: Object,
    searchKey: Number,
  },
  computed: {
    isHighlighted() {
      return this.node.value === this.searchKey;
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
}

.node-value.highlight {
  background-color: #4caf50;
  color: white;
  border-color: #388e3c;
}

.children {
  display: flex;
   width: 100%;
   /* align-items: center; */
  justify-content: space-between;
  margin-top: 16px;
}


.children > * {
  margin: 0 10px;
}

</style>
