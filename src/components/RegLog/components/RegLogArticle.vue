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
            <input v-model.trim="RePasswordVal" autocomplete="on" name="RePassword" id="RePassword" type="password"  placeholder="Повторіть пароль" :class="{checkNotPassed: RePasswordLabel}">
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
    capitalizeFirstLetter: function(string) {
      string = string.toLowerCase();
      return string.charAt(0).toUpperCase() + string.slice(1);
    },
    register: function() {
      var regular_email = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      var regular_name_surname_patronymic = /^[йцукенгшщзхїфівапролджєячсмитьбюЙЦУКЕНГШЩЗХЇФІВАПРОЛДЖЄЯЧСМИТЬБЮ]+$/;
      var regular_phone = /^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){12}(\s*)?$/;
      var regular_password = /(?=.*[0-9])(?=.*[_a-zA-ZйцукенгшщзхїфівапролджєячсмитьбюЙЦУКЕНГШЩЗХЇФІВАПРОЛДЖЄЯЧСМИТЬБЮ])/;

      var email = false;
      var name = false;
      var surname = false;
      var patronymic = false;
      var phone = false;
      var password = false;
      var rePassword = false;

      this.NameVal = this.capitalizeFirstLetter(this.NameVal);
      this.SurnameVal = this.capitalizeFirstLetter(this.SurnameVal);
      this.PatronymicVal = this.capitalizeFirstLetter(this.PatronymicVal);

      if (this.EmailVal.length < 1) {
        this.EmailLabel =
          "Email потрібно ввести для подальшої можливості входу";
      } else if (regular_email.test(this.EmailVal) == false) {
        this.EmailLabel = "Введіть дійсний Email";
      } else {
        email = true;
        this.EmailLabel = false;
      }
      // ********************************************************************************************
      if (this.NameVal.length < 1) {
        this.NameLabel = "Введіть своє ім'я";
      } else if (regular_name_surname_patronymic.test(this.NameVal) == false) {
        this.NameLabel = "Ім'я вводити лише українськими літерами";
      } else {
        name = true;
        this.NameLabel = false;
      }
      // ********************************************************************************************
      if (this.SurnameVal.length < 1) {
        this.SurnameLabel = "Введіть своє прізвище";
      } else if (
        regular_name_surname_patronymic.test(this.SurnameVal) == false
      ) {
        this.SurnameLabel = "Прізвище вводити лише українськими літерами";
      } else {
        surname = true;
        this.SurnameLabel = false;
      }
      // ********************************************************************************************
      if (this.PatronymicVal.length < 1) {
        this.PatronymicLabel = "Введіть своє ім'я по батькові";
      } else if (
        regular_name_surname_patronymic.test(this.PatronymicVal) == false
      ) {
        this.PatronymicLabel =
          "Ім'я по батькові вводити лише українськими літерами";
      } else {
        patronymic = true;
        this.PatronymicLabel = false;
      }
      // ********************************************************************************************
      if (this.PhonelVal.length < 1) {
        this.PhoneLabel =
          "Вкажіть свій номер телефону, щоб ми могли з вами зв'язатися";
      } else if (regular_phone.test(this.PhonelVal) == false) {
        this.PhoneLabel = "Введіть дійсний номер телефону";
      } else {
        phone = true;
        this.PhoneLabel = false;
      }
      // ********************************************************************************************
      if (this.PasswordVal.length < 1) {
        this.PasswordLabel =
          "Цей парроль ви використовуватимете для подальшого входу в аккаунт";
      } else if (this.PasswordVal.length < 8) {
        this.PasswordLabel = "Пароль має містити не менше 8 символів";
      } else if (regular_password.test(this.PasswordVal) == false) {
        this.PasswordLabel =
          "Пароль обов'язково має місти одну велику букву одну маленьку одну 1 цифру";
      } else {
        password = true;
        this.PasswordLabel = false;
      }
      // ********************************************************************************************
      if (this.RePasswordVal.length < 1) {
        this.RePasswordLabel =
          "Повторіть пароль, щоб переконатись, що ви не помилились";
      } else if (this.PasswordVal != this.RePasswordVal) {
        this.RePasswordLabel = "Паролі не співпадають";
      } else {
        rePassword = true;
        this.RePasswordLabel = false;
      }
      // ********************************************************************************************
      if (
        email == true &&
        name == true &&
        surname == true &&
        patronymic == true &&
        phone == true &&
        password == true &&
        rePassword == true
      ) {
        $.ajax({
          url: "../orlyky/server/set/register.php",
          type: "POST",
          dataType: "json",
          data: {
            email: this.inputs.regEmail.val,
            name: this.inputs.regName.val,
            surname: this.inputs.regSurname.val,
            patronymic: this.inputs.regPatronymic.val,
            phone: this.inputs.regPhone.val,
            password: this.inputs.regPassword.val,
            rePassword: this.inputs.regRePassword.val
          },

          success: function(data) {
            if (!data.errorRegEx) {
              if (data.errorEmail) {
                registerData.inputs.regEmail.label =
                  "Цей Email уже зареєстроований";
              }

              if (data.errorPhone) {
                registerData.inputs.regPhone.label =
                  "Цей номер телефону уже зареєстроований";
              }

              if (data.id) {
                document.cookie = "orlykId=" + data.id;

                window.location.reload();
              }
            } else {
              alert("errorRegEx");
            }
          },

          error: function() {
            alert("error");
          }
        });
      }
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
