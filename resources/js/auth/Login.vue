<template>

  <v-dialog width="500" v-model="loginDialog" persistent>
      <v-card class="" elevation="5" :loading="loading" >
        <template slot="progress">
          <v-progress-linear
            color="black"
            height="5"
            indeterminate
          ></v-progress-linear>
        </template>
        <v-card-title class="justify-left">
            STUDENT PORTAL
            <v-spacer/>
            <v-btn @click="toggleLoginDialog(false)" icon dark small color="success"><v-icon>mdi-close</v-icon></v-btn>
        </v-card-title>
        <v-divider></v-divider>
        <v-card-text>
        
        <v-tabs-items v-model="tab">
          <!-- Login -->
          <v-tab-item >
            <v-card-text>
              <p>Sign in with your Username and Password:</p>
              <v-form id="LoginForm" ref="LoginForm" v-on:submit.prevent="handleLogin">

                <v-text-field
                  type="username"
                  label="Username"
                  name="username"
                  v-model="employee.username"
                  prepend-icon="mdi-account-circle"
                  required
                  readonly 
                  autocomplete="off"
                  @focus="$event.target.removeAttribute('readonly');"
                  outlined
                  dense
                  :rules="[...rules.required]"
                ></v-text-field>

                <v-text-field
                  v-model="employee.password"
                  id="hiddenPassword"
                  label="Password"
                  autocomplete="off"
                  prepend-icon="mdi-lock" 
                  :type="showPassword ? 'text' : 'password' "
                  :append-icon="showPassword ? 'mdi-eye': 'mdi-eye-off'"
                  @click:append="showPassword = !showPassword"
                  @focus="$event.target.removeAttribute('readonly');"
                  required
                  readonly
                  outlined
                  dense
                  name="password"
                  :rules="rules.required"
                ></v-text-field>

                <v-divider></v-divider>

                <v-card-actions :class="{ 'pa-3': $vuetify.breakpoint.smAndUp }">
                  <v-spacer></v-spacer>
                  <v-btn small color="info" type="submit" :disabled="disableBtn">
                    <v-icon left>mdi-lock</v-icon>
                    Login
                  </v-btn>
                </v-card-actions>

              </v-form>
            </v-card-text>
          </v-tab-item>
        </v-tabs-items>
        </v-card-text>
      </v-card>
  </v-dialog>
</template>
<script>
import { mapActions, mapState } from 'vuex'
export default {
    props: ['dialog'],
    name : 'LoginPage',
    data() {
        return {
            showPassword: false, 
            disableBtn: false,
            loading: false,
            employee : {},
            tab : 0,
            loginDialog: false
        };
    },
    computed: {
      ...mapState([
        'rules'
      ])
    },

    methods: {
      ...mapActions([
          'login'
      ]),

      toggleLoginDialog(value){
        this.$emit('toggleLoginDialog', value);
      },
      
      resetForm(){
        if(this.$refs.LoginForm){
          this.$refs.LoginForm.reset();
        }

        if(this.$refs.RegisterForm){
          this.$refs.RegisterForm.reset();
        }
      },

      handleLogin() {
        this.disableBtn = true
         if(this.$refs.LoginForm.validate()){
          const myForm = document.getElementById('LoginForm');
          const formdata = new FormData(myForm)

          axios({
              method: "POST",
              url: `login`,
              data: formdata,
              config: {
                  headers: { "Content-Type": "multipart/form-data" },
              },
          })   
          .then((res)=>{
             this.login()
          })
          .catch(err =>{
          this.disableBtn = false
            console.log(err)
            alert('Something Went Wrong')
          })
        }
            
      },

      handleRegistration(){
        this.disableBtn = true
        if(this.$refs.RegisterForm.validate()){
          const myForm = document.getElementById('RegisterForm');
          const formdata = new FormData(myForm);

          axios({
            method : "POST",
            url : 'register',
            data: formdata,
            config: {
                  headers: { "Content-Type": "multipart/form-data" },
              },
          })
          .then(() => {
             this.login()
          })
          .catch(err =>{
            this.disableBtn = false
            console.log(err)
            alert('Something Went Wrong')
          })
        }
      },
         
    },

    mounted() {
      
    },
    watch: {
      dialog(val){
        this.loginDialog = val
      }
    },
};
</script>
