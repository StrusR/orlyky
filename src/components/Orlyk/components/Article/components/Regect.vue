<template>
  <div id="Regect" v-if="orlData.accessRights == 'statement' && myAccessRights == 'command'">
    <div class="minHeader">{{orlData.surname}} {{orlData.name}} {{orlData.patronymic}}</div>
    <div class="content">
        <h3>Вкажіть спосіб видалення користувача!</h3>
        <div class="radio">
            <a :class="{active: method=='voting'}" @click="method='voting'">
                <h4>Проголосувати</h4>
                <p>Тут ви вказуєте, що юнак не з вашого гуртка і ви його не знаєте, але він може бути учасником куреня. Якщо всі члени проводу проголосують так само, заявку буде відхилено. Якщо хоч хтось 1 з проводу підтвердить заявку, її буде прийнято. Вам ця заявка більше не буде відображатись, але відображатиметься всім членам проводу, хто ще не проголосував.</p>
            </a>
            <a :class="{active: method=='delete'}" @click="method='delete'">
                <h4>Видалити</h4>
                <p>Нерекомендований спосіб видалення користувача. Заявку буде відхилено без голосування. Використовувати, якщо ви точно впевнені, що реєстрація помилкова</p>
            </a>
        </div>
        <div class="btn">
            <a @click="Cancel">Відміна</a>
            <a @click="Voting(orlData.id)" v-if="method=='voting'">Проголосувати</a>
            <a @click="Regect(orlData.id)" v-else-if="method=='delete'">Видалити</a>
        </div>
    </div>
  </div>
</template>

<script>
var RegectData = {
  method: false,
  update: false
};
export default {
  name: "Regect",
  props: ["orlData", "myAccessRights"],
  data: function() {
    return RegectData;
  },
  watch: {
    update: function() {
      this.$router.push({ name: "profile", params: { id: this.update } });
      this.method = false;
      this.update = false;
    }
  },
  methods: {
    Regect: function(id) {
      $.ajax({
        url: "../orlyky/server/set/regectOrlyk.php",
        type: "POST",
        dataType: "json",
        data: {
          id: id
        },

        success: function(data) {
          if (data.response) {
            RegectData.update = data.response;
          } else {
            alert("false");
          }
        },

        error: function() {
          alert("error");
        }
      });
    },
    Voting: function(id) {
      $.ajax({
        url: "../orlyky/server/set/regectOrlykVoiting.php",
        type: "POST",
        dataType: "json",
        data: {
          id: id
        },

        success: function(data) {
          if (data.response) {
            RegectData.update = data.response;
          } else {
            alert("false");
          }
        },

        error: function() {
          alert("error");
        }
      });
    },

    Cancel: function() {
      this.update = this.orlData.id;
    }
  }
};
</script>

<style>
#Regect {
  background: white;
  box-shadow: -2px 2px 5px 0px black;
  position: fixed;
  top: 10%;
  left: 25%;
  width: 50%;
  z-index: 2;
}
#Regect .minHeader {
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  width: 100%;
  padding: 1%;
  box-sizing: border-box;
  color: white;
}
#Regect .content {
  padding-top: 3%;
}
#Regect .content h3 {
  padding: 1%;
  box-sizing: border-box;
  text-align: center;
  font-size: 1.5em;
}
#Regect .content .radio {
  display: flex;
  justify-content: space-around;
}
#Regect .content .radio a {
  cursor: pointer;
  box-shadow: -2px 2px 5px 0px black;
  margin-top: 1%;
  width: 30%;
}
#Regect .content .radio a:hover {
  box-shadow: -2px 2px 5px 0px rgb(138, 1, 1);
}
#Regect .content .radio a:hover h4 {
  background: linear-gradient(rgb(152, 0, 0) 20%, rgb(104, 0, 0));
}
#Regect .content .radio .active {
  box-shadow: -2px 2px 5px 0px rgb(0, 81, 0);
}
#Regect .content .radio .active h4 {
  background: linear-gradient(rgb(0, 108, 0) 20%, rgb(0, 81, 0));
}
#Regect .content .radio .active:hover {
  box-shadow: -2px 2px 5px 0px rgb(0, 121, 0);
}
#Regect .content .radio .active:hover h4 {
  background: linear-gradient(rgb(0, 108, 0) 20%, rgb(0, 121, 0));
}
#Regect .content .radio h4 {
  text-align: center;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  padding: 1%;
  box-sizing: border-box;
  color: white;
  font-size: 1.2em;
}
#Regect .content .radio p {
  padding: 1%;
  box-sizing: border-box;
}
#Regect .content .btn {
  display: flex;
  justify-content: space-between;
  padding: 1%;
  box-sizing: border-box;
  margin-top: 5%;
}
#Regect .content .btn a {
  padding: 1%;
  box-sizing: border-box;
  color: white;
  width: 120px;
  text-align: center;
  cursor: pointer;
}
#Regect .content .btn a:last-child {
  background: linear-gradient(rgb(0, 108, 0) 20%, rgb(0, 81, 0));
}
#Regect .content .btn a:last-child:hover {
  background: linear-gradient(rgb(0, 108, 0) 20%, rgb(0, 121, 0));
}
#Regect .content .btn a:first-child {
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
}
#Regect .content .btn a:first-child:hover {
  background: linear-gradient(rgb(152, 0, 0) 20%, rgb(104, 0, 0));
}
</style>
