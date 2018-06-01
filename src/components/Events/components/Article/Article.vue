<template>
    <article id="EventsArticle">
        <div class="leftCol EventsBlock" v-for="(event, index) in events" :key="'event' + index">
          <div class="banner">
            <div class="topic"><router-link :to="{ path: `/event/${event.id}`}">{{event.topic}}</router-link></div>
          </div>
        </div>
        <section-create-event></section-create-event>
    </article>
</template>

<script>
var CreateEvent = require("../Article/components/CreateEvent.vue");

var EventsData = {
  events: ""
};

export default {
  name: "EventsArticle",
  data: function() {
    return EventsData;
  },
  components: {
    "section-create-event": CreateEvent
  },
  created: function() {
    $.ajax({
      url: "../orlyky/server/get/events.php",
      type: "POST",
      dataType: "json",

      success: function(data) {
        // alert(data.events[0].topic);
        EventsData.events = data.events;
      },

      error: function() {
        alert("error");
      }
    });
  }
};
</script>

<style>
#EventsArticle > .EventsBlock {
  margin-bottom: 1%;
  box-shadow: -2px 2px 5px 0px black;
}
#EventsArticle > .EventsBlock > .banner {
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
  position: relative;
}
#EventsArticle > .EventsBlock > .banner > .topic {
  position: absolute;
  bottom: 10px;
  left: 10px;
  font-size: 1.5em;
  font-weight: bold;
}
#EventsArticle > .EventsBlock > .banner > .topic > a {
  color: white;
}
</style>
