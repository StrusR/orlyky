<template>
    <div id="CreateEvent" class="rightCol">
        <div class="minHeader">
            Ствоити подію
        </div>
        <input type="text" placeholder="Тема">
        <textarea name="description" placeholder="Опис"></textarea>
        <p>Відбудетться з:</p>
        <select name="year" v-model="selectedFrom[0]">
            <option v-for="year in yearsFrom" :key="'yearsFrom'+year" :value="year">{{year}}</option>
        </select>
        <select name="month" v-model="selectedFrom[1]">
            <option v-for="month in monthsFrom" :key="'monthFrom'+month" :value="month">{{monthUa[month]}}</option>
        </select>
        <select name="day" v-model="selectedFrom[2]">
            <option v-for="day in daysFrom" :key="'monthFrom'+day" :value="day">{{day}}</option>
        </select>
        <p>по:</p>
        <select name="year" v-model="selectedTo[0]">
            <option v-for="year in yearsTo" :key="'yearsTo'+year" :value="year">{{year}}</option>
        </select>
        <select name="month" v-model="selectedTo[1]">
            <option v-for="month in monthsTo" :key="'monthTo'+month" :value="month">{{monthUa[month]}}</option>
        </select>
        <select name="day" v-model="selectedTo[2]">
            <option v-for="day in daysTo" :key="'monthTo'+day" :value="day">{{day}}</option>
        </select>
    </div>
</template>

<script>
var CreateEventData = {
  currentDate: new Date(),
  possibleDateFrom: new Date(),
  possibleDateTo: new Date(),

  selectedFrom: [],
  selectedFullDateFrom: new Date(),

  yearsFrom: [],
  monthsFrom: [],
  daysFrom: [],

  selectedTo: [],
  selectedFullDateTo: new Date(),

  yearsTo: [],
  monthsTo: [],
  daysTo: [],

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
  ]
};

