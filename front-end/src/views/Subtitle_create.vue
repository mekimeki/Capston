<template lang="html">
  <div class="">
    <video_></video_>
    <hr>
    <createMain_></createMain_>
    <createInput_></createInput_>
  </div>
</template>

<script>
import video_ from "@/components/video_/Video";
import createMain_ from "@/components/createBox_/CreateMain";
import createInput_ from "@/components/createBox_/CreateInput";
export default {
  components:{
    video_,
    createMain_,
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
