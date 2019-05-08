<template lang="html">
  <div class="">
    <!-- audio record -->
    <div id="scroll_div">
      <v-card class="ma-2" v-for="(sub,i) in s_getter" color="orange">
        <v-btn fab small v-on:click="preview_play($event,i)">
          <v-icon>play_arrow</v-icon>
        </v-btn>
        <v-btn fab small v-on:click="recording($event)">
          <v-icon>mic</v-icon>
        </v-btn>
        <span>{{s_getter[i][1][0]}}</span>
        <span>~</span>
        <span>{{s_getter[i][1][1]}}</span>
        <span>:</span>
        <span>{{s_getter[i][2]}}</span>
      </v-card>
    </div>
    <br>
    <v-card color="orange" class="ma-2">
      <v-layout justify-center>
        <audio_></audio_>
        <!-- <audio id="audio" controls src=""></audio> -->
      </v-layout>
    </v-card>
    <!-- modal -->
    <v-layout row justify-center>
     <v-dialog v-model="dialog" persistent max-width="290">
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
   </v-layout>
  </div>
</template>

<script>

// import video_ from '@/components/video_/Video';
import axios from 'axios';
import { mapActions, mapGetters} from 'vuex';//vuex
import audio_ from '@/components/video_/Audio';
export default {
  components:{
    audio_,
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
    }
  },
  methods:{
    preview_play(evt,num){
      evt.target.innerHTML = 'pause';
      this.video.currentTime = this.s_getter[num][1][0];
      if(!this.video.paused){
        this.video.pause();
      }

      this.video.play();
      let inter = setInterval(()=>{
        if(this.video.currentTime.toFixed(1) === this.s_getter[num][1][1].toFixed(1)){
          evt.target.innerHTML = 'play_arrow';
          clearInterval(inter);
          this.video.pause();
        }
      });
    },
    recording(evt){
      if(this.check){
        this.record.start();
        this.check = false;
        if(!this.video.paused){
          this.video.pause();
        }
        this.dialog = true;
        evt.target.innerHTML = 'mic';
      }else{
        this.record.stop();//recording stop

        this.chunks = [];//chunks reset

        this.record.ondataavailable = (e) => {//first event data fush in chunks -> this.record event stop
          console.log("ondataavailable");
          this.chunks.push(e.data);
        }

        this.record.addEventListener("stop",() =>{//second event stop event

          this.blob = new Blob(this.chunks, { 'type' : 'audio/webm; codecs=opus' });//blob data create
          this.audioURL = window.URL.createObjectURL(this.blob);//audio data url create
          this.audio.src = this.audioURL;//url connect
          this.save();

        });
        this.check = true;
        evt.target.innerHTML = 'mic_off';
        this.dialog = false;
      }
    },
    save(){//audio blob to file data
      let file = new File([this.blob], "audio.webm", {type:"audio/webm; codecs=opus"});//create file data
      let form = new FormData();//form create
      form.append("audio",file);// file data to form append
      let url = "http://localhost/voice/record";//url
      axios.post(url,form).then((res) => {//axios to url
        console.log(res.data);//check
      }).catch( error => {
        console.log('failed', error);
      });
    }
  },
  mounted:function(){
    this.video = this.v_getter;
    this.audio = document.getElementById('audio');//audio
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
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
      s_getter:'subtitle_getter',
    }),
  },
}
</script>

<style lang="css" scoped>
.line{
  border:2px solid black;
}
#scroll_div{
  overflow: scroll;
  height:300px;
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
    margin-left: 50%;
    width: 50%
  }

  to {
    margin-left: 0%;
    width: 100%;
  }
}
</style>
