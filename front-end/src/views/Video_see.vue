<template lang="html">
  <div class="">
    <video_></video_>
    <hr>
    <capture_></capture_>
    <hr>
    <subtitle_></subtitle_>
  </div>
</template>

<script>
import video_ from '@/components/video_/Video';
import capture_ from '@/components/video_/Capture';
import subtitle_ from '@/components/video_/Subtitle';
export default {
  name:"video_see",
  components:{
    video_,
    capture_,
    subtitle_
  },
  data(){
    return{

    }
  }
}
</script>

<style lang="css" scoped>
</style>
