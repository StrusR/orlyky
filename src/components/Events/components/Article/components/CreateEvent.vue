<template>
    <div id="CreateEvent" class="rightCol">
        <div class="minHeader">
            <h2>Створити подію</h2>
            <div class="daysTogether">Днів: {{daysTogether}}</div>
        </div>
        <input type="text" :placeholder="topicpPaceholder" v-model="topic">
        <textarea placeholder="Опис" v-model="description"></textarea>
        <p>Відбудетться з:</p>
        <select name="year" v-model="selectedYearFrom">
            <option v-for="(year,index) in yearsListFrom" :key="'yearsListFrom'+index" :value="year">{{year}}</option>
        </select>
        <select name="month" v-model="selectedMonthFrom">
            <option v-for="(month, index) in monthsListFrom" :key="'monthFrom'+index" :value="month">{{monthUa[month]}}</option>
        </select>
        <select name="day" v-model="selectedDayFrom">
            <option v-for="(day, index) in daysListFrom" :key="'monthFrom'+index" :value="day">{{day}}</option>
        </select>
        <p>по:</p>
        <select name="year" v-model="selectedYearTo">
            <option v-for="(year, index) in yearsListTo" :key="'yearsListTo'+index" :value="year">{{year}}</option>
        </select>
        <select name="month" v-model="selectedMonthTo">
            <option v-for="(month, index) in monthsListTo" :key="'monthTo'+index" :value="month">{{monthUa[month]}}</option>
        </select>
        <select name="day" v-model="selectedDayTo">
            <option v-for="(day, index) in daysListTo" :key="'monthTo'+index" :value="day">{{day}}</option>
        </select>
        <div class="message" v-if="message">{{message}}</div>
        <button @click="createEvent">Створити</button>
    </div>
</template>

<script>
var CreateEventData = {
  topic: "",
  topicpPaceholder: "Назва",
  message: "",
  description: "",

  currentDate: new Date(),

  possibleYearFrom: "",
  possibleMonthFrom: "",
  possibleDayFrom: "",

  selectedYearFrom: "",
  selectedMonthFrom: "",
  selectedDayFrom: "",

  selectedFullDateFrom: new Date(),

  yearsListFrom: [],
  monthsListFrom: [],
  daysListFrom: [],

  possibleYearTo: "",
  possibleMonthTo: "",
  possibleDayTo: "",

  selectedYearTo: "",
  selectedMonthTo: "",
  selectedDayTo: "",

  selectedFullDateTo: new Date(),

  yearsListTo: [],
  monthsListTo: [],
  daysListTo: [],

  daysListTogether: "",

  monthUa: [
    "Січень",
    "Лютий",
    "Березень",
    "Квітень",
    "Травень",
    "Червень",
    "Липень",
    "Серпень",
    "Вересень",
    "Жовтень",
    "Листопад",
    "Грудень"
  ],

  EvId: false
};

