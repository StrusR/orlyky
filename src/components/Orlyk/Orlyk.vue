<template>
  <div id="Orlyk">
      <section-header></section-header>
      <section-article v-if="orlData" :orlData="orlData"></section-article>
  </div>
</template>

<script>
var Header = require("../globals/Header/Header.vue");
var Article = require("../Orlyk/components/Article.vue");

var OrlykData = {
  myId: true,
  urlId: "",
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
        this.$router.push({ name: "Orlyk", params: { id: this.myId } });
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
      $.ajax({
        url: "../orlyky/server/get/orlyk.php",
        type: "POST",
        dataType: "json",
        data: {
          id: OrlykData.urlId
        },

        success: function(data) {
          if (data.myId == false) {
            OrlykData.myId = false;
          } else {
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
            }
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
