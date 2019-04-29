<template lang="html">
  <div class="">
    <v-layout>
      <v-flex sm4>
        <video_></video_>
      </v-flex>
      <v-flex sm8>
        <v-card class="pa-4">
          <v-text-field
            label="타이틀"
          ></v-text-field>
          <v-textarea
            label="설명"
          ></v-textarea>
          <v-text-field
            label="카테고리"
          ></v-text-field>
        </v-card>
        <v-btn>제작</v-btn>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import video_ from '@/components/video_/Video';
export default {
  components:{
    video_,
  },
  data(){
    return{
      create_text:{
        title:'',
        content:'',
        category:'',
      }
    }
  },
  methods:{

  },
  mounted:function(){

  }
}
</script>

<style lang="css" scoped>
</style>
