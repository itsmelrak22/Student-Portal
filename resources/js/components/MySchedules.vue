<template>
    <section id="about">
      <v-toolbar dense flat>
            <h1>MY ADSVISING</h1>
        </v-toolbar>
      <v-container class="" >
        <v-row mt-2 mx-2>
          <v-col col="6" class="mx-2">
            <v-card color="#385F73" dark >
            <v-card-title class="text-h5">
              John Doe
            </v-card-title>

            <v-card-subtitle> Adviser </v-card-subtitle>
          </v-card>
          </v-col>
          <v-col col="6" class="mx-2">
          </v-col>
        </v-row>
      </v-container>
      <v-container fluid>
          
     
      </v-container>
    </section>
  </template>
  
  <style scoped>
  #about {
    background-color: #078a32bb;
  }
  </style>

<script>
export default {
  data: () => ({
    headers: [
      {
        text: 'SCHEDULE CODE',
        align: 'start',
        value: 'name',
      },
      { text: 'Description', value: '' },
      { text: 'Day', value: '' },
      { text: 'Time', value: '' },
    ],
    studentSubjects: []
  }),
}
</script>
  