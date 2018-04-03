<template>
    <div id="Ev">
        <section-header :myData="myData"></section-header>
        <router-view :event="event" v-if="event"></router-view>
    </div>
</template>

<script>
var Header = require("../globals/Header/Header.vue");

var EvData = {
  myId: "",
  myAccessRights: "",
  myData: "",

  page: true,
  event: "",
  eventId: ""
};

export default {
  name: "Ev",
  components: {
    "section-header": Header
  },
  data: function() {
    return EvData;
  },
  created: function() {
    this.event = "";
    this.eventId = this.$route.params.id;
    this.updateMyProfile();
    this.updateEvent();
  },
  watch: {
    myId: function() {
      if (this.myId == false) {
        this.$router.push({ name: "RegLog" });
        this.myId = "";
      }
    },
    myAccessRights: function() {
      if (this.myAccessRights == "statement") {
        this.$router.push({ name: "Statement" });
      }
    },

    page: function() {
      this.$router.push({ name: "notFound" });
      this.page = true;
    },
    $route(to, from) {
      this.updateEvent();
    }
  },
  methods: {
    updateMyProfile: function() {
      $.ajax({
        url: "../orlyky/server/get/myProfile.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          EvData.myId = data.id;
          EvData.myAccessRights = data.accessRights;
          EvData.myData = data;
        },

        error: function() {
          alert("error");
        }
      });
    },
    updateEvent: function() {
      $.ajax({
        url: "../orlyky/server/get/event.php",
        type: "POST",
        dataType: "json",
        data: {
          id: EvData.eventId
        },

        success: function(data) {
          EvData.page = data.page;
          EvData.event = data.event;
        },

        error: function() {
          alert("error");
        }
      });
    }
  }
};
</script>

<style scoped>

</style>