export default {
  name: "CreateEvent",
  data: function() {
    return CreateEventData;
  },
  created: function() {
    this.possibleDateFrom.setFullYear(this.currentDate.getFullYear() + 5);

    this.selectedFrom[0] = this.currentDate.getFullYear();
    this.selectedFrom[1] = this.currentDate.getMonth();
    this.selectedFrom[2] = this.currentDate.getDate();

    this.selectedTo[0] = this.selectedFullDateFrom.getFullYear();
    this.selectedTo[1] = this.selectedFullDateFrom.getMonth();
    this.selectedTo[2] = this.selectedFullDateFrom.getDate();

    for (
      var y = this.currentDate.getFullYear();
      y <= this.possibleDateFrom.getFullYear();
      y++
    ) {
      this.yearsFrom.push(y);
    }

    this.updateSelectFrom();
    this.updateSelectTo();
  },
  watch: {
    selectedFrom: function() {
      this.updateSelectFrom();
      this.updateSelectTo();
    },
    selectedTo: function() {
      this.selectedFullDateTo.setFullYear(this.selectedTo[0]);
      this.selectedFullDateTo.setMonth(this.selectedTo[1]);
      this.selectedFullDateTo.setDate(this.selectedTo[2]);

      this.updateSelectTo();
    }
  },
  methods: {
    updateSelectFrom: function() {
      this.selectedFullDateFrom.setFullYear(this.selectedFrom[0]);
      this.selectedFullDateFrom.setMonth(this.selectedFrom[1]);
      this.selectedFullDateFrom.setDate(this.selectedFrom[2]);

      this.monthsFrom = [];
      this.daysFrom = [];

      for (var m = 0; m < 12; m++) {
        if (
          this.currentDate.getFullYear() <
          this.selectedFullDateFrom.getFullYear()
        ) {
          this.monthsFrom.push(m);
        } else {
          if (this.currentDate.getMonth() <= m) {
            this.monthsFrom.push(m);
          }
        }
      }

      for (
        var d = 1;
        d <=
        33 -
          new Date(
            this.selectedFullDateFrom.getFullYear(),
            this.selectedFullDateFrom.getMonth(),
            33
          ).getDate();
        d++
      ) {
        if (
          this.currentDate.getFullYear() ==
          this.selectedFullDateFrom.getFullYear()
        ) {
          if (
            this.currentDate.getMonth() < this.selectedFullDateFrom.getMonth()
          ) {
            this.daysFrom.push(d);
          } else {
            if (this.currentDate.getDate() <= d) {
              this.daysFrom.push(d);
            }
          }
        } else {
          this.daysFrom.push(d);
        }
      }

      var repD = true;
      for (var i = 0; i < this.monthsFrom.length; i++) {
        if (this.selectedFrom[1] == this.monthsFrom[i]) {
          repD = false;
        }
      }
      if (repD) {
        this.selectedFrom[1] = this.monthsFrom[0];
      }

      var repM = true;
      for (var i = 0; i < this.daysFrom.length; i++) {
        if (this.selectedFrom[2] == this.daysFrom[i]) {
          repM = false;
        }
      }
      if (repM) {
        this.selectedFrom[2] = this.daysFrom[0];
      }
      this.possibleDateTo = new Date();
      this.possibleDateTo.setFullYear(this.selectedFullDateFrom.getFullYear());
      this.possibleDateTo.setMonth(this.selectedFullDateFrom.getMonth() + 1);
      this.possibleDateTo.setDate(this.selectedFullDateFrom.getDate());

      this.selectedTo[0] = this.selectedFullDateFrom.getFullYear();
      this.selectedTo[1] = this.selectedFullDateFrom.getMonth();
      this.selectedTo[2] = this.selectedFullDateFrom.getDate();

      this.yearsTo = [];
      for (
        var y = this.selectedFullDateFrom.getFullYear();
        y <= this.possibleDateTo.getFullYear();
        y++
      ) {
        this.yearsTo.push(y);
      }
    },
    updateSelectTo: function() {
      this.selectedFullDateTo.setFullYear(this.selectedTo[0]);
      this.selectedFullDateTo.setMonth(this.selectedTo[1]);

      this.monthsTo = [];
      this.daysTo = [];
      if (
        this.selectedFullDateFrom.getFullYear() ==
        this.selectedFullDateTo.getFullYear()
      ) {
        if (this.selectedFullDateFrom.getMonth() < 11) {
          for (
            var m = this.selectedFullDateFrom.getMonth();
            m <= this.possibleDateTo.getMonth();
            m++
          ) {
            if (m < 12) {
              this.monthsTo.push(m);
            }
          }
        } else {
          this.monthsTo.push(11);
        }
      } else {
        this.monthsTo.push(0);
      }

      for (
        var d = 1;
        d <=
        33 -
          new Date(
            this.selectedFullDateTo.getFullYear(),
            this.selectedFullDateTo.getMonth(),
            33
          ).getDate();
        d++
      ) {
        if (
          this.possibleDateTo.getMonth() > this.selectedFullDateTo.getMonth() ||
          this.selectedFullDateFrom.getMonth() == 11
        ) {
          if (
            this.selectedFullDateFrom.getFullYear() !=
            this.selectedFullDateTo.getFullYear()
          ) {
            if (this.possibleDateTo.getDate() >= d) {
              this.daysTo.push(d);
            }
          } else {
            if (this.selectedFullDateFrom.getDate() <= d) {
              this.daysTo.push(d);
            }
          }
        } else {
          if (this.possibleDateTo.getDate() >= d) {
            this.daysTo.push(d);
          }
        }
      }
      var repY = true;
      for (var i = 0; i < this.yearsTo.length; i++) {
        if (this.selectedTo[0] == this.yearsTo[i]) {
          repY = false;
        }
      }
      if (repY) {
        this.selectedTo[0] = this.yearsTo[0];
      }

      var repD = true;
      for (var i = 0; i < this.monthsTo.length; i++) {
        if (this.selectedTo[1] == this.monthsTo[i]) {
          repD = false;
        }
      }
      if (repD) {
        this.selectedTo[1] = this.monthsTo[0];
      }

      var repM = true;
      for (var i = 0; i < this.daysTo.length; i++) {
        if (this.selectedTo[2] == this.daysTo[i]) {
          repM = false;
        }
      }
      if (repM) {
        this.selectedTo[2] = this.daysTo[0];
      }
    }
  }
};
</script>

<style scoped>
#CreateEvent {
  width: 30%;
}
#CreateEvent > .minHeader {
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(128, 0, 0) 20%, rgb(60, 0, 0));
  color: white;
  top: 0;
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
</style>
