<template>
  <div id="RegLog" v-if="!myId">
      <section-header></section-header>
      <section-article></section-article>
  </div>
</template>

<script>
var RegLogHeader = require("../RegLog/components/RegLogHeader.vue");
var RegLogArticle = require("../RegLog/components/RegLogArticle.vue");

var RegLogData = {
  myId: true
};

export default {
  name: "RegLog",
  components: {
    "section-header": RegLogHeader,
    "section-article": RegLogArticle
  },
  data: function() {
    return RegLogData;
  },
  watch: {
    myId: function() {
      if (this.myId) {
        this.$router.push({ name: "profile", params: { id: this.myId } });
        this.myId = "";
      }
    }
  },
  created: function() {
    this.updateOrlykMyProfile();
  },
  methods: {
    updateOrlykMyProfile: function() {
      $.ajax({
        url: "../orlyky/server/get/myProfile.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          RegLogData.myId = data.id;
        },

        error: function() {
          alert("error");
        }
      });
    }
  }
};
</script>
