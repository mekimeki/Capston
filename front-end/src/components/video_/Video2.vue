<template lang="html">
  <div class="">
  <div id="video_box">
    <!-- <video id="video" src="@/components/test.mp4" v-on:timeupdate="seek_timeupdate()" muted="muted">
    </video> -->

    <video id="video" :src="videoLink"
      v-on:timeupdate="seek_timeupdate()"
    >
    </video>
    <div id="controller">
      <v-layout>
        <v-flex xl12 sm12 md12 >
          <v-slider
            v-on:change="seek_change()"
            v-on:mousedown="mouse_down()"
            v-on:mouseup="mouse_up()"
            id="seek_bar"
            v-model="slider_play"
            color="teal lighten-1"
            :label="time"
            text-color="white"
            max="100"
            min="0"
          ></v-slider>
        </v-flex>
        <v-flex xl1 sm1 md1>
          <v-btn fab small
            v-on:click="play($event)">
            <v-icon large color="teal lighten-1" id="play_btn">play_circle_outline</v-icon>
          </v-btn>
        </v-flex>
        <v-flex xl3 sm3 md3>
          <v-layout>
            <v-flex xl12 sm12 md12>
              <v-btn fab small
                v-on:click="audio_on_off($event)"
              >
                <v-icon middle color="teal lighten-1" id="audio_btn">volume_up</v-icon>
              </v-btn>
            </v-flex>
            <v-flex xl12 sm12 sm12>
              <v-slider id="audio_seek"
                v-on:change="audio_change($event)"
                v-model="slider_audio"
                color="teal lighten-1"
                max="100"
                min="0"
              ></v-slider>
            </v-flex>
          </v-layout>
        </v-flex>
        <v-flex xl3 sm3 md3>
          <v-layout>
            <v-flex xl12 sm12 md12>
              <v-btn fab small id="speed_btn">
                <v-icon middle color="teal lighten-1">replay_10</v-icon>
              </v-btn>
            </v-flex>
            <v-flex xl12 sm12 md12>
              <v-slider id="speed_seek"
                v-on:change="speed_change($event)"
                v-model="slider_speed"
                color="teal lighten-1"
                max="100"
                min="0"
              ></v-slider>
            </v-flex>
            <span></span>
          </v-layout>
        </v-flex>
      </v-layout>
    </div>
  </div>
  </div>
</template>

<script>
import { mapActions } from 'vuex'//vuex actions import
export default {
  data(){
    return{
      videoLink:'',
      video:'',
      time:'00:00/00:00',
      slider_play:0,
      slider_audio:100,
      slider_speed:0,
    }
  },
  methods:{
    ...mapActions(['video_action','seek_bar_action','video_link_action','video_link_view_action']),//vuex actions connect
    time_change(seconds){
      let hour = parseInt(seconds/3600);
      let min = parseInt((seconds%3600)/60);
      let sec = seconds%60;
      return hour+":"+min+":" + sec;
    },
    play(evt){
      if (this.video.paused){
        this.video.play();
        evt.target.innerHTML = 'pause_circle_outline';
      }else{
        this.video.pause();
        evt.target.innerHTML = 'play_circle_outline';
      }
    },
    audio_on_off(evt){
      if(this.video.muted === false){
        this.video.muted = true;
        evt.target.innerHTML = 'volume_off';
        this.slider_audio = 0;
      }else{
        this.video.muted = false;
        evt.target.innerHTML = 'volume_up';
        this.slider_audio = 100;
      }
    },
    audio_change(evt){
      if(this.video.muted){
        this.video.muted = false;
      }
      this.video.volume = this.slider_audio /100;
    },
    speed_change(evt){
      if(!this.video.paused){
        this.video.pause();
      }
      let speed = this.slider_speed;
      alert(speed / 10);
      this.video.playbackRate = parseInt(this.slider_speed / 10);
      this.video.play();
    },
    mouse_down(){
      if(!this.video.paused){
        this.video.pause();
      }
    },
    mouse_up(){
      if(this.video.paused){
        this.video.play();
      }
    },
    seek_change(){
      this.video.currentTime = this.video.duration * (this.slider_play / 100);
    },
    seek_timeupdate(){
      this.slider_play = (100/ this.video.duration) * this.video.currentTime;
      this.time = this.time_change(Math.ceil(video.currentTime))+"/"+this.time_change(Math.ceil(video.duration));
    }
  },
  mounted:function(){
    if(this.$route.name === 'v-video'){//viewo view axios
      this.video_link_view_action(this.$route.query.video).then(result =>{
        this.videoLink = result.video;
      });
    }else{
      //axios
      this.video_link_action(this.$route.query.video).then(result =>{
        this.videoLink = result.video;
      });
    }
    this.video = document.getElementById("video");//video
    this.video_action(this.video);//vuex actions
    this.seek_bar = document.getElementById('seek_bar');
    this.seek_bar_action(this.seek_bar);//vuex mapActions
    this.video.onloadeddata = () =>{
      this.time = this.time_change(Math.ceil(video.currentTime))+"/"+this.time_change(Math.ceil(video.duration));
      if(this.$route.query.time){
        this.video.currentTime = this.$route.query.time;
      }
      // this.video.play();
    }
  },
  updated:function(){
    if(!this.video.paused){
      document.getElementById('play_btn').innerHTML = 'pause_circle_outline';
    }else{
      document.getElementById('play_btn').innerHTML = 'play_circle_outline';
    }
    if(this.video.muted === true){
      document.getElementById('audio_btn').innerHTML = 'volume_off';
    }else{
      document.getElementById('audio_btn').innerHTML = 'volume_up';
    }
    if((this.slider_play === 100)||(this.slider_play === 0)){
      document.getElementById('play_btn').innerHTML = 'play_circle_outline';
    }
    if(this.slider_audio === 0){
      document.getElementById('audio_btn').innerHTML = 'volume_off';
    }else{
      document.getElementById('audio_btn').innerHTML = 'volume_up';
    }
  }
}
</script>

<style lang="css" scoped>
video{
  width:100%;
}
#video_box{
  position: relative;
  width:100%;
  height:100%;
}
#controller{
  position: relative;
  display: inline-block;
  text-align: center;
  opacity: 0.6;
  background: white;
  border-radius: 20px;
  width:100%;
  visibility: hidden;
  top:-76px;
  margin-bottom:-30%;
}
#video_box:hover #controller{
  position: relative;
  visibility: inherit;
  top:-80px;
}
#speed_seek{
  padding-right:5px;
}

</style>
