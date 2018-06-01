<template>
  <article id="eventInventory">
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
          <router-link :to="{ path: `/event/${this.$route.params.id}/menu`}"></router-link>
        </div>
        <div class="icon inventory">
          <router-link class="active" :to="{ path: `/event/${this.$route.params.id}/inventory`}"></router-link>
        </div>
      </div>
    </div>
    <div class="leftCol days">
      <div class="day" v-for="(day, dIndex) in days" :key="'day'+day.day">
        <div class="minHeader">
          День {{day.day}}
        </div>
        <div class="content">
          <div class="time" v-for="(time, tIndex) in day.times" :key="'time'+time.id">
            <div class="hour">
              <div v-if="time.hour >= 5 && time.hour < 12">Сніданок {{hours[time.hour]}}:{{minutes[time.minute/5]}}</div>
              <div v-else-if="time.hour >= 13 && time.hour < 17">Обід {{hours[time.hour]}}:{{minutes[time.minute/5]}}</div>
              <div v-else>Вечеря {{hours[time.hour]}}:{{minutes[time.minute/5]}}</div>
            </div>
            <ul v-if="time.dishes">
              <li v-for="(dish, dishIndex) in time.dishes" :key="'dish'+time.id+'dish'+dishIndex" @click="selectDish(dIndex, tIndex, dishIndex)" :title="dish.name">{{dish.name}} <span :title="roundingPercentageTitle(dish.roundingPercentage)" :class="{red: dish.roundingPercentage<0, green: dish.roundingPercentage>0}">{{Math.round(dish.roundingPercentage)}} %</span></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="rightCol" v-if="rightCol">
      <div class="minHeader">
        <p>{{days[selectedDayIndex].day}} день</p>
        <h2>{{days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].name}}</h2>
          <div class="selectedTime">{{hours[days[selectedDayIndex].times[selectedTimeIndex].hour]}}:{{minutes[days[selectedDayIndex].times[selectedTimeIndex].minute/5]}}</div>
      </div>
      <ul v-if="days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients">
        <li v-for="ingredient in days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.groat" :key="'ingredient'+ingredient.id+'day'+selectedDay+'hour'+selectedHour+'minute'+selectedMinute" v-if="days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.groat">
          <div class="name">{{ingredient.name}}</div>
          <div v-if="ingredient.type == 3" class="type">шт.</div>
          <div v-else class="type">гр.</div>
          <div class="weight">{{ingredient.weight}}</div>
        </li>
        <li v-for="ingredient in days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.canned" :key="'ingredient'+ingredient.id+'day'+selectedDay+'hour'+selectedHour+'minute'+selectedMinute" v-if="days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.canned">
          <div class="name">{{ingredient.name}}</div>
          <div v-if="ingredient.type == 3" class="type">шт.</div>
          <div v-else class="type">гр.</div>
          <div class="weight">{{ingredient.weight}}</div>
        </li>
        <li v-for="ingredient in days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.milk" :key="'ingredient'+ingredient.id+'day'+selectedDay+'hour'+selectedHour+'minute'+selectedMinute" v-if="days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.milk">
          <div class="name">{{ingredient.name}}</div>
          <div v-if="ingredient.type == 3" class="type">шт.</div>
          <div v-else class="type">гр.</div>
          <div class="weight">{{ingredient.weight}}</div>
        </li>
        <li v-for="ingredient in days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.meat" :key="'ingredient'+ingredient.id+'day'+selectedDay+'hour'+selectedHour+'minute'+selectedMinute" v-if="days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.meat">
          <div class="name">{{ingredient.name}}</div>
          <div v-if="ingredient.type == 3" class="type">шт.</div>
          <div v-else class="type">гр.</div>
          <div class="weight">{{ingredient.weight}}</div>
        </li>
        <li v-for="ingredient in days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.vegetable" :key="'ingredient'+ingredient.id+'day'+selectedDay+'hour'+selectedHour+'minute'+selectedMinute" v-if="days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.vegetable">
          <div class="name">{{ingredient.name}}</div>
          <div v-if="ingredient.type == 3" class="type">шт.</div>
          <div v-else class="type">гр.</div>
          <div class="weight">{{ingredient.weight}}</div>
        </li>
        <li v-for="ingredient in days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.spices" :key="'ingredient'+ingredient.id+'day'+selectedDay+'hour'+selectedHour+'minute'+selectedMinute" v-if="days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.spices">
          <div class="name">{{ingredient.name}}</div>
          <div v-if="ingredient.type == 3" class="type">шт.</div>
          <div v-else class="type">гр.</div>
          <div class="weight">{{ingredient.weight}}</div>
        </li>
        <li v-for="ingredient in days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.sweet" :key="'ingredient'+ingredient.id+'day'+selectedDay+'hour'+selectedHour+'minute'+selectedMinute" v-if="days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.sweet">
          <div class="name">{{ingredient.name}}</div>
          <div v-if="ingredient.type == 3" class="type">шт.</div>
          <div v-else class="type">гр.</div>
          <div class="weight">{{ingredient.weight}}</div>
        </li>
        <li v-for="ingredient in days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.other" :key="'ingredient'+ingredient.id+'day'+selectedDay+'hour'+selectedHour+'minute'+selectedMinute" v-if="days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.other">
          <div class="name">{{ingredient.name}}</div>
          <div v-if="ingredient.type == 3" class="type">шт.</div>
          <div v-else class="type">гр.</div>
          <div class="weight">{{ingredient.weight}}</div>
        </li>
        <li v-for="ingredient in days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.notRounded" :key="'ingredient'+ingredient.id+'day'+selectedDay+'hour'+selectedHour+'minute'+selectedMinute" v-if="days[selectedDayIndex].times[selectedTimeIndex].dishes[selectedDishIndex].ingredients.notRounded">
          <div class="name">{{ingredient.name}}</div>
          <div v-if="ingredient.type == 3" class="type">шт.</div>
          <div v-else class="type">гр.</div>
          <div class="weight">{{ingredient.weight}}</div>
        </li>
      </ul>
    </div>
  </article>
