<template>
    <article id="DishesArticle">
        <div class="navigation">
          <div class="sortIcons">
            <div class="icon breakfasts" @click="selectedGroup='breakfast'"><div :class="{active: selectedGroup=='breakfast'}"></div></div>
            <div class="icon firstDishes" @click="selectedGroup='firstDish'"><div :class="{active: selectedGroup=='firstDish'}"></div></div>
            <div class="icon mainDishes" @click="selectedGroup='mainDish'"><div :class="{active: selectedGroup=='mainDish'}"></div></div>
            <div class="icon garnishes" @click="selectedGroup='garnish'"><div :class="{active: selectedGroup=='garnish'}"></div></div>
            <div class="icon salads" @click="selectedGroup='salad'"><div :class="{active: selectedGroup=='salad'}"></div></div>
            <div class="icon appetizer" @click="selectedGroup='appetizer'"><div :class="{active: selectedGroup=='appetizer'}"></div></div>
            <div class="icon drinks" @click="selectedGroup='drink'"><div :class="{active: selectedGroup=='drink'}"></div></div>
            <div class="icon sweets" @click="selectedGroup='sweet'"><div :class="{active: selectedGroup=='sweet'}"></div></div>
          </div>
        </div>
        <transition name="fade">

        <div v-if="selectedGroup==index" class="type leftCol" v-for="(type, index) in dishes" :key="index">
            <div class="dish" v-for="dish in type" :key="'dish'+ dish.id" @click="selectDish(dish)">
                <div class="minHeader">{{dish.name}}</div>
                <ul v-if="dish.dishIngredients" class="dishIngredients">
                    <li v-for="(dishIngredient, dIndex) in dish.dishIngredients" :key="'dishIngredient'+dIndex">
                      <div v-if="ingredient.id == dishIngredient.ingredientId" v-for="ingredient in ingredients" :key="'dishIngredient'+dishIngredient.id+'ingredient'+ingredient.id">
                        <div class="name">{{ingredient.name}}<span v-if="dishIngredient.round == 1"></span></div>
                        <div class="weight">{{dishIngredient.weight}}</div>
                        <div v-if="ingredient.type == 3" class="type">шт.</div>
                        <div v-else class="type">гр.</div>
                      </div>
                    </li>
                </ul>
            </div>
        </div>
        </transition>
        <div class="rightCol">
            <div class="minHeader">
                <h2 v-if="rightCol == 'addDish'">Додати страву</h2>
                <h2 v-if="rightCol == 'changeDish'">Редагувати страву</h2>
                <div @click="addDishShow()" class="addBtn">+</div>
            </div>
            <div class="content">
              <input type="text" placeholder="Назва страви" v-model="selectedName">
              <div class="sortPanel">
                <div class="sortIcons">
                  <div class="icon breakfasts" @click="selectedType='breakfast'"><div :class="{active: selectedType=='breakfast'}"></div></div>
                  <div class="icon firstDishes" @click="selectedType='firstDish'"><div :class="{active: selectedType=='firstDish'}"></div></div>
                  <div class="icon mainDishes" @click="selectedType='mainDish'"><div :class="{active: selectedType=='mainDish'}"></div></div>
                  <div class="icon garnishes" @click="selectedType='garnish'"><div :class="{active: selectedType=='garnish'}"></div></div>
                  <div class="icon salads" @click="selectedType='salad'"><div :class="{active: selectedType=='salad'}"></div></div>
                  <div class="icon appetizer" @click="selectedType='appetizer'"><div :class="{active: selectedType=='appetizer'}"></div></div>
                  <div class="icon drinks" @click="selectedType='drink'"><div :class="{active: selectedType=='drink'}"></div></div>
                  <div class="icon sweets" @click="selectedType='sweet'"><div :class="{active: selectedType=='sweet'}"></div></div>
                </div>
              </div>
              <ul class="selectedIngredients" v-if="selectedIngredients">
                  <li v-if="selectedIngredient" class="ingredient" v-for="(selectedIngredient, sIndex) in selectedIngredients" :key="'selectedIngredient'+sIndex">
                    <div v-if="ingredient.id == selectedIngredient.ingredientId" v-for="ingredient in ingredients" :key="'selectedIngredient'+sIndex+'ingredient'+ingredient.id">
                      <div class="name">{{ingredient.name}}</div>
                      <input class="weight" type="number" v-model="selectedIngredient.weight">
                      <div v-if="ingredient.type == 3" class="type">шт.</div>
                      <div v-else class="type">гр.</div>
                      <input class="round" type="checkbox" v-if="ingredient.type == 1" v-model="selectedIngredient.round" :true-value="1" :false-value="0" title="Закругляти до цілого для зручності приготування. Інші продукти будуть пораховані пропорційно">
                      <div class="delete" @click="deleteingredient(selectedIngredients, sIndex)" title="Видалити інградієнт">×</div>
                    </div>
                  </li>
              </ul>
              <div class="border"></div>
              <input type="text" v-model="search" placeholder="Пошук" class="search">
              <input type="number" v-model="weight" placeholder="Вага" class="weight">
              <ul class="filteredIngredients">
                <li v-for="(filteredIngredient, index) in filteredIngredients" :key="'filteredIngredient'+index">
                  <div class="name">{{filteredIngredient.name}}</div>
                  <div class="add" @click="addIngradient(filteredIngredient)" title="Додати інградієнт">+</div>
                </li>
              </ul>
              <button @click="addDish()" v-if="rightCol == 'addDish'">Додати</button>
              <button @click="changeDish()" v-if="rightCol == 'changeDish'">Редагувати</button>
              <button @click="deleteDish()" v-if="rightCol == 'changeDish'">Видалити</button>
            </div>
        </div>
    </article>
