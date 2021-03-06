// The following line loads the standalone build of Vue instead of the runtime-only build,
// so you don't have to do: import Vue from 'vue/dist/vue'
// This is done with the browser options. For the config, see package.json
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

var Home = require("./components/Home.vue");
var RegLog = require("./components/RegLog/RegLog.vue");

var Orlyk = require("./components/Orlyk/Orlyk.vue");
var Accept = require("./components/Orlyk/components/Article/components/Accept.vue");
var Regect = require("./components/Orlyk/components/Article/components/Regect.vue");

var News = require("./components/News/News.vue");

var Events = require("./components/Events/Events.vue");

var Ev = require("./components/Ev/Ev.vue");
var eventMain = require("./components/Ev/components/eventMain.vue");
var eventMenu = require("./components/Ev/components/eventMenu.vue");
var eventInventory = require("./components/Ev/components/eventInventory.vue");

var Dishes = require("./components/Dishes/Dishes.vue");
var Ingredients = require("./components/Ingredients/Ingredients.vue");

var Statement = require("./components/Statement/Statement.vue");


var router = new VueRouter({
  routes: [{
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/RegLog',
      name: 'RegLog',
      component: RegLog
    },
    {
      path: '/profile/:id',
      name: 'profile',
      component: Orlyk,
      children: [{
          path: 'accept',
          name: 'accept',
          component: Accept
        },
        {
          path: 'regect',
          name: 'regect',
          component: Regect
        }
      ]
    },
    {
      path: '/news',
      name: 'news',
      component: News
    },
    {
      path: '/events',
      name: 'events',
      component: Events
    },
    {
      path: '/event/:id',
      name: 'event',
      component: Ev,
      children: [{
          path: '/',
          name: 'eventMain',
          component: eventMain
        },
        {
          path: 'menu',
          name: 'eventMenu',
          component: eventMenu
        },
        {
          path: 'inventory',
          name: 'eventInventory',
          component: eventInventory
        }
      ]
    },
    {
      path: '/dishes',
      name: 'dishes',
      component: Dishes
    },
    {
      path: '/ingredients',
      name: 'ingredients',
      component: Ingredients
    },
    {
      path: '/statement/:id',
      name: 'statement',
      component: Statement
    },
    {
      path: '*',
      redirect: "/"
    },
    {
      path: '/#/',
      redirect: "/"
    }
  ],
  scrollBehavior(to, from, savedPosition) {
    return {
      x: 0,
      y: 0
    }
  }
});

var app = new Vue({
  el: '#app',
  router: router
})