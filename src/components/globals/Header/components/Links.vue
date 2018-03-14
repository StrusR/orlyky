<template>
    <div class="Links">
        <a>{{name}} {{surname}}</a>
        <a>Вихід</a>
        <a>Новини</a>
    </div>
</template>

<script>
var LinksData = {
  name: "Роман",
  surname: "Струсь"
};
export default {
  name: "Links",
  data: function() {
    return LinksData;
  }
};
</script>

<style scoped>
.Links a {
  float: right;
  color: white;
  cursor: pointer;
  font-size: 1.3em;
  margin-left: 1%;
}

.Links a:first-child {
  float: left;
}
</style>