</template>

<script>
var DishesArticleData = {
  interval: true,
  dishes: "",
  ingredients: "",
  rightCol: "addDish",
  selectedGroup: "breakfast",

  selectedDish: "",
  selectedName: "",
  selectedType: "breakfast",
  selectedIngredients: [],
  filteredIngredients: [],
  search: "",
  weight: 1,
  round: 0,

  up: ""
};

export default {
  name: "DishesArticle",
  data: function() {
    return DishesArticleData;
  },
  watch: {
    search: function() {
      this.search = this.LowerCase(this.search);
      this.filterIngregients();
    }
  },
  created: function() {
    var that = this;
    this.updateDishes();
    this.updateIngredients();
    this.up = setInterval(() => {
      that.updateDishes();
      that.updateIngredients();
    }, 1000);
  },
  destroyed: function() {
    clearInterval(this.up);
  },
  methods: {
    LowerCase: function(string) {
      string = string.toLowerCase();
      return string;
    },
    updateDishes: function() {
      var that = this;
      $.ajax({
        url: "../orlyky/server/get/dishes.php",
        type: "POST",
        dataType: "json",
        data: {
          ret: "all"
        },

        success: function(data) {
          that.dishes = data.dishes;
        },

        error: function() {
          console.log("error updateDishes");
        }
      });
    },
    updateIngredients: function() {
      var that = this;
      $.ajax({
        url: "../orlyky/server/get/ingredients.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          that.ingredients = data.ingredients;
          that.filterIngregients();
        },

        error: function() {
          console.log("error updateIngredients");
        }
      });
    },
    filterIngregients: function() {
      var that = this;
      this.filteredIngredients = [];

      jQuery.each(that.ingredients, function(iKey, i) {
        var audit = true;
        jQuery.each(that.selectedIngredients, function(sKey, s) {
          if (s.ingredientId == i.id) {
            audit = false;
          }
        });
        if (audit) {
          if (that.search != "") {
            if (that.LowerCase(i.name).indexOf(that.search) !== -1) {
              that.filteredIngredients.push(i);
            }
          } else {
            that.filteredIngredients.push(i);
          }
        }
      });
    },
    selectDish: function(dish) {
      this.search = "";
      this.selectedDish = dish.id;
      this.selectedName = dish.name;
      this.selectedType = dish.type;
      this.selectedIngredients = [];
      if (dish.dishIngredients) {
        jQuery.each(dish.dishIngredients, function(key, val) {
          DishesArticleData.selectedIngredients.push({
            dishId: val.dishId,
            ingredientId: val.ingredientId,
            weight: val.weight,
            round: val.round
          });
        });
      }
      this.rightCol = "changeDish";
      this.filterIngregients();
    },
    deleteingredient: function(all, sIndex) {
      if (all) {
        this.selectedIngredients = [];
        jQuery.each(all, function(key, val) {
          if (key != sIndex) {
            DishesArticleData.selectedIngredients.push(val);
          }
        });
      }
      this.filterIngregients();
    },
    addIngradient: function(ingredient) {
      if (this.weight > 0) {
        this.selectedIngredients.push({
          dishId: this.selectedDish,
          ingredientId: ingredient.id,
          weight: this.weight,
          round: this.round
        });
        this.search = "";
      }
      this.filterIngregients();
    },
    changeDish: function() {
      var that = this;
      $.ajax({
        url: "../orlyky/server/set/changeDish.php",
        type: "POST",
        dataType: "json",
        data: {
          id: that.selectedDish,
          name: that.selectedName,
          type: that.selectedType,
          ingredients: JSON.stringify(that.selectedIngredients)
        },

        success: function(data) {
          that.updateDishes();
        }
      });
    },
    addDish: function() {
      var that = this;
      $.ajax({
        url: "../orlyky/server/set/addDish.php",
        type: "POST",
        dataType: "json",
        data: {
          name: that.selectedName,
          type: that.selectedType,
          ingredients: JSON.stringify(that.selectedIngredients)
        },

        success: function(data) {
          that.updateDishes();
          that.addDishShow();
        }
      });
    },
    deleteDish: function() {
      var that = this;
      $.ajax({
        url: "../orlyky/server/set/deleteDish.php",
        type: "POST",
        dataType: "json",
        data: {
          id: that.selectedDish
        },

        success: function(data) {
          that.updateDishes();
          that.addDishShow();
        }
      });
    },
    addDishShow: function() {
      this.selectedDish = false;
      this.selectedName = "";
      this.selectedIngredients = [];
      this.rightCol = "addDish";
    }
  }
};
</script>

