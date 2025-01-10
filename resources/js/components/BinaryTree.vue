<template>
  <div class="tree-node">
    <!-- Node Value -->
    <div class="tree-node-value">{{ node.value }}</div>

    <!-- Children Nodes -->
    <div v-if="node.left || node.right" class="tree-children">
      <div class="tree-child" v-if="node.left">
        <BinaryTreeNode :node="node.left" />
      </div>
      <div class="tree-child" v-if="node.right">
        <BinaryTreeNode :node="node.right" />
      </div>
    </div>
  </div>
</template>

<script>
export default {

  props: {
    node: {
      type: Object,
      required: true,
    },
  },
};
</script>

<style scoped>
.tree-node {
  display: flex;
  flex-direction: column;
  align-items: center;
  position: relative;
}

.tree-node-value {
  padding: 10px;
  background-color: #007bff;
  color: white;
  border-radius: 50%;
  border: 2px solid #0056b3;
  text-align: center;
  width: 40px;
  height: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1;
}

.tree-children {
  display: flex;
  justify-content: space-evenly;
  margin-top: 20px;
  position: relative;
  width: 100%;
}

.tree-child {
  flex: 1;
  display: flex;
  justify-content: center;
  position: relative;
}

/* Lines between nodes */
.tree-child::before {
  content: '';
  position: absolute;
  top: -20px;
  width: 50%;
  height: 20px;
  border-top: 2px solid #555;
}

.tree-child:first-child::before {
  left: 50%;
  border-right: 2px solid #555;
}

.tree-child:last-child::before {
  right: 50%;
  border-left: 2px solid #555;
}

/* Additional styling for the container */
.tree-children {
  gap: 20px;
}

.tree-node-value {
  position: relative;
  z-index: 10;
}
</style>
