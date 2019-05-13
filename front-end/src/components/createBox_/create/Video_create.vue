<template lang="html">
  <v-layout row wrap>
    <v-flex xs6 sm6 md6 id="center">
        <video_></video_>
    </v-flex>
    <v-flex xs12 sm12 md12>
      <createVideo_></createVideo_>
    </v-flex>
  </v-layout>
</template>

<script>
import video_ from "@/components/video_/Video2";
import createVideo_ from "@/components/createBox_/CreateVideo";
export default {
  components: {
    video_,
    createVideo_
  },
  data() {
    return {};
  }
};
</script>

<style lang="css" scoped>
#center {
  left: 0;
  right: 0;
  margin-left: auto;
  margin-right: auto;
}
</style>
