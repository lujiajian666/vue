import Vue from 'vue';
import Router from 'vue-router';
import Hello from '@/components/Hello';
import Index from '@/components/index';
import Charts from '@/components/charts';

Vue.use(Router)

export default new Router({
  routes: [
    {path: '/', name: 'Index', component: Index},
    {path: '/hello', name: 'Hello', component: Hello},
    {path: '/charts',name:'charts',component:Charts}
  ]
})
