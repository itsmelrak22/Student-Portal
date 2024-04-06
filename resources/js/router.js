import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import Schedule from './components/Schedule'
import Department from './components/Department'
import College from './components/College'
import Registrar from './components/Registrar'
import Professor from './components/Professor'
import Students from './components/Students'
import Subjects from './components/Subjects'

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/registrar',
            name: 'registrar',
            component: Registrar
        },
        {
            path: '/college',
            name: 'college',
            component: College
        },
        {
            path: '/department',
            name: 'department',
            component: Department
        },
        {
            path: '/schedule',
            name: 'schedule',
            component: Schedule
        },
        {
            path: '/professor',
            name: 'professor',
            component: Professor
        },

        {
            path: '/students',
            name: 'students',
            component : Students
        },

        {
            path: '/subjects',
            name: 'subjects',
            component : Subjects
        }

      
    ],
});