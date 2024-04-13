<template>
  <v-footer dark padless>
    <v-card flat tile class="secondary  text-center">
      <v-card-text>
      
      </v-card-text>

      <v-card-text class=" pt-0">
     
      </v-card-text>

      <v-divider></v-divider>

      <v-card-text class="">
        <!-- {{ new Date().getFullYear() }} — <strong></strong> -->
      </v-card-text>
    </v-card>
  </v-footer>
</template>

<style scoped>
.v-card {
  width: 100%;
}
</style>

<script>
export default {
  data: () => ({
    icons: [
      {
        text: "mdi-facebook",
        link: "",
      },
      {
        text: "mdi-twitter",
        link: "",
      },
      {
        text: "mdi-linkedin",
        link: "",
      },
      {
        text: "mdi-instagram",
        link: "https://instagram.com/joabson_arley/",
      },
    ],
  }),
};
</script>
