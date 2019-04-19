<template lang="html">
  <div>
    <div id="videoplayer">
      <video id="video" v-on:timeupdate="seek_timeupdate()" controls src="@/components/test.mp4">
      </video>
      <!-- <video id="video" class="video-js vjs-default-skin" preload="auto" width="500" height="360" data-setup='{}' v-on:timeupdate="seek_timeupdate()">
        <source src="http://172.26.3.246/storage/streamable_videos/53.m3u8" type="application/x-mpegURL">
      </video> -->

      <div id="videoController">
        <span>
          <span id="seekBarTime">{{video_time}}</span>
        </span>
        <input id="seekBar" type="range" name="" value="0"
          v-on:change="seek_change()"
          v-on:dblclick="video_loop(true)"
          v-on:click="video_loop(false)"
          v-on:mousedown="mouse_down()"
          v-on:mousemove="mouse_move($event)"
          v-on:mouseup="mouse_up()"
        >
        <span id="seekBarLastTime">{{time_change(Math.floor(parseInt(video.duration)))}}</span>
        <button class="btn" id="playBtn" type="button" name="button" v-on:click="play()">Play</button>
        <span id="videoAudio">
          <input id="audioBar" type="range" name="" value="100" v-on:change="audio_change()">
          <button class="btn" id="audioBtn" type="button" name="button" v-on:click="audioOn_off()">on</button>
        </span id="videoSpeend">
        <span id="videoSpeed">
          <input id="speedBar" type="range" name="" value="10" v-on:change="speed_change()">
          <button class="btn" id="speedBtn" type="button" name="button">on</button>
        </span>
      </div>
    </div>
      <!-- Wathch-time:{{watch_time}}
      first-time:{{first_loop_time}}
      last-time:{{last_loop_time}} -->
  </div>
</template>

<script>
import { mapActions } from 'vuex'//vuex actions import
import axios from 'axios';//axios import

