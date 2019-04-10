<template lang="html">
  <div class="">
    <!--
        video 총시간 구하기
    -->
    <!-- <input type="text" name="" value="" v-model="videoLink">
    <hr> -->
    <div id="videoplayer">
      <video id="video" width="500" v-on:timeupdate="seek_timeupdate()">
        <source src="@/components/test.mp4" type="video/mp4">
        <track kind="subtitles" src="@/components/word.vtt" srclang="en">
      </video>

      <!-- <video id="video" class="video-js vjs-default-skin" preload="auto" width="500" height="360" data-setup='{}' v-on:timeupdate="seek_timeupdate()">
        <source src="http://172.26.3.246/storage/streamable_videos/53.m3u8" type="application/x-mpegURL">
      </video> -->

      <div id="videoController">
        <input id="seekBar" type="range" name="" value="0"
          v-on:change="seek_change()"
          v-on:dblclick="video_loop(true)"
          v-on:click="video_loop(false)"
          v-on:mousedown="mouse_down()"
          v-on:mouseover="mouse_over()"
          v-on:mouseup="mouse_up()"
        >
        <button class="btn" id="playBtn" type="button" name="button" v-on:click="play()">Play</button>
        <span id="videoAudio">
          <input id="audioBar" type="range" name="" value="100" v-on:change="audio()">
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
      first_loop_time: "",//first loop time
      last_loop_time: "",//last loop time
      watch_time: "",//video play time
      loop_check: false,//loop Check
    }
  },
  methods: {
    ...mapActions(['video_action','seek_bar_action']),//vuex actions connect
    play(){//play on/off
      if (this.video.paused){
        this.video.play();
        this.play_btn.style.backgroundImage = "url("+require('@/assets/playstop.jpg')+")";
      }else{
        this.video.pause();
        this.play_btn.style.backgroundImage = "url("+require('@/assets/play.jpg')+")";
      }
    },
    seek_change(){//play input[range]bar reflection
      this.move_time = this.video.duration * (this.seek_bar.value / 100);
      this.video.currentTime = this.move_time;

    },
    seek_timeupdate(){//play video reflection
      if(!this.video.paused){
        this.move_time = (100/ this.video.duration) * this.video.currentTime;
        this.seek_bar.value = this.move_time;
        if(this.loop_check){//this.loop_check true is start
          this.watch_time = this.video.currentTime;
        }
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
    mouse_over(){
    },
    audio(){//audio volume control
      this.video.volume = this.audio_bar.value /100;
    },
    audioOn_off(){//audio volume on/off
      if(this.video.muted === false){
        this.firstValue_audio = this.audio_bar.value;
        this.video.muted = true;
        this.audio_bar.value = 1;
        this.audio_btn.style.backgroundImage = "url("+require('@/assets/audiostop.png')+")";
      }else{
        video.muted = false;
        this.audio_bar.value = this.firstValue_audio;
        this.audio_btn.style.backgroundImage = "url("+require('@/assets/audio.png')+")";
      }
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
    },
    video_loop(check){
      if(check){//check true -> dblclick
        this.first_loop_time = this.video.currentTime;
        console.log("dblclcik");
        this.video.pause();
      }else{//check false -> click
        if(this.first_loop_time!= ""){
          if(this.last_loop_time!= ""){
            this.last_loop_time = 0;
            this.first_loop_time = 0;
            this.loop_check = false;
          }else{
            this.last_loop_time = this.video.currentTime;
            this.loop_check = true;
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
  #videoplayer{
    float:left;
    padding:1em 1em .5em;
    background-color: #ffffff;
    border: 1px solid black;
    border-radius: 10px;
  }
  #videoController{
    padding: 1px;
    border: 1px solid white;
    width:500px;
    /* visibility: hidden; */
    position:absolute;
    top:260px;
  }
  #videoplayer:hover #videoController{
    visibility: inherit;
    position:absolute;
    top:260px;
  }
  /* buttons css */
  .btn{
    text-indent:-10000px;
    width:20px;
    height:20px;
    border:none;
    cursor:pointer;
  }
  #playBtn{
    background-size: 20px;
    background-image:url("../../assets/play.jpg");
    margin:5px;
  }
  #audioBtn{
    background-size:20px;
    background-image:url("../../assets/audio.png");
    margin:5px;
  }
  #speedBtn{
    background-size:20px;
    background-image:url("../../assets/speed.jpg");
    margin:5px;
  }
  /* seekbar css */
  #seekBar{
    -webkit-appearance:none;
    background: white;
    width:80%;
    height:5px;
    cursor: pointer;
  }
  #seekBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    width:15px;
    height:15px;
    background:rgb(47,7,186);
    border-radius: 10px;
    cursor:pointer;
  }
  /* audioBar css */
  #audioBar{
    transform: rotate(-90deg);
    -webkit-appearance:none;
    background:white;
    width:30%;
    height:5px;
    position:absolute;
    top:-71px;
    left:368px;
    visibility: hidden;
  }
  #audioBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    width:15px;
    height:15px;
    background: rgb(47,7,186);
    border-radius: 10px;
    cursor:pointer;
  }
  #videoAudio:hover #audioBar{
    visibility: inherit;
  }
  /* speedBar css */
  #speedBar{
    transform: rotate(-90deg);
    -webkit-appearance:none;
    background:white;
    width:30%;
    height:5px;
    position:absolute;
    top:-70px;
    left:398px;
    visibility: hidden;
  }

  #speedBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    width:15px;
    height: 15px;
    background: rgb(47,7,186);
    border-radius: 10px;
  }

  #videoSpeed:hover #speedBar{
    visibility: inherit;
  }

</style>