</template>

<script>
export default {
  name: "eventInventory",
  props: ["event"],
  data: function() {
    return {
      days: "",

      rightCol: false,
      selectedDayIndex: null,
      selectedTimeIndex: null,
      selectedDishIndex: null,

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
      ],
      up: null
    };
  },
  created: function() {
    var that = this;
    this.updateFood();
    this.up = setInterval(() => {
      that.updateFood();
    }, 1000);
  },
  destroyed: function() {
    clearInterval(this.up);
  },
  watch: {
    days: function() {
      if (
        this.days[this.selectedDayIndex] === undefined ||
        this.days[this.selectedDayIndex].times === undefined ||
        this.days[this.selectedDayIndex].times[this.selectedTimeIndex] ===
          undefined ||
        this.days[this.selectedDayIndex].times[this.selectedTimeIndex]
          .dishes === undefined ||
        this.days[this.selectedDayIndex].times[this.selectedTimeIndex].dishes[
          this.selectedDishIndex
        ] === undefined
      ) {
        this.rightCol = false;
      }
    }
  },
  methods: {
    roundingPercentageTitle: function(roundingPercentage) {
      if (roundingPercentage > 0) {
        return (
          "Із за заокруглення інградієнтів, їх буде використано на " +
          roundingPercentage +
          " % більше, ніж потрібно."
        );
      } else if (roundingPercentage < 0) {
        return (
          "Із за заокруглення інградієнтів, їх буде використано на " +
          roundingPercentage +
          " % менше, ніж потрібно."
        );
      } else {
        return "Округлення не має";
      }
    },
    updateFood: function() {
      var that = this;
      $.ajax({
        url: "../orlyky/server/get/inventory.php",
        type: "POST",
        dataType: "json",
        data: {
          id: that.event.id
        },

        success: function(data) {
          that.days = data.days;
        }
      });
    },
    selectDish: function(dIndex, tIndex, dishIndex) {
      this.selectedDayIndex = dIndex;
      this.selectedTimeIndex = tIndex;
      this.selectedDishIndex = dishIndex;

      this.rightCol = true;
    }
  }
};
</script>

