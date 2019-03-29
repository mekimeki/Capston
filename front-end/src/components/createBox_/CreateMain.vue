<template lang="html">
  <div class="">
    <!-- 자막 작성 칸 -->
    {{subtitle_length}}
    <v-btn color="success">자막작성</v-btn>
    <div class="">
      <input type="text" name="" value="" v-model="check_time.first">
      ~
      <input type="text" name="" value="" v-model="check_time.last">
      <v-textarea
      outline
      label="자막작성"
      rows="5"
      v-on:click="time_check(true)"
      v-model="subtitle_write"
      >
      </v-textarea>
      <v-btn color="success"
      v-on:click="time_check(false)"
      >추가</v-btn>
    </div>
    <!-- subtitle Box -->
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
    <hr>
  </div>
</template>

<script>
import {mapState, mapGetters, mapActions} from 'vuex'
import axios from 'axios';
export default {
  data(){
    return{
      //video
      video:"",//video
      //scroll values
      scroll_div:"",
      scroll_top:"",
      //subtitle save values
      check_time:{
        'first':'',
        'last':'',
        'now':'',
      },//subtitle create box times
      subtitle_length:{
        'first':'',
        'last':'',
      },//subtitle length
      create_number:"",//create times
      subtitle_box:[],//subtitle box
      subtitle:[],//subtitle total
      subtitle_middle:[],//subtitle middle
      subtitle_write:"",//subtitle wirte
    }
  },
  methods:{
    ...mapActions(['subtitle_action']),
    time_check(check){//subtitle create time update
      if(check){//first true
        console.log("first");
        this.check_time.first = this.video.currentTime;
      }else{//last false
        if(!(this.check_time.first === "")){
          if(this.check_time.last === ""){
            if(this.check_time.first === this.video.currentTime){
              this.check_time.last = this.video.currentTime +2;
              this.create_number = this.check_time.first;
            }else{
              this.check_time.last = this.video.currentTime;
              this.create_number = this.check_time.first;
            }
          }
        }
      }
    },
    scroll_bottom(){//scroll check scroll event
      this.scroll_top = this.scroll_div.scrollTop;
    },
    subtitle_box_put(first,end){//push subtitle_box
      for (let i = first; i < end; i++) {
        this.subtitle_box.push({
          'firstTime':this.s_getter[i][1][0],
          'lastTime':this.s_getter[i][1][1],
          'textArea':this.s_getter[i][2],
        });//store.js subtitle getter
      }
    },
    subtitle_middle_create(check){
      this.subtitle_box.splice(check+1,0,{
        'firstTime':this.subtitle_box[check].lastTime+1,
        'lastTime':this.subtitle_box[check].lastTime+3,
        'textArea':'자막박스',
      });
    },
    subtitle_middle_delete(check){
      console.log(check);
      if(check === 0){
        this.subtitle_box.shift();
      }else{
        this.subtitle_box.splice(check,1);
      }
    }
  },
  mounted:function(){//components load start
    this.video = this.v_getter;//stroe.js video getter
    this.scroll_div = document.getElementById('scroll_div');//scroll div
    //subtitle -> push
    let url = "http://localhost/Capstone_practice/project_videoPlayer/videoBack/videoText_parser.php"//url path
    axios.get(url).then((res)=>{
      this.subtitle_action(res.data);//store.js action
      this.subtitle_length.first = 0;
      this.subtitle_length.last = this.s_getter.length;
      this.subtitle = this.s_getter;//subtitle total
      if(this.subtitle_length.last > 100){
        this.subtitle_box_put(this.subtitle_length.first,5);
      }else{
        this.subtitle_box_put(this.subtitle_length.first,this.subtitle_length.last);
      }
    },(error)=>{alert("연결을 확인해 주세요")});
  },
  computed:{
    ...mapGetters({//video getter
      v_getter:'video_getter',
      s_getter:'subtitle_getter',
    }),
  },
  watch:{
    check_time:function(data){//create box
      this.first_time = data;
      this.last_time = data+2;
      this.subtitle_box.push({
        firstTime : this.first_time,
        lastTime : this.last_time,
        textArea: "자막을 적어주세요",
      });
    },
    scroll_top(data){//infinite scroll
      if(Math.ceil(data) >= Math.floor(this.scroll_div.scrollHeight-this.scroll_div.clientHeight)){//
        if(this.subtitle_length.first === this.subtitle_length.last){

        }else{
          this.subtitle_length.first = this.subtitle_length.first + 5;
          for (let i = this.subtitle_length.first; i < this.subtitle_length.first+5; i++) {
            this.subtitle_box.push({
              'firstTime':this.s_getter[i][1][0],
              'lastTime':this.s_getter[i][1][1],
              'textArea':this.s_getter[i][2],
            });//store.js subtitle getter
          }
          for (let i = 0; i < this.subtitle_box.length; i++) {
            for (let s = 0; s < this.subtitle_middle.length; s++) {
              if(this.subtitle_box[i].firstTime > this.subtitle_middle.fristTime){
                this.subtitle_box.splice(i,0,{
                  'firstTime':this.subtitle_middle[s].firstTime,
                  'lastTime':this.subtitle_middle[s].lastTime,
                  'textArea':this.subtitle_middle[s].textArea,
                });
                this.subtitle_middle.splice(s-1,1);
              }
            }
          }
        }//else end
      }
    },
    create_number(data){
      //data == this.check_time.first
      this.subtitle_middle.push({
        'firstTime':this.check_time.first,
        'lastTime':this.check_time.last,
        'textArea':this.subtitle_write,
      });
      for (let i = 0; i < this.subtitle_box.length; i++) {
        for (let s = 0; s < this.subtitle_middle.length; s++) {
          if(this.subtitle_box[i].firstTime > data){
            this.subtitle_box.splice(i,0,{
              'firstTime':this.subtitle_middle[s].firstTime,
              'lastTime':this.subtitle_middle[s].lastTime,
              'textArea':this.subtitle_middle[s].textArea,
            });
            this.subtitle_middle.splice(s-1,1);
          }
        }
      }
      this.check_time.first = "";
      this.check_time.last = "";
      this.subtitle_write = "";
      data = "";
      console.log("createNumber");
    }
  }
}
</script>

<style lang="css" scoped>
  #create_bar{
    -webkit-appearance:none;
    background: black;
    width:100%;
    height:10px;
    cursor:pointer;
  }
  #create_bar::-webkit-slider-thumb{
    -webkit-appearance:none;
    width:15px;
    height:15px;
    background:rgb(47,7,186);
    cursor:pointer;
  }
  #scroll_div{
    overflow: scroll;
    width:500px;
    height:500px;
  }
</style>
