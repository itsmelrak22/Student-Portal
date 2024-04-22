<template>
  <v-app id="inspire">
      <v-navigation-drawer
        v-model="drawer"
        app
      >
      <template v-if="loggedInUser.role == 'Student' ">
         <v-list dense >
            <v-subheader  >Student Dashboard:</v-subheader>
            <v-list-item
                  v-for="(item, i) in studentView"
                  :key="i + 'studentView'"
                  :to="item.to"
               >
               <v-list-item-icon>
                     <v-icon v-text="item.icon"></v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                     <v-list-item-title v-text="item.text"></v-list-item-title>
                  </v-list-item-content>
               </v-list-item>
         </v-list>
      </template>
      <template v-if="loggedInUser.role == 'Adviser' ">
         <v-list dense >
            <v-subheader  >Adviser Dashboard:</v-subheader>
            <v-list-item
                  v-for="(item, i) in adviserView"
                  :key="i + 'adviserView'"
                  :to="item.to"
               >
               <v-list-item-icon>
                     <v-icon v-text="item.icon"></v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                     <v-list-item-title v-text="item.text"></v-list-item-title>
                  </v-list-item-content>
               </v-list-item>
         </v-list>
      </template>
      <template v-else>
         <v-list dense>
         <v-subheader v-show="loggedInUser.role != 'Student'">Schedules :</v-subheader>
            <v-divider></v-divider>
            <v-list-item
               v-for="(item, i) in scheduleItems"
               :key="i + 'scheduleItems'"
               :to="item.to"
               v-if=" loggedInUser.role == 'Admin' || checkPermisions(item.to)"
            >
               <v-list-item-icon>
                  <v-icon v-text="item.icon"></v-icon>
               </v-list-item-icon>
               <v-list-item-content>
                  <v-list-item-title v-text="item.text"></v-list-item-title>
               </v-list-item-content>
            </v-list-item> 
            <v-subheader v-show="loggedInUser.role != 'Student'">Users:</v-subheader>
            <v-divider></v-divider>
            <v-list-item
               v-for="(item, i) in userItems"
               :key="i + 'userItems'"
               :to="item.to"
               v-if=" loggedInUser.role == 'Admin' ||  checkPermisions(item.to)"
            >
               <v-list-item-icon>
                  <v-icon v-text="item.icon"></v-icon>
               </v-list-item-icon>
               <v-list-item-content>
                  <v-list-item-title v-text="item.text"></v-list-item-title>
               </v-list-item-content>
            </v-list-item>

      </v-list>

      <v-list dense>
         <v-subheader v-show="loggedInUser.role != 'Student'">Master Lists:</v-subheader>
            <v-divider></v-divider>
            <v-list-item
               v-for="(item, i) in items"
               :key="i + 'items'"
               :to="item.to"
               v-if=" loggedInUser.role == 'Admin' ||  checkPermisions(item.to)"
            >
               <v-list-item-icon>
                  <v-icon v-text="item.icon"></v-icon>
               </v-list-item-icon>
               <v-list-item-content>
                  <v-list-item-title v-text="item.text"></v-list-item-title>
               </v-list-item-content>
            </v-list-item>
            <v-divider></v-divider>
      </v-list>
      </template>


      </v-navigation-drawer>

      <v-app-bar app>
         <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
         <v-toolbar-title>Student Portal System - {{ loggedInUser.role }} Dashboard</v-toolbar-title>
         <v-spacer></v-spacer>
         <span class="overline">{{loggedInUser.email}}</span>
         <v-tooltip bottom>
            <template v-slot:activator="{ on : tooltip }">
            <v-menu offset-y max-width="300">
            <template v-slot:activator="{ on : menu, attrs }">
               <v-btn
                  icon
                  v-bind="attrs"
                  v-on="{ ...tooltip, ...menu }"
               >
                  <v-icon>mdi-account-circle</v-icon>
               </v-btn>
            </template>
            <v-list dense>
                  <v-subheader>ACCOUNT</v-subheader>
                  <v-list-item-group>
                  <v-list-item >
                     <v-list-item-content>
                        <v-form id="logOut" method="POST" action="logout" >
                           <input type="hidden" name="_token" :value="csrf">
                           <input type="submit" value="Logout" depressed class="caption" > <v-icon>mdi-logout</v-icon>
                        </v-form>
                     </v-list-item-content>
                  </v-list-item>
                  </v-list-item-group>
            </v-list>
            </v-menu>
            </template>
            <span>Menu</span>
         </v-tooltip>
      </v-app-bar>

      <v-main class="ma-2">
         <router-view></router-view>
      </v-main>
  </v-app>
</template>

<script>
import {mapState} from 'vuex';
   export default {
      data: () => ({
         drawer: null,
         userItems: [
            {text:'Registrar', icon:'mdi-account-group', to:'registrar'},
            {text:'Professor', icon:'mdi-account-tie', to:'professor'},
            // {text:'Adviser', icon:'mdi-hand-wave', to:'adviser'},
            {text: 'Students', icon: 'mdi-account-box-multiple', to : 'students'},
         ],

         items:[
            // {text:'College', icon:'mdi-home', to:'college'},
            {text: 'Course', icon: 'mdi-book', to : 'course'},
           // {text:'Department', icon:'mdi-home', to:'department'},
            {text: 'Subjects', icon: 'mdi-book-open', to : 'subjects'},
            {text: 'Events', icon: 'mdi-account', to : 'events'},
         ],

         scheduleItems: [
            {text:'Schedule', icon:'mdi-home', to:'schedule'},
         ],
         adviserView: [
            {text:'My Advises', icon:'mdi-home', to:'my-advises'},
         ],

         studentView: [
            {text:'My Enrolled Subjects', icon:'mdi-home', to:'my-enrolled-subjects'},
            {text:'My Grades', icon:'mdi-home', to:'my-grades'},
            {text:'My Schedules', icon:'mdi-home', to:'my-schedules'},
            {text:'My Advising', icon:'mdi-home', to:'my-advising'},
         ],
         csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
         currentRole: null,

      }),

      computed: {
         ...mapState([
            'loggedInUser',
            'PERMISSIONS'
         ])

      },
      methods: {
         checkPermisions(to){
            // console.log("this.loggedInUser.role", this.loggedInUser.role);
            // console.log("this.PERMISSIONS", this.PERMISSIONS);
            // console.log("this.PERMISSIONS[this.loggedInUser.role]", this.PERMISSIONS[this.loggedInUser.role]);
            console.log('to', to)
            console.log('this.loggedInUser.role', this.loggedInUser.role)
            console.log('this.PERMISSIONS[this.loggedInUser.role]', this.PERMISSIONS[this.loggedInUser.role])
            return this.PERMISSIONS[this.loggedInUser.role].includes(to);

         }
      },
      mounted(){
         this.currentRole = this.loggedInUser.role
         console.log(this.PERMISSIONS);
      }

   }
</script>