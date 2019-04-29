<template lang="html">
  <v-container>
    <v-layout row wrap>
      <v-flex xs12 sm7 md7>
        <video_></video_>
        <subtitle_></subtitle_>
      </v-flex>
      <v-flex xs12 sm5 md5 class="pa-2">
        <createInput_></createInput_>
        <createSubtitle_></createSubtitle_>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import video_ from "@/components/video_/Video";
import createSubtitle_ from "@/components/createBox_/CreateSubtitle";
import createInput_ from "@/components/createBox_/CreateInput";
import subtitle_ from "@/components/video_/Subtitle.vue";
export default {
  components:{
    video_,
    createSubtitle_,
    createInput_,
    subtitle_,
  },
  data(){
    return{

    }
  }
}
</script>

<style lang="css" scoped>
</style>
