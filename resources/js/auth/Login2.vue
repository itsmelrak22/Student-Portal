

<template>
  <v-app>
    <navigation :flat="flat" @toggleLoginButton="toggleLoginButton" />
    <v-main class="pt-0">
      <home />
      <about />
      <login :dialog="loginDialog"  @toggleLoginDialog="toggleLoginDialog"/>
    </v-main>
    <v-scale-transition>
      <v-btn
        fab
        v-show="fab"
        v-scroll="onScroll"
        dark
        fixed
        bottom
        right
        color="secondary"
        @click="toTop"
      >
        <v-icon>mdi-arrow-up</v-icon>
      </v-btn>
    </v-scale-transition>
    <foote />
  </v-app>
</template>
<style scoped>
.v-main {
  /* background-image: url("../assets/img/bgMain.png"); */
  background-attachment: fixed;
  background-position: center;
  background-size: cover;
}
</style>
<script>
import { mapActions, mapState } from 'vuex'
import navigation from "../components/Navigation.vue";
import foote from "../components/Footer.vue";
import home from "../components/HomeSection.vue";
import about from "../components/AboutSection.vue";
import download from "../components/DownloadSection.vue";
import pricing from "../components/PricingSection.vue";
import contact from "../components/ContactSection.vue";
import Login from "./Login.vue";
export default {
    name : 'LoginPage',
    components: {
      navigation,
      foote,
      home,
      about,
      download,
      pricing,
      contact,
      Login,
    },

    data() {
        return {
            showPassword: false, 
            disableBtn: false,
            loading: false,
            employee : {},
            tab : 0,
            fab: null,
            color: "",
            flat: null,
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
        this.loginDialog = value

      },

      toggleLoginButton(value){
        console.log('toggleLoginButton', value)
        this.loginDialog = value;
      },

      onScroll(e) {
        if (typeof window === "undefined") return;
        const top = window.pageYOffset || e.target.scrollTop || 0;
        this.fab = top > 60;
      },
      toTop() {
        this.$vuetify.goTo(0);
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
      fab(value) {
        if (value) {
          this.color = "secondary";
          this.flat = false;
        } else {
          this.color = "transparent";
          this.flat = true;
        }
      },
    },
    created(){
      const top = window.pageYOffset || 0;
      if (top <= 60) {
        this.color = "transparent";
        this.flat = true;
      }
    }
};
</script>