<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}
#DishesArticle > .navigation > .sortIcons > .icon.breakfasts:hover > div,
#DishesArticle > .navigation > .sortIcons > .icon.firstDishes:hover > div,
#DishesArticle > .navigation > .sortIcons > .icon.mainDishes:hover > div,
#DishesArticle > .navigation > .sortIcons > .icon.garnishes:hover > div,
#DishesArticle > .navigation > .sortIcons > .icon.salads:hover > div,
#DishesArticle > .navigation > .sortIcons > .icon.appetizer:hover > div,
#DishesArticle > .navigation > .sortIcons > .icon.drinks:hover > div,
#DishesArticle > .navigation > .sortIcons > .icon.sweets:hover > div {
  margin-left: 2px;
}
#DishesArticle > .type {
  position: absolute;
  box-shadow: none;
  float: left;
  margin-bottom: 1%;
  background: none;
}
#DishesArticle > .type > .dish {
  box-shadow: -2px 2px 5px 0px black;
  float: left;
  margin-bottom: 1%;
  margin-left: 5px;
  margin-right: 5px;
  margin-top: 5px;
  width: calc(33.333% - 10px);
  cursor: pointer;
  background: white;
}
#DishesArticle > .type > .dish > .minHeader {
  width: 100%;
  height: 50px;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
  position: relative;
}
#DishesArticle > .type > .dish > ul {
  list-style-type: none;
  overflow-y: scroll;
  width: 100%;
  height: calc(23px * 4);
}
#DishesArticle > .type > .dish > ul > li {
  background-color: rgb(215, 215, 215);
  height: 23px;
  overflow: hidden;
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
#DishesArticle > .type > .dish > ul > li::after,
#DishesArticle > .type > .dish > ul > li > div::after {
  display: block;
  clear: both;
  content: "";
}
#DishesArticle > .type > .dish > ul > li:nth-child(2n) {
  background-color: white;
}
#DishesArticle > .type > .dish > ul > li > div {
  padding: 1%;
  box-sizing: border-box;
}
#DishesArticle > .type > .dish > ul > li > div > .name {
  float: left;
  width: 75%;
}
#DishesArticle > .type > .dish > ul > li > div > .name > span {
  display: inline-block;
  width: 6px;
  height: 6px;
  border: 1px solid black;
  border-radius: 50%;
  margin-left: 3px;
  margin-top: 3px;
  vertical-align: text-top;
  box-sizing: border-box;
}
#DishesArticle > .type > .dish > ul > li > div > .weight {
  float: left;
  width: 15%;
  text-align: center;
}
#DishesArticle > .type > .dish > ul > li > div > .type {
  float: left;
  width: 10%;
}
#DishesArticle > .rightCol > .minHeader {
  position: relative;
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
}
#DishesArticle > .rightCol > .minHeader > h2 {
  position: absolute;
  bottom: 1%;
  left: 2%;
  font-size: 1.1em;
}
#DishesArticle > .rightCol > .minHeader > .addBtn {
  position: absolute;
  cursor: pointer;
  border: 1px dotted white;
  top: 2%;
  right: 2%;
  font-size: 1.1em;
  width: 20px;
  height: 20px;
  text-align: center;
}
#DishesArticle > .rightCol > .content {
  padding: 1%;
  box-sizing: border-box;
}
#DishesArticle > .rightCol > .content input {
  padding: 1%;
  width: 98%;
  border: none;
  border-bottom: 1px solid black;
  float: left;
  box-sizing: border-box;
  margin: 1%;
}
#DishesArticle > .rightCol > .content > .sortPanel {
  width: 100%;
  float: left;
}
#DishesArticle > .rightCol > .content > .sortPanel > .sortIcons {
  display: flex;
  justify-content: space-between;
  padding: 1%;
  padding-bottom: 2%;
}
#DishesArticle > .rightCol > .content > .sortPanel > .sortIcons > .icon {
  width: 30px;
  height: 30px;
  cursor: pointer;
}
#DishesArticle > .rightCol > .content > .sortPanel > .sortIcons > .icon > div {
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
#DishesArticle
  > .rightCol
  > .content
  > .sortPanel
  > .sortIcons
  > .icon
  > div.active {
  background-color: rgb(255, 255, 255);
  margin-top: -2px;
}
#DishesArticle .icon.breakfasts > div {
  background-image: url("dist/img/dishesIcons/breakfasts.png");
}
#DishesArticle .icon.firstDishes > div {
  background-image: url("dist/img/dishesIcons/soups.png");
}
#DishesArticle .icon.mainDishes > div {
  background-image: url("dist/img/dishesIcons/mainDishes.png");
}
#DishesArticle .icon.garnishes > div {
  background-image: url("dist/img/dishesIcons/garnishes.png");
}
#DishesArticle .icon.salads > div {
  background-image: url("dist/img/dishesIcons/salads.svg");
}
#DishesArticle .icon.appetizer > div {
  background-image: url("dist/img/dishesIcons/appetizer.png");
}
#DishesArticle .icon.drinks > div {
  background-image: url("dist/img/dishesIcons/drinks.png");
}
#DishesArticle .icon.sweets > div {
  background-image: url("dist/img/dishesIcons/desserts.png");
}
#DishesArticle
  > .rightCol
  > .content
  > .sortPanel
  > .sortIcons
  > .icon.breakfasts:hover
  > div,
