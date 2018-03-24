import Vue from 'vue';
import Router from 'vue-router';
import Employee from '@/components/employee';
import Index from '@/components/index';
import Charts from '@/components/charts';
import Contact from '@/components/Contact';
import ContentDiv from '@/components/indexContent';
import Background from '@/components/background/Background';
import BackgroundIndex from '@/components/background/BackgroundIndex';
import B_First from '@/components/background/Employee';
import Article from '@/components/background/Article';
import News from '@/components/news';
import VacationApply from '@/components/background/VacationApply';
import WorkAttendance from '@/components/background/WorkAttendance';
import AttendanceVerify from '@/components/background/AttendanceVerify';
import Role from '@/components/background/Role';
import Authority from '@/components/background/Authority'
import Department from '@/components/background/Department'
import Message from '@/components/background/Message'
import Advice from '@/components/background/Advice'
Vue.use(Router)

export default new Router({
    routes: [
        {
          path: '/', name: 'Index', component: Index,
          children:[
            {path:'',name:'contentDiv',component:ContentDiv},
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
                    component: B_First,
                },
                {
                    path: 'article',
                    name:'article',
                    component: Article
                },
                {
                    path:'vacationApply',
                    name:'vacationApply',
                    component: VacationApply
                },
                {
                    path:'workAttendance',
                    name:'workAttendance',
                    component: WorkAttendance
                },
                {
                    path:'attendanceVerify',
                    name:'attendanceVerify',
                    component: AttendanceVerify
                },
                {
                    path:'role',
                    name:'role',
                    component:Role
                },
                {
                    path:'authority',
                    name:'authority',
                    component:Authority
                },
                {
                    path:'department',
                    name:'department',
                    component:Department
                },
                {
                    path:'message',
                    name:'message',
                    component:Message
                },
                {
                    path:'advice',
                    name:'advice',
                    component:Advice
                }
            ]
        }
    ]
})
