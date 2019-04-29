<template lang="html">
  <v-container>
   <v-flex xs12 sm4>
    <v-overflow-btn
      :items="select"
      label="Select"
    ></v-overflow-btn>
   </v-flex>
   <v-layout row wrap>
     <v-flex xs12 sm6 md6 class="pa-1">
       <v-card class="video">
         <v-card-text class="dropzone" id="video" v-on:dragover.prevent v-on:drop="on_drop($event)">
           drop Zone video
           <v-card-text class="" v-show="image_video">
             <video id="video_preview" :src="image_video" autoplay width="150" height="150" muted="muted"></video>
             <!-- <img v-bind:src="image_video" alt="" class="img" width="180" height="120"/> -->
             <v-spacer></v-spacer>
              <button id="videobtn" type="button" name="button"v-on:click="remove_file($event)">remove</button>
              <button type="button" name="button" v-on:click="file_upload_video($event)">upload</button>
              <hr>
              <v-progress-circular
                :rotate="360"
                :size="100"
                :width="15"
                :value="percent"
                color="teal"
                v-model="percent_video"
              >
                {{percent_video}}
              </v-progress-circular>
           </v-card-text>
         </v-card-text>
         <label>
           <input class="hidden" id="videoInput" type="file" name="video" v-on:change="on_change($event)" multiple>
         </label>
         <div class="">
           <v-btn color="success" v-on:click="file_select_video($event)">video file select</v-btn>
           <span>{{video_file_name}}</span>
         </div>
       </v-card>
      </v-flex>

      <v-flex xs12 sm6 md6 class="pa-1">
        <v-card class="subtitle">
          <v-card-text class="dropzone" id="subtitle" v-on:dragover.prevent v-on:drop="on_drop($event)">
            drop Zone subtitle
            <v-card-text class="" v-show="image_subtitle">
              <img v-bind:src="image_subtitle" alt="" class="img" width="180" height="120"/>
              <v-spacer></v-spacer>
               <button id="subtitlebtn" type="button" name="button"v-on:click="remove_file($event)">remove</button>
               <button type="button" name="button" v-on:click="file_upload_subtitle($event)">upload</button>
               <hr>
               <v-progress-circular
                 :rotate="360"
                 :size="100"
                 :width="15"
                 :value="percent_subtitle"
                 color="teal"
               >
                 {{percent_subtitle}}
               </v-progress-circular>
            </v-card-text>
          </v-card-text>
          <label>
            <input class="hidden" id="subtitleInput" type="file" name="subtitle" v-on:change="on_change($event)">
          </label>
          <div class="">
            <v-btn color="success" v-on:click="file_select_subtitle($event)">subtitle file select</v-btn>
            <span>{{subtitle_file_name}}</span>
          </div>
        </v-card>
      </v-flex>
      <div class="" v-if="up_getters.video">
        <b-btn v-on:click="move()">다음으로</b-btn>
      </div>
   </v-layout>
  </v-container>
</template>


