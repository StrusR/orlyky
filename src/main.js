// The following line loads the standalone build of Vue instead of the runtime-only build,
// so you don't have to do: import Vue from 'vue/dist/vue'
// This is done with the browser options. For the config, see package.json
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

var RegLog = require("./components/RegLog/RegLog.vue");
var Orlyk = require("./components/Orlyk/Orlyk.vue");

const router = new VueRouter({
  routes: [
    { path: '/RegLog', component: RegLog },
    { path: '/Orlyk', component: Orlyk }
    // { path: '*', component: NotFound }
  ],
  scrollBehavior(to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
});

new Vue({
  el: '#app',
  router: router
})
