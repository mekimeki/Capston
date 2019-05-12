<template lang="html">
  <div>
    <v-btn color="red" fab small v-on:click="cut()" style="color:'white';">
      CUT
    </v-btn>
    <v-btn color="blue" fab small v-on:click="click_play()">
      <v-icon color="white">
        play_arrow
      </v-icon>
    </v-btn>

    <div class="text-xs-center">
      <v-dialog
        v-model="open"
        hide-overlay
        persistent
        width="300"
      >
        <v-card>
          <v-card-text>
            Please stand by
            <v-progress-linear v-model="percent_video_cut"></v-progress-linear>
          </v-card-text>
        </v-card>
      </v-dialog>
    </div>

    <!-- <template v-if="open">
      <v-flex>
         <v-progress-linear v-model="precent_video_cut"></v-progress-linear>
      </v-flex>
    </template> -->
    <canvas style="display:none" id="canvasd" width="800" height="500"></canvas>
    <br>
    <span id="bar_start">{{video_firstTime}}</span>
    <div id="ranges">
      <input id="range_1" type="range" name="" value="" max="100" v-on:change="change_time_bar($event,true)">
      <input id="range_2" type="range" name="" value="" max="100" v-on:change="change_time_bar($event,false)">
    </div>
    <br>
    <span id="bar_end">{{video_lastTime}}</span>
    <br>

    START:<input class="input" type="text" name="" value="" v-model="video_firstTime" v-on:keyup="keyup_time_change($event,true)">
    END:<input class="input" type="text" name="" value="" v-model="video_lastTime" v-on:keyup="keyup_time_change($event,false)">
    <div class="" v-show="up_getters.firstTime&&up_getters.lastTime">
      <v-btn v-on:click="move()">다음으로</v-btn>
    </div>
  </div>
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
      percent_video_cut:0,
      check:false,
      //
      canvas:'',
      image:'',
      image_view:'',
      //
      background_image:[],
      dialog:false,
    }
  },
  methods:{
    ...mapActions(['video_cut_actions','percent_action','video_cut_image_action']),
    move(){
      this.percent_action(0);
      this.$router.push({name:'subtitle', query:{video:this.$route.query.video, firstTime:this.up_getters.firstTime, lastTime:this.up_getters.lastTime}});
    },
    change_time_bar(evt,check){
      if (check) {
        this.firstTime = (this.video.duration * (evt.target.value /100));
        this.video_firstTime = this.time_change(Math.ceil(this.video.duration * (evt.target.value / 100)));
        document.getElementById('bar_start').style.left = document.getElementById('bar_start').style.left = parseInt(document.getElementById('range_1').value)+"%";
      }else{
        this.lastTime = (this.video.duration * ((evt.target.value) /100));
        this.video_lastTime = this.time_change(Math.ceil(this.video.duration * (parseInt(evt.target.value) / 100)));
        document.getElementById('bar_end').style.left = document.getElementById('bar_end').style.left = (parseInt(document.getElementById('range_2').value))+"%";
      }
    },
    click_play(){
      this.video.currentTime = Math.ceil(parseInt(this.firstTime));
      this.video.play();
      let interval = setInterval(()=>{
        if(parseInt(this.video.currentTime).toFixed(1) === parseInt(this.lastTime).toFixed(1)){
          this.video.pause();
          clearInterval(interval);
        }
      },150);
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
    keyup_time_change(evt,check){
      console.log("check",check);
      if(check){
        document.getElementById('range_1').value = Math.ceil(parseInt((this.time_second(evt.target.value) * 100)/this.video.duration));
          document.getElementById('bar_start').style.left = document.getElementById('bar_start').style.left = parseInt(document.getElementById('range_1').value)+"%";
      }else{
        document.getElementById('range_2').value = Math.ceil(parseInt((this.time_second(evt.target.value) * 100)/this.video.duration));
        document.getElementById('bar_end').style.left = document.getElementById('bar_end').style.left = parseInt(document.getElementById('range_2').value)+"%";
      }
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
        firstTime : this.firstTime,
        lastTime : this.lastTime,
      }
      this.video_cut_actions(upload_data);
      let inter = setInterval(() => {
        this.percent_video_cut = this.percent;
        if(this.percent_video_cut === 100){
          if(this.up_getters.firstTime&&this.up_getters.lastTime){
            this.open = false;
            clearInterval(inter);
          }
        }
      }, 100);
    },
  },
  mounted:function(){
    this.video_cut_image_action(this.$route.query.video).then(result=>{
      console.log("cut",result);

      for (var i = 0; i < result.img.length; i++) {
        let img = document.createElement('img');
        img.style.width = '10%';
        img.style.height = '100%';
        img.src = result.img[i];
        document.getElementById('ranges').append(img);
      }


    });
    this.canvas = document.getElementById("canvasd");//canvas element
    this.image = document.getElementById("image");//image element

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
  },
}
</script>

<style lang="css" scoped>
#ranges {
  position: relative;
  margin: auto;
  /* margin: 0 auto 20px; */
  height:50px;
  width:100%;
  text-align: center;
  border: 2px solid rgb(9, 164, 251);
  background-size: 10% 100%;
  float:left !important;
  /* background-repeat: repeat-x !important; */
}
input[type=range] {
  -webkit-appearance: none;
  width: 50%;
  cursor: pointer;
  animate: 0.2s;
  background-size: 20% 20%;
}
#ranges input {
  pointer-events: none;
  position: absolute;
  left: 0; top: 15px;
  width: 100%;
  outline:none;
  height: 18px;
  margin: 0;
  padding: 0;
  border-radius: 8px;
}
#ranges input::-webkit-slider-thumb {
  pointer-events: all;
  position: relative;
  z-index: 1;
  -webkit-appearance:none;
  height: 60px;
  width: 5px;
  background: rgb(9, 164, 251);
  border-radius: 10px;
  cursor: pointer;
}
#bar_start{
  border:2px solid rgb(9, 164, 251);
  border-radius: 10px;
  opacity: 0.8;
  position: relative; left: 0%;
}
#bar_end{
  margin: auto;
  border:2px solid rgb(9, 164, 251);
  border-radius: 10px;
  opacity: 0.8;
  position: relative; left: 100%;
}
.input{
  border-radius: 10px;
  border:2px solid rgb(9, 164, 251);
}

</style>
