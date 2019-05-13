<template lang="html">
  <v-layout>
    <v-flex xs6 sm6 md6>
    <v-layout pa-3 row wrap>
      <v-flex xs12 sm12 md12>
        <video_></video_>
        <createSubtitleOption_></createSubtitleOption_>
      </v-flex>
      <v-flex xs12 sm12 md12>
        <div class="subtitlePlus pl-2">자막 추가하기</div>
        <createInput_></createInput_>
      </v-flex>
    </v-layout>
    </v-flex>
    <v-flex xs6 sm6 md6>
      <createSubtitle_></createSubtitle_>
    </v-flex>

  </v-layout>
</template>

<script>
import video_ from "@/components/video_/Video2";
import createSubtitle_ from "@/components/createBox_/CreateSubtitle";
import createInput_ from "@/components/createBox_/CreateInput";
import subtitle_ from "@/components/video_/Subtitle.vue";
import createSubtitleOption_ from "@/components/createBox_/CreateSubtitle_option";
export default {
  components:{
    video_,
    createSubtitle_,
    createInput_,
    subtitle_,
    createSubtitleOption_,
  },
  data(){
    return{

    }
  }
}
</script>

<style lang="css" scoped>
.subtitlePlus{
  font-size: 1.3rem;
  font-weight: 600;
}
</style>
