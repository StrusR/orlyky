<template>
    <article id="EventMenu">
      <div class="navigation">
        <div class="sortIcons">
          <div class="icon main">
            <router-link :to="{ path: `/event/${this.$route.params.id}`}"></router-link>
          </div>
          <div class="icon plan">
            <a></a>
          </div>
          <div class="icon estimate">
            <a></a>
          </div>
          <div class="icon menu">
            <router-link class="active" :to="{ path: `/event/${this.$route.params.id}/menu`}"></router-link>
          </div>
          <div class="icon inventory">
            <router-link :to="{ path: `/event/${this.$route.params.id}/inventory`}"></router-link>
          </div>
        </div>
      </div>
      <div class="leftCol days" v-if="days">
        <div class="day" v-for="(day, dindex) in days" :key="'day'+day.day">
          <div class="minHeader" @click="selectDay(day.day)">День {{day.day}}</div>
          <div class="content">
            <div class="time" v-for="(time, tindex) in day.times" :key="'time'+time.id" @click="selectTime(day.day, dindex, time.hour, time.minute, tindex)">

              <div class="hour">
                <div v-if="time.hour >= 5 && time.hour < 12">Сніданок {{hours[time.hour]}}:{{minutes[time.minute/5]}}</div>
                <div v-else-if="time.hour >= 13 && time.hour < 17">Обід {{hours[time.hour]}}:{{minutes[time.minute/5]}}</div>
                <div v-else>Вечеря {{hours[time.hour]}}:{{minutes[time.minute/5]}}</div>
              </div>
              
              <ul v-if="time.dishes">
                <li v-for="(dish, index) in time.dishes.breakfasts" :key="'time'+time.id+'breakfasts'+index">{{dish.name}}</li>
                <li v-for="(dish, index) in time.dishes.firstDishes" :key="'time'+time.id+'firstDishes'+index">{{dish.name}}</li>
                <li v-for="(dish, index) in time.dishes.mainDishes" :key="'time'+time.id+'mainDishes'+index">{{dish.name}}</li>
                <li v-for="(dish, index) in time.dishes.garnishes" :key="'time'+time.id+'garnishes'+index">{{dish.name}}</li>
                <li v-for="(dish, index) in time.dishes.salads" :key="'time'+time.id+'salads'+index">{{dish.name}}</li>
                <li v-for="(dish, index) in time.dishes.appetizers" :key="'time'+time.id+'appetizers'+index">{{dish.name}}</li>
                <li v-for="(dish, index) in time.dishes.drinks" :key="'time'+time.id+'drinks'+index">{{dish.name}}</li>
                <li v-for="(dish, index) in time.dishes.sweets" :key="'time'+time.id+'sweets'+index">{{dish.name}}</li>
              </ul>
              
            </div>
          </div>
        </div>
      </div>

      <div class="rightCol">
        <div class="minHeader">
          <p>{{selectedDay}} день</p>
          <h2 v-if="rightCol == 'addTime'">Додати сніданок обід чи вечерю</h2>
          <h2 v-if="rightCol == 'changeTime'">
            <p v-if="selectedHour >= 5 && selectedHour < 12">Змінити сніданок</p>
            <p v-else-if="selectedHour >= 13 && selectedHour < 17">Змінити обід</p>
            <p v-else>Змінити вечерю</p>
          </h2>
          <div class="selectedTime">{{hours[selectedHour]}}:{{minutes[selectedMinute/5]}}</div>
        </div>

        <select class="time" v-model="selectedNewHour">
          <option :value="index" v-for="(hour, index) in hours" :key="'createTimeHour'+index">{{hour}}</option>
        </select>
        <select class="time" v-model="selectedNewMinute">
          <option :value="parseInt(minute)" v-for="(minute, index) in minutes" :key="'createTimeMinute'+index">{{minute}}</option>
        </select>

        <div class="sortPanel">
          <div class="sortIcons">
            <div class="icon breakfasts" @click="activeGroup=1"><div :class="{active: activeGroup==1}"></div></div>
            <div class="icon firstDishes" @click="activeGroup=2"><div :class="{active: activeGroup==2}"></div></div>
            <div class="icon mainDishes" @click="activeGroup=3"><div :class="{active: activeGroup==3}"></div></div>
            <div class="icon garnishes" @click="activeGroup=4"><div :class="{active: activeGroup==4}"></div></div>
            <div class="icon salads" @click="activeGroup=5"><div :class="{active: activeGroup==5}"></div></div>
            <div class="icon appetizer" @click="activeGroup=6"><div :class="{active: activeGroup==6}"></div></div>
            <div class="icon drinks" @click="activeGroup=7"><div :class="{active: activeGroup==7}"></div></div>
            <div class="icon sweets" @click="activeGroup=8"><div :class="{active: activeGroup==8}"></div></div>
          </div>
        </div>

        <select v-if="activeGroup==1" class="dishes" v-model="selectedBreakfast" multiple>
          <option :value="breakfast.id" v-for="(breakfast, index) in dishes['breakfast']" :key="'breakfast'+index">{{breakfast.name}}</option>
        </select>
        <select v-if="activeGroup==2" class="dishes" v-model="selectedFirstDish" multiple>
          <option :value="firstDish.id" v-for="(firstDish, index) in dishes['firstDish']" :key="'firstDish'+index">{{firstDish.name}}</option>
        </select>
        <select v-if="activeGroup==3" class="dishes" v-model="selectedMainDish" multiple>
          <option :value="mainDish.id" v-for="(mainDish, index) in dishes['mainDish']" :key="'mainDish'+index">{{mainDish.name}}</option>
        </select>
        <select v-if="activeGroup==4" class="dishes" v-model="selectedGarnish" multiple>
          <option :value="garnish.id" v-for="(garnish, index) in dishes['garnish']" :key="'garnish'+index">{{garnish.name}}</option>
        </select>
        <select v-if="activeGroup==5" class="dishes" v-model="selectedSalad" multiple>
          <option :value="salad.id" v-for="(salad, index) in dishes['salad']" :key="'salad'+index">{{salad.name}}</option>
        </select>
        <select v-if="activeGroup==6" class="dishes" v-model="selectedAppetizer" multiple>
          <option :value="appetizer.id" v-for="(appetizer, index) in dishes['appetizer']" :key="'appetizer'+index">{{appetizer.name}}</option>
        </select>
        <select v-if="activeGroup==7" class="dishes" v-model="selectedDrink" multiple>
          <option :value="drink.id" v-for="(drink, index) in dishes['drink']" :key="'drink'+index">{{drink.name}}</option>
        </select>
        <select v-if="activeGroup==8" class="dishes" v-model="selectedSweet" multiple>
          <option :value="sweet.id" v-for="(sweet, index) in dishes['sweet']" :key="'sweet'+index">{{sweet.name}}</option>
        </select>
        <button @click="addTime" v-if="rightCol == 'addTime'">Додати</button>
        <button @click="changeTime" v-if="rightCol == 'changeTime'">Змінити</button>
        <button @click="deleteTime" v-if="rightCol == 'changeTime'">Видалити</button>
      </div>

    </article>
