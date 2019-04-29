<template lang="html">
  <v-container>
    <v-layout row wrap>
      <v-flex xs12 sm8 md8>
        <video_></video_>
        <capture_></capture_>
        <subtitle_></subtitle_>
      </v-flex>
      <v-flex xs12 sm4 md4>
        <content_></content_>
      </v-flex>
    </v-layout>
    <v-flex xs12 sm12 md12>
      <comment_></comment_>
    </v-flex>
  </v-container>
</template>

<script>
import video_ from '@/components/video_/Video';
import capture_ from '@/components/video_/Capture';
import subtitle_ from '@/components/video_/Subtitle';
import content_ from '@/components/video_/Contents';
import comment_ from '@/components/video_/Comment'
export default {
  name:"video_see",
  components:{
    video_,
    capture_,
    subtitle_,
    content_,
    comment_,
  },
  data(){
    return{

    }
  }
}
</script>

<style lang="css" scoped>
</style>
