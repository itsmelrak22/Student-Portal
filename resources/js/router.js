import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)
import Schedule from './components/Schedule';
import Department from './components/Department';
import College from './components/College';
import Registrar from './components/Registrar';
import Professor from './components/Professor';
import Students from './components/Students';
import Subjects from './components/Subjects';
import Events from './components/Events';

import store from './store';

const checkIfAdmin = ( to, from, next, allowedRoles ) => {
    // console.log( 'allowedRoles', allowedRoles )  
    if ( allowedRoles.includes( store.state.loggedInUser.role )) {
        next(); 
    
    } else {
        alert('Restricted Page!')
        next('/'); 
    }
}

export default new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/registrar',
            name: 'registrar',
            component: Registrar,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin'])
            }
        },
        {
            path: '/college',
            name: 'college',
            component: College,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin'])
            }
        },
        {
            path: '/department',
            name: 'department',
            component: Department,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin'])
            }
        },
        {
            path: '/schedule',
            name: 'schedule',
            component: Schedule,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin'])
            }
        },
        {
            path: '/professor',
            name: 'professor',
            component: Professor,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin'])
            }
        },

        {
            path: '/students',
            name: 'students',
            component : Students,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin'])
            }
        },

        {
            path: '/subjects',
            name: 'subjects',
            component : Subjects,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin'])
            }
        },
        {
            path: '/events',
            name: 'events',
            component : Events,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin'])
            }
        }

      
    ],
});