</template>

<script>
var EventMenuData = {
  days: '',
  dishes: '',

  eventId: '',

  rightCol: 'addTime',

  selectedDay: 1,
  selectedHour: 7,
  selectedMinute: 0,

  activeGroup: 1,

  selectedNewHour: 7,
  selectedNewMinute: 0,

  selectedBreakfast: [],
  selectedFirstDish: [],
  selectedMainDish: [],
  selectedGarnish: [],
  selectedSalad: [],
  selectedAppetizer: [],
  selectedDrink: [],
  selectedSweet: [],

  update: false,

  hours: [
    '00',
    '01',
    '02',
    '03',
    '04',
    '05',
    '06',
    '07',
    '08',
    '09',
    '10',
    '11',
    '12',
    '13',
    '14',
    '15',
    '16',
    '17',
    '18',
    '19',
    '20',
    '21',
    '22',
    '23',
  ],
  minutes: [
    '00',
    '05',
    '10',
    '15',
    '20',
    '25',
    '30',
    '35',
    '40',
    '45',
    '50',
    '55',
  ],

  up: null,
};

export default {
  name: 'EventMenu',
  data: function() {
    return EventMenuData;
  },
  created: function() {
    var that = this;
    this.eventId = this.$route.params.id;

    this.updateMenu();
    this.updateDishes();

    this.up = setInterval(() => {
      that.updateMenu();
      that.updateDishes();
    }, 1000);
  },
  destroyed: function() {
    clearInterval(this.up);
  },
  watch: {
    update: function() {
      this.updateMenu();
      this.update = false;
    },
  },
  methods: {
    updateMenu: function() {
      $.ajax({
        url: '../orlyky/server/get/menu.php',
        type: 'POST',
        dataType: 'json',
        data: {
          id: EventMenuData.eventId,
        },

        success: function(data) {
          EventMenuData.days = data.days;
        },
      });
    },
    updateDishes: function() {
      $.ajax({
        url: '../orlyky/server/get/dishes.php',
        type: 'POST',
        dataType: 'json',
        data: {
          ret: 'names',
        },

        success: function(data) {
          EventMenuData.dishes = data.dishes;
        },

        error: function() {
          alert('error');
        },
      });
    },
    selectDay: function(day) {
      this.rightCol = 'addTime';
      this.selectedDay = day;
      this.selectedNewHour = 7;
      this.selectedNewMinute = 0;
      this.selectedHour = 7;
      this.selectedMinute = 0;
      this.selectedBreakfast = [];
      this.selectedFirstDish = [];
      this.selectedMainDish = [];
      this.selectedGarnish = [];
      this.selectedSalad = [];
      this.selectedAppetizer = [];
      this.selectedDrink = [];
      this.selectedSweet = [];
    },
    selectTime: function(day, dayIndex, hour, minute, time) {
      this.rightCol = 'changeTime';
      this.selectedDay = day;
      this.selectedNewHour = hour;
      this.selectedNewMinute = minute;
      this.selectedHour = hour;
      this.selectedMinute = minute;
      this.selectedBreakfast = [];
      this.selectedFirstDish = [];
      this.selectedMainDish = [];
      this.selectedGarnish = [];
      this.selectedSalad = [];
      this.selectedAppetizer = [];
      this.selectedDrink = [];
      this.selectedSweet = [];
      if (this.days[dayIndex].times[time].dishes.breakfasts) {
        for (
          var i = 0;
          i < this.days[dayIndex].times[time].dishes.breakfasts.length;
          i++
        ) {
          this.selectedBreakfast.push(
            this.days[dayIndex].times[time].dishes.breakfasts[i].id
          );
        }
      }
      if (this.days[dayIndex].times[time].dishes.firstDishes) {
        for (
          var i = 0;
          i < this.days[dayIndex].times[time].dishes.firstDishes.length;
          i++
        ) {
          this.selectedFirstDish.push(
            this.days[dayIndex].times[time].dishes.firstDishes[i].id
          );
        }
      }
      if (this.days[dayIndex].times[time].dishes.mainDishes) {
        for (
          var i = 0;
          i < this.days[dayIndex].times[time].dishes.mainDishes.length;
          i++
        ) {
          this.selectedMainDish.push(
            this.days[dayIndex].times[time].dishes.mainDishes[i].id
          );
        }
      }
      if (this.days[dayIndex].times[time].dishes.garnishes) {
        for (
          var i = 0;
          i < this.days[dayIndex].times[time].dishes.garnishes.length;
          i++
        ) {
          this.selectedGarnish.push(
            this.days[dayIndex].times[time].dishes.garnishes[i].id
          );
        }
      }
      if (this.days[dayIndex].times[time].dishes.salads) {
        for (
          var i = 0;
          i < this.days[dayIndex].times[time].dishes.salads.length;
          i++
        ) {
          this.selectedSalad.push(
            this.days[dayIndex].times[time].dishes.salads[i].id
          );
        }
      }
      if (this.days[dayIndex].times[time].dishes.appetizers) {
        for (
          var i = 0;
          i < this.days[dayIndex].times[time].dishes.appetizers.length;
          i++
        ) {
          this.selectedAppetizer.push(
            this.days[dayIndex].times[time].dishes.appetizers[i].id
          );
        }
      }
      if (this.days[dayIndex].times[time].dishes.drinks) {
        for (
          var i = 0;
          i < this.days[dayIndex].times[time].dishes.drinks.length;
          i++
        ) {
          this.selectedDrink.push(
            this.days[dayIndex].times[time].dishes.drinks[i].id
          );
        }
      }
      if (this.days[dayIndex].times[time].dishes.sweets) {
        for (
          var i = 0;
          i < this.days[dayIndex].times[time].dishes.sweets.length;
          i++
        ) {
          this.selectedSweet.push(
            this.days[dayIndex].times[time].dishes.sweets[i].id
          );
        }
      }
    },
    addTime: function() {
      $.ajax({
        url: '../orlyky/server/set/addTime.php',
        type: 'POST',
        dataType: 'json',
        data: {
          id: EventMenuData.eventId,
          day: EventMenuData.selectedDay,
          hour: EventMenuData.selectedNewHour,
          minute: EventMenuData.selectedNewMinute,
          type: 'menu',
          dishes: JSON.stringify(
            EventMenuData.selectedBreakfast.concat(
              EventMenuData.selectedFirstDish,
              EventMenuData.selectedMainDish,
              EventMenuData.selectedGarnish,
              EventMenuData.selectedSalad,
              EventMenuData.selectedAppetizer,
              EventMenuData.selectedDrink,
              EventMenuData.selectedSweet
            )
          ),
        },

        success: function(data) {
          EventMenuData.update = data.response;
          if (data.response) {
            EventMenuData.rightCol = 'changeTime';
            EventMenuData.selectedHour = EventMenuData.selectedNewHour;
            EventMenuData.selectedMinute = EventMenuData.selectedNewMinute;
          }
        },

        error: function() {
          alert('error');
        },
      });
    },
    changeTime: function() {
      $.ajax({
        url: '../orlyky/server/set/changeTime.php',
        type: 'POST',
        dataType: 'json',
        data: {
          id: EventMenuData.eventId,
          day: EventMenuData.selectedDay,
          hour: EventMenuData.selectedHour,
          minute: EventMenuData.selectedMinute,
          newHour: EventMenuData.selectedNewHour,
          newMinute: EventMenuData.selectedNewMinute,
          type: 'menu',
          dishes: JSON.stringify(
            EventMenuData.selectedBreakfast.concat(
              EventMenuData.selectedFirstDish,
              EventMenuData.selectedMainDish,
              EventMenuData.selectedGarnish,
              EventMenuData.selectedSalad,
              EventMenuData.selectedAppetizer,
              EventMenuData.selectedDrink,
              EventMenuData.selectedSweet
            )
          ),
        },

        success: function(data) {
          EventMenuData.update = data.response;
          if (data.response) {
            EventMenuData.selectedHour = EventMenuData.selectedNewHour;
            EventMenuData.selectedMinute = EventMenuData.selectedNewMinute;
          }
        },

        error: function() {
          alert('error');
        },
      });
    },
    deleteTime: function() {
      $.ajax({
        url: '../orlyky/server/set/deleteTime.php',
        type: 'POST',
        dataType: 'json',
        data: {
          id: EventMenuData.eventId,
          day: EventMenuData.selectedDay,
          hour: EventMenuData.selectedHour,
          minute: EventMenuData.selectedMinute,
        },

        success: function(data) {
          EventMenuData.update = data.response;
          if (data.response) {
            EventMenuData.rightCol = 'addTime';
            EventMenuData.selectedNewHour = 7;
            EventMenuData.selectedNewMinute = 0;
            EventMenuData.selectedBreakfast = [];
            EventMenuData.selectedFirstDish = [];
            EventMenuData.selectedMainDish = [];
            EventMenuData.selectedGarnish = [];
            EventMenuData.selectedSalad = [];
            EventMenuData.selectedAppetizer = [];
            EventMenuData.selectedDrink = [];
            EventMenuData.selectedSweet = [];
          }
        },

        error: function() {
          alert('error');
        },
      });
    },
  },
};
</script>

