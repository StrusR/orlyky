<template>
  <div id="RegLog">
      <section-header></section-header>
      <section-article></section-article>
  </div>
</template>

<script>
var RegLogHeader = require("../RegLog/components/RegLogHeader.vue");
var RegLogArticle = require("../RegLog/components/RegLogArticle.vue");

export default {
  name: "RegLog",
  components: {
    "section-header": RegLogHeader,
    "section-article": RegLogArticle
  }
};
</script>

<style scoped>

</style>
