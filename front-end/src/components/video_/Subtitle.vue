<template lang="html">
  <div class="">
    <!-- button_s -->
    <div id="btn_box">
      <span>
        <v-btn fab small v-on:click="subtitle_stop($event)">
          <v-icon color="teal lighten-1">blur_on</v-icon>
        </v-btn>
        <!-- <v-btn fab small v-on:click="record_open('')">
          <v-icon color="blue">mic</v-icon>
        </v-btn> -->
        <v-btn fab small v-on:click="words_open()">
          <v-icon color="teal lighten-1">list_alt</v-icon>
        </v-btn>
      </span>
    </div>
    <!-- subtite -->

    <v-tooltip v-model="show" top>
      <template v-slot:activator="{ on }">
        <div top id="subtitle_box"
        >
          <span
            id="subtitle_span"
            v-on:mouseup="select_drag($event,subtitle_open.split('#')[0])"
          >{{subtitle_open.split('#')[0]}}</span>
          <v-icon id="bookmark_check" v-show="subtitle_open" color="white" v-on:click="subtitle_bookmark(subtitle_open.split('#')[0])">bookmark</v-icon>
          <v-icon id="bookmark_check" v-show="subtitle_open" color="white" v-on:click="record_open(subtitle_open.split('#')[1])">mic</v-icon>
        </div>
      </template>
      <span id="tooltop"></span>
      <v-icon small color="white" v-on:click="word_bookmark($event,false)">add</v-icon>
      <v-icon small color="white" v-on:click="show=false">clear</v-icon>
    </v-tooltip>


    <!-- selected word_s  -->
    <div class="text-xs-center">
    </div>
    <v-alert
      :value="alert"
      type="white"
      transition="scale-transition"
    >
      <v-layout row wrap>
        <v-flex v-for="line in subtitle_word" xl2 sm2 md2>
          <v-btn small color="teal lighten-1" class="pa-1 ma-1" v-on:click="word_bookmark($event,true)">{{line['text']['content']}}</v-btn>
        </v-flex>
      </v-layout>
    </v-alert>
    <!-- <div class="" id="words">
    </div> -->

    <!-- <record_></record_> -->

    <v-layout row justify-center>
      <v-dialog v-model="dialog"  transition="dialog-bottom-transition" id="record" width="700">
        <v-card>
          <v-layout justify-end>
            <v-btn color="teal lighten-1" icon dark @click="dialog = false">
              <v-icon>close</v-icon>
            </v-btn>
          </v-layout>
          <record_></record_>
        </v-card>
      </v-dialog>
    </v-layout>

  </div>
</template>

<script>
import axios from 'axios';//axios
import record_ from '@/components/video_/Record';//record
import { mapActions, mapGetters} from 'vuex';//vuex

