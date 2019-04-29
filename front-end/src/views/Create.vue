<template lang="html">
  <div class="">
    <router-view></router-view>
  </div>
</template>

<script>
import video_ from '@/components/video_/Video';
import createVideo_ from '@/components/createBox_/CreateVideo';
import uploadPage_ from '@/components/createBox_/Upload';
import createSubtitle_ from "@/components/createBox_/CreateSubtitle";
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
