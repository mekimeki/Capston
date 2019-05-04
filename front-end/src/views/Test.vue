<template lang="html">
  <div class="">
    <!-- audio record -->
    <div class="line">
      <audio id="audio" controls src=""></audio>
      <!-- <video id="video" autoplay poster="posterimage.jpg" controls></video> -->
    </div>
    <br>
    <div class="line">
      <!-- <v-btn color="success" type="button" name="button" v-on:click="start()">녹음</v-btn>
      <v-btn color="success" type="button" name="button" v-on:click="stop_save()">녹음끝</v-btn>
      <v-btn color="success" type="button" name="button" v-on:click="save()">저장</v-btn> -->
      <v-btn color="error" fab large dark v-on:click="recording()">
        <v-icon id="recording_icon">play_arrow</v-icon>
      </v-btn>
      <v-btn v-on:click="checkk()">
        check
      </v-btn>

      <v-btn @click="test">
        TEST
      </v-btn>
    </div>
  </div>
</template>

<script>
import createContent_ from "@/components/createBox_/CreateContent";
import createInput_ from "@/components/createBox_/CreateInput";
// import video_ from '@/components/video_/Video';
import axios from "axios";
export default {
  components: {
    createContent_,
    createInput_
  },
  data() {
    return {
      audio: "", //audio
      video: "", //video check
      record: "", //MediaRecorder object
      chunks: [], //blob parameter
      blob: "", //blob data
      audioURL: "", //audo URL
      check: true,
      recording_icon: ""
    };
  },
  methods: {
    recording() {
      if (this.check) {
        this.record.start();
        alert("녹음 시작");
        this.check = false;
        this.recording_icon.innerHTML = "pause";
      } else {
        this.record.stop(); //recording stop

        this.chunks = []; //chunks reset

        this.record.ondataavailable = e => {
          //first event data fush in chunks -> this.record event stop
          this.chunks.push(e.data);
        };

        this.record.addEventListener("stop", () => {
          //second event stop event

          this.blob = new Blob(this.chunks, {
            type: "audio/webm; codecs=opus"
          }); //blob data create
          this.audioURL = window.URL.createObjectURL(this.blob); //audio data url create
          this.audio.src = this.audioURL; //url connect
          this.save();
        });
        alert("녹음 종료");
        this.check = true;
        this.recording_icon.innerHTML = "play_arrow";
      }
    },
    save() {
      //audio blob to file data
      let file = new File([this.blob], "audio.webm", {
        type: "audio/webm; codecs=opus"
      }); //create file data
      let form = new FormData(); //form create
      form.append("audio", file); // file data to form append
      let url = "http://localhost/voice/record"; //url
      axios
        .post(url, form)
        .then(res => {
          //axios to url
          console.log(res.data); //check
        })
        .catch(error => {
          console.log("failed", error);
        });
    },
    checkk() {
      axios
        .post("http://localhost/voice/extract")
        .then(res => {
          console.log(res.data);
        })
        .catch(error => {
          console.log("faillll2", error);
        });
    },
    test() {
      var form = new FormData();
      form.append("title", "testtt");
      form.append("lang", "한국어");
      form.append("words", ["test", "test22"]);

      axios.post("http://172.26.3.143/api/create", form).then(res => {
        console.log("ok");
      });
    }
  },
  mounted: function() {
    this.audio = document.getElementById("audio"); //audio
    // this.video = document.getElementById('video');//video test
    this.recording_icon = document.getElementById("recording_icon");
    navigator.mediaDevices
      .getUserMedia({ audio: true, video: false })
      .then(stream => {
        //
        //navigator 브라우저에 대한 정보
        //medioDevices 액세스 제공
        //getUserMedia 권한 부여
        // this.video.srcObject = stream;//test stream data
        // this.video.play();//test
        this.record = new MediaRecorder(stream, {
          //미디어 쉽게 기록할 수 있도록 해주는 메소
          audioBitsPerSecond: 128000,
          mimeType: ""
        });
      })
      .catch(err => {
        console.log("error", err.message); //error message
      });
  }
};
</script>

<style lang="css" scoped>
.line {
  border: 2px solid black;
}
</style>
