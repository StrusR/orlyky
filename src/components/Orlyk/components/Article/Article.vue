<template>
    <article id="OrlykArticle">
        <div class="leftCol">
            <div class="baner">
                <p class="int">{{orlData.surname}} {{orlData.name}} {{orlData.patronymic}}</p>
                <a @click="Settings" v-if="orlData.myAccessRights=='command' && $route.params.id!=myId" class="settings"></a>
            </div>
            <div class="content">
                <div class="row">
                    <div class="leftCol">Email:</div>
                    <div class="rightCol">{{orlData.email}}</div>
                </div>
                <div class="row">
                    <div class="leftCol">Номер телефону:</div>
                    <div class="rightCol">+{{orlData.phone}}</div>
                </div>
            </div>
        </div>
    </article>
</template>

<script>
export default {
  name: "Article",
  props: ["orlData", "myId"],
  methods: {
    Settings: function() {
      //   updateOrlykSettings(this.id);
    }
  },
  components: {}
};
</script>

<style scoped>
#OrlykArticle {
  margin-top: 7%;
}
#OrlykArticle {
  box-shadow: -2px 2px 5px 0px rgb(60, 0, 0);
  height: 100%;
}

#OrlykArticle .baner {
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
  color: white;
  position: relative;
}

#OrlykArticle .baner .int {
  position: absolute;
  bottom: 10px;
  left: 10px;
  font-size: 1.5em;
  font-weight: bold;
}

#OrlykArticle .baner .settings {
  display: block;
  position: absolute;
  top: 10px;
  right: 10px;
  background-image: url("dist/img/settings.png");
  background-size: 20px 20px;
  width: 20px;
  height: 20px;
  cursor: pointer;
}

#OrlykArticle .content > .row {
  padding: 2%;
  box-sizing: border-box;
  width: 100%;
  border-bottom: 1px solid rgb(60, 0, 0);
}

#OrlykArticle .content > .row::after {
  content: "";
  clear: both;
  display: block;
}

#OrlykArticle .content > .row > .leftCol {
  width: 30%;
  float: left;
}

#OrlykArticle .content > .row > .rightCol {
  width: 70%;
  float: left;
}
</style>
