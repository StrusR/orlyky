<template>
  <div id="Orlyk">
      <section-header></section-header>
      <section-article v-if="orlData" :orlData="orlData" :myId="myId"></section-article>
  </div>
</template>

<script>
var Header = require("../globals/Header/Header.vue");
var Article = require("../Orlyk/components//Article/Article.vue");

var OrlykData = {
  myId: false,
  urlId: "",
  page: true,
  myAccessRights: "",
  orlData: ""
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
      }
    },
    myAccessRights: function() {
      if (this.myAccessRights == "statement") {
        this.$router.push({ name: "Statement" });
      }
    },
    orlData: function() {
      if (this.orlData) {
      } else {
        this.$router.push({
          path: `/profile/${this.myId}`
        });
      }
    },
    page: function() {
      if (this.page == false) {
        this.$router.push({
          path: `/profile/${this.myId}`
        });
      }
    },
    $route(to, from) {
      this.updateOrlyk();
    }
  },
  created: function() {
    this.updateOrlyk();
  },
  methods: {
    updateOrlyk: function() {
      OrlykData.urlId = this.$route.params.id;
      OrlykData.page = true;
      $.ajax({
        url: "../orlyky/server/get/orlyk.php",
        type: "POST",
        dataType: "json",
        data: {
          id: OrlykData.urlId
        },

        success: function(data) {
          OrlykData.myId = data.myId;
          if (data.myAccessRights == "statement") {
            OrlykData.myAccessRights = data.myAccessRights;
          } else if (data.page == true) {
            if (data.myAccessRights == "command") {
              OrlykData.orlData = data;
            } else if (data.accessRights != "statement") {
              OrlykData.orlData = data;
            } else {
              OrlykData.orlData = false;
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

<style scoped>

</style>
