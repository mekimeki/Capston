<template lang="html">
  <v-container>
    <v-layout row wrap>
      <v-flex xs12 sm7 md7>
        <v-layout row wrap>
          <v-flex>
            <video_></video_>
          </v-flex>
          <v-flex>
            <search_></search_>
          </v-flex>
        </v-layout>
      </v-flex>
      <v-flex xs12 sm5 md5 class="pa-2">
        <content_></content_>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
import video_ from "@/components/video_/Video2";
import content_ from "@/components/createBox_/CreateContent";
import search_ from "@/components/createBox_/CreateSearch";
export default {
  components:{
    video_,
    content_,
    search_,
  },
  data(){
    return{

    }
  }
}
</script>

<style lang="css" scoped>
</style>