export default {
  components:{
    record_
  },
  data(){
    return{
      video:"",//video element
      subtitle:[],//subtitle
      interval:"",//video time check interval
      video_time_check:"",//video time check
      subtitle_open:"",//subtitle open
      subtitle_word:[],//word search button list
      show:false,//tooltip open
      location:{
        _x:'',
        _y:'',
      },
      dialog:false,
      location:'',
      alert:false,
    }
  },
  methods:{
    ...mapActions(['subtitle_action','subtitle_word_action','subtitle_open_action','search_action','bookmark_action','bookmark_image_action','subtitle_view_action','subtitle_record_action']),
    words_drag(event){
      // this.location = document.getElementById('words').getBoundingClientRect();
      // console.log('drag');
      // console.log(location);
    },
    words_dragover(event){
      console.log('dragover');
      // document.getElementById('words').style.top = event.pageY+"px";
      // document.getElementById('words').style.left = event.pageX+"px";
      // console.log('dragover');
    },
    words_dragend(event){
      console.log('x',event.pageY);
      console.log('y',event.pageX);
      console.log('top',event.target.style.top);
      console.log('left',event.target.style.left);
      event.target.style.top = event.pageY+"px";
      event.target.style.left = event.pageX+"px";
    },
    words_open(){
      if(this.alert){
        this.alert = false;
      }else{
        this.alert = true;
      }
    },
    record_open(value){
      this.subtitle_record_action(value);
      this.dialog = true;
      if(!this.video.paused){
        this.video.pause();
      }
    },
    drop(evt){
      /*
        영역 밖에 나갔을 때 처리
        좀더 저확하게 맞추는게 필요
      */
      document.getElementById('subtitle_box').style.top = -100+evt.offsetY+"px";
      document.getElementById('subtitle_box').style.left = 120+evt.offsetX+"px";
    },
    word_select(subtitle){//word search
      this.subtitle_word_action(subtitle).then(result=>{
        this.subtitle_word = result;
        this.words_open();
      });
    },
    select_drag(evt,subtitle){//drag search event
      let selectionText = document.getSelection();
      document.getElementById('tooltop').innerHTML = selectionText;
      if (document.getElementById('tooltop').innerHTML) {
        this.show = true;
      }else{
        this.word_select(subtitle);
      }
    },
    word_bookmark(evt,check){
      let word;
      if (check) {
        word = evt.target.innerHTML;
      }else{
        word = document.getElementById('tooltop').innerHTML;
      }
      this.search_action(word).then(result =>{
        if(result === 'undefined'){
          alert("is not search result");
        }else{
          word = word+ "#";
          for (let i = 0; i < result.length; i++) {
            word = word +"\n"+ result[i];
          }
          this.bookmark_action(word);
        }
      }).
      catch(result => {
        alert(result);
      });
    },
    subtitle_bookmark(value){
      this.cp_getter.click();
      this.bookmark_image_action(this.cpd_getter);
      this.bookmark_action(value);
    },
    subtitle_stop(evt){//subtitle stop
      if(evt.target.innerHTML === "blur_on"){
        evt.target.innerHTML = "blur_off";
        this.subtitle_open = "";
        clearInterval(this.interval);
      }else{
        evt.target.innerHTML = "blur_on";
        this.interval = setInterval(()=>{
          this.video_time_check = this.video.currentTime;
        },150);
      }
    },
  },
  mounted:function(){
    this.video = this.v_getter;//video
    // subtitle 불러오는 부분 생각 해보기

    // this.subtitle_open_action('').then(result =>{
    //   this.subtitle_action(result);//store.js action
    //   this.subtitle = this.s_getter;
    //   this.interval = setInterval(()=>{
    //     this.video_time_check = this.video.currentTime;
    //   },150);
    // });

    this.subtitle_view_action(this.$route.query.video).then(result=>{
      this.subtitle_action(result);//store.js action
      this.subtitle = this.s_getter;
      this.interval = setInterval(()=>{
        this.video_time_check = this.video.currentTime;
      },150);
    });
  },
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
      s_getter:'subtitle_getter',
      cp_getter:'capture_getter',
      cpd_getter:'capture_data_getter',
      a:'bookmark_image_getter',
    }),
  },
  watch:{
    video_time_check: function(data){//subtitle view methods
      for (let i = 0; i < this.subtitle.length; i++) {
        if(this.video.currentTime.toFixed(1) === parseInt(this.subtitle[i][1][0]).toFixed(1)){
          this.subtitle_open = this.subtitle[i][2]+"#"+i;
        }
        else if(this.video.currentTime.toFixed(1) === parseInt(this.subtitle[i][1][1]).toFixed(1)){
          this.subtitle_open = "";
        }
      }
    }
  },
}
</script>

<style lang="css" scoped>
#record{
  height:50% !important;
  top:50% !important;
}
#subtitle_box{
  color:white;
  background: black;
  position: relative;
  display: inline-block;
  height:100%;
  left:30%;
  top:-155px;
  cursor:pointer;
  opacity: 0.6;
}
#subtitle_box:hover{
  background: #26A69A;
}
/* #subtitle_span:hover{
  background: orange;
} */
#btn_box{
  /* float:right; */
  position:absolute;
  top:20px;
}
.btn{
  float:left;
}

#bookmark_check:hover{
  background: white;
  border-radius: 20px;
}
#words{

}
</style>