export default {
  name: "CreateEvent",
  data: function() {
    return CreateEventData;
  },
  created: function() {
    this.possibleYearFrom = new Date(
      this.currentDate.getFullYear() + 4,
      this.currentDate.getMonth(),
      this.currentDate.getDate()
    );
    this.selectedYearFrom = this.currentDate.getFullYear();
    this.selectedMonthFrom = this.currentDate.getMonth();
    this.selectedDayFrom = this.currentDate.getDate();

    this.selectedYearTo = this.currentDate.getFullYear();
    this.selectedMonthTo = this.currentDate.getMonth();
    this.selectedDayTo = this.currentDate.getDate();

    this.yearsListFrom = [];
    for (
      var y = new Date(
        this.currentDate.getFullYear(),
        this.currentDate.getMonth(),
        this.currentDate.getDate()
      );
      y <= this.possibleYearFrom;
      y.setFullYear(y.getFullYear() + 1)
    ) {
      this.yearsListFrom.push(y.getFullYear());
    }
    this.updateMonthsFrom();
  },
  watch: {
    selectedYearFrom: function() {
      this.updateMonthsFrom();
    },
    selectedMonthFrom: function() {
      this.updateDaysFrom();
    },
    selectedDayFrom: function() {
      this.updateYersTo();
    },
    selectedYearTo: function() {
      this.updateMonthsTo();
    },
    selectedMonthTo: function() {
      this.updateMonthsTo();
    },
    selectedDayTo: function() {
      this.updateDaysTo();
    },
    EvId: function() {
      this.$router.push({ path: `/event/${this.EvId}` });
      this.EvId = false;
    }
  },
  methods: {
    updateMonthsFrom: function() {
      this.possibleMonthFrom = new Date(this.selectedYearFrom, 11, 1);
      var lastSelectedMonthFrom = this.selectedMonthFrom;
      var reset = true;

      this.monthsListFrom = [];
      for (
        var m = new Date(this.selectedYearFrom, 0, 1);
        m <= this.possibleMonthFrom;
        m.setMonth(m.getMonth() + 1)
      ) {
        if (
          m >=
          new Date(
            this.currentDate.getFullYear(),
            this.currentDate.getMonth() - 1,
            this.currentDate.getDate()
          )
        ) {
          this.monthsListFrom.push(m.getMonth());
          if (m.getMonth() == lastSelectedMonthFrom) {
            reset = false;
          }
        }
      }
      if (reset) {
        this.selectedMonthFrom = this.monthsListFrom[0];
      }
      this.updateDaysFrom();
    },
    updateDaysFrom: function() {
      this.possibleDayFrom = new Date(
        this.selectedYearFrom,
        this.selectedMonthFrom,
        33 -
          new Date(this.selectedYearFrom, this.selectedMonthFrom, 33).getDate()
      );
      var lastSelectedDayFrom = this.selectedDayFrom;
      var reset = true;

      this.daysListFrom = [];
      for (
        var d = new Date(this.selectedYearFrom, this.selectedMonthFrom, 1);
        d <= this.possibleDayFrom;
        d.setDate(d.getDate() + 1)
      ) {
        if (
          d >=
          new Date(
            this.currentDate.getFullYear(),
            this.currentDate.getMonth(),
            this.currentDate.getDate()
          )
        ) {
          this.daysListFrom.push(d.getDate());
          if (d.getDate() == lastSelectedDayFrom) {
            reset = false;
          }
        }
      }
      if (reset) {
        this.selectedDayFrom = this.daysListFrom[0];
      }
      this.updateYersTo();
    },
    updateYersTo: function() {
      this.possibleYearTo = new Date(
        this.selectedYearFrom,
        this.selectedMonthFrom + 1,
        this.selectedDayFrom
      );

      var lastSelectedYearTo = this.selectedYearTo;
      var reset = true;

      this.yearsListTo = [];
      for (
        var y = new Date(
          this.selectedYearFrom,
          this.selectedMonthFrom,
          this.selectedDayFrom
        );
        y.getFullYear() <= this.possibleYearTo.getFullYear();
        y.setFullYear(y.getFullYear() + 1)
      ) {
        if (
          y >=
          new Date(
            this.currentDate.getFullYear(),
            this.currentDate.getMonth(),
            this.currentDate.getDate()
          )
        ) {
          this.yearsListTo.push(y.getFullYear());
          if (y.getFullYear() == lastSelectedYearTo) {
            reset = false;
          }
        }
      }
      if (reset) {
        this.selectedYearTo = this.yearsListTo[0];
      }
      this.updateMonthsTo();
    },
    updateMonthsTo: function() {
      this.possibleMonthTo = new Date(
        this.selectedYearFrom,
        this.selectedMonthFrom + 1,
        this.selectedDayFrom
      );
      var lastSelectedMonthTo = this.selectedMonthTo;
      var reset = true;

      this.monthsListTo = [];

      if (this.selectedYearFrom < this.selectedYearTo) {
        var mFor = new Date(this.selectedYearTo, 0, 1);
      } else {
        var mFor = new Date(this.selectedYearTo, this.selectedMonthFrom, 1);
      }

      for (
        var m = mFor;
        m <= this.possibleMonthTo;
        m.setMonth(m.getMonth() + 1)
      ) {
        if (m.getMonth() == 11) {
          this.monthsListTo.push(11);
          break;
        } else {
          this.monthsListTo.push(m.getMonth());
        }
        if (m.getMonth() == lastSelectedMonthTo) {
          reset = false;
        }
      }
      if (reset) {
        this.selectedMonthTo = this.monthsListTo[0];
      }
      this.updateDaysTo();
    },
    updateDaysTo: function() {
      this.possibleDayTo = new Date(
        this.selectedYearFrom,
        this.selectedMonthFrom + 1,
        this.selectedDayFrom
      );
      var lastSelectedDayTo = this.selectedDayTo;
      var reset = true;

      this.daysListTo = [];
      if (this.selectedMonthFrom != this.selectedMonthTo) {
        var dFor = new Date(this.selectedYearTo, this.selectedMonthTo, 1);
      } else {
        var dFor = new Date(
          this.selectedYearTo,
          this.selectedMonthTo,
          this.selectedDayFrom
        );
      }

      for (var d = dFor; d <= this.possibleDayTo; d.setDate(d.getDate() + 1)) {
        if (
          // d.getFullYear() == this.selectedYearTo &&
          d.getMonth() == this.selectedMonthTo
        ) {
          this.daysListTo.push(d.getDate());

          if (d.getDate() == lastSelectedDayTo) {
            reset = false;
          }
        }
      }
      if (reset) {
        this.selectedDayTo = this.daysListTo[0];
      }
      this.daysTogether =
        new Date(
          this.selectedYearTo,
          this.selectedMonthTo,
          this.selectedDayTo
        ) -
        new Date(
          this.selectedYearFrom,
          this.selectedMonthFrom,
          this.selectedDayFrom
        );
      this.daysTogether = this.daysTogether / 24 / 60 / 60 / 1000 + 1;
    },
    createEvent: function() {
      if (this.topic != "") {
        this.topicpPaceholder = "Назва";

        $.ajax({
          url: "../orlyky/server/set/createEvent.php",
          type: "POST",
          dataType: "json",
          data: {
            topic: CreateEventData.topic,
            description: CreateEventData.description,
            selectedYearFrom: CreateEventData.selectedYearFrom,
            selectedMonthFrom: CreateEventData.selectedMonthFrom,
            selectedDayFrom: CreateEventData.selectedDayFrom,
            selectedYearTo: CreateEventData.selectedYearTo,
            selectedMonthTo: CreateEventData.selectedMonthTo,
            selectedDayTo: CreateEventData.selectedDayTo
          },
          success: function(data) {
            if (data.topic == false) {
              CreateEventData.message = "Ця подія уже створена";
            } else {
              CreateEventData.message = "";
              CreateEventData.EvId = data.id;
            }
          }
        });
      } else {
        this.topicpPaceholder = "Введіть назву події";
      }
    }
  }
};
</script>

<style>
#CreateEvent > .minHeader {
  position: relative;
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
}
#CreateEvent > .minHeader > h2 {
  position: absolute;
  bottom: 1%;
  left: 2%;
}
#CreateEvent > .minHeader > .daysTogether {
  position: absolute;
  top: 2%;
  right: 2%;
}
#CreateEvent > input {
  padding: 1%;
  width: 100%;
  border: none;
  border-bottom: 1px solid black;
}
#CreateEvent > textarea {
  width: 100%;
  border: none;
  padding: 1%;
}
#CreateEvent > select {
  width: calc(100% / 3);
  margin-right: -4px;
  border: 1px solid black;
  padding: 1%;
  box-sizing: border-box;
}
#CreateEvent > .message {
  text-align: center;
  color: red;
  margin-top: 2%;
}
#CreateEvent > button {
  display: block;
  cursor: pointer;
  padding: 1%;
  width: 50%;
  background: linear-gradient(rgb(90, 142, 0), rgb(190, 200, 0));
  color: white;
  margin: auto;
  margin-top: 3%;
  font-size: 1.1em;
}
</style>
