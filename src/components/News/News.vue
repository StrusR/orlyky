<template>
    <div id="News">
        <section-header :myData="myData"></section-header>
        <section-article></section-article>
    </div>
</template>

<script>
var Header = require("../globals/Header/Header.vue");
var Article = require("../News/components/Article/Article.vue");

var NewsData = {
  myId: "",
  myAccessRights: "",
  myData: ""
};

export default {
  name: "News",
  components: {
    "section-header": Header,
    "section-article": Article
  },
  created: function() {
    this.updateMyProfile();
  },
  data: function() {
    return NewsData;
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
    orlData: function() {
      if (this.orlData) {
      } else {
        this.$router.push({ name: "profile", params: { id: this.myId } });
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
          NewsData.myId = data.id;
          NewsData.myAccessRights = data.accessRights;
          NewsData.myData = data;
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
