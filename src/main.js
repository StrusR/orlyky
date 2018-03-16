// The following line loads the standalone build of Vue instead of the runtime-only build,
// so you don't have to do: import Vue from 'vue/dist/vue'
// This is done with the browser options. For the config, see package.json
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

var RegLog = require("./components/RegLog/RegLog.vue");
var Orlyk = require("./components/Orlyk/Orlyk.vue");

var router = new VueRouter({
  routes: [
    { path: '/RegLog', name: 'RegLog', component: RegLog },
    { path: '/profile/:id', name: 'profile', component: Orlyk },
    // { path: '*', component: NotFound }
    { path: '*', redirect: "/RegLog" }
  ],
  scrollBehavior(to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
});

var app = new Vue({
  el: '#app',
  router: router
})
