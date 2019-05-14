<template lang="html">
  <div class="">
    <!-- audio record -->
    <div>
      <v-card class="ma-2" color="teal lighten-1">
        <v-btn class="play_btn" fab small v-on:click="preview_play($event,number)">
          <v-icon color="teal lighten-1">play_arrow</v-icon>
        </v-btn>
        <v-btn id="recording_btn" fab small v-on:click="recording($event,s_getter[number])">
          <v-icon color="teal lighten-1">mic_off</v-icon>
        </v-btn>
        <span>{{s_getter[number][1][0]}}</span>
        <span>~</span>
        <span>{{s_getter[number][1][1]}}</span>
        <span>:</span>
        <span>{{s_getter[number][2]}}</span>
        <span id="animation" v-if="recording_check">녹음중...</span>
      </v-card>
    </div>
    <br>
    <v-card class="ma-2">
      <v-layout justify-center row wrap>
        <v-flex xl12 sm12 md12>
          <graph_></graph_>
        </v-flex>
        <v-flex xl12 sm12 md12>
          <audio_></audio_>
        </v-flex>
      </v-layout>
    </v-card>
    <!-- modal -->
    <!-- <v-layout row justify-center>
     <v-dialog v-model="dialog" persistent max-width="500" max-height="300">
       <template v-slot:activator="{ on }">
       </template>
       <v-card>
         <v-layout justify-center>
           <v-btn fab large v-on:click="recording($event)" color="red">
             <v-icon>
               mic
             </v-icon>
           </v-btn>
         </v-layout>
       </v-card>
     </v-dialog>
   </v-layout> -->
  </div>
</template>

<script>

// import video_ from '@/components/video_/Video';
import axios from 'axios';
import { mapActions, mapGetters} from 'vuex';//vuex
import audio_ from '@/components/video_/Audio';
import graph_ from '@/components/video_/Graph';
export default {
  components:{
    audio_,
    graph_,
  },
  data(){
    return {
      audio:"",//audio
      video:"",//video check
      record:"",//MediaRecorder object
      chunks:[],//blob parameter
      blob:"",//blob data
      audioURL:"",//audo URL
      check:true,
      recording_icon:"",
      video_end_check:"",
      dialog:false,
      number:0,
      recording_check:false,
    }
  },
  methods:{
    ...mapActions(['graph_origin_action','graph_record_action','graph_reset_action']),
    preview_play(evt,num){
      if(evt){
        evt.target.innerHTML = 'pause';
      }
      this.video.currentTime = this.s_getter[num][1][0];
      if(!this.video.paused){
        this.video.pause();
      }
      this.video.play();
      let inter = setInterval(()=>{
        if(this.video.currentTime.toFixed(1) === this.s_getter[num][1][1].toFixed(1)){
          if(evt){
            evt.target.innerHTML = 'play_arrow';
          }
          clearInterval(inter);
          this.video.pause();
        }
      });
    },
    recording(evt,data){
      if(this.check){
        this.graph_reset_action('');
        let data_s = {
          'video_pk':this.$route.query.video,
          'id': this.l_getter.email,
          'firstTime': data[1][0],
          'lastTime': data[1][1],
        }
        this.graph_origin_action(data_s);

        this.record.start();
        this.check = false;
        if(!this.video.paused){
          this.video.pause();
        }

        this.preview_play(false,this.number);
        this.recording_check = true;
        evt.target.innerHTML = 'mic';

      }else{
        this.record.stop();//recording stop
        // this.chunks = [];//chunks reset
        this.record.ondataavailable = (e) => {//first event data fush in chunks -> this.record event stop
          console.log("ondataavailable");
          this.chunks = [];
          this.chunks.push(e.data);
        }
        this.record.addEventListener("stop",() =>{//second event stop event
          this.blob = new Blob(this.chunks, { 'type' : 'audio/webm; codecs=opus' });//blob data create
          this.audioURL = window.URL.createObjectURL(this.blob);//audio data url create
          this.audio.src = this.audioURL;//url connect
          this.save(data,this.blob);
        });
        this.check = true;
        this.recording_check = false;
        evt.target.innerHTML = 'mic_off';
      }
    },
    save(data,data_blob){//audio blob to file data
      let file =  new File([this.blob], "audio.webm", {
        type: "audio/webm; codecs=opus"
      });
      console.log('file',file);
      let data_s = {
        "audio" : file,
        "originText": "Freud said love and work work and love", //data 에 있는 정보로 바꿔야함
        "originDuration": parseInt(data[1][1]) - parseInt(data[1][0]),
        "id": this.l_getter.email,
        "title": this.$route.query.video+".mp4",
      }
      this.graph_record_action(data_s);
    }
  },
  mounted:function(){
    this.video = this.v_getter;
    this.audio = this.a_getter;//audio
    console.log("audio",this.audio);
    // this.video = document.getElementById('video');//video test
    this.recording_icon = document.getElementById("recording_icon");
    navigator.mediaDevices.getUserMedia({audio:true,video:false}).then((stream)=>{//
    //navigator 브라우저에 대한 정보
    //medioDevices 액세스 제공
    //getUserMedia 권한 부여
      // this.video.srcObject = stream;//test stream data
      // this.video.play();//test
      this.record = new MediaRecorder(stream,{//미디어 쉽게 기록할 수 있도록 해주는 메소
        audioBitsPerSecond : 128000,
        mimeType :''
      });
    }).catch((err)=>{
      console.log("error",err.message);//error message
    });
  },
  updated:function(){
  },
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
      s_getter:'subtitle_getter',
      l_getter:'login_getters',
      sr_getter:'subtitle_record_getter',
      a_getter:'audio_getter',
    }),
  },
  watch:{
    sr_getter: function(data){
      this.number = this.sr_getter;
      console.log('?',this.sr_getter);
    },
    a_getter: function(data){
      this.audio = this.a_getter;
    }
  }
}
</script>

<style lang="css" scoped>
.line{
  border:2px solid black;
}
#scroll_div{
  overflow: scroll;
  height:80px;
}
span{
  color:white;
  text-transform: uppercase;
}
#animation{
  animation-iteration-count: infinite;
  animation-duration: 3s;
  animation-name: slidein;
}

@keyframes slidein {
  from {
    margin-left: 30%;
    width: 100%
  }

  to {
    margin-left: 20%;
    width: 100%;
  }
}
</style>
