<template lang="html">
  <div class="">
    <span>{{sb_getter.length}}</span>
    <div id="scroll_div"
    v-on:scroll="scroll()">
      <div class="textarea" v-for="(tent, i) in content" v-if="i >= scroll_num.first && i<= scroll_num.last">
        <input type="text" name="" value="" v-model="tent.firstTime">~
        <input type="text" name="" value="" v-model="tent.lastTime">
        <v-textarea
        outline
        name="input-7-4"
        label="Outline textarea"
        value="자막을 작성 하시오."
        v-model="tent.textarea">
        </v-textarea>
        <v-btn color="success" v-on:click="create_btn(i)">추가</v-btn>
        <v-btn color="success" v-on:click="delete_btn(i)">삭제</v-btn>
      </div>
    </div>
    <div class="">
      <v-btn color="success" v-on:click="">저장</v-btn>
    </div>
  </div>
</template>

<script>
import {mapState,mapGetters,mapActions} from 'vuex';
import axios from 'axios';
export default {
  data(){
    return{
      video:"",
      scroll_div:"",
      scroll_bottom:"",

      content:[],
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
    create_btn(check){
      this.content.splice(check+1,0,{
        "firstTime":this.content[check].lastTime+1,
        "lastTime":this.content[check].lastTime+3,
        "textArea":"Content Box",
      })
    },
    delete_btn(check){
      if(check === 0){
        this.content.shift();
      }else{
        this.content.splice(check,1);
      }
    },
    save_btn(){

    },
    scroll(){
      console.log("?");
      this.scroll_bottom = this.scroll_div.scrollTop;
    }
  },
  mounted:function(){
    this.video = this.v_getter;
    this.scroll_div = document.getElementById('scroll_div');
    let url = "";
    if (true) { //subtitle create
      url = "http://localhost/Capstone_practice/project_videoPlayer/videoBack/videoText_parser.php"//url path
    }else{ //content create
    } //
    //
    axios.get(url).then((res)=>{
      this.subtitle_action(res.data);
      for (let i = 0; i < this.s_getter.length; i++) {
        this.content.push({
          "firstTime": this.s_getter[i][1][0],
          "lastTime": this.s_getter[i][1][1],
          "textArea":this.s_getter[i][2],
        });
      }
    },(error)=>{alert("연결을 확인해 주세요")});
    //
    this.terval = setInterval(()=>{//체크 변수
      this.video_time_check = this.video.currentTime;
    },100);
  },
  beforeUpdate:function(){
  },
  updated:function(){
    console.log("check updated");//2num loop
    while (this.sb_getter.length != 0) {
      let i = 0;
      for (i; i < this.content.length; i++) {
        if (this.content[i].firstTime > this.sb_getter[0].firstTime) {
          break;
        }else{
          if(this.content.length === i){
            i = 0;
            break;
          }
        }
      }
      this.content.splice(i,0,{
        "firstTime":this.sb_getter[0].firstTime,
        "lastTime":this.sb_getter[0].lastTime,
        "textArea":this.sb_getter[0].textArea,
      });
      this.sb_getter.splice(0,1);
    }
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
      for (let i = 0; i < this.content.length; i++) {
        //
        if (this.content[i].firstTime.toFixed(1) === data.toFixed(1)) {
          if(this.scroll_num.first<=i && i<= this.scroll_num.last){
          }else{
            this.scroll_num.last = this.scroll_num.last +i;
          }

          //
          setTimeout(()=>{
            clearInterval(this.terval);
            let input = document.getElementsByClassName("textarea");
            input[i].style.backgroundColor = "blue";
            input[i].scrollIntoView({behavior:'smooth'});
            setTimeout(()=>{
              this.terval = setInterval(()=>{
                this.video_time_check = this.video.currentTime;
              },100);
            },this.content[i].lastTime - this.content[i].firstTime);
          },100);
          //
        }//if end
      }//for end
    },
  }
}
</script>

<style lang="css" scoped>
#scroll_div{
  overflow: scroll;
  height:300px;
}
</style>
