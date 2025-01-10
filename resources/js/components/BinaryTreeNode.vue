<template>
  <div class="tree-node text-center position-relative" ref="parentNode">
    <!-- Node Circle -->
    <div class="tree-node-value mx-auto">{{ node.value }}</div>

    <!-- Children with Connection Lines -->
    <div class="tree-children d-flex justify-content-between">
      <!-- Left Connection -->
      <div v-if="node.left" class="child-node position-relative" ref="leftChild">
        <span class="connection-line-left"></span> <!-- First Line -->
        <!-- <span class="connection-line secondary"></span>  -->
        <BinaryTreeNode :node="node.left" />
      </div>

      <!-- Right Connection -->
      <div v-if="node.right" class="child-node position-relative" ref="rightChild">
        <span class="connection-line-right"></span>
        <!-- <span class="connection-line secondary"></span> Second Line -->
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
  align-items: center;
  display: flex;
  flex-direction: column;
  margin: 20px;
  position: relative;
}

.tree-node-value {
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

.tree-children {
  display: flex;
  justify-content: space-between;
  width: 100%;
  position: relative;
  margin-top: 20px;
}

.child-node {
  position: relative;
  flex: 1;
  display: flex;
  justify-content: center; /* Centers the node horizontally */
}

/* Primary Connection Line */
.connection-line-left {
  position: absolute;
  top: -20px; /* Aligns the line under the parent node */
  left: 50%;
  width: 70px; /* Adjust width to control the length of the diagonal line */
  height: 2px; /* Horizontal line thickness */
  background-color: #000;
  transform-origin: top right; /* Set rotation origin for leaning */
  transform: translateX(-50%) rotate(-45deg); /* Apply diagonal lean */
}
.connection-line-right {
  position: absolute;
  top: -15px;
  left: 40%;
  width: 70px;
  height: 2px;
  background-color: #000;
  transform-origin: top right;
  transform: translateX(-50%) rotate(45deg); /* Leaning to the right */
}

/* Secondary Connection Line */
.connection-line.secondary {
  position: absolute;
  top: 10px; /* Spacing below the first line */
  left: 50%;
  width: 2px;
  height: 50px; /* Length of the secondary line */
  background-color: #000; /* Lighter color for differentiation */
  transform: translateX(-50%);
}
</style>

