<template lang="html">
  <div class="">
    <video_></video_>
    <hr>
    <createInput_></createInput_>
    <createSubtitle_></createSubtitle_>
  </div>
</template>

<script>
import video_ from "@/components/video_/Video";
import createSubtitle_ from "@/components/createBox_/CreateContent";
import createInput_ from "@/components/createBox_/CreateInput";
export default {
  components:{
    video_,
    createSubtitle_,
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
