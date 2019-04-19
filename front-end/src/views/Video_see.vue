<template lang="html">
  <v-container>
    <v-layout>
      <v-flex xs12>
        <video_></video_>
        <!-- <content_></content_> -->
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import video_ from '@/components/video_/Video';
import capture_ from '@/components/video_/Capture';
import subtitle_ from '@/components/video_/Subtitle';
import content_ from '@/components/video_/Contents';
export default {
  name:"video_see",
  components:{
    video_,
    capture_,
    subtitle_,
    content_,
  },
  data(){
    return{

    }
  }
}
</script>

<style lang="css" scoped>
</style>
