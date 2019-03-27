<template lang="html">
  <div class="">
    <input type="text" name="" value="" v-model="videoLink">
    <hr>
    <div id="videoplayer">
      <video id="video" width="500" v-on:timeupdate="seek_timeupdate()">
        <source src="@/components/test.mp4" type="video/mp4">
      </video>
      <div id="videoController">
        <input id="seekBar" type="range" name="" value="0"
          v-on:change="seek_change()"
          v-on:dblclick="video_loop(true)"
          v-on:click="video_loop(false)"
          v-on:mousedown="mouse_down()"
          v-on:mouseup="mouse_up()">
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
      Wathch-time:{{watch_time}}
      first-time:{{first_loop_time}}
      last-time:{{last_loop_time}}
      <hr>
      video:
      {{video_times}}
  </div>
</template>

<script>
import { mapActions } from 'vuex'

export default {
  name:"video_",
  data() {
    return {
      interval:"",//seek bar update setinterval
      video_times:[],//video_times;
      //video values
      videoLink: "/media/test.6397655f.mp4",
      video: "",//play video
      play_btn : "",//play button
      seek_bar : "", // play bar
      move_time : "",// move play time
      //audio values
      firstValue_audio: "",//audio first volume
      audio_bar:"",//audo range
      audio_btn: "",//audio button
      //speed values
      speed_bar:"",
      speed_btn:"",
      speed:"",
      //video Loop
      first_loop_time: "",
      last_loop_time: "",
      watch_time: "",
      loop_check: false,
    }
  },
  methods: {
    ...mapActions(['video_action']),
    seek_bar_update(start,end){
      this.video_times.push({
        'start':start,
        'end':this.video.duration,
        'now':this.video.currentTime,
      });
    },
    play(){
      if (this.video.paused){
        console.log("play");
        this.video.play();
        this.play_btn.style.background = "red";
      }else{
        this.video.pause();
        this.play_btn.style.background = "green";
      }
    },
    seek_change(){
      this.move_time = this.video.duration * (this.seek_bar.value / 100);
      this.video.currentTime = this.move_time;
    },
    seek_timeupdate(){
      if(!this.video.paused){
        this.move_time = (100/ this.video.duration) * this.video.currentTime;
        this.seek_bar.value = this.move_time;
        this.video_times[0].now = this.move_time;
      }
      if(this.loop_check){
        this.watch_time = this.video.currentTime;
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
        console.log("up");
        this.video.play();
      }else{

      }
    },
    audio(){
      console.log("audio");
      this.video.volume = this.audio_bar.value /100;
    },
    audioOn_off(){
      if(this.video.muted === false){
        this.firstValue_audio = this.audio_bar.value;
        this.video.muted = true;
        this.audio_bar.value = 1;
        this.audio_btn.style.background = "blue";
      }else{
        video.muted = false;
        this.audio_bar.value = this.firstValue_audio;
        this.audio_btn.style.background = "red";
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
      if(check){//dblclick
        this.first_loop_time = this.video.currentTime;
        this.video.pause();
      }else {//click
        if(this.first_loop_time!= ""){
          if(this.last_loop_time != ""){
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
    console.log("beforeMout");
  },
  mounted: function() {
    //video
    this.video = document.getElementById("video");//video
    this.play_btn = document.getElementById("playBtn");//play
    this.seek_bar = document.getElementById("seekBar");//seek bar
    //audio
    this.audio_bar = document.getElementById("audioBar");//audio bar
    this.audio_btn = document.getElementById("audioBtn");//audio
    //speed
    this.speed_bar = document.getElementById("speedBar");//speed bar
    this.speed_btn = document.getElementById("speedBtn");//speedn btn

    // this.$store.dispatch('video_action',this.video);//vuex actions
    this.video_action(this.video);
    //video start , end time -> seek bar seek
    this.interval = setInterval(()=>{//setInterval start
      if(this.video.readyState === 4){
        this.seek_bar_update(0,this.video.duration);
        clearInterval(this.interval);//setInterval stop
      }
    }, 300);// video start tiem end time check

  },
  beforeUpdate: function() {
    // this.video = document.getElementById("video");//혹시나 해서.
    // console.log("video beforeUpdate");
  },
  updated: function(){
    // console.log("video update");
  },
  computed:{
    video_first_time(){
      // if(this.video_times){
      //   return this.video_times[0].start;
      // }
    },
    video_last_time(){
      // if(this.video_times){
      //   if(Math.floor((this.video.duration/60)/60) === 0){//minute
      //     this.video.first_time = this.video.duration/60;
      //   }else if(Math.floor(end/60) === 0){//second
      //     this.video.first_time = this.video.duration;
      //   }else{//hours
      //     this.video.first_time = (this.video.duration/60)/60;
      //   }
      //   return this.video_times[0].end;
      // }
    },
  },
  watch: {//loop
    watch_time: function(data){
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
  #videoplayer{
    float:left;
    padding:1em 1em .5em;
    background-color: white;
    border: 5px solid rgb(47,7,186);
    border-radius: 15px;
  }
  #videoController{
    border: 5px solid rgb(47, 7, 186);
    width:500px;
    border-radius: 15px;
    visibility: hidden;
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
    width:15px;
    height:15px;
    border:none;
    cursor:pointer;
  }
  #playBtn{
    background:green;
  }
  #audioBtn{
    background:red;
  }
  #speedBtn{
    background:blue;
  }
  /* seekbar css */
  #seekBar{
    -webkit-appearance:none;
    background: white;
    width:80%;
    height:10px;
  }
  #seekBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    width:15px;
    height:15px;
    background:rgb(47,7,186);
    cursor:pointer;
  }
  /* audioBar css */
  #audioBar{
    transform: rotate(-90deg);
    -webkit-appearance:none;
    background:white;
    width:30%;
    height:10px;
    position:absolute;
    top:-77px;
    left:343px;
    visibility: hidden;
  }
  #audioBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    width:15px;
    height:15px;
    background: rgb(47,7,186);
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
    height:10px;
    position:absolute;
    top:-77px;
    left:358px;
    visibility: hidden;
  }

  #speedBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    width:15px;
    height: 15px;
    background: rgb(47,7,186);
  }

  #videoSpeed:hover #speedBar{
    visibility: inherit;
  }

</style>
