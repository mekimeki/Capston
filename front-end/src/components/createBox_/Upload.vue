<template lang="html">
  <div class="">
    <!-- 파일 선택시 같은 파일 재선택 안됨 문제 .-->
    <div class="video">
      <div class="dropzone" id="video" v-on:dragover.prevent v-on:drop="on_drop($event)">
        drop Zone video

        <div class="" v-show="image_video">
          <img v-bind:src="image_video" alt="" class="img" width="180" height="120"/>
          <br>
          <br>
          <button class="btn" id="videobtn" v-on:click="remove_file($event)">REMOVE</button>
          <span>|</span>
          <button class="btn" type="submit" name="button" v-on:click="file_upload()">Upload</button>
        </div>

      </div>
      <label>
        <input class="hidden" id="videoInput" type="file" name="video" v-on:change="on_change($event)" multiple>
      </label>
      <div class="">
        <v-btn color="success" v-on:click="file_select_video($event)">video file select</v-btn>
        <span>{{video_file_name}}</span>
      </div>
    </div>

    <hr>

    <div class="subtitle">
      <div class="dropzone" id="subtitle" v-on:dragover.prevent v-on:drop="on_drop($event)">
        drop Zone subtitle

        <div class="" v-show="image_subtitle">
          <img v-bind:src="image_subtitle" alt="" class="img" width="180" height="120"/>
          <br>
          <br>
          <button class="btn" id="subtitlebtn" v-on:click="remove_file($event)">REMOVE</button>
          <span>|</span>
          <button class="btn" type="submit" name="button" v-on:click="file_upload($event)">Upload</button>
        </div>

      </div>
      <label>
        <input class="hidden" id="subtitleInput" type="file" name="subtitle" v-on:change="on_change($event)">
      </label>
      <div class="">
        <v-btn color="success" v-on:click="file_select_subtitle($event)">subtitle file select</v-btn>
        <span>{{subtitle_file_name}}</span>
      </div>
    </div>
    <router-link to="" v-if="up_getters.subtitle"> 다음 단계로 </router-link>
    //원래
    <!-- v-if="up_getters.video && up_getters.subtitle" -->
  </div>
</template>

<script>
import {mapState,mapGetters,mapActions} from 'vuex';
export default {
  data() {
    return {
      //
      image_view_video:"https://cdn0.iconfinder.com/data/icons/social-messaging-ui-color-shapes-3/3/72-512.png",
      image_view_subtitle:"http://www.multipelife.com/wp-content/uploads/2016/05/remove-subtitle.jpg",
      //
      image_video: "",
      image_subtitle:"",
      //
      reader:"",
      files:"",
      //
      subtitle_file_name:"",
      video_file_name:"",
      //
      input_video:"",
      input_subtitle:"",
    }
  },
  methods: {
    ...mapActions(['upload_actions']),
    on_drop(evt){//on drop methods
      evt.stopPropagation();
      evt.preventDefault();
      if(evt.target.id === "video"){
        this.files = evt.dataTransfer.files;
        this.create_video_file(this.files[0]);
      }else if(evt.target.id === "subtitle"){
        this.files = evt.dataTransfer.files;
        this.create_subtitle_file(this.files[0]);

      }
    },

    on_change(evt){//change methods
      if(evt.target.id === "videoInput"){
        this.files = evt.target.files;
        console.log("change",this.files[0]);
        this.create_video_file(this.files[0]);
      }else if(evt.target.id === "subtitleInput"){
        this.files = evt.target.files;
        console.log("change",this.files[0]);
        this.create_subtitle_file(this.files[0]);;
      }
    },
    file_select_video(evt){
      this.input_video.click();
    },
    file_select_subtitle(evt){
      this.input_subtitle.click();
    },
    create_video_file(file) {//create file video methods
      if (!file.type.match('video.*')) {
        alert('video를 선택해라');
        return;
      }else{
        this.image_video = this.image_view_video;
        this.video_file_name = file.name;
      }
    },
    create_subtitle_file(file) {//create file subtitle methods
      if (file.name.substring(file.name.length,file.name.length-3) != 'srt') {
        // !file.type.match('text*')
        alert('subtitle를 선택해라');//subtitle 선택하기
        return;
      }else{
        this.image_subtitle = this.image_view_subtitle;
        this.subtitle_file_name = file.name;
      }
    },
    remove_file(evt) {//remove file video and subtitle
      if(evt.target.id === "videobtn"){
        this.image_video = '';
        this.video_file_name = "";
        this.input_video.value = "";
      }else if(evt.target.id === "subtitlebtn"){
        this.image_subtitle = '';
        this.subtitle_file_name = "";
        this.input_subtitle.value = "";
      }
    },

    file_upload(){//다시
      // let form = new FormData();
      if (this.video_file_name) {
        if (this.files.length) {
          this.upload_actions(this,files[0],true);
          // form.append("video",this.files[0]);
        }
      }else if(this.subtitle_file_name){
        if (this.files.length) {
          this.upload_actions(this.files[0],false);
          // form.append("subtitle",this.files[0]);
        }
      }
      // let url_token = "http://172.26.3.246/get-token"
      // // let url = "http://localhost/Capstone_practice/project_videoPlayer/videoBack/TestUpload.php";
      // let url = "http://172.26.3.246/upload"
      // axios.get(url_token).then((res)=>{
      //   //
      //   console.log(res.data);
      //   if (res.data) {
      //     form.append("_token",res.data);
      //     console.log(form);
      //     axios.post(url,form).then((res) => {
      //       console.log("성공",res.data);
      //     }).catch( error => {
      //       console.log('failed', error);
      //     });
      //   }
      //   //
      // }).catch( error => {
      //   console.log('failed',error);
      // });
    }//
  },
  mounted:function(){
    this.input_video = document.getElementById("videoInput");
    this.input_subtitle = document.getElementById("subtitleInput");
    // let url = "http://172.26.3.246/get-token";
    // axios.get(url).then((res) => {
    //   this.token = res.data;
    // }).catch( error => {
    //   console.log('failed', error);
    // });
  },
  computed:{
    ...mapGetters({
      up_getters:'upload_getters',
    })
  }

}
</script>

<style lang="css" scoped>
*{
  font-family: 'Arial';
  font-size: 12px;
}
.dropzone{
  width:200px;
  height:200px;
  border:1px solid black;
}
.hidden{
  display: none;
}
</style>
