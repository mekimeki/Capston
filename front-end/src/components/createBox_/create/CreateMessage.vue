<template lang="html">
  <div class="">
    <v-layout>
      <v-flex sm4>
        <video_></video_>
      </v-flex>
      <v-flex sm8>
        <v-card class="pa-4" style="border:5px solid #4DB6AC;">
          <v-text-field
            label="제목"
            v-model="create_text.title"
          ></v-text-field>
          <v-textarea
            label="설명"
            v-model="create_text.explain"
          ></v-textarea>
          <v-overflow-btn
            :items="category_list"
            label="카테고리"
            target="#dropdown-example"
            v-model="category"
          ></v-overflow-btn>
        </v-card>
        <v-btn v-on:click="click_upload_created()" color="teal lighten-2">작성하기</v-btn>
      </v-flex>
    </v-layout>
  </div>
</template>

<script>
import {mapActions} from 'vuex';
import video_ from '@/components/video_/Video2';
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
      },
      category_list:['판타지', 'SF', '공포', '스릴러','코미디','멜로','액션'],
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
          alert(this.$route.query.video+'success');
          this.$router.push({name:'v-video', query:{video:this.$route.query.video}});
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
