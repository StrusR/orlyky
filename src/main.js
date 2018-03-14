// The following line loads the standalone build of Vue instead of the runtime-only build,
// so you don't have to do: import Vue from 'vue/dist/vue'
// This is done with the browser options. For the config, see package.json
import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

var RegLog = require("./components/RegLog/RegLog.vue");

const router = new VueRouter({
  routes: [
    { path: '/RegLog', component: RegLog }
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
