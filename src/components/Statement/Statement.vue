<template>
  <div id="Statement">
      <div class="message">
            <p>Ваша заявка розглядається проводом куреня.</p>
            <p>Це може заяняти декілька днів</p>
            <a @click="SignOut">Вихід</a>
      </div>
  </div>
</template>

<script>
var StatementData = {
  session: ""
};
export default {
  name: "Statement",
  data: function() {
    return StatementData;
  },
  watch: {
    session: function() {
      if (this.session == false) {
        this.$router.push({ name: "RegLog" });
      } else {
        alert("error");
      }
      this.session = "";
    }
  },
  methods: {
    SignOut: function() {
      $.ajax({
        url: "../orlyky/server/set/SignOut.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          StatementData.session = data.session;
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
