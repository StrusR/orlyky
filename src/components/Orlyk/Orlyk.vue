<template>
  <div id="Orlyk" v-if="page">
      <section-header :myData="myData"></section-header>
      <section-article v-if="orlData" :orlData="orlData" :myId="myData.myId" :myAccessRights="myAccessRights"></section-article>
  </div>
</template>

<script>
var Header = require("../globals/Header/Header.vue");
var Article = require("../Orlyk/components//Article/Article.vue");

var OrlykData = {
  myId: "",
  myAccessRights: "",
  urlId: "",
  page: false,
  orlData: false,
  myData: ""
};

export default {
  name: "Orlyk",
  data: function() {
    return OrlykData;
  },
  components: {
    "section-header": Header,
    "section-article": Article
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
      if (this.page == false) {
        this.$router.push({ name: "profile", params: { id: this.myId } });
        this.page = false;
      }
    },
    $route(to, from) {
      this.updateOrlyk();
    }
  },
  created: function() {
    this.orlData = "";
    this.updateOrlykMyProfile();
    this.updateOrlyk();
  },
  methods: {
    updateOrlykMyProfile: function() {
      $.ajax({
        url: "../orlyky/server/get/myProfile.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          OrlykData.myId = data.id;
          OrlykData.myAccessRights = data.accessRights;
          OrlykData.myData = data;
        },

        error: function() {
          alert("error");
        }
      });
    },
    updateOrlyk: function() {
      OrlykData.urlId = this.$route.params.id;
      $.ajax({
        url: "../orlyky/server/get/orlyk.php",
        type: "POST",
        dataType: "json",
        data: {
          id: OrlykData.urlId
        },

        success: function(data) {
          if (data.page == true) {
            OrlykData.page = true;
            if (
              OrlykData.myAccessRights == "command" ||
              data.accessRights != "statement"
            ) {
              OrlykData.orlData = data;
            } else {
              OrlykData.page = false;
            }
          } else {
            OrlykData.page = false;
          }
        },

        error: function() {
          alert("error");
        }
      });
    }
  }
};
</script>