export default {
  name:"video_",//component name
  data() {
    return {
      //video values
      videoLink: "/media/test.6397655f.mp4",//video src
      video: "",//play video
      play_btn : "",//play button
      seek_bar : "", // play bar
      now_time: "",
      move_time : "",// move play time
      //audio values
      firstValue_audio: "",//audio first volume
      audio_bar:"",//audo range
      audio_btn: "",//audio button
      //speed values
      speed_bar:"",//speed range
      speed_btn:"",//speed button
      speed:"",//speed
      //video Loop values
      first_loop_time: 0,//first loop time
      last_loop_time: 0,//last loop time
      watch_time: "",//video play time
      loop_check: false,//loop Check
      // time:0,//video time view
      time:"",
      linear:"",
      linear_check:true,
    }
  },
  methods: {
    ...mapActions(['video_action','seek_bar_action']),//vuex actions connect
    time_change(seconds){
      let hour = parseInt(seconds/3600);
      let min = parseInt((seconds%3600)/60);
      let sec = seconds%60;

      return hour+":"+min+":" + sec
    },
    play(){//play on/off
      if (this.video.paused){
        this.video.play();
        this.play_btn.style.backgroundImage = "url("+require('@/assets/play-stop.png')+")";
      }else{
        this.video.pause();
        this.play_btn.style.backgroundImage = "url("+require('@/assets/play.png')+")";

      }
    },
    seek_change(){//play input[range]bar reflection
      this.move_time = this.video.duration * (this.seek_bar.value / 100);
      this.video.currentTime = this.move_time;
      if(!this.first_loop_time === 0){
        this.seek_bar.style.background = "linear-gradient(to right, red 0% 0%, blue 0% "+parseInt(this.seek_bar.value)+"%, red 0% 0%)";
      }
    },
    seek_timeupdate(){//play video reflection
      if(!this.video.paused){//play
        this.move_time = (100/ this.video.duration) * this.video.currentTime;
        this.seek_bar.value = this.move_time;
        this.time = this.video.currentTime;//time
        if(this.first_loop_time == 0){
          this.seek_bar.style.background = "linear-gradient(to right, red 0% 0%, blue 0% "+parseInt(this.seek_bar.value)+"%, red 0% 0%)";
        }
        this.play_btn.style.backgroundImage = "url("+require('@/assets/play-stop.png')+")";
        this.now_time.style.position = "relative";
        this.now_time.style.left = this.now_time.style.left = parseInt(this.seek_bar.value)+"%";

        if(this.loop_check){//this.loop_check true is start
          this.watch_time = this.video.currentTime;
        }
      }else{//not play
        this.play_btn.style.backgroundImage = "url("+require('@/assets/play.png')+")";
      }
    },
    mouse_down(){
      if(this.video.paused){

      }else{
        this.video.pause();
      }
    },
    mouse_up(){
      if(this.video.paused){
        this.video.play();
      }else{

      }
    },
    mouse_move(evt){
      if(this.first_loop_time === 0){
        this.seek_bar.style.background = "linear-gradient(to right, red 0% 0%, blue 0% "+parseInt(this.seek_bar.value)+"%, red 0% 0%)";
      }else if(this.first_loop_time != 0){
        if(this.linear_check){
          this.seek_bar.style.background = "linear-gradient(to right, red "+this.linear+"% "+this.linear+"%, yellow "+this.linear+"% "+parseInt(this.seek_bar.value)+"%, red 0% 0%)";
          this.linear_check = false;
        }else{

        }
      }
    },
    audio_change(){//audio volume control
      if(this.video.muted){
        console.log("?");
        this.video.muted = false;
        this.audio_btn.style.backgroundImage = "url("+require('@/assets/audio-play.png')+")";
      }
      this.video.volume = this.audio_bar.value /100;
      this.audio_bar.style.background = "linear-gradient(to right, red 0% 0%, blue 0% "+parseInt(this.audio_bar.value)+"%, red 0% 0%)";
    },
    audioOn_off(){//audio volume on/off
      if(this.video.muted === false){
        this.firstValue_audio = this.audio_bar.value;
        this.video.muted = true;
        this.audio_bar.value = 1;
        this.audio_btn.style.backgroundImage = "url("+require('@/assets/audio-stop.png')+")";
      }else{
        video.muted = false;
        this.audio_bar.value = this.firstValue_audio;
        this.audio_btn.style.backgroundImage = "url("+require('@/assets/audio-play.png')+")";
      }
      this.audio_bar.style.background = "linear-gradient(to right, red 0% 0%, blue 0% "+parseInt(this.audio_bar.value)+"%, red 0% 0%)";
    },
    speed_change(){
      if(this.video.paused){

      }else{
        this.video.pause();
      }
      this.speed = this.speed_bar.value;
      alert(this.speed / 10);
      this.video.playbackRate = parseInt(this.speed / 10);
      this.video.play();
      this.speed_bar.style.background = "linear-gradient(to right, red 0% 0%, blue 0% "+parseInt(this.speed_bar.value)+"%, red 0% 0%)";
    },
    video_loop(check){
      if(check){//check true -> dblclick
        this.first_loop_time = this.video.currentTime;
        this.video.pause();
        this.linear = this.seek_bar.value;
      }else{//check false -> click
        if(this.first_loop_time!= ""){
          if(this.last_loop_time!= ""){
            this.last_loop_time = 0;
            this.first_loop_time = 0;
            this.loop_check = false;
          }else{
            this.last_loop_time = this.video.currentTime;
            this.loop_check = true;
            this.linear_check = true;
          }
        }
      }
    }
  },
  created: function() {
  },
  beforeMount: function(){
    // console.log("beforeMout");
  },
  mounted: function() {
    //video
    // axios video streming
    // let url = "http://172.26.3.246/test";
    //
    // axios.get(url).then((res)=>{
    //   alert("axios",res.data);
    // },(error)=>{alert("연결을 확인해 주세요")});

    this.video = document.getElementById("video");//video
    this.play_btn = document.getElementById("playBtn");//play
    this.seek_bar = document.getElementById("seekBar");//seek bar
    //audio
    this.audio_bar = document.getElementById("audioBar");//audio bar
    this.audio_btn = document.getElementById("audioBtn");//audio
    //speed
    this.speed_bar = document.getElementById("speedBar");//speed bar
    this.speed_btn = document.getElementById("speedBtn");//speedn btn
    this.now_time = document.getElementById("seekBarTime");
    // this.$store.dispatch('video_action',this.video);//vuex actions test
    this.video_action(this.video);//vuex actions
    this.seek_bar_action(this.seek_bar);
  },
  beforeUpdate: function() {
    // console.log("video beforeUpdate");
    // this.video = document.getElementById("video");//video
  },
  updated: function(){
    // console.log("video update");
  },
  computed:{
    video_time(){
      return this.time_change(Math.floor(parseInt(this.time)));
    },
  },
  watch: {
    //loop
    watch_time: function(data){
      console.log("video watch");
      if(this.loop_check === true){
        if(Math.floor(this.last_loop_time) === Math.floor(data)){
          this.video.currentTime = this.first_loop_time;
        }
      }
    },
  },
}
</script>
<style lang="css" scoped>


