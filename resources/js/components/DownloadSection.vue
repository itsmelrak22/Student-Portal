<template>
  <section id="download">
    <v-container fluid>
      <v-row align="center" justify="center">
        <v-col cols="10">
          <v-row align="center" justify="center">
            <v-col sm="4" class="hidden-xs-only">
              <v-img src="assets/img/cvsu-bacoor-logo.png" class="d-block ml-auto mr-auto" max-width="350px" />
            </v-col>
            <v-col cols="12" sm="8" class=" text-left card-transparent-background">
              <h1  class="font-weight-light color-white display-2 mb-2"> Courses Offered</h1>

              <ul class="courses-style">
                <li>
                  Bachelor of Secondary Education
                </li>
                <li>BS Business Management</li>
                <li>BS Computer Science</li>
                <li>BS Criminology</li>
                <li>BS Hospitality Management (formerly BS Hotel and Restaurant Management)</li>
                <li>BS Information Technology</li>
                <li>BS Psychology</li>
              </ul>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-container>
  </section>
</template>

<style scoped>
#download {
  background-image: url("https://cvsu.edu.ph/wp-content/uploads/2022/06/cvsu-front-scaled.jpg");
  background-attachment: fixed;
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  height: 500px;
}

#download .container,
#download .row {
  height: 100%;
}
.courses-style li{
    color: white;
    size: 20px!important;
}
</style>