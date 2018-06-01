<template>
  <div id="Home"></div>
</template>

<script>
var HomeData = {
  myId: ""
};

export default {
  name: "Home",
  data: function() {
    return HomeData;
  },
  watch: {
    myId: function() {
      if (this.myId) {
        this.$router.push({ name: "profile", params: { id: this.myId } });
      } else {
        this.$router.push({ name: "RegLog" });
      }
      this.myId = "";
    }
  },
  mounted: function() {
    this.updateOrlykMyProfile();
  },
  methods: {
    updateOrlykMyProfile: function() {
      $.ajax({
        url: "../orlyky/server/get/myProfile.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          HomeData.myId = data.id;
        },

        error: function() {
          alert("error");
        }
      });
    }
  }
};
</script>
