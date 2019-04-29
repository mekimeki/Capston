<template lang="html">
  <v-container>
    <v-btn fab dark large color="success" v-on:click="cut()">
      CUT
    </v-btn>
    <template v-if="open">
      <v-flex>
         <v-progress-linear v-model="precent_video_cut"></v-progress-linear>
      </v-flex>
    </template>
    <v-layout row wrap sm8>
      <v-flex shrink style="width: 100px">
         <v-text-field
          v-on:keyup="keyup_time_change()"
          v-model = "time[0]"
         >
         </v-text-field>
         <v-text-field
          v-model = "firstTime"
         >
         </v-text-field>
       </v-flex>
       <v-flex>
         <v-range-slider
           v-on:change="change_time()"
           v-model="time"
           :max="100"
           :min="0"
           :step="1"
         ></v-range-slider>
       </v-flex>
       <v-flex shrink style="width: 100px">
         <v-text-field
          v-on:keyup="keyup_time_change()"
          v-model = "time[1]"
         >
         </v-text-field>
         <v-text-field
          v-on:keyup="keyup_time_change()"
          v-model = "lastTime"
         >
         </v-text-field>
       </v-flex>
    </v-layout>
    <div class="" v-if="up_getters.firstTime&&up_getters.lastTime">
      <v-btn v-on:click="move()">다음으로</v-btn>
    </div>
  </v-container>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';//vuex actions import
import axios from 'axios';
export default {
  data(){
    return{
      video:"",//video element
      seek_bar:"",//seek bar element
      time:[0,10],
      //video time
      video_firstTime:"",
      video_lastTime:"",
      //
      firstTime:0,
      lastTime:0,
      open:false,
      precent_video_cut:0,
      check:false,
    }
  },
  methods:{
    ...mapActions(['video_cut_actions','percent_action']),
    move(){
      this.percent_action(0);
      this.$router.push({name:'subtitle', query:{video:this.up_getters.video, firstTime:this.up_getters.firstTime, lastTime:this.up_getters.lastTime}});
    },
    time_change(seconds){
      let hour = parseInt(seconds/3600);
      let min = parseInt((seconds%3600)/60);
      let sec = seconds%60;
      return hour+":"+min+":" + sec
    },
    time_second(time){
      let time_s = time.split(":");
      let hour = parseInt((time_s[0] * 60) * 60);
      let min = parseInt(time_s[1] * 60);
      let sec = parseInt(time_s[2]);
      return hour + min + sec;
    },
    change_time(){
      this.video_firstTime = this.time[0];
      this.video_lastTime = this.time[1];
      this.firstTime = this.time_change(this.video.duration * (this.time[0] / 100));
      this.lastTime = this.time_change(this.video.duration * (this.time[1] / 100));
    },
    keyup_time_change(){
      this.video_firstTime = this.time[0];
      this.video_lastTime = this.time[1];
      this.firstTime = this.time_change(this.video.duration * (this.time[0] / 100));
      this.lastTime = this.time_change(this.video.duration * (this.time[1] / 100));
    },
    cut(){
      if(confirm("정말 자르겠습니까?")){
        this.open = true;
        this.upload();
      }else{
        this.open = false;
      }
    },
    upload(){
      let upload_data = {//setTime
        video_pk : this.$route.query.video,   //up_getters.video,
        firstTime : this.video.duration * (this.time[0] / 100),
        lastTime : this.video.duration * (this.time[1] / 100),
      }
      this.video_cut_actions(upload_data);
      let inter = setInterval(() => {
        this.precent_video_cut = this.percent;
        if(this.percent_video_cut === 100){
          console.log("clear");
          clearInterval(inter);
        }
      }, 100);
    }
  },
  mounted:function(){
    this.video = this.v_getter;//video element
    this.seek_bar = this.seb_getter;//seek_bar element
    this.video.onloadeddata = () =>{
      this.firstTime = this.time_change(this.firstTime);
      this.lastTime = this.time_change(this.video.duration);
    }
  },
  updated:function(){
  },
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
      s_getter:'subtitle_getter',
      sb_getter:'subtitle_buffer_getter',
      seb_getter:'seek_bar_getter',
      up_getters: 'upload_getters',
      percent:'percent_getter'
    }),
  },
  watch: {
    //loop
    video_firstTime:function(data){
      this.check = true;
      let clickEvent  = document.createEvent ('MouseEvents');
      clickEvent.initEvent ('dblclick', true, true);
      this.seek_bar.dispatchEvent (clickEvent);

      this.seek_bar.style.background = "linear-gradient(to right, red "+data+"% "+data+"%, yellow "+data+"% "+this.time[1]+"%, red 0% 0%)";
      this.video.currentTime = this.video.duration * (data / 100);
      this.video.play();
      setTimeout(()=>{
        this.seek_bar.click();
      },500);
    },
    video_lastTime:function(data){
      this.check = true;
      let clickEvent  = document.createEvent ('MouseEvents');
      clickEvent.initEvent ('dblclick', true, true);
      this.seek_bar.dispatchEvent (clickEvent);

      this.seek_bar.style.background = "linear-gradient(to right, red "+this.time[0]+"% "+this.time[0]+"%, yellow "+this.time[0]+"% "+data+"%, red 0% 0%)";
      this.video.currentTime = this.video.duration * (data / 100);
      this.video.play();
      setTimeout(()=>{
        this.seek_bar.click();
      },500);
    }
  },
}
</script>

<style lang="css" scoped>
</style>
