<template lang="html">
  <div class="">
    check:{{up_getters}}
    <div class="" v-if="!vc_getters">
      <div class="" v-if="up_getters.subtitle">
        <!-- v-if="up_getters.video && up_getters.subtitle" -->
        <div class="" v-if="!vc_getters">
          <video_></video_>
        </div>
        <createVideo_></createVideo_>
      </div>
      <div class="" v-else>
        <uploadPage_></uploadPage_>
      </div>
    </div>

    <div class="" v-if="up_getters.subtitle && vc_getters">
      <div class="">
        <video_></video_>
        <hr>
        <createInput_></createInput_>
        <createSubtitle_></createSubtitle_>
      </div>
      <div class="">

      </div>
    </div>

  </div>
</template>

<script>
import video_ from '@/components/video_/Video';
import createVideo_ from '@/components/createBox_/createVideo';
import uploadPage_ from '@/components/createBox_/Upload';
import createSubtitle_ from "@/components/createBox_/CreatSubtitle";
import createInput_ from "@/components/createBox_/CreateInput";
import {mapState,mapGetters,mapActions} from 'vuex';
export default {
  components:{
    video_,
    createVideo_,
    uploadPage_,
    createSubtitle_,
    createInput_,
  },
  computed:{
    ...mapGetters({
      up_getters:'upload_getters',
      vc_getters:'video_cut_getters',
    }),
  }
}
</script>

<style lang="css" scoped>
</style>
