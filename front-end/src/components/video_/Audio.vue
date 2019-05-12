<template lang="html">
  <div id="audio_box">
    <audio id="audio" controls
      style="display:none"
      v-on:timeupdate="seek_timeupdate()"
    >
      <source src="" type="audio/">
    </audio>
    <div id="controller">
      <v-layout>
        <v-flex xl8 sm8 md8>
          <v-slider
            v-on:change="seek_change()"
            v-on:mousedown="mouse_down()"
            v-on:mouseup="mouse_up()"
            v-on:dblclick="video_loop(true)"
            v-on:click="video_loop(false)"
            id="seek_bar"
            v-model="slider"
            color="teal lighten-1"
            :label="time"
            max="100"
            min="0"
          ></v-slider>
        </v-flex>
        <v-flex xl1 sm1 md1>
          <v-btn fab small class="btn"
            v-on:click="play($event)"
          >
            <v-icon large color="teal lighten-1" id="play_btn">play_circle_outline</v-icon>
          </v-btn>
        </v-flex>
        <v-flex xl2 sm2 md2>
          <v-layout>
            <v-flex xl12 sm12 md12>
              <v-btn fab small class="btn"
                v-on:click="audio_on_off($event)"
              >
                <v-icon large color="teal lighten-1" id="audio_btn">volume_up</v-icon>
              </v-btn>
            </v-flex>
            <v-flex xl12 sm12 md12>
              <v-slider
                id="seek_speaker"
                v-on:change="seek_speaker_change()"
                v-model="slider_audio"
                color="teal lighten-1"
                max="100"
                min="0"
              ></v-slider>
            </v-flex>
          </v-layout>
        </v-flex>
        <v-flex xl1 sm1 md1>
          <v-btn fab small class="btn"
            v-on:click="audio_upload($event)"
          >
            <v-icon large color="teal lighten-1">get_app</v-icon>
          </v-btn>
        </v-flex>
      </v-layout>
    </div>
  </div>
</template>

<script>
import {mapActions} from 'vuex';
export default {
  data(){
    return{
      audio:'',
      seek_bar:'',
      seek_speaker_bar:'',
      slider:0,
      slider_audio:100,
      time:'00:00/00:00',
      firstTime: 0,
      lastTime: 0,
    }
  },
  methods:{
    ...mapActions(['audio_action']),
    time_change(seconds){
      let hour = parseInt(seconds/3600);
      let min = parseInt((seconds%3600)/60);
      let sec = seconds%60;
      return hour+":"+min+":" + sec;
    },
    seek_timeupdate(){
      this.slider = (100/ this.audio.duration) * this.audio.currentTime;
      this.time = this.time_change(Math.ceil(audio.currentTime))+"/"+this.time_change(Math.ceil(audio.duration));
    },
    seek_change(){
      if(this.slider === 0){
        document.getElementById('play_btn').innerHTML = 'pause_circle_outline';
      }
      this.audio.currentTime = this.audio.duration * (this.slider / 100);
    },
    seek_speaker_change(){
      if(this.audio.muted){
        this.audio.muted = false;
      }
      this.audio.volume = this.slider_audio /100;
    },
    play(evt){
      if (this.audio.paused) {
        this.audio.play();
        evt.target.innerHTML = 'pause_circle_outline';
      }else{
        this.audio.pause();
        evt.target.innerHTML = 'play_circle_outline';
      }
    },
    mouse_down(){
      if(!this.audio.paused){
        this.audio.pause();
      }
    },
    mouse_up(){
      if(this.audio.paused){
        this.audio.play();
      }
    },
    audio_on_off(evt){
      if(this.audio.muted === false){
        this.audio.muted = true;
        evt.target.innerHTML = 'volume_off';
      }else{
        this.audio.muted = false;
        evt.target.innerHTML = 'volume_up';
      }
    },
    audio_upload(evt){//이부분만 하면 됨
      let blob = new Blob([this.audio], { 'type' : 'audio/mp3' });
      let objURL = window.URL.createObjectURL(blob);
      //Memory Off
      if (window.__Xr_objURL_forCreatingFile__) {
        window.URL.revokeObjectURL(window.__Xr_objURL_forCreatingFile__);
      }
      window.__Xr_objURL_forCreatingFile__ = objURL;
      let a = document.createElement('a');
      a.download = 'audio';
      a.href = objURL;
      a.click();
    }
  },
  mounted:function(){
    this.audio = document.getElementById('audio');
    this.audio_action(this.audio);
    this.seek_bar = document.getElementById('seek_bar');
    this.seek_speaker = document.getElementById('seek_speaker');
    this.audio.onloadeddata = () =>{
      this.time = this.time_change(Math.ceil(audio.currentTime))+"/"+this.time_change(Math.ceil(audio.duration));
    }
  },
  updated:function(){
    if(!this.audio.paused){
      document.getElementById('play_btn').innerHTML = 'pause_circle_outline';
    }else{
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
#audio_box{
  background: white;
  position: relative;
  width:100%;
  text-align: center;
}
#controller{
  position: relative;
  display: inline-block;
  text-align: center;
  border:5px solid #26A69A;
  border-radius: 20px;
  width:100%;
}


</style>
