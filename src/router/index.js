import Vue from 'vue';
import Router from 'vue-router';
import Employee from '@/components/employee';
import Index from '@/components/index';
import Charts from '@/components/charts';
import Contact from '@/components/Contact';
import contentDiv from '@/components/indexContent';
import Background from '@/components/background/Background';
import BackgroundIndex from '@/components/background/BackgroundIndex';
import B_First from '@/components/background/B_First';
import Article from '@/components/background/Article';
import News from '@/components/news';

Vue.use(Router)

export default new Router({
    routes: [
        {
          path: '/', name: 'Index', component: Index,
          children:[
            {path:'',name:'contentDiv',component:contentDiv},
            {path: '/employee', name: 'employee', component: Employee},
            {path: '/charts', name: 'charts', component: Charts},
            {path: '/contact', name: 'contact', component: Contact},
          ]
        },
        {path: '/news', name: 'news', component: News},
        {path: '/background', name: 'background', component: Background},
        {
            path: '/backgroundIndex', name: 'backgroundIndex', component: BackgroundIndex,
            children: [
                {
                    path: '',
                    name:'B_First',
                    component: B_First
                },
                {
                    path: 'article',
                    name:'article',
                    component: Article
                }
            ]
        }
    ]
})
