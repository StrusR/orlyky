<template>
    <div id="Ingredients">
        <section-header :myData="myData"></section-header>
        <section-article></section-article>
    </div>
</template>

<script>
var Header = require("../globals/Header/Header.vue");
var Article = require("../Ingredients/components/Article.vue");

var DishesData = {
  myId: "",
  myAccessRights: "",
  myData: ""
};

export default {
  name: "Ingredients",
  components: {
    "section-header": Header,
    "section-article": Article
  },
  data: function() {
    return DishesData;
  },
  created: function() {
    this.updateMyProfile();
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
          DishesData.myId = data.id;
          DishesData.myAccessRights = data.accessRights;
          DishesData.myData = data;
        },

        error: function() {
          alert("error");
        }
      });
    }
  }
};
</script>
