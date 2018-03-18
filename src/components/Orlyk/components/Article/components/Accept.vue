<template>
  <div id="Accept" v-if="orlData.accessRights == 'statement' && myAccessRights == 'command'">
    <div class="minHeader">{{orlData.surname}} {{orlData.name}} {{orlData.patronymic}}</div>
    <div class="content">
        <h3>Вкажіть права користувача!</h3>
        <div class="radio">
            <a :class="{active: accessRights=='command'}" @click="accessRights='command'">
                <h4>Провід</h4>
                <p>Має всі права що і ви. Може приймати і видаляти заявки учасників, а також видаляти уже зареєстрованих учасників. Може створювати новини, завдання а також давати згоду на публікацію новини чи завдання учасників.</p>
            </a>
            <a :class="{active: accessRights=='participant'}" @click="accessRights='participant'">
                <h4>Учасник</h4>
                <p>Має обмежений доступ прав. Не може видаляти учасників, не може бачити заявки учасників,(навіть через url адресу). Може публікувати новину чи задання лише після схвалення її проводом.</p>
            </a>
        </div>
        <div class="btn">
            <a @click="Cancel">Відміна</a>
            <a @click="Accept(orlData.id, accessRights)" v-if="accessRights">Прийняти</a>
        </div>
    </div>
  </div>
</template>

<script>
var AcceptData = {
  myAccessRights: false,

  accessRights: false,
  update: false
};
export default {
  name: "Accept",
  props: ["orlData"],
  data: function() {
    return AcceptData;
  },
  updated: function() {
    this.updateMyProfile();
    if (this.orlData.accessRights != "statement") {
      this.update = true;
    }
  },
  watch: {
    update: function() {
      this.$router.push({ name: "profile", params: { id: this.orlData.id } });
      this.accessRights = false;
      this.update = false;
    }
  },
  methods: {
    updateMyProfile: function() {
      $.ajax({
        url: "../orlyky/server/get/myProfile.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          AcceptData.myAccessRights = data.accessRights;
        },

        error: function() {
          alert("error");
        }
      });
    },
    Accept: function(id, accessRights) {
      $.ajax({
        url: "../orlyky/server/set/acceptOrlyk.php",
        type: "POST",
        dataType: "json",
        data: {
          id: id,
          accessRights: accessRights
        },

        success: function(data) {
          if (data.response) {
            AcceptData.update = true;
          } else {
            alert("error");
          }
        },

        error: function() {
          alert("error");
        }
      });
    },

    Cancel: function() {
      this.update = true;
    }
  }
};
</script>

<style scoped>
#Accept {
  background: white;
  box-shadow: -2px 2px 5px 0px rgb(60, 0, 0);
  position: fixed;
  top: 10%;
  left: 25%;
  width: 50%;
  z-index: 2;
}
#Accept .minHeader {
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
  width: 100%;
  padding: 1%;
  box-sizing: border-box;
  color: white;
}
#Accept .content {
  padding-top: 3%;
}
#Accept .content h3 {
  padding: 1%;
  box-sizing: border-box;
  text-align: center;
  font-size: 1.5em;
}
#Accept .content .radio {
  display: flex;
  justify-content: space-around;
}
#Accept .content .radio a {
  cursor: pointer;
  box-shadow: -2px 2px 5px 0px rgb(60, 0, 0);
  margin-top: 1%;
  width: 30%;
}
#Accept .content .radio a:hover {
  box-shadow: -2px 2px 5px 0px rgb(138, 1, 1);
}
#Accept .content .radio a:hover h4 {
  background: linear-gradient(rgb(152, 0, 0) 20%, rgb(104, 0, 0));
}
#Accept .content .radio .active {
  box-shadow: -2px 2px 5px 0px rgb(0, 81, 0);
}
#Accept .content .radio .active h4 {
  background: linear-gradient(rgb(0, 108, 0) 20%, rgb(0, 81, 0));
}
#Accept .content .radio .active:hover {
  box-shadow: -2px 2px 5px 0px rgb(0, 121, 0);
}
#Accept .content .radio .active:hover h4 {
  background: linear-gradient(rgb(0, 108, 0) 20%, rgb(0, 121, 0));
}
#Accept .content .radio h4 {
  text-align: center;
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
  padding: 1%;
  box-sizing: border-box;
  color: white;
  font-size: 1.2em;
}
#Accept .content .radio p {
  padding: 1%;
  box-sizing: border-box;
}
#Accept .content .btn {
  display: flex;
  justify-content: space-between;
  padding: 1%;
  box-sizing: border-box;
  margin-top: 5%;
}
#Accept .content .btn a {
  padding: 1%;
  box-sizing: border-box;
  color: white;
  width: 100px;
  text-align: center;
  cursor: pointer;
}
#Accept .content .btn a:last-child {
  background: linear-gradient(rgb(0, 108, 0) 20%, rgb(0, 81, 0));
}
#Accept .content .btn a:last-child:hover {
  background: linear-gradient(rgb(0, 108, 0) 20%, rgb(0, 121, 0));
}
#Accept .content .btn a:first-child {
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
}
#Accept .content .btn a:first-child:hover {
  background: linear-gradient(rgb(152, 0, 0) 20%, rgb(104, 0, 0));
}
</style>
