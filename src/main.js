// The Vue build version to load with the `import` command
// (runtime-only or standalone) has been set in webpack.base.conf with an alias.
import Vue from 'vue'
import App from './App'
import router from './router'
import echarts from 'echarts'
import axios from "axios"
import Vuex from 'vuex'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'

Vue.use(ElementUI);
Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        username:"",
        phpUrl:"http://localhost/vue-project-one/think5/public/index.php?s=",
        imgUrl:"http://localhost/vue-project-one/think5/public"
    }
})

Vue.prototype.$axios=axios;
Vue.prototype.$echarts=echarts;
Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  store,
  template: '<App/>',
  components: { App },
})
