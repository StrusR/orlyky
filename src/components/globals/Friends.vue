<template>
  <div id="Friends">
    <div class="sort">sort</div>
    <div class="content">
        <div v-for="friend in friends" :key="friend.id" class="friend">
            <router-link :to="{ name: 'profile', params: { id: friend.id }}">{{friend.surname}} {{friend.name}}</router-link>
            <div class="btn" v-if="friend.accessRights == 'statement'">
                <a @click="updateAccept(friend.id)"></a>
                <a @click="Reject(friend.id)"></a>
            </div>
        </div>
    </div>
    <section-background-close v-if="orlData" v-on:backgroundClick="close"></section-background-close>
    <section-accept :orlData="orlData" v-on:backgroundClick="close" ref="accept"></section-accept>
  </div>
</template>

<script>
var BackgroundClose = require("../globals/BackgroundClose.vue");
var Accept = require("../globals/Accept.vue");

var FriendsData = {
  friends: "",
  orlData: false
};
export default {
  name: "Friends",
  data: function() {
    return FriendsData;
  },
  watch: {
    orlData: function() {
      if (this.orlData != false) {
        this.$router.push({ name: "profile", params: { id: this.orlData.id } });
      }
    }
  },
  components: {
    "section-background-close": BackgroundClose,
    "section-accept": Accept
  },
  created: function() {
    this.updateFriends();
  },
  methods: {
    updateFriends: function() {
      $.ajax({
        url: "../orlyky/server/get/friends.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          FriendsData.friends = data;
        },

        error: function() {
          alert("error");
        }
      });
    },
    close: function() {
      this.$refs.accept.accessRights = false;
      this.$refs.accept.isColorAnimation = false;
      this.$router.push({ name: "profile", params: { id: this.orlData.id } });
      this.orlData = false;
    },

    Reject: function(id) {
      alert(id);
    },
    updateAccept: function(id) {
      $.ajax({
        url: "../orlyky/server/get/orlyk.php",
        type: "POST",
        dataType: "json",
        data: {
          id: id
        },

        success: function(data) {
          FriendsData.orlData = data;
        }
      });
    }
  }
};
</script>

<style scoped>
#Friends {
  height: 100%;
}
#Friends .sort {
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
  color: white;
  top: 0;
}
#Friends .content {
  overflow-y: auto;
  height: calc(100% - 100px);
  bottom: 0;
  width: 100%;
}
#Friends .content > .friend {
  padding: 2%;
  box-sizing: border-box;
  border-bottom: 1px solid rgb(227, 227, 227);
}
#Friends .content > .friend::after {
  display: block;
  content: "";
  clear: both;
}
#Friends .content > .friend > a {
  cursor: pointer;
  float: left;
  width: calc(100% - 50px);
}
#Friends .content > .friend > a:hover {
  text-decoration: underline;
}
#Friends .content > .friend > .btn {
  float: left;
  width: 50px;
  text-align: right;
}
#Friends .content > .friend > .btn a {
  display: block;
  float: right;
  cursor: pointer;
  background-size: 20px 20px;
  width: 20px;
  height: 20px;
  margin-left: 5px;
}
#Friends .content > .friend > .btn a:first-child {
  background-image: url("dist/img/accept.png");
}
#Friends .content > .friend > .btn a:last-child {
  background-image: url("dist/img/reject.png");
}
</style>
