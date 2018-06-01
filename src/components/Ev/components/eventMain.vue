<template>
    <article id="EventMain">
      <div class="navigation">
        <div class="sortIcons">
          <div class="icon main">
            <router-link class="active" :to="{ path: `/event/${this.$route.params.id}`}"></router-link>
          </div>
          <div class="icon plan">
            <a class="minHeader"></a>
          </div>
          <div class="icon estimate">
            <a></a>
          </div>
          <div class="icon menu">
            <router-link :to="{ path: `/event/${this.$route.params.id}/menu`}"></router-link>
          </div>
          <div class="icon inventory">
            <router-link :to="{ path: `/event/${this.$route.params.id}/inventory`}"></router-link>
          </div>
        </div>
      </div>
        <div class="leftCol tableContainer">
          <table class="participants">
            <tr v-for="(participant, pIndex) in participants" :key="'participant'+participant.user.id">
              <th class="name">{{participant.user.surname}} {{participant.user.name}}</th>
              <th :class="{tr: day, fl: !day}" v-for="(day, index) in participant.days" :key="'day'+participant.userId+'i'+index">
                <input :id="'input'+participant.user.id+'day'+index" type="checkbox" v-model="participant.days[index]">
                <label :for="'input'+participant.user.id+'day'+index">
                  <span v-if="!day">×</span>
                  <span v-if="day">+</span>
                </label>
              </th>
              <th class="space"></th>
              <th class="del" @click="deleteFriend(participants, pIndex)">×</th>
            </tr>
          </table>
        </div>
        <select v-if="selectedFriend" v-model="selectedFriend">
          <option :value="filteredFriend" v-for="filteredFriend in filteredFriends" :key="'filteredFriend'+filteredFriend.id">{{filteredFriend.surname}} {{filteredFriend.name}}</option>
        </select>
        <button v-if="selectedFriend" @click="pushFriend()">+</button>
        <button @click="saveEventParticipants()">Зберегти</button>
        
    </article>
</template>

<script>
var EventMainData = {
  participants: [],
  days: null,
  friends: null,

  filteredFriends: [],
  selectedFriend: null,
  up: null
};

export default {
  name: "EventMain",
  props: ["event"],
  data: function() {
    return EventMainData;
  },
  created: function() {
    var that = this;
    this.updateParticipants();
    // this.up = setInterval(() => {
    //   that.updateParticipants();
    // }, 1000);
  },
  destroyed: function() {
    clearInterval(this.up);
  },
  watch: {
    participants: function() {
      this.updateFilteredFriends();
    },
    friends: function() {
      this.updateFilteredFriends();
    }
  },
  methods: {
    updateParticipants: function() {
      var that = this;
      $.ajax({
        url: "../orlyky/server/get/eventParticipants.php",
        type: "POST",
        dataType: "json",
        data: {
          id: that.event.id
        },

        success: function(data) {
          that.participants = data.eventParticipants;
          that.days = data.days;
          that.friends = data.friends;
        }
      });
    },
    saveEventParticipants: function() {
      var that = this;
      $.ajax({
        url: "../orlyky/server/set/eventParticipants.php",
        type: "POST",
        dataType: "json",
        data: {
          id: that.event.id,
          eventParticipants: JSON.stringify(that.participants)
        },

        success: function(data) {
          that.updateParticipants();
        }
      });
    },
    updateFilteredFriends: function() {
      var that = this;
      this.filteredFriends = [];

      jQuery.each(that.friends, function(fKey, f) {
        var audit = true;
        jQuery.each(that.participants, function(pKey, p) {
          if (p.user.id == f.id) {
            audit = false;
          }
        });
        if (audit) {
          // if (that.search != "") {
          //   if (that.LowerCase(i.name).indexOf(that.search) !== -1) {
          //     that.filteredIngredients.push(i);
          //   }
          // } else {
          that.filteredFriends.push(f);
          // }
        }
      });
      this.selectedFriend = this.filteredFriends[0];
    },
    pushFriend: function() {
      var that = this;
      if (!this.participants) {
        this.participants = [];
      }
      var newP = {
        user: {
          id: that.selectedFriend.id,
          name: that.selectedFriend.name,
          surname: that.selectedFriend.surname
        },
        days: []
      };
      for (var i = 0; i < that.days; i++) {
        newP.days.push(true);
      }
      this.participants.push(newP);
    },
    deleteFriend: function(all, pIndex) {
      var that = this;
      if (all) {
        this.participants = [];
        jQuery.each(all, function(key, val) {
          if (key != pIndex) {
            that.participants.push(val);
          }
        });
      }
    }
  }
};
</script>

<style>
#EventMain > .navigation > .sortIcons > .icon.main:hover > a,
#EventMain > .navigation > .sortIcons > .icon.plan:hover > a,
#EventMain > .navigation > .sortIcons > .icon.estimate:hover > a,
#EventMain > .navigation > .sortIcons > .icon.menu:hover > a,
#EventMain > .navigation > .sortIcons > .icon.inventory:hover > a {
  margin-left: 2px;
}
#EventMain .icon.main > a {
  background-image: url("dist/img/eventIcons/home.png");
}
#EventMain .icon.plan > a {
  background-image: url("dist/img/eventIcons/plan.png");
}
#EventMain .icon.estimate > a {
  background-image: url("dist/img/eventIcons/estimate.png");
}
#EventMain .icon.menu > a {
  background-image: url("dist/img/eventIcons/menu.png");
}
#EventMain .icon.inventory > a {
  background-image: url("dist/img/eventIcons/inventory.png");
}

#EventMain > .tableContainer {
  background: none;
  width: auto;
}
#EventMain > .tableContainer > .participants {
  color: white;
  border-collapse: collapse;
}
#EventMain > .tableContainer > .participants > tr > th {
  border: 1px solid white;
  width: 25px;
  height: 25px;
}
#EventMain > .tableContainer > .participants > tr > th.name {
  width: 200px;
  text-align: left;
  padding-left: 1%;
  box-sizing: border-box;
}
#EventMain > .tableContainer > .participants > tr > th.space {
  width: 10px;
  border-top: none;
  border-bottom: none;
  border-right: none;
}
#EventMain > .tableContainer > .participants > tr > th.del {
  color: red;
  border: 1px solid red;
  cursor: pointer;
}
#EventMain > .tableContainer > .participants > tr > th > input {
  display: none;
}
#EventMain > .tableContainer > .participants > tr > th > label {
  display: inline-block;
  width: 100%;
  padding: 2px 0;
  /* height: 100%; */
}
#EventMain > .tableContainer > .participants > tr > th > label span {
  display: inline-block;
  width: 100%;
  height: 100%;
  cursor: pointer;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  -o-user-select: none;
  user-select: none;
}
#EventMain > .tableContainer > .participants > tr > th.tr {
  background: none;
}
#EventMain > .tableContainer > .participants > tr > th.fl {
  background: rgba(255, 0, 0, 0.167);
}
</style>
