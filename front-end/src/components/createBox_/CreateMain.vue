<template lang="html">
  <div class="">
    <br>
    <span>firstTime:{{create_bar_start_time}}</span>
    <input id="create_bar" type="range" name="" value="" max="100" min="0"
    v-on:change="create_bar_change()"
    v-on:mousedown="mouse_down()"
    v-on:mouseup="mouse_up()"
    v-on:mousemove="mouse_move($event)"
    >
    <span>endTime:{{create_bar_end_time}}</span>
    <hr>
    <div class="">
      video_times:{{video_times}}
      subtitle_length:{{subtitle_length}}
    </div>
    <hr>
    <button type="button" name="button"
    v-if="!subtitle_box"
    v-on:click="create_subtitle(true)">클릭</button>
    <!-- subtitle Box -->
    <div id="scroll_div"
    v-on:scroll="scroll_bottom()">
      <div v-for="subtitle in subtitle_box">
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
          <button type="button" name="button" v-on:click="create_subtitle(false)">클릭</button>
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
      video:"",//video
      create_bar:"",//create bar
      video_times:[],//video start time and end time
      interval:"",//setInterval values
      move_time:"",//video currentTime move check
      //scroll values
      scroll_div:"",
      scroll_top:"",
      //subtitle save value
      check_time:"",//check time
      subtitle_length:{
        'first':'',
        'last':'',
      },//subtitle length
      subtitle_box:[],//subtitle save Box

    }
  },
  methods:{
    ...mapActions(['subtitle_action']),
    create_bar_update(start,end){
      this.video_times.push({
        'start':start,
        'end':end
      });
      this.create_bar.max = Math.floor(end);
      this.create_bar.min = start;
      this.create_bar.value = start;
    },
    create_bar_change(){//create bar change
      this.move_time = this.video.duration * (this.create_bar.value / 100);
      this.video.currentTime = this.move_time;
    },
    mouse_down(e){//mouse down
      if(!this.video.paused){
        this.video.pause();
      }
    },
    mouse_up(){//mouse up
      if(this.video.paused){
        this.video.play();
      }
    },
    mouse_move(event){//
      // console.log(event.pageX);
      // console.log(event.pageY);
    },
    create_subtitle(check){//subtitle save button method
      if(check){//subtitle not true
        this.video.pause();
        this.check_time = this.video.currentTime;//check time update -> watch
        this.video.play();
      }else{//subtitle ok false
        consosle.log("있을때");
      }
    },
    scroll_bottom(){
      this.scroll_top = this.scroll_div.scrollTop;
    }
  },
  mounted:function(){//components load start
    this.video = this.v_getter;//stroe.js video getter
    this.create_bar = document.getElementById('create_bar');//create bar
    this.scroll_div = document.getElementById('scroll_div');
    this.terval_move = setInterval(()=>{ //create bar move
      if(!this.video.paused){
        this.move_time = (100/ this.video.duration) * this.video.currentTime;
        this.create_bar.value = this.move_time;
      }
    });

    this.Interval = setInterval(()=>{//setInterval start
      if(this.video.readyState === 4){
        //video times start = video start Time end = video end Time
        if(Math.floor((this.video.duration/60)/60) === 0){//end time minute
          this.create_bar_update(0,this.video.duration*60);
        }else if(Math.floor((this.video.duration/60)) === 0){//end time second
          this.create_bar_update(0,this.video.duration);
        }else{//end time hours
          this.create_bar_update(0,this.video.duration*60*60);
        }
        clearInterval(this.Interval);//setInterval stop
      }
    }, 500);// video start tiem end time check
    //if subtitle ok
    let url = "http://localhost/Capstone_practice/project_videoPlayer/videoBack/videoText_parser.php"//url path
    axios.get(url).then((res)=>{
      this.subtitle_action(res.data);//store.js action
      this.subtitle_length.first = 0;
      this.subtitle_length.last = this.s_getter.length;

      for (let i = this.subtitle_length.first; i < 5; i++) {
        this.subtitle_box.push({
          'firstTime':this.s_getter[i][1][0],
          'lastTime':this.s_getter[i][1][1],
          'textArea':"",
        });//store.js subtitle getter
        for (let s = 2; s < this.s_getter[i].length; s++) {
          this.subtitle_box[i].textArea = this.subtitle_box[i].textArea + this.s_getter[i][s];
        }
      }
    });

  },
  computed:{
    ...mapGetters({//video getter
      v_getter:'video_getter',
      s_getter:'subtitle_getter',
    }),
    create_bar_start_time(){
    },
    create_bar_end_time(){
    }
  },
  watch:{
    check_time:function(data){
      this.first_time = data;
      this.last_time = data+2;
      this.subtitle_box.push({
        firstTime : this.first_time,
        lastTime : this.last_time,
        textArea: "자막을 적어주세요",
      });
    },
    scroll_top(data){//scroll
      if(data === this.scroll_div.scrollHeight-this.scroll_div.clientHeight){//div.clientHeight =
        console.log("wt");
        if(this.subtitle_length.first === this.subtitle_length.last){

        }else{
          this.subtitle_length.first = this.subtitle_length.first + 5;
          for (let i = this.subtitle_length.first; i < this.subtitle_length.first+5; i++) {
            this.subtitle_box.push({
              'firstTime':this.s_getter[i][1][0],
              'lastTime':this.s_getter[i][1][1],
              'textArea':"",
            });//store.js subtitle getter
            for (let s = 2; s < this.s_getter[i].length; s++) {
              this.subtitle_box[i].textArea = this.subtitle_box[i].textArea +"\n"+this.s_getter[i][s];
            }
          }
        }//else end
      }
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
