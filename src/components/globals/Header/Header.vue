<template>
  <header id="Header">
    <section-logo></section-logo>
    <section-links></section-links>
  </header>
</template>

<script>
var LogoComponent = require("../../globals/Logo.vue");
var LinksComponent = require("../Header/components/Links.vue");

export default {
  name: "Header",
  components: {
    "section-logo": LogoComponent,
    "section-links": LinksComponent
  }
};
</script>

<style scoped>
#Header {
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
  padding: 1%;
  box-sizing: border-box;
  position: fixed;
  width: 100%;
  top: 0;
}
#Header::after {
  display: block;
  content: "";
  clear: both;
}
</style>
