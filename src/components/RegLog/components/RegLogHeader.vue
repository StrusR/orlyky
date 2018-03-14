<template>
  <header id="RegLogHeader">
    <section-logo></section-logo>
    <form id="loginComp" class="content">
        <p class="message" v-if="message">{{message}}</p>
        <input type="email" placeholder="Email або Телефон"  v-model="login">
        <input type="password" placeholder="Пароль" v-model="password">
        <input type="button" @click="SignIn" value="Увійти">
    </form>
  </header>
</template>

<script>
var LogoComponent = require("../../globals/logo.vue");

var RegLogHeaderData = {
  login: "",
  password: "",
  message: false
};
export default {
  name: "RegLogHeader",
  data: function() {
    return RegLogHeaderData;
  },
  components: {
    "section-logo": LogoComponent
  },
  methods: {
    SignIn: function() {
      alert("SignIn");
    }
  }
};
</script>

<style scoped>
#RegLogHeader {
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
  padding: 1%;
  box-sizing: border-box;
  position: fixed;
  width: 100%;
  top: 0;
}
#RegLogHeader::after {
  display: block;
  content: "";
  clear: both;
}
#RegLogHeader form {
  float: right;
  width: 70%;
  text-align: right;
}
#RegLogHeader form input {
  padding: 0.4%;
  box-sizing: border-box;
  border: none;
  margin-left: 0.3%;
}
#RegLogHeader form input:-webkit-autofill {
  -webkit-box-shadow: 0 0 0 1000px white inset !important;
}
#RegLogHeader form input[type="button"] {
  cursor: pointer;
  padding-left: 2%;
  padding-right: 2%;
}

#RegLogHeader form p {
  display: inline;
  padding: 0.4%;
  box-sizing: border-box;
  margin-left: 0.3%;
  color: white;
}
</style>
