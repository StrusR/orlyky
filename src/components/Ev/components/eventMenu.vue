<template>
    <article id="EventMenu">

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
                <li v-for="(dish, index) in time.dishes.breakfasts" :key="'time'+time.id+'dish'+index">{{dish.name}}</li>
              </ul>
              <ul v-if="time.dishes">
                <li v-for="(dish, index) in time.dishes.firstDishes" :key="'time'+time.id+'dish'+index">{{dish.name}}</li>
              </ul>
              <ul v-if="time.dishes">
                <li v-for="(dish, index) in time.dishes.mainDishes" :key="'time'+time.id+'dish'+index">{{dish.name}}</li>
              </ul>
              <ul v-if="time.dishes">
                <li v-for="(dish, index) in time.dishes.garnishes" :key="'time'+time.id+'dish'+index">{{dish.name}}</li>
              </ul>
              <ul v-if="time.dishes">
                <li v-for="(dish, index) in time.dishes.salads" :key="'time'+time.id+'dish'+index">{{dish.name}}</li>
              </ul>
              <ul v-if="time.dishes">
                <li v-for="(dish, index) in time.dishes.drinks" :key="'time'+time.id+'dish'+index">{{dish.name}}</li>
              </ul>
              <ul v-if="time.dishes">
                <li v-for="(dish, index) in time.dishes.sweets" :key="'time'+time.id+'dish'+index">{{dish.name}}</li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="rightCol changeTime">
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

        <select v-model="selectedNewHour">
          <option :value="index" v-for="(hour, index) in hours" :key="'createTimeHour'+index">{{hour}}</option>
        </select>
        <select v-model="selectedNewMinute">
          <option :value="parseInt(minute)" v-for="(minute, index) in minutes" :key="'createTimeMinute'+index">{{minute}}</option>
        </select>

        <select class="dishes" v-model="selectedBreakfast" multiple size="2">
          <option :value="breakfast.id" v-for="(breakfast, index) in dishes['breakfasts']" :key="'breakfast'+index">{{breakfast.name}}</option>
        </select>
        <select class="dishes" v-model="selectedFirstDish" multiple size="2">
          <option :value="firstDish.id" v-for="(firstDish, index) in dishes['firstDishes']" :key="'firstDish'+index">{{firstDish.name}}</option>
        </select>
        <select class="dishes" v-model="selectedMainDish" multiple size="2">
          <option :value="mainDish.id" v-for="(mainDish, index) in dishes['mainDishes']" :key="'mainDish'+index">{{mainDish.name}}</option>
        </select>
        <select class="dishes" v-model="selectedGarnish" multiple size="2">
          <option :value="garnish.id" v-for="(garnish, index) in dishes['garnishes']" :key="'garnish'+index">{{garnish.name}}</option>
        </select>
        <select class="dishes" v-model="selectedSalad" multiple size="2">
          <option :value="salad.id" v-for="(salad, index) in dishes['salads']" :key="'salad'+index">{{salad.name}}</option>
        </select>
        <select class="dishes" v-model="selectedDrink" multiple size="2">
          <option :value="drink.id" v-for="(drink, index) in dishes['drinks']" :key="'drink'+index">{{drink.name}}</option>
        </select>
        <select class="dishes" v-model="selectedSweet" multiple size="2">
          <option :value="sweet.id" v-for="(sweet, index) in dishes['sweets']" :key="'sweet'+index">{{sweet.name}}</option>
        </select>
        <button @click="addTime" v-if="rightCol == 'addTime'">Додати</button>
        <button @click="changeTime" v-if="rightCol == 'changeTime'">Змінити</button>
        <button @click="deleteTime" v-if="rightCol == 'changeTime'">Видалити</button>
      </div>

    </article>
</template>

<script>
var EventMenuData = {
  days: "",
  dishes: "",

  eventId: "",

  rightCol: "addTime",

  selectedDay: 1,
  selectedHour: "",
  selectedMinute: "",

  selectedNewHour: 7,
  selectedNewMinute: 0,

  selectedBreakfast: [],
  selectedFirstDish: [],
  selectedMainDish: [],
  selectedGarnish: [],
  selectedSalad: [],
  selectedDrink: [],
  selectedSweet: [],

  update: false,

  hours: [
    "00",
    "01",
    "02",
    "03",
    "04",
    "05",
    "06",
    "07",
    "08",
    "09",
    "10",
    "11",
    "12",
    "13",
    "14",
    "15",
    "16",
    "17",
    "18",
    "19",
    "20",
    "21",
    "22",
    "23"
  ],
  minutes: [
    "00",
    "05",
    "10",
    "15",
    "20",
    "25",
    "30",
    "35",
    "40",
    "45",
    "50",
    "55"
  ]
};