<style lang="scss">
#EventMenu {
  > .navigation {
    > .sortIcons {
      > .icon.main:hover,
      > .icon.plan:hover,
      > .icon.estimate:hover,
      > .icon.menu:hover,
      > .icon.inventory:hover {
        > a {
          margin-left: 2px;
        }
      }
    }
  }
  .icon.main > a {
    background-image: url('dist/img/eventIcons/home.png');
  }
  .icon.plan > a {
    background-image: url('dist/img/eventIcons/plan.png');
  }
  .icon.estimate > a {
    background-image: url('dist/img/eventIcons/estimate.png');
  }
  .icon.menu > a {
    background-image: url('dist/img/eventIcons/menu.png');
  }
  .icon.inventory > a {
    background-image: url('dist/img/eventIcons/inventory.png');
  }
}
#EventMenu > .days {
  background: none;
  box-shadow: none;
}
#EventMenu > .days > .day {
  box-shadow: -2px 2px 5px 0px black;
  width: 100%;
  float: left;
  margin-bottom: 1%;
}
#EventMenu > .days > .day > .minHeader {
  width: 100%;
  height: 40px;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
  position: relative;
  cursor: pointer;
  padding: 0.5%;
  box-sizing: border-box;
}
#EventMenu > .days > .day > .content {
  background: white;
}
#EventMenu > .days > .day > .content::after {
  display: block;
  content: '';
  clear: both;
}
#EventMenu > .days > .day > .content > .time {
  float: left;
  width: 32.333%;
  cursor: pointer;
  margin: 0.5%;
  margin-bottom: 0.8%;
  box-sizing: border-box;
  box-shadow: -2px 2px 5px 0px black;
}
#EventMenu > .days > .day > .content > .time > .hour {
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  padding: 1%;
  box-sizing: border-box;
  color: white;
}
#EventMenu > .days > .day > .content > .time > ul {
  list-style-type: none;
  overflow-y: scroll;
  width: 100%;
  height: calc(23px * 4);
}
#EventMenu > .days > .day > .content > .time > ul > li {
  background-color: rgb(215, 215, 215);
  height: 23px;
  padding: 1%;
  box-sizing: border-box;
  overflow: hidden;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
