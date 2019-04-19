<template>
  <v-container fluid grid-list-md>
    <v-layout xs4 row wrap>
      <v-flex d-flex xs12 sm6 md3 v-for="i in 16">
        <v-card color="purple" dark>
          <v-card-title primary class="title">Lorem</v-card-title>
          <v-card-text>{{ lorem }}</v-card-text>
        </v-card>
      </v-flex>
    </v-layout>
  </v-container>
</template>


<script>
  export default {
    data(){
      return{
        lorem:'추천영상',
      }
    }
  }
</script>
