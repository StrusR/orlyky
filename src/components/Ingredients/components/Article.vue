<template>
    <article id="IngredientsArticle">
      <div class="navigation">
        <div class="sortIcons">
          <div class="icon groat" @click="selectedGroup='groat'"><div :class="{active: selectedGroup=='groat'}"></div></div>
          <div class="icon canned" @click="selectedGroup='canned'"><div :class="{active: selectedGroup=='canned'}"></div></div>
          <div class="icon milk" @click="selectedGroup='milk'"><div :class="{active: selectedGroup=='milk'}"></div></div>
          <div class="icon vegetable" @click="selectedGroup='vegetable'"><div :class="{active: selectedGroup=='vegetable'}"></div></div>
          <div class="icon meat" @click="selectedGroup='meat'"><div :class="{active: selectedGroup=='meat'}"></div></div>
          <div class="icon spices" @click="selectedGroup='spices'"><div :class="{active: selectedGroup=='spices'}"></div></div>
          <div class="icon sweet" @click="selectedGroup='sweet'"><div :class="{active: selectedGroup=='sweet'}"></div></div>
          <div class="icon other" @click="selectedGroup='other'"><div :class="{active: selectedGroup=='other'}"></div></div>
        </div>
      </div>
      
      <transition name="fade" >
        <div class="leftCol" v-if="group==selectedGroup" v-for="group in groupList" :key="group">
          <div class="ingtedient" v-if="ingredient.gr==group" v-for="(ingredient, index) in ingredients" :key="'ingtedient'+index" @click="selectIngredient(ingredient)">
            <div class="minHeader">
              {{ingredient.name}}
            </div>
            <ul>
              <li>Ціна за
                {{ingredient.weight}}
                <span v-if="ingredient.type==3"> шт.</span>
                <span v-else> гр.</span>
              </li>
              <li>{{ingredient.price}} грн</li>.
            </ul>
          </div>
        </div>
      </transition>
      
       <div class="rightCol">
            <div class="minHeader">
                <h2 v-if="rightCol == 'addIngredient'">Додати ігнрадієнт</h2>
                <h2 v-if="rightCol == 'changeIngredient'">Редагувати ігнрадієнт</h2>
                <div @click="addIngredientShow()" class="addBtn">+</div>
            </div>

            <input type="text" placeholder="Назва інградієнту" v-model="selectedName">
            <div class="sortPanel">
              <div class="sortIcons">
                <div class="icon groat" @click="selectedGroupEdit='groat'"><div :class="{active: selectedGroupEdit=='groat'}"></div></div>
                <div class="icon canned" @click="selectedGroupEdit='canned'"><div :class="{active: selectedGroupEdit=='canned'}"></div></div>
                <div class="icon milk" @click="selectedGroupEdit='milk'"><div :class="{active: selectedGroupEdit=='milk'}"></div></div>
                <div class="icon vegetable" @click="selectedGroupEdit='vegetable'"><div :class="{active: selectedGroupEdit=='vegetable'}"></div></div>
                <div class="icon meat" @click="selectedGroupEdit='meat'"><div :class="{active: selectedGroupEdit=='meat'}"></div></div>
                <div class="icon spices" @click="selectedGroupEdit='spices'"><div :class="{active: selectedGroupEdit=='spices'}"></div></div>
                <div class="icon sweet" @click="selectedGroupEdit='sweet'"><div :class="{active: selectedGroupEdit=='sweet'}"></div></div>
                <div class="icon other" @click="selectedGroupEdit='other'"><div :class="{active: selectedGroupEdit=='other'}"></div></div>
              </div>
            </div>
            <input v-if="selectedType==2" type="number" v-model="selectedWeight" placeholder="Вага" class="weight" disabled> 
            <input v-else-if="selectedType==1" type="number" v-model="selectedWeight" placeholder="Вага" class="weight">
            <input v-if="selectedType==3" type="number" v-model="selectedWeight" placeholder="Вага" class="weight" disabled> 
            <input type="number" v-model="selectedPrice" placeholder="Ціна" class="price">
            <select class="type" v-model="selectedType">
                <option value="1">уп.</option>
                <option value="2">гр.</option>
                <option value="3">шт.</option>
            </select> 

            <button @click="addIngredient()" v-if="rightCol == 'addIngredient'">Додати</button>
            <button @click="changeIngredient()" v-if="rightCol == 'changeIngredient'">Редагувати</button>
            <button @click="deleteIngredient()" v-if="rightCol == 'changeIngredient'">Видалити</button>
        </div>
    </article>
