<template>
    <div id="EventMain">
        <div class="banner">
            <div class="topic">{{event.topic}}</div>
        </div>
        <div class="plan">plan</div>
        <div class="estimate">estimate</div>
        <div class="menu"><router-link :to="{ path: `/event/${this.$route.params.id}/menu`}">Меню</router-link></div>
        <div class="inventory">inventory</div>
    </div>
</template>

<script>
var EventMainData = {};

export default {
  name: "EventMain",
  props: ["event"],
  data: function() {
    return EventMainData;
  }
};
</script>

<style scoped>
#EventMain {
  box-shadow: -2px 2px 5px 0px rgb(60, 0, 0);
}
#EventMain > .banner {
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
  color: white;
  position: relative;
}
#EventMain > .banner > .topic {
  position: absolute;
  bottom: 10px;
  left: 10px;
  font-size: 1.5em;
  font-weight: bold;
}
</style>