<style>
#eventInventory > .navigation > .sortIcons > .icon.main:hover > a,
#eventInventory > .navigation > .sortIcons > .icon.plan:hover > a,
#eventInventory > .navigation > .sortIcons > .icon.estimate:hover > a,
#eventInventory > .navigation > .sortIcons > .icon.menu:hover > a,
#eventInventory > .navigation > .sortIcons > .icon.inventory:hover > a {
  margin-left: 2px;
}
#eventInventory .icon.main > a {
  background-image: url("dist/img/eventIcons/home.png");
}
#eventInventory .icon.plan > a {
  background-image: url("dist/img/eventIcons/plan.png");
}
#eventInventory .icon.estimate > a {
  background-image: url("dist/img/eventIcons/estimate.png");
}
#eventInventory .icon.menu > a {
  background-image: url("dist/img/eventIcons/menu.png");
}
#eventInventory .icon.inventory > a {
  background-image: url("dist/img/eventIcons/inventory.png");
}
#eventInventory > .days {
  background: none;
  box-shadow: none;
}
#eventInventory > .days > .day {
  box-shadow: -2px 2px 5px 0px black;
  width: 100%;
  float: left;
  margin-bottom: 1%;
}
#eventInventory > .days > .day > .minHeader {
  width: 100%;
  height: 40px;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
  position: relative;
  padding: 0.5%;
  box-sizing: border-box;
}
#eventInventory > .days > .day > .content {
  background: white;
}
#eventInventory > .days > .day > .content::after {
  display: block;
  content: "";
  clear: both;
}
#eventInventory > .days > .day > .content > .time {
  float: left;
  width: 32.333%;
  margin: 0.5%;
  margin-bottom: 0.8%;
  box-sizing: border-box;
  box-shadow: -2px 2px 5px 0px black;
}
#eventInventory > .days > .day > .content > .time > .hour {
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  padding: 1%;
  box-sizing: border-box;
  color: white;
}
#eventInventory > .days > .day > .content > .time > ul {
  list-style-type: none;
  overflow-y: scroll;
  width: 100%;
  height: calc(23px * 4);
}
#eventInventory > .days > .day > .content > .time > ul > li {
  background-color: rgb(215, 215, 215);
  height: 23px;
  padding: 1%;
  box-sizing: border-box;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
  cursor: pointer;
}
#eventInventory > .days > .day > .content > .time > ul > li:nth-child(2n) {
  background-color: white;
}
#eventInventory > .days > .day > .content > .time > ul > li span {
  float: right;
}
#eventInventory > .days > .day > .content > .time > ul > li span.red {
  color: red;
}
#eventInventory > .days > .day > .content > .time > ul > li span.green {
  color: green;
}
#eventInventory > .rightCol > .minHeader {
  position: relative;
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
}
#eventInventory > .rightCol > .minHeader > h2 {
  position: absolute;
  bottom: 1%;
  left: 2%;
  font-size: 1.1em;
}
#eventInventory > .rightCol > .minHeader > p {
  position: absolute;
  top: 1%;
  right: 2%;
  font-size: 0.9em;
}
#eventInventory > .rightCol > .minHeader > .selectedTime {
  position: absolute;
  top: 1%;
  left: 2%;
  font-size: 0.9em;
}
#eventInventory > .rightCol > ul {
  list-style-type: none;
  overflow-y: scroll;
  width: 100%;
  height: calc(23px * 15);
}
#eventInventory > .rightCol > ul > li {
  background-color: rgb(215, 215, 215);
  height: 23px;
}
#eventInventory > .rightCol > ul > li::after {
  display: block;
  clear: both;
  content: "";
}
#eventInventory > .rightCol > ul > li:nth-child(2n) {
  background-color: white;
}
#eventInventory > .rightCol > ul li .name {
  float: left;
}

#eventInventory > .rightCol > ul li .weight {
  float: right;
}
#eventInventory > .rightCol > ul li .type {
  float: right;
}
</style>