</template>

<script>
var IngredientsArticleData = {
  ingredients: "",
  selectedGroup: "groat",
  selectedGroupEdit: "groat",
  rightCol: "addIngredient",
  selectedIngredient: "",
  selectedPrice: "",
  selectedName: "",
  selectedType: 1,
  selectedWeight: 1000,

  groupList: [
    "groat",
    "canned",
    "milk",
    "vegetable",
    "meat",
    "spices",
    "sweet",
    "other"
  ],
  up: ""
};

export default {
  name: "IngredientsArticle",
  data: function() {
    return IngredientsArticleData;
  },
  created: function() {
    var that = this;
    this.updateIngredients();
    this.up = setInterval(() => {
      that.updateIngredients();
    }, 1000);
  },
  destroyed: function() {
    clearInterval(this.up);
  },
  watch: {
    selectedType: function() {
      if (this.selectedType == 2) {
        this.selectedWeight = 1000;
      } else if (this.selectedType == 3) {
        this.selectedWeight = 1;
      }
    }
  },
  methods: {
    updateIngredients: function() {
      var that = this;
      $.ajax({
        url: "../orlyky/server/get/ingredients.php",
        type: "POST",
        dataType: "json",

        success: function(data) {
          that.ingredients = data.ingredients;
        },

        error: function() {
          alert("error");
        }
      });
    },
    selectIngredient: function(ingredient) {
      this.rightCol = "changeIngredient";
      this.selectedIngredient = ingredient.id;
      this.selectedPrice = ingredient.price;
      this.selectedName = ingredient.name;
      this.selectedType = ingredient.type;
      this.selectedWeight = ingredient.weight;
      this.selectedGroupEdit = ingredient.gr;
    },
    addIngredient: function() {
      var that = this;
      $.ajax({
        url: "../orlyky/server/set/addIngredient.php",
        type: "POST",
        dataType: "json",
        data: {
          name: that.selectedName,
          type: that.selectedType,
          weight: that.selectedWeight,
          price: that.selectedPrice,
          gr: that.selectedGroupEdit
        },

        success: function(data) {
          that.updateIngredients();
        }
      });
    },
    changeIngredient: function() {
      var that = this;
      $.ajax({
        url: "../orlyky/server/set/changeIngredient.php",
        type: "POST",
        dataType: "json",
        data: {
          id: that.selectedIngredient,
          name: that.selectedName,
          type: that.selectedType,
          weight: that.selectedWeight,
          price: that.selectedPrice,
          gr: that.selectedGroupEdit
        },

        success: function(data) {
          that.updateIngredients();
        }
      });
    },
    deleteIngredient: function() {
      var that = this;
      $.ajax({
        url: "../orlyky/server/set/deleteIngredient.php",
        type: "POST",
        dataType: "json",
        data: {
          id: that.selectedIngredient
        },

        success: function(data) {
          that.updateIngredients();
          that.addIngredientShow();
        }
      });
    },
    addIngredientShow: function() {
      this.rightCol = "addIngredient";
      this.selectedIngredient = "";
      this.selectedPrice = "";
      this.selectedName = "";
      this.selectedType = 1;
      this.selectedWeight = 1000;
    }
  }
};
</script>