/* video css scoped is now file only css*/
  #video{
    width:100%;
    height:100%;
  }
  #videoController{
    position:sticky;
    width:100%;
    height:110px;
    /* border:1px solid black; */

    /* visibility: hidden; */
  }
  #videoplayer{
    width:100%;
    height:100%;

    float:left;
  }
  /* #videoplayer:hover #videoController{
    visibility: inherit;
    position:absolute;
  } */

  /* #videoContainer{
    background: black;
    width:100%;
    height:100%;
  } */

  /* buttons css */
  .btn{
    text-indent:-10000px;
    /* border:none; */
    cursor:pointer;
    width:5%;
    height:50%;
  }
  #playBtn{
    background-size:100%;
    background-image:url("../../assets/play.png");
  }
  #audioBtn{
    width:20%;
    background-size:25%;
    background-image:url("../../assets/audio-play.png");
  }
  #speedBtn{
    background-size:100%;
    background-image:url("../../assets/speed.png");
  }
  /* seekbar css */
  #seekBar_span{
    width:100%;
    height:100%;
  }
  #seekBar{
    position:sticky;
    -webkit-appearance:none;
    /* background:red; */
    width:100%;
    height:.2rem;
    background:linear-gradient(to right, red 0% 0%, blue 0% 0%, red 0% 0%);
    cursor:pointer;
  }
  #seekBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    appearance: none;
    width:0.5rem;
    height:0.5rem;
    background:blue;
    border-radius: 50%;
    cursor:pointer;

  }
  /* audioBar css */
  #audioBar{
    /* transform: rotate(-90deg); */
    position:absolute;
    margin-top:2%;
    margin-left:6%;
    -webkit-appearance:none;
    background:red;
    width:10%;
    height:.2rem;
    visibility: hidden;
  }
  #audioBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    width:0.5rem;
    height:0.5rem;
    background: blue;
    border-radius: 10px;
    cursor:pointer;
  }
  #videoAudio:hover #audioBar{
    visibility: inherit;
  }
  /* speedBar css */
  #speedBar{
    margin-left:5%;
    margin-top:2%;
    position:absolute;
    -webkit-appearance:none;
    background:red;
    width:10%;
    height:.2rem;
    background:linear-gradient(to left, red 90%, blue 10%);
    visibility: hidden;
  }

  #speedBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    background: blue;
    width:0.5rem;
    height:0.5rem;
    border-radius: 10px;
    cursor:pointer;
  }

  #videoSpeed:hover #speedBar{
    visibility: inherit;
  }
  #seekBarTime{
    border:1px solid red;
    border-radius: 10px;
    position: relative; left: 0%;
  }
  #seekBarLastTime{
    width:8%;
    position: absolute;
  }


  /* @media only screen and (max-width:800px){
    #videoContainer{
      width:90%;
      height:80%;
    }

  } */
</style>
