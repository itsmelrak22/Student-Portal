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
import Adviser from './components/Adviser';
import Course from './components/Course';



import MyGrades from './components/MyGrades';
import MyEnrolledSubjects from './components/MyEnrolledSubjects';
import MySchedules from './components/MySchedules';
import MyAdvising from './components/MyAdvising';
import MyAdvises from './components/MyAdvises';

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
                checkIfAdmin(to, from, next, ['Admin', 'Registrar', 'Professor'])
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
            path: '/adviser',
            name: 'adviser',
            component: Adviser,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin', 'Registrar'])
            }
        },

        {
            path: '/students',
            name: 'students',
            component : Students,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin', 'Registrar'])
            }
        },

        {
            path: '/subjects',
            name: 'subjects',
            component : Subjects,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin', 'Registrar'])
            }
        },
        {
            path: '/events',
            name: 'events',
            component : Events,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin'])
            }
        },
        {
            path: '/course',
            name: 'course',
            component : Course,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Admin', 'Registrar'])
            }
        },
        {
            path: '/my-grades',
            name: 'my-grades',
            component : MyGrades,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Student'])
            }
        },
        {
            path: '/my-enrolled-subjects',
            name: 'my-enrolled-subjects',
            component : MyEnrolledSubjects,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Student'])
            }
        },
        {
            path: '/my-schedules',
            name: 'my-schedules',
            component : MySchedules,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Student'])
            }
        },
        {
            path: '/my-advising',
            name: 'my-advising',
            component : MyAdvising,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Student'])
            }
        },
        {
            path: '/my-advises',
            name: 'my-advises',
            component : MyAdvises,
            beforeEnter: (to, from, next) => {
                checkIfAdmin(to, from, next, ['Adviser'])
            }
        }

      
    ],
});