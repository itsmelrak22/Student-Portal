require('./bootstrap');
import Vue from 'vue'
import Vuetify from 'vuetify'
import Router from './router'
import store from './store'
import App from './template/App';
import GuestDashboard from './auth/Login2';
// import Login from './auth/Login';
Vue.use(Vuetify)


new Vue({
    el: '#app',
    store,
    router:Router,
    vuetify: new Vuetify(),
    components : {
        App,
        GuestDashboard,
        // Landing
    }
    // render: h=>h(App)
});
