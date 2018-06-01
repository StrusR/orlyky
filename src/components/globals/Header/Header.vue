<template>
  <header id="Header">
    <section-logo></section-logo>
    <section-links :myData="myData"></section-links>
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
  },
  props: ["myData"]
};
</script>

<style>
#Header {
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  border-bottom: 1px solid white;
  padding: 1%;
  box-sizing: border-box;
  position: fixed;
  width: 100%;
  top: 0;
  z-index: 1000;
}
#Header::after {
  display: block;
  content: "";
  clear: both;
}
</style>
