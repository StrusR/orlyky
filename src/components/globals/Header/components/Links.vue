<template>
    <div class="Links">
        <a>{{myData.name}} {{myData.surname}}</a>
        <a>Вихід</a>
        <a>Новини</a>
    </div>
</template>

<script>
export default {
  name: "Links",
  props: ["myData"]
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