#DishesArticle
  > .rightCol
  > .content
  > .sortPanel
  > .sortIcons
  > .icon.firstDishes:hover
  > div,
#DishesArticle
  > .rightCol
  > .content
  > .sortPanel
  > .sortIcons
  > .icon.mainDishes:hover
  > div,
#DishesArticle
  > .rightCol
  > .content
  > .sortPanel
  > .sortIcons
  > .icon.garnishes:hover
  > div,
#DishesArticle
  > .rightCol
  > .content
  > .sortPanel
  > .sortIcons
  > .icon.salads:hover
  > div,
#DishesArticle
  > .rightCol
  > .content
  > .sortPanel
  > .sortIcons
  > .icon.appetizer:hover
  > div,
#DishesArticle
  > .rightCol
  > .content
  > .sortPanel
  > .sortIcons
  > .icon.drinks:hover
  > div,
#DishesArticle
  > .rightCol
  > .content
  > .sortPanel
  > .sortIcons
  > .icon.sweets:hover
  > div {
  margin-top: -2px;
}
#DishesArticle > .rightCol > .content > select {
  padding: 1%;
  width: 100%;
  border: none;
  border-bottom: 1px solid black;
}
#DishesArticle > .rightCol > .content > .border {
  box-shadow: -2px 2px 3px 0px rgb(103, 122, 154);
  width: 98%;
  height: 1px;
  margin: auto;
  background: rgb(103, 122, 154);
  margin-top: 1%;
}
#DishesArticle > .rightCol > .content > input.search {
  margin: 2%;
  margin-right: 0;
  width: 78%;
  border-bottom: 1px solid white;
  border-right: 1px solid white;
  padding: 2%;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
  /* box-shadow: -2px 2px 3px 0px black; */
}
#DishesArticle > .rightCol > .content > input.weight {
  margin: 2%;
  width: 18%;
  padding: 2%;
  margin-left: 0;
  border-bottom: 1px solid white;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
  /* box-shadow: -2px 2px 3px 0px black; */
}
#DishesArticle > .rightCol > .content > input.weight::placeholder,
#DishesArticle > .rightCol > .content > input.search::placeholder {
  color: white;
}
#DishesArticle > .rightCol > .content > ul {
  list-style-type: none;
  max-height: calc(27px * 4);
}
#DishesArticle > .rightCol > .content > ul > li {
  border-bottom: 1px solid black;
  padding: 1%;
  box-sizing: border-box;
  height: 27px;
}
#DishesArticle > .rightCol > .content > ul > li:last-child {
  border: none;
}
#DishesArticle > .rightCol > .content > ul > li::after {
  display: block;
  content: "";
  clear: both;
}
#DishesArticle > .rightCol > .content > .selectedIngredients {
  overflow-y: scroll;
  width: 100%;
  border-bottom: 1px solid black;
}
#DishesArticle > .rightCol > .content > .selectedIngredients > li {
  background-color: rgb(215, 215, 215);
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
#DishesArticle
  > .rightCol
  > .content
  > .selectedIngredients
  > li:nth-child(2n) {
  background-color: white;
}
#DishesArticle
  > .rightCol
  > .content
  > .selectedIngredients
  > li
  > div
  > .name {
  float: left;
  width: 70%;
  cursor: default;
}
#DishesArticle
  > .rightCol
  > .content
  > .selectedIngredients
  > li
  > div
  > .weight {
  float: left;
  width: 10%;
  margin: 0;
  border: 1px dotted black;
  background: none;
}
#DishesArticle
  > .rightCol
  > .content
  > .selectedIngredients
  > li
  > div
  > .round {
  float: left;
  width: 5%;
  margin: 0;
  cursor: pointer;
}
#DishesArticle
  > .rightCol
  > .content
  > .selectedIngredients
  > li
  > div
  > .type {
  float: left;
  width: 10%;
  cursor: default;
}
#DishesArticle
  > .rightCol
  > .content
  > .selectedIngredients
  > li
  > div
  > .delete {
  float: right;
  width: 5%;
  cursor: pointer;
}
#DishesArticle > .rightCol > .content > .filteredIngredients {
  overflow-y: scroll;
  width: 100%;
  border-top: 1px solid black;
  margin-top: 3px;
}
#DishesArticle > .rightCol > .content > .filteredIngredients > li {
  background-color: rgb(215, 215, 215);
  overflow: hidden;
  white-space: nowrap;
  text-overflow: ellipsis;
}
#DishesArticle
  > .rightCol
  > .content
  > .filteredIngredients
  > li:nth-child(2n) {
  background-color: white;
}
#DishesArticle > .rightCol > .content > .filteredIngredients > li > .name {
  float: left;
  width: 90%;
}
#DishesArticle > .rightCol > .content > .filteredIngredients > li > .add {
  float: left;
  width: 10%;
  text-align: center;
  cursor: pointer;
}
#DishesArticle > .rightCol > .content > button {
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
