<template>
    <div class="Links">
        <a>{{myData.name}} {{myData.surname}}</a>
        <a @click="SignOut">Вихід</a>
        <a>Новини</a>
    </div>
</template>

<script>
var LinksData = {
  session: ""
};
export default {
  name: "Links",
  props: ["myData"],
  data: function() {
    return LinksData;
  },
  watch: {
    session: function() {
      if (this.session == false) {
        this.$router.push({ name: "RegLog" });
        this.session = "";
      }
    }
  },
  methods: {
    SignOut: function() {
      $.ajax({
        url: "../orlyky/server/set/SignOut.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          LinksData.session = data.session;
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
.Links a {
  float: right;
  color: white;
  cursor: pointer;
  font-size: 1.3em;
  margin-left: 1%;
}

.Links a:first-child {
  float: left;
}
</style>
