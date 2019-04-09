<template lang="html">
  <div class="">
    <label for="">처음시간</label>
    <input type="text" name="" value="" v-model="check_time.firstTime">
    <label for="">끝시간</label>
    <input type="text" name="" value="" v-model="check_time.lastTime">
    <br>
    <div class="">
      <v-btn color="success" v-on:click="cut()">자르기</v-btn>
    </div>
    <div v-show="check == true">
      <img src="https://cdn0.iconfinder.com/data/icons/social-messaging-ui-color-shapes-3/3/72-512.png" alt="" width="200" height="200">
      <v-btn color="success" v-on:click="cancel()">취소</v-btn>
      <v-btn color="success" v-on:click="upload()">업로드</v-btn>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';//vuex actions import
import axios from 'axios';
export default {
  data(){
    return{
      video:"",
      seek_bar:"",
      video_time:"",
      move_time:"",
      check_time:{
        firstTime:"",
        lastTime:"",
      },
      check:false,
    }
  },
  methods:{
    ...mapActions(['video_cut_actions']),
    mousedown_firstTime(){
      this.check_time.firstTime = this.video.currentTime;
    },
    mouseup_lastTime(){
      this.check_time.lastTime = this.video.duration * (this.seek_bar.value / 100);
      if(this.check_time.firstTime >= this.check_time.lastTime){
        alert("시간이 잘못 설정 되었습니다.");
        this.check_time.firstTime = "";
        this.check_time.lastTime = "";
      }
      this.video.play();
    },
    cut(){
      if(this.check_time.firstTime && this.check_time.lastTime ){
        this.check = true;
      }else{
        alert("아직 자를수 없습니다.");
      }
    },
    cancel(){
      this.check = false;
      this.check_time.firstTime = "";
      this.check_time.lastTime = "";
    },
    upload(){
      this.video_cut_actions(this.check_time);
    }
  },
  mounted:function(){
    this.video = this.v_getter;//video element
    this.seek_bar = this.seb_getter;//seek_bar element

    this.seek_bar.addEventListener("mousedown",() =>{
      this.mousedown_firstTime();
    });

    this.seek_bar.addEventListener("mouseup",() =>{
      this.mouseup_lastTime();
    });
  },
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
      s_getter:'subtitle_getter',
      sb_getter:'subtitle_buffer_getter',
      seb_getter:'seek_bar_getter',
    }),
  },
}
</script>

<style lang="css" scoped>
</style>