#EventMenu > .days > .day > .content > .time > ul > li:nth-child(2n) {
  background-color: white;
}
#EventMenu > .rightCol > .minHeader {
  position: relative;
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
}
#EventMenu > .rightCol > .minHeader > h2 {
  position: absolute;
  bottom: 1%;
  left: 2%;
  font-size: 1.1em;
}
#EventMenu > .rightCol > .minHeader > p {
  position: absolute;
  top: 1%;
  right: 2%;
  font-size: 0.9em;
}
#EventMenu > .rightCol > .minHeader > .selectedTime {
  position: absolute;
  top: 1%;
  left: 2%;
  font-size: 0.9em;
}
#EventMenu > .rightCol > select {
  width: 48%;
  float: left;
  padding: 1%;
  box-sizing: border-box;
}
#EventMenu > .rightCol > select.time {
  border: 1px solid black;
  margin: 1%;
}
#EventMenu > .rightCol > .sortPanel {
  width: 100%;
  float: left;
}
#EventMenu > .rightCol > .sortPanel > .sortIcons {
  display: flex;
  justify-content: space-between;
  padding: 1%;
  padding-bottom: 2%;
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon {
  width: 30px;
  height: 30px;
  cursor: pointer;
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon > div {
  width: 100%;
  height: 100%;
  background-color: rgb(215, 215, 215);
  background-size: cover;
  box-shadow: -2px 2px 3px 0px black;
  border: 1px solid rgb(177, 177, 177);
  box-sizing: border-box;

  -webkit-transition: all.1s ease;
  -moz-transition: all.1s ease;
  -o-transition: all.1s ease;
  -ms-transition: all.1s ease;
  transition: all.1s ease;
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon > div.active {
  background-color: rgb(255, 255, 255);
  margin-top: -2px;
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.breakfasts > div {
  background-image: url('dist/img/dishesIcons/breakfasts.png');
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.firstDishes > div {
  background-image: url('dist/img/dishesIcons/soups.png');
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.mainDishes > div {
  background-image: url('dist/img/dishesIcons/mainDishes.png');
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.garnishes > div {
  background-image: url('dist/img/dishesIcons/garnishes.png');
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.salads > div {
  background-image: url('dist/img/dishesIcons/salads.svg');
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.appetizer > div {
  background-image: url('dist/img/dishesIcons/appetizer.png');
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.drinks > div {
  background-image: url('dist/img/dishesIcons/drinks.png');
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.sweets > div {
  background-image: url('dist/img/dishesIcons/desserts.png');
}
#EventMenu
  > .rightCol
  > .sortPanel
  > .sortIcons
  > .icon.breakfasts:hover
  > div {
  margin-top: -2px;
}
#EventMenu
  > .rightCol
  > .sortPanel
  > .sortIcons
  > .icon.firstDishes:hover
  > div {
  margin-top: -2px;
}
#EventMenu
  > .rightCol
  > .sortPanel
  > .sortIcons
  > .icon.mainDishes:hover
  > div {
  margin-top: -2px;
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.garnishes:hover > div {
  margin-top: -2px;
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.salads:hover > div {
  margin-top: -2px;
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.appetizer:hover > div {
  margin-top: -2px;
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.drinks:hover > div {
  margin-top: -2px;
}
#EventMenu > .rightCol > .sortPanel > .sortIcons > .icon.sweets:hover > div {
  margin-top: -2px;
}
#EventMenu > .rightCol > .dishes {
  width: 100%;
  background: rgb(103, 122, 154);
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  padding: 0;
  color: white;
  height: 50vh;
}
#EventMenu > .rightCol > .dishes > option {
  padding: 1%;
}
#EventMenu > .rightCol > button {
  display: block;
  cursor: pointer;
  padding: 1%;
  width: 100%;
  height: 100%;
  background: linear-gradient(rgb(90, 142, 0), rgb(190, 200, 0));
  color: white;
  margin: auto;
  font-size: 1.1em;
  float: left;
}
</style>