<script>
import {
  mapState,
  mapGetters,
  mapActions
} from 'vuex';
export default {
  data() {
    return {
      image_view_video: require('@/assets/video-select.png'),//image view video
      image_view_subtitle: require('@/assets/subtitle-select.png'),//image view subtitle
      image_video: "",//image video
      image_subtitle: "",//image subtitle
      files: "",//file
      file_data:{
        video:'',
        subtitle:'',
      },
      subtitle_file_name: "",//subtitle file name
      video_file_name: "",//video file name
      input_video: "",//input video element
      input_subtitle: "",//input subtitle element
      select: [{ //select
          text: "공개용"
        },
        {
          text: "개인용"
        }
      ],
      page_move:"",
      percent_video:0,
      percent_subtitle:0,
    }
  },
  methods: {
    ...mapActions(['upload_actions','percent_action']),
    move(){
      this.percent_action(0);
      this.$router.push({name:'c-video', query:{video:this.up_getters.video}});
    },
    on_drop(evt) { //on drop methods
      evt.stopPropagation();
      evt.preventDefault();
      if (evt.target.id === "video") {//element id check
        this.files = evt.dataTransfer.files;
        this.create_video_file(this.files[0]);
      } else if (evt.target.id === "subtitle") {//element id check
        this.files = evt.dataTransfer.files;
        this.create_subtitle_file(this.files[0]);
      }
    },

    on_change(evt) { //change methods
      if (evt.target.id === "videoInput") {//element id check
        this.up_getters.video = false;
        this.files = evt.target.files;
        this.create_video_file(this.files[0]);
      } else if (evt.target.id === "subtitleInput") {//element id check
        this.up_getters.subtitle = false;
        this.files = evt.target.files;
        this.create_subtitle_file(this.files[0]);;
      }
    },
    file_select_video(evt) {
      this.input_video.click();
    },
    file_select_subtitle(evt) {
      this.input_subtitle.click();
    },
    create_video_file(file) { //create file video methods
      if(this.percent === 100){
        this.percent_action(0);
      }
      if (!file.type.match('video.*')) {//video filter
        alert('video를 선택해라');
        return;
      } else {
        let reader = new FileReader();
        reader.onload = (e) => {
          document.getElementById('video_preview').src = e.target.result;
        }
        reader.readAsDataURL(file);

        this.file_data.video = file;
        this.image_video = this.image_view_video;
        this.video_file_name = file.name;
      }
    },
    create_subtitle_file(file) { //create file subtitle methods
      if(this.percent === 100){
        this.percent_action(0);
      }
      if (file.name.substring(file.name.length, file.name.length - 3) != 'srt') {//srt filter
        alert('subtitle를 선택해라'); //subtitle 선택하기
        return;
      } else {
        this.file_data.subtitle = file;
        this.image_subtitle = this.image_view_subtitle;
        this.subtitle_file_name = file.name;
      }
    },
    remove_file(evt) { //remove file video and subtitle
      if (evt.target.id === "videobtn") { //element id check
        this.image_video = '';
        this.video_file_name = "";
        this.input_video.value = "";
        this.up_getters.video = false;
      } else if (evt.target.id === "subtitlebtn") {//element id check
        this.image_subtitle = '';
        this.subtitle_file_name = "";
        this.input_subtitle.value = "";
        this.up_getters.subtitle = false;
      }
    },
    file_upload_video() { //
      if (this.video_file_name) {
        if (this.files.length) {
          let payload = {
            file : this.file_data.video,//file 넣는거 따로 하던가 해야겠다.
            check: true,
          }
          this.upload_actions(payload); //upload
          let inter = setInterval(() => {
            this.percent_video = this.percent;
            if(this.percent_video === 100){
              console.log("clear");
              clearInterval(inter);
            }
          }, 100);
        }
      }
    },
    file_upload_subtitle(){
      if(this.up_getters.video){
        if (this.subtitle_file_name) {
          if (this.files.length) {
            let payload = {
              file : this.file_data.subtitle,
              video_pk : this.up_getters.video,
              check:false
            }
            this.upload_actions(payload); //upload
            let inter = setInterval(() => {
              this.percent_subtitle = this.percent;
              if(this.percent_subtitle === 100){
                console.log("clear");
                clearInterval(inter);
              }
            }, 100);
            // this.page_move = true;
          }
        }
      }else{
        alert("video를 업로드 후 업로드 해주세요.");
      }
    }
  },
  mounted: function() {
    this.input_video = document.getElementById('videoInput');
    this.input_subtitle = document.getElementById('subtitleInput');
  },
  updated: function() {
  },
  computed: {
    ...mapGetters({
      up_getters: 'upload_getters',
      percent:'percent_getter',
    })
  },
  watch:{
    // page_move:function(data){
    //   //subtitle 도 체크할 방법 찾기
    //   if(this.up_getters.video){
    //     this.$router.push({name:'c-video', query:{video:this.up_getters.video}});
    //   }
    // },
  }
}
</script>

<style lang="css" scoped>
.hidden{
  display: none;
}
</style>
