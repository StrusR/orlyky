<template>
    <div id="Events">
        <section-header :myData="myData"></section-header>
        <section-article></section-article>
    </div>
</template>

<script>
var Header = require("../globals/Header/Header.vue");
var Article = require("../Events/components//Article/Article.vue");

var EventsData = {
  myId: "",
  myAccessRights: "",
  myData: ""
};

export default {
  name: "Events",
  components: {
    "section-header": Header,
    "section-article": Article
  },
  created: function() {
    this.updateMyProfile();
  },
  data: function() {
    return EventsData;
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
    }
  },
  methods: {
    updateMyProfile: function() {
      $.ajax({
        url: "../orlyky/server/get/myProfile.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          EventsData.myId = data.id;
          EventsData.myAccessRights = data.accessRights;
          EventsData.myData = data;
        },

        error: function() {
          alert("error");
        }
      });
    }
  }
};
</script>
