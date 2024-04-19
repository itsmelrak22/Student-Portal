<template>
    <section id="about">
      <v-toolbar dense flat>
            <h1>MY STUDENT ADVISEE</h1>
        </v-toolbar>
      <v-container class="" >
        <v-row mt-2 mx-2>
          <v-col col="6" class="mx-2">
            <v-card color="#385F73" dark >
            <v-card-title class="text-h5">
              Active Semester
            </v-card-title>

            <v-card-subtitle>2023-2024 - SECOND</v-card-subtitle>
          </v-card>
          </v-col>
          <v-col col="6" class="mx-2">
          </v-col>
        </v-row>
      </v-container>
      <v-container fluid>
          
        <v-data-table
        height="65vh"
          :headers="headers"
          :items="studentSubjects"
          class="elevation-1"
        >
          <template v-slot:header.name="{ header }">
            {{ header.text.toUpperCase() }}
          </template>
        </v-data-table>
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
        text: 'STUDENT CODE',
        align: 'start',
        value: 'name',
      },
      { text: 'Name', value: '' },
      { text: 'Year', value: '' },
      { text: 'Section', value: '' },
    ],
    studentSubjects: []
  }),
}
</script>
  