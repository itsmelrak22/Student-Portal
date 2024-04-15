import axios from 'axios';
import Vue from 'vue';
import Vuex from 'vuex';
import collegeActions from './college_store/collegeActions';
import collegeData from './college_store/collegeData';
import collegeMutations from './college_store/collegeMutations';
import departmentMutations from './department_store/departmentMutations';
import departmentActions from './department_store/departmentActions';
import departmentData from './department_store/departmentData';
import scheduleData from './schedule_store/scheduleData';
import scheduleActions from './schedule_store/scheduleActions';
import scheduleMutations from './schedule_store/scheduleMutations';
import createPersistedState from 'vuex-persistedstate';

import USER_STORE_STATES from './users_store/state';
import USER_STORE_MUTATIONS from './users_store/mutations';
import USER_STORE_ACTIONS from './users_store/actions';
import USER_STORE_GETTERS from './users_store/getters';
import studentData from './student_store/studentData';
import studentActions from './student_store/studentActions';
import studentMutations from './student_store/studentMutations';
import SUBJECT_STORE_STATES from './subject_store/state';
import SUBJECT_STORE_MUTATIONS from './subject_store/mutations';
import SUBJECT_STORE_ACTIONS from './subject_store/actions';
import EVENT_STORE_STATES from './events_store/state';
import EVENT_STORE_MUTATIONS from './events_store/mutations';
import EVENT_STORE_ACTIONS from './events_store/actions';
Vue.use(Vuex)
const persistedData = new createPersistedState({
    key:'local_storage',
    storage: localStorage,
    reducer : state => ({
        loggedInUser : state.loggedInUser
    })
})

export default new Vuex.Store({
    state:{
        /* 
        * 
        * KARL ->
        * 
        * */

        ...USER_STORE_STATES,

        /* 
        * 
        * <- KARL
        * 
        * */
        ...scheduleData,
        ...departmentData,
        ...collegeData,
        ...studentData,
        ...SUBJECT_STORE_STATES,
        ...EVENT_STORE_STATES,
        ROLES: ['Registrar', 'Professor', 'Student', 'Adviser'],
        professorData: [],
        registrarData: [],
        loggedInUser : null,
        allUsers : [],
        rules: {
            required: [(v) => !!v || "Field is required"],
            email: [
                (v) =>
                    !v ||
                    /^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
                    "E-mail must be valid",
            ],
            password: [
                (v) => !!v || "Field is required",
                // (v) => !v || /[0-9]/.test(v) || "Must contain number",
                // (v) => !v || /[a-zA-Z]/.test(v) || "Must contain letter",
                // v => !v || /[@$!%*?&]/.test(v) || 'Must contain symbol',
                (v) =>
                    (v || "").length >= 8 ||
                    "Must contain atlest 8 characters.",
            ],
            hex: [
                (v) =>
                    !v || /[0-9A-Fa-f]{6}/.test(v) || "Must be a hex value",
            ],
            uniqueEmail(list) {
                return [
                    (v) => !!v || "Field is required",
                    (v) => 
                        // console.log(typeof _.find(list, {name : v}) === 'object', list, v)
                        typeof _.find(list, {email : v}) === 'undefined' ||
                        "Email is already exists.",
                ];
            },
            uniqueDataEdit(list, excludeName, property) {
                return [
                  (v) => !!v || "Field is required",
                  (v) =>
                    typeof _.find(list, (item) => item[property] === v && item[property] !== excludeName) === 'undefined' ||
                    "already exists.",
                ];
            },        
            confirmpassword(temp, actual) {
                return [(v) => temp === actual || "Password must match"];
            },
            uniqueRole(list) {
                return [
                    (v) => !!v || "Field is required",
                    (v) => 
                        // console.log(typeof _.find(list, {name : v}) === 'object', list, v)
                        typeof _.find(list, {name : v}) === 'undefined' ||
                        "Role is already exists.",
                ];
            },
            uniquePermission(list) {
                return [
                    (v) => !!v || "Field is required",
                    (v) => 
                        // console.log(typeof _.find(list, {name : v}) === 'object', list, v)
                        typeof _.find(list, {name : v}) === 'undefined' ||
                        "Permission is already exists.",
                ];
            },
            array: [(v) => !v.length == 0 || "Field is required"],
            higher_number(min, max) {
                return [
                    (v) => !!v || "Field is required",
                    (v) => v > min || "Must Higher",
                    (v) => v <= max || "Too much",
                ];
            },
            numberRule: [
                (v) => {
                    if (!isNaN(v) && v >= 0 && v <= 99) return true;
                    return "Field is required";
                },
            ],
        },
    },

    actions:{
         /* 
        * 
        * KARL ->
        * 
        * */
       
         ...USER_STORE_ACTIONS,

         /* 
         * 
         * <- KARL
         * 
         * */
        ...scheduleActions,
        ...departmentActions,
        ...collegeActions,
        ...studentActions,
        ...SUBJECT_STORE_ACTIONS,
        ...EVENT_STORE_ACTIONS,

        getProfessorData(context){
            context.commit('getProfessorData')
        },
        getRegistrarData(context){
            context.commit('getRegistrarData')
        },

        login({commit}){
            axios({
                method : "GET",
                url : 'auth-user',
            })
            .then( response => {
                commit('login', response.data);
            } )
        },

        logout(context){
            context.commit('logout');
        },
    },

    mutations:{
        /* 
        * 
        * KARL ->
        * 
        * */
       
        ...USER_STORE_MUTATIONS,

        /* 
        * 
        * <- KARL
        * 
        * */
        ...scheduleMutations,
        ...departmentMutations,
        ...collegeMutations,
        ...studentMutations,
        ...SUBJECT_STORE_MUTATIONS,
        ...EVENT_STORE_MUTATIONS,
        
        getProfessorData(state){
            axios({
                method: "GET",
                url: '/getProfessorData'
            }).then((res) =>{
                state.professorData = res.data
            })
        },
        getRegistrarData(state){
            axios({
                method: "GET",
                url: '/getRegistrarData'
            }).then((res) =>{
                state.registrarData = res.data
            })
        },


        login(state, payload){
            state.loggedInUser = payload
            window.location.href='/';
        },

        logout(state){
            state.loggedInUser = {}
            state.isLoggedin = false;
        },

        getUsers(state, data){
            state.allUsers = data
        }
    },
    getters:{
        /* 
        * 
        * KARL ->
        * 
        * */
       
        ...USER_STORE_GETTERS,

        /* 
        * 
        * <- KARL
        * 
        * */ 
    },
    plugins: [persistedData]
});