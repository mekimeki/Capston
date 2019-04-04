<template lang="html">
  <div class="">
    <div class="">
      {{sb_getter.length}}
    </div>
    <div id="scroll_div"
    v-on:scroll="scroll()">
      <div class="textarea" v-for="(subtitle, i) in subtitle_box" v-if="i >= scroll_num.first && i<= scroll_num.last">
        <input type="text" name="" value="" v-model="subtitle.firstTime">
        ~
        <input type="text" name="" value="" v-model="subtitle.lastTime">
        <v-textarea
            outline
            name="input-7-4"
            label="Outline textarea"
            value="자막을 작성 하시오."
            v-model="subtitle.textArea"
          ></v-textarea>
          <v-btn color="success"
          v-on:click="subtitle_middle_create(i)">추가</v-btn>
          <v-btn color="success"
          v-on:click="subtitle_middle_delete(i)">삭제</v-btn>
      </div>
      <hr>
    </div>
    <div class="">
      <v-btn color="success" v-on:click="subtitle_save()">저장</v-btn>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import {mapState,mapGetters,mapActions} from 'vuex';
export default {
  data(){
    return{
      video:"",
      subtitle_box:[],
      //
      scroll_div:"",
      scroll_bottom:"",
      scroll_top:"",
      scroll_num:{
        first:0,
        last:100,
      },
      terval:"",
      //
      video_time_check:"",
    }
  },
  methods:{
    ...mapActions(['subtitle_action']),
    subtitle_middle_create(check){
      this.subtitle_box.splice(check+1,0,{
        "firstTime":this.subtitle_box[check].lastTime+1,
        "lastTime":this.subtitle_box[check].lastTime+3,
        "textArea":"자막박스",
      })
    },
    subtitle_middle_delete(check){
      if(check === 0){
        this.subtitle_box.shift();
      }else{
        this.subtitle_box.splice(check,1);
      }
    },
    scroll(){
      this.scroll_bottom = this.scroll_div.scrollTop;
    },
    subtitle_save(){
      let form = new FormData();
      form.append("subtitle",JSON.stringify(this.subtitle_box));
      let url = `http://localhost/Capstone_practice/project_videoPlayer/videoBack/TestVideo.php`;
      axios.post(url,form).then( (res) => {
        console.log(res.data);
      }).catch( error => {
        console.log('failed', error);
      });
    }
  },
  mounted:function(){
    this.video = this.v_getter;
    this.scroll_div = document.getElementById('scroll_div');
    let url = "http://localhost/Capstone_practice/project_videoPlayer/videoBack/videoText_parser.php"//url path
    axios.get(url).then((res)=>{
      this.subtitle_action(res.data);
      for (let i = 0; i < this.s_getter.length; i++) {
        this.subtitle_box.push({
          "firstTime": this.s_getter[i][1][0],
          "lastTime": this.s_getter[i][1][1],
          "textArea":this.s_getter[i][2],
        });
      }
      this.terval = setInterval(()=>{
        this.video_time_check = this.video.currentTime;
      },100);
    },(error)=>{alert("연결을 확인해 주세요")});
  },
  updated:function(){
    for (let i = 0; i < this.subtitle_box.length; i++) {
      for (let s = 0; s < this.sb_getter.length; s++) {
        if(this.subtitle_box[i].firstTime > this.sb_getter[s].firstTime){
          this.subtitle_box.splice(i,0,{
            "firstTime":this.sb_getter[s].firstTime,
            "lastTime":this.sb_getter[s].lastTime,
            "textArea":this.sb_getter[s].textArea,
          });
          this.sb_getter.splice(s-1,1);
        }
      }
    }//end for
  },
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
      s_getter:'subtitle_getter',
      sb_getter:'subtitle_buffer_getter',
    }),
  },
  watch:{
    scroll_bottom:function(data){
      if(Math.ceil(data) >= Math.floor(this.scroll_div.scrollHeight-this.scroll_div.clientHeight)){
        this.scroll_num.last = this.scroll_num.last + 100;
      }
    },
    video_time_check:function(data){
      //코드 수정 필요
      let input = document.getElementsByClassName("textarea");
      for (let i = 0; i < this.subtitle_box.length; i++) {
        if (this.subtitle_box[i].firstTime.toFixed(1) === data.toFixed(1)) {
          if(this.scroll_num.first<=i && i<= this.scroll_num.last){
          }else{
            this.scroll_num.last = this.scroll_num.last +i;
          }
          setTimeout(()=>{
            clearInterval(this.terval);
            let input = document.getElementsByClassName("textarea");
            input[i].style.backgroundColor = "blue";
            input[i].scrollIntoView({behavior:'smooth'});
            setTimeout(()=>{
              this.terval = setInterval(()=>{
                this.video_time_check = this.video.currentTime;
              },100);
            },this.subtitle_box[i].lastTime - this.subtitle_box[i].firstTime);
          },100);
        }
      }
    },
  }

}
</script>

<style lang="css" scoped>
#scroll_div{
  overflow: scroll;
  width:700px;
  height:300px;
}
</style>
