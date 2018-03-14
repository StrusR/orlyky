<template>
  <div id="RegLogArticle">
    <form autocomplete="on">
        <div>
            <h2>Реєстрація</h2>
        </div>
        <div class="inputBlock">
            <input v-model.trim="EmailVal" autocomplete="on" name="Email" id="Email" type="email"  placeholder="Email" :class="{checkNotPassed: EmailLabel}">
            <label v-if="EmailLabel" for="Email" :title="EmailLabel">!</label>
        </div>
        <div class="inputBlock">
            <input v-model.trim="SurnameVal" autocomplete="on" name="Surname" id="Surname" type="text"  placeholder="Прізвище" :class="{checkNotPassed: SurnameLabel}" class="capitalizeFirstLetter">
            <label v-if="SurnameLabel" for="Surname" :title="SurnameLabel">!</label>
        </div>
        <div class="inputBlock">
            <input v-model.trim="NameVal" autocomplete="on" name="Name" id="Name" type="text"  placeholder="Ім'я" :class="{checkNotPassed: NameLabel}" class="capitalizeFirstLetter">
            <label v-if="NameLabel" for="Name" :title="NameLabel">!</label>
        </div>
        <div class="inputBlock">
            <input v-model.trim="PatronymicVal" autocomplete="on" name="Patronymic" id="Patronymic" type="text"  placeholder="По-батькові" :class="{checkNotPassed: PatronymicLabel}" class="capitalizeFirstLetter">
            <label v-if="PatronymicLabel" for="Patronymic" :title="PatronymicLabel">!</label>
        </div>
        <div class="inputBlock">
            <input v-model.trim="PhonelVal" autocomplete="on" name="Phone" id="Phone" type="text"  placeholder="Номер телефону" :class="{checkNotPassed: PhoneLabel}">
            <label v-if="PhoneLabel" for="Phone" :title="PhoneLabel">!</label>
        </div>
        <div class="inputBlock">
            <input v-model.trim="PasswordVal" autocomplete="on" name="Password" id="Password" type="password"  placeholder="Пароль" :class="{checkNotPassed: PasswordLabel}">
            <label v-if="PasswordLabel" for="Password" :title="PasswordLabel">!</label>
        </div>
        <div class="inputBlock">
            <input v-model.trim="RePasswordlVal" autocomplete="on" name="RePassword" id="RePassword" type="password"  placeholder="Повторіть пароль" :class="{checkNotPassed: RePasswordLabel}">
            <label v-if="RePasswordLabel" for="RePassword" :title="RePasswordLabel">!</label>
        </div>
        <div>
            <input value="Зареєструватися" type="button" @click="register">
        </div>
    </form>
  </div>
</template>

<script>
var LogoComponent = require("../../globals/logo.vue");

var RegLogArticleData = {
  EmailVal: "",
  SurnameVal: "",
  NameVal: "",
  PatronymicVal: "",
  PhonelVal: "",
  PasswordVal: "",
  RePasswordVal: "",

  EmailLabel: false,
  SurnameLabel: false,
  NameLabel: false,
  PatronymicLabel: false,
  PhoneLabel: false,
  PasswordLabel: false,
  RePasswordLabel: false
};
export default {
  name: "RegLogArticle",
  data: function() {
    return RegLogArticleData;
  },
  methods: {
    register: function() {
      alert("register");
    }
  }
};
</script>

<style scoped>
#RegLogArticle {
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
  color: white;
  width: 50%;
  margin: auto;
  margin-top: 7%;
  text-align: center;
  padding: 2%;
  box-sizing: border-box;
}
#RegLogArticle form {
  width: 50%;
  margin: auto;
}
#RegLogArticle form div {
  position: relative;
  margin-top: 1%;
  height: 40px;
}
#RegLogArticle form div input {
  box-shadow: -2px 2px 5px 0px rgb(60, 0, 0);
  padding: 1%;
  padding-left: 2%;
  padding-right: 10%;
  border: none;
  box-sizing: border-box;
  width: 100%;
  height: 100%;
  border-radius: 3px;
}
#RegLogArticle form div .capitalizeFirstLetter {
  text-transform: capitalize;
}
#RegLogArticle form div .checkNotPassed {
  border: 1px solid red;
}
#RegLogArticle form div label {
  float: left;
  border: 1px solid red;
  color: red;
  border-radius: 50%;
  position: absolute;
  right: 5px;
  top: 7px;
  box-sizing: border-box;
  font-weight: bold;
  font-size: 1.2em;
  height: 26px;
  width: 26px;
  cursor: pointer;
}
#RegLogArticle form div input[type="button"] {
  margin-top: 1%;
  width: auto;
  padding-left: 2.5%;
  padding-right: 2.5%;
  cursor: pointer;
  background: linear-gradient(green, rgb(0, 52, 0));
  color: white;
}
</style>
