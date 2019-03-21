<template lang="html">
  <v-container grid-list-md text-xs-center>
    <h3>목록</h3>
    <v-layout row wrap v-for="i in 2">
      <v-flex xs4 v-for="i in 10">
        <video src="videofile.ogg" autoplay poster="posterimage.jpg" controls>

        </video>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
export default {}
</script>

<style lang="css" scoped>

</style>
