<template>
  <div id="BackgroundClose" @click="onBackgroundClick">

  </div>
</template>
<script>
export default {
  name: "BackgroundClose",
  methods: {
    onBackgroundClick: function() {
      this.$emit("backgroundClick");
    }
  }
};
</script>

<style scoped>
#BackgroundClose {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: black;
  opacity: 0.7;
  z-index: 1;
}
</style>
