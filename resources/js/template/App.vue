<template>
  <v-app id="inspire">
      <v-navigation-drawer
        v-model="drawer"
        app
      >
         <v-list dense>
            <v-subheader>Schedules :</v-subheader>
               <v-divider></v-divider>
               <v-list-item
                  v-for="(item, i) in scheduleItems"
                  :key="i + 'scheduleItems'"
                  :to="item.to"
               >
                  <v-list-item-icon>
                     <v-icon v-text="item.icon"></v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                     <v-list-item-title v-text="item.text"></v-list-item-title>
                  </v-list-item-content>
               </v-list-item> 
            <v-subheader>Users:</v-subheader>
               <v-divider></v-divider>
               <v-list-item
                  v-for="(item, i) in userItems"
                  :key="i + 'userItems'"
                  :to="item.to"
               >
                  <v-list-item-icon>
                     <v-icon v-text="item.icon"></v-icon>
                  </v-list-item-icon>
                  <v-list-item-content>
                     <v-list-item-title v-text="item.text"></v-list-item-title>
                  </v-list-item-content>
               </v-list-item>
               <v-subheader>Master Lists:</v-subheader>
               <v-divider></v-divider>
               <v-list-item
                  v-for="(item, i) in items"
                  :key="i + 'items'"
                  :to="item.to"
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
      </v-navigation-drawer>

      <v-app-bar app>
         <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
         <v-toolbar-title>Student Portal System</v-toolbar-title>
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
            {text:'Registrar', icon:'mdi-home', to:'registrar'},
            {text:'Professor', icon:'mdi-hand-wave', to:'professor'},
            {text:'Adviser', icon:'mdi-hand-wave', to:'adviser'},
            {text: 'Students', icon: 'mdi-account', to : 'students'},
         ],

         items:[
            // {text:'College', icon:'mdi-home', to:'college'},
            {text: 'Course', icon: 'mdi-account', to : 'course'},
            {text:'Department', icon:'mdi-home', to:'department'},
            {text: 'Subjects', icon: 'mdi-account', to : 'subjects'},
            {text: 'Events', icon: 'mdi-account', to : 'events'},
         ],

         scheduleItems: [
            {text:'Schedule', icon:'mdi-home', to:'schedule'},
         ],
         csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
         currentRole: null,

      }),

      computed: {
         ...mapState([
            'loggedInUser'
         ])

      },
      mounted(){
         this.currentRole = this.loggedInUser.role
      }

   }
</script>