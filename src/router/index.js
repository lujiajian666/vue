import Vue from 'vue';
import Router from 'vue-router';
import Hello from '@/components/Hello';
import Head from '@/components/head';
import Index from '@/components/index';

Vue.use(Router)

export default new Router({
  routes: [
    {path: '/', name: 'Index', component: Index},
    {path: '/hello', name: 'Hello', component: Hello},
  ]
})
