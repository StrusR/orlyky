<template>
  <div id="Friends">
    <div class="sort">sort</div>
    <div class="friends">
        <div v-for="friend in friends" :key="friend.id" class="friend">
            <router-link :to="{ name: 'profile', params: { id: friend.id }}">{{friend.surname}} {{friend.name}}</router-link>
            <div class="btn" v-if="friend.accessRights == 'statement'">
                <router-link :to="{ path: `/profile/${friend.id}/accept`}"></router-link>
                <router-link :to="{ path: `/profile/${friend.id}/regect`}"></router-link>
            </div>
        </div>
    </div>
  </div>
</template>

<script>
var FriendsData = {
  friends: ""
};
export default {
  name: "Friends",
  data: function() {
    return FriendsData;
  },
  props: ["orlData"],
  watch: {
    orlData: function() {
      if (this.orlData != false) {
        this.updateFriends();
      }
    }
  },
  created: function() {
    this.updateFriends();
  },
  // updated: function() {
  //   this.updateFriends();
  // },
  methods: {
    updateFriends: function() {
      $.ajax({
        url: "../orlyky/server/get/friends.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          FriendsData.friends = data;
        }
      });
    }
  }
};
</script>

<style>
#Friends {
  height: 100%;
}
#Friends .sort {
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
  top: 0;
}
#Friends .friends {
  overflow-y: auto;
  height: calc(100% - 100px);
  bottom: 0;
  width: 100%;
  height: 65vh;
}
#Friends .friends > .friend {
  padding: 2%;
  box-sizing: border-box;
  border-bottom: 1px solid rgb(227, 227, 227);
}
#Friends .friends > .friend::after {
  display: block;
  content: "";
  clear: both;
}
#Friends .friends > .friend > a {
  cursor: pointer;
  float: left;
  width: calc(100% - 50px);
}
#Friends .friends > .friend > a:hover {
  text-decoration: underline;
}
#Friends .friends > .friend > .btn {
  float: left;
  width: 50px;
  text-align: right;
}
#Friends .friends > .friend > .btn a {
  display: block;
  float: right;
  cursor: pointer;
  background-size: 20px 20px;
  width: 20px;
  height: 20px;
  margin-left: 5px;
}
#Friends .friends > .friend > .btn a:first-child {
  background-image: url("dist/img/accept.png");
}
#Friends .friends > .friend > .btn a:last-child {
  background-image: url("dist/img/reject.png");
}
</style>
