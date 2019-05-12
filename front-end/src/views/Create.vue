<template lang="html">
  <div class="">
    <router-view></router-view>
  </div>
</template>

<script>
import {mapState,mapGetters,mapActions} from 'vuex';
export default {
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
