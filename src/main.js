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
    {
      path: '/', name: 'Orlyk', component: Orlyk, children: [
        {
          // при совпадении пути с шаблоном /user/:id/profile
          // в <router-view> компонента User будет отображён UserProfile
          path: 'profile/:id',
          component: Orlyk
        },
        // {
        //   // при совпадении с шаблоном /user/news
        //   // в <router-view> компонента User будет отображён UserPosts
        //   path: 'news',
        //   component: news
        // }
      ]
    }
    // { path: '*', component: NotFound }
  ],
  scrollBehavior(to, from, savedPosition) {
    return { x: 0, y: 0 }
  }
});

var app = new Vue({
  el: '#app',
  router: router
})