export default {
  name: "EventMenu",
  data: function() {
    return EventMenuData;
  },
  created: function() {
    this.eventId = this.$route.params.id;

    this.updateMenu();
    this.updateDishes();
    // this.updateDishes();
  },
  watch: {
    update: function() {
      this.updateMenu();
      this.update = false;
    }
  },
  methods: {
    updateMenu: function() {
      $.ajax({
        url: "../orlyky/server/get/menu.php",
        type: "POST",
        dataType: "json",
        data: {
          id: EventMenuData.eventId
        },

        success: function(data) {
          EventMenuData.days = data.days;
        },

        error: function() {
          alert("error");
        }
      });
    },
    updateDishes: function() {
      $.ajax({
        url: "../orlyky/server/get/dishes.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          EventMenuData.dishes = data.dishes;
        },

        error: function() {
          alert("error");
        }
      });
    },
    selectDay: function(day) {
      this.rightCol = "addTime";
      this.selectedDay = day;
      this.selectedNewHour = 7;
      this.selectedNewMinute = parseInt(this.possibleMinutes[0]);
      this.selectedHour = 7;
      this.selectedMinute = 0;
      this.selectedBreakfast = [];
      this.selectedFirstDish = [];
      this.selectedMainDish = [];
      this.selectedGarnish = [];
      this.selectedSalad = [];
      this.selectedDrink = [];
      this.selectedSweet = [];
    },
    selectTime: function(day, dayIndex, hour, minute, time) {
      this.rightCol = "changeTime";
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
        url: "../orlyky/server/set/addTime.php",
        type: "POST",
        dataType: "json",
        data: {
          id: EventMenuData.eventId,
          day: EventMenuData.selectedDay,
          hour: EventMenuData.selectedNewHour,
          minute: EventMenuData.selectedNewMinute,
          type: "menu",
          dishes: JSON.stringify(
            EventMenuData.selectedBreakfast.concat(
              EventMenuData.selectedFirstDish,
              EventMenuData.selectedMainDish,
              EventMenuData.selectedGarnish,
              EventMenuData.selectedSalad,
              EventMenuData.selectedDrink,
              EventMenuData.selectedSweet
            )
          )
        },

        success: function(data) {
          EventMenuData.update = data.response;
          if (data.response) {
            EventMenuData.rightCol = "changeTime";
            EventMenuData.selectedHour = EventMenuData.selectedNewHour;
            EventMenuData.selectedMinute = EventMenuData.selectedNewMinute;
          }
        },

        error: function() {
          alert("error");
        }
      });
    },
    changeTime: function() {
      $.ajax({
        url: "../orlyky/server/set/changeTime.php",
        type: "POST",
        dataType: "json",
        data: {
          id: EventMenuData.eventId,
          day: EventMenuData.selectedDay,
          hour: EventMenuData.selectedHour,
          minute: EventMenuData.selectedMinute,
          newHour: EventMenuData.selectedNewHour,
          newMinute: EventMenuData.selectedNewMinute,
          type: "menu",
          dishes: JSON.stringify(
            EventMenuData.selectedBreakfast.concat(
              EventMenuData.selectedFirstDish,
              EventMenuData.selectedMainDish,
              EventMenuData.selectedGarnish,
              EventMenuData.selectedSalad,
              EventMenuData.selectedDrink,
              EventMenuData.selectedSweet
            )
          )
        },

        success: function(data) {
          EventMenuData.update = data.response;
          if (data.response) {
            EventMenuData.selectedHour = EventMenuData.selectedNewHour;
            EventMenuData.selectedMinute = EventMenuData.selectedNewMinute;
          }
        },

        error: function() {
          alert("error");
        }
      });
    },
    deleteTime: function() {
      $.ajax({
        url: "../orlyky/server/set/deleteTime.php",
        type: "POST",
        dataType: "json",
        data: {
          id: EventMenuData.eventId,
          day: EventMenuData.selectedDay,
          hour: EventMenuData.selectedHour,
          minute: EventMenuData.selectedMinute
        },

        success: function(data) {
          EventMenuData.update = data.response;
          if (data.response) {
            EventMenuData.rightCol = "addTime";
            EventMenuData.selectedNewHour = 7;
            EventMenuData.selectedNewMinute = 0;
            EventMenuData.selectedBreakfast = [];
            EventMenuData.selectedFirstDish = [];
            EventMenuData.selectedMainDish = [];
            EventMenuData.selectedGarnish = [];
            EventMenuData.selectedSalad = [];
            EventMenuData.selectedDrink = [];
            EventMenuData.selectedSweet = [];
          }
        },

        error: function() {
          alert("error");
        }
      });
    }
  }
};
</script>

<style scoped>
#EventMenu > .days > .day {
  box-shadow: -2px 2px 5px 0px rgb(60, 0, 0);
  width: 100%;
  float: left;
  margin-bottom: 1%;
}
#EventMenu > .days > .day > .minHeader {
  width: 100%;
  height: 50px;
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
  color: white;
  position: relative;
  cursor: pointer;
}
#EventMenu > .days > .day > .content > .time {
  float: left;
  width: 33%;
  cursor: pointer;
}
#EventMenu > .days > .day > .content > .time > ul {
  list-style-type: none;
}
#EventMenu > .rightCol > .minHeader {
  position: relative;
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
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
  width: 50%;
  float: left;
  border: 1px solid black;
  padding: 1%;
  box-sizing: border-box;
}
#EventMenu > .rightCol > .dishes {
  width: 100%;
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
