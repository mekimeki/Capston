<template lang="html">
  <div class="">
    <v-layout>
      <v-flex sm4>
        <video_></video_>
      </v-flex>
      <v-flex sm8>
        <v-card class="pa-4">
          <v-text-field
            label="TITLE"
            v-model="create_text.title"
          ></v-text-field>
          <v-textarea
            label="EXPLANATION"
            v-model="create_text.explain"
          ></v-textarea>
          <v-text-field
            label="CATEGORY"
          ></v-text-field>
        </v-card>
        <v-btn v-on:click="click_upload_created()">CREATE</v-btn>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import {mapActions} from 'vuex';
import video_ from '@/components/video_/Video';
export default {
  components:{
    video_,
  },
  data(){
    return{
      create_text:{
        title:'',
        explain:'',
        category:'',
      }
    }
  },
  methods:{
    ...mapActions(['upload_created_action']),
    click_upload_created(){
      let data = {
        video_pk: this.$route.query.video,
        text: this.create_text,
      }
      this.upload_created_action(data).then(result=>{
        if(result){
          this.$router.push({name:'main'});
        }
      });
    }
  },
  mounted:function(){

  }
}
</script>

<style lang="css" scoped>
</style>