<style>
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
}
#IngredientsArticle > .navigation > .sortIcons > .icon.groat:hover > div,
#IngredientsArticle > .navigation > .sortIcons > .icon.canned:hover > div,
#IngredientsArticle > .navigation > .sortIcons > .icon.milk:hover > div,
#IngredientsArticle > .navigation > .sortIcons > .icon.vegetable:hover > div,
#IngredientsArticle > .navigation > .sortIcons > .icon.meat:hover > div,
#IngredientsArticle > .navigation > .sortIcons > .icon.spices:hover > div,
#IngredientsArticle > .navigation > .sortIcons > .icon.sweet:hover > div,
#IngredientsArticle > .navigation > .sortIcons > .icon.other:hover > div {
  margin-left: 2px;
}
#IngredientsArticle .icon.groat > div {
  background-image: url("dist/img/ingregientsIcons/groat.png");
}
#IngredientsArticle .icon.canned > div {
  background-image: url("dist/img/ingregientsIcons/canned.png");
}
#IngredientsArticle .icon.milk > div {
  background-image: url("dist/img/ingregientsIcons/milk.png");
}
#IngredientsArticle .icon.vegetable > div {
  background-image: url("dist/img/ingregientsIcons/vegetable.png");
}
#IngredientsArticle .icon.meat > div {
  background-image: url("dist/img/ingregientsIcons/meat.png");
}
#IngredientsArticle .icon.spices > div {
  background-image: url("dist/img/ingregientsIcons/spices.png");
}
#IngredientsArticle .icon.sweet > div {
  background-image: url("dist/img/ingregientsIcons/sweet.png");
}
#IngredientsArticle .icon.other > div {
  background-image: url("dist/img/ingregientsIcons/other.png");
}
#IngredientsArticle .leftCol {
  background: none;
  box-shadow: none;
  float: left;
  margin-bottom: 1%;
  position: absolute;
}
#IngredientsArticle .leftCol .ingtedient {
  box-shadow: -2px 2px 5px 0px black;
  float: left;
  margin-bottom: 1%;
  margin-left: 5px;
  margin-right: 5px;
  margin-top: 5px;
  width: calc(33% - 10px);
  cursor: pointer;
}
#IngredientsArticle .leftCol .ingtedient .minHeader {
  width: 100%;
  height: 50px;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
  position: relative;
}
#IngredientsArticle .leftCol .ingtedient ul {
  background: white;
}
#IngredientsArticle .leftCol .ingtedient ul li {
  display: inline-block;
}
#IngredientsArticle .rightCol .minHeader {
  position: relative;
  width: 100%;
  height: 100px;
  background: linear-gradient(rgb(103, 122, 154) 20%, rgb(53, 53, 53));
  color: white;
}
#IngredientsArticle > .rightCol > .minHeader > h2 {
  position: absolute;
  bottom: 1%;
  left: 2%;
  font-size: 1.1em;
}
#IngredientsArticle > .rightCol > .minHeader > .addBtn {
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
#IngredientsArticle > .rightCol > .sortPanel {
  width: 100%;
  float: left;
}
#IngredientsArticle > .rightCol > .sortPanel > .sortIcons {
  display: flex;
  justify-content: space-between;
  padding: 1%;
  padding-bottom: 2%;
}
#IngredientsArticle > .rightCol > .sortPanel > .sortIcons > .icon {
  width: 30px;
  height: 30px;
  cursor: pointer;
}
#IngredientsArticle > .rightCol > .sortPanel > .sortIcons > .icon > div {
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
#IngredientsArticle > .rightCol > .sortPanel > .sortIcons > .icon > div.active {
  background-color: rgb(255, 255, 255);
  margin-top: -2px;
}
#IngredientsArticle > .rightCol input {
  padding: 1%;
  width: 100%;
  border: none;
  border-bottom: 1px solid black;
  float: left;
  box-sizing: border-box;
  font-size: 0.9em;
  height: 25px;
}
#IngredientsArticle > .rightCol input.price {
  width: 40%;
  border-right: 1px solid black;
}
#IngredientsArticle > .rightCol .weight {
  padding: 1.2%;
  width: 30%;
  border: none;
  border-bottom: 1px solid black;
  float: left;
  box-sizing: border-box;
  font-size: 0.9em;
  height: 25px;
  border-right: 1px solid black;
}
#IngredientsArticle > .rightCol .type {
  padding: 1%;
  width: 30%;
  border: none;
  border-bottom: 1px solid black;
  float: left;
  box-sizing: border-box;
  font-size: 0.9em;
  height: 25px;
}
#IngredientsArticle > .rightCol > button {
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
