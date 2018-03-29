<template>
    <article id="EventsArticle">
        <div class="leftCol EventsBlock">
            EventsArticle
        </div>
        <section-create-event></section-create-event>
    </article>
</template>

<script>
var CreateEvent = require("../Article/components/CreateEvent.vue");

var EventsData = {};

export default {
  name: "EventsArticle",
  components: {
    "section-create-event": CreateEvent
  }
};
</script>

<style scoped>
#EventsArticle > .EventsBlock {
  box-shadow: -2px 2px 5px 0px rgb(60, 0, 0);
}
</style>
