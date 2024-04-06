<template>
  <v-app id="inspire">
      <v-navigation-drawer
        v-model="drawer"
        app
      >
         <v-list dense>
            <v-subheader>List of Tables:</v-subheader>
               <v-list-item
                  v-for="(item, i) in items"
                  :key="i"
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
         items:[
            {text:'Registrar', icon:'mdi-home', to:'registrar'},
            {text:'College', icon:'mdi-home', to:'college'},
            {text:'Schedule', icon:'mdi-home', to:'schedule'},
            {text:'Department', icon:'mdi-home', to:'department'},
            {text:'Professor', icon:'mdi-hand-wave', to:'professor'},
            {text: 'Students', icon: 'mdi-account', to : 'students'},
            {text: 'Subjects', icon: 'mdi-account', to : 'subjects'},
         ],
         csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),

      }),

      computed: {
         ...mapState([
            'loggedInUser'
         ])

      },
   }
</script>