<template lang="html">
  <v-container>
    <v-layout row wrap>
      <v-flex xs12 sm7 md7>
        <video_></video_>
      </v-flex>
      <v-flex xs12 sm5 md5 class="pa-2">
        <createInput_></createInput_>
        <createContent_></createContent_>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import video_ from "@/components/video_/Video";
import createContent_ from "@/components/createBox_/CreateContent";
import createInput_ from "@/components/createBox_/CreateInput";
export default {
  components:{
    video_,
    createContent_,
    createInput_,
  },
  data(){
    return{

    }
  }
}
</script>

<style lang="css" scoped>
</style>
