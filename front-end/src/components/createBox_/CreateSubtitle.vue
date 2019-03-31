<template lang="html">
  <div class="">
    {{subtitle_length}}
    <div id="scroll_div"
    v-on:scroll="scroll_bottom()">
      <div v-for="(subtitle, i) in subtitle_box">
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
          <hr>
      </div>
    </div>
    <div class="">
      <v-btn color="success"
      v-on:click="subtitle_create()">저장</v-btn>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import {mapState,mapGetters,mapActions} from 'vuex';
export default {
  data(){
    return{
      //video
      video:"",
      //scroll
      scroll_div:"",
      scroll_top:"",
      //subtitle
      subtitle_length:{
        'first':0,
        'last':0,
      },
      subtitle_box:[],
      //
      check:0,
      repeat:"",//반복
    }
  },
  methods:{
    ...mapActions(['subtitle_action']),
    subtitle_box_create(start){
      for (let i = start; i < start+5; i++) {
        this.subtitle_box.push({
          "firstTime": this.s_getter[i][1][0],
          "lastTime": this.s_getter[i][1][1],
          "textArea":this.s_getter[i][2],
        });
      }
    },
    subtitle_input_create(){
      if(this.subtitle_box.length > 1){
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
      }else{
        for (let i = 0; i < this.sb_getter.length; i++) {
          this.subtitle_box.push({
            "firstTime":this.sb_getter[i].firstTime,
            "lastTime":this.sb_getter[i].lastTime,
            "textArea":this.sb_getter[i].textArea,
          });
          this.sb_getter.splice(i,1);
        }
      }
    },
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
    scroll_bottom(){
      this.scroll_top = this.scroll_div.scrollTop;
    },
    subtitle_create(){
      while (this.subtitle_length.first !== this.subtitle_length.last) {
        clearInterval(this.repeat);
        this.subtitle_box_create(this.subtitle_length.first);
        this.subtitle_length.first = this.subtitle_length.first + 5;
      }
      // let params = new URLSearchParams();
      // params.append('subtitle', this.subtitle_box);
      let form = new FormData();
      form.append("subtitle",this.subtitle_box);
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
      this.subtitle_length.last = this.s_getter.length;
      if(this.subtitle_length.last > 100){
        this.repeat = setInterval(() => {
          if(this.subtitle_length.first === this.subtitle_length.last){
            clearInterval(this.repeat);
          }
          this.subtitle_box_create(this.subtitle_length.first);
          this.subtitle_length.first = this.subtitle_length.first + 5;
        }, 1000);
      }
    },(error)=>{alert("연결을 확인해 주세요")});
    setInterval(()=>{//input 에서 계속 받아오기.
      this.check = this.sb_getter.length;
    }, 500);
  },
  beforeUpdate:function(){
    // console.log("before");
  },
  updated:function(){
    // console.log("update");
    this.subtitle_input_create();
  },
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
      s_getter:'subtitle_getter',
      sb_getter:'subtitle_buffer_getter'
    }),
  },
  watch:{
    scroll_top:function(data){
      if(Math.ceil(data) >= Math.floor(this.scroll_div.scrollHeight-this.scroll_div.clientHeight)){//
        this.subtitle_box_create(this.subtitle_length.first);
        this.subtitle_length.first = this.subtitle_length.first + 5;
      }
    },
    check:function(){
      this.subtitle_input_create();
    }
  },
}
</script>

<style lang="css" scoped>
  #scroll_div{
    overflow: scroll;
    width:500px;
    height:500px;
  }
</style>
