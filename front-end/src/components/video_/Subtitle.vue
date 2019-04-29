<template lang="html">
  <div class="">
    <v-card-text>
      <v-btn v-on:click="select(subtitle_open.split('#')[0])">
        자막:{{subtitle_open.split('#')[0]}}
      </v-btn>

      <v-btn v-on:click="subtitle_bookmark(subtitle_open.split('#')[1])">
        <v-icon>check</v-icon>
      </v-btn>

      <v-btn v-on:click="subtitle_stop($event)">
        <v-icon>blur_on</v-icon>
      </v-btn>
      <v-btn v-on:click="record()">
        <v-icon>mic</v-icon>
      </v-btn>
    </v-card-text>

    <v-layout row wrap>
      <v-flex v-for="line in subtitle_word">
        <v-btn color="primary" class="pa-1 ma-1">{{line['text']['content']}}</v-btn>
      </v-flex>
    </v-layout>

    <v-dialog v-model="dialog"max-width="600">
      <v-card>
        <v-flex xs12 sm12 md12 class="pa-4">
          <record_ v-if="dialog"></record_>
        </v-flex>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="green darken-1"
            flat="flat"
            @click="dialog = false"
          >
            닫기
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>


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
      dialog:"",//record modal open value
    }
  },
  methods:{
    ...mapActions(['subtitle_action','subtitle_word_action','subtitle_open_action']),
    record(){//record open
      this.dialog = true;
    },
    select(subtitle){//word search
      this.subtitle_word_action(subtitle).then(result=>{
        this.subtitle_word = result;
      });
    },
    set_cookie(name,value,delete_date){
      var date = new Date();
      date.setDate(date.getDate() + parseInt(delete_date));
      document.cookie = name + '=' + value + ';expires='+ date.toGMTString() + ";";
      console.log(document.cookie);
    },
    subtitle_bookmark(value){
      this.cp_getter.click();
      console.log(this.cpd_getter);
      // let cookie_value = value + '#' + this.cpd_getter;
      // let form = new FormData();
      // form.append('data',this.cpd_getter)
      // axios.post('http://localhost/Capstone_practice/video_capture/Save.php',form).then(res=>{
      //   console.log(res.data);
      // }).catch(res=>{
      //
      // });
      // this.set_cookie('subtitle',cookie_value,1);
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
    //subtitle 불러오는 부분 생각 해보기
    this.subtitle_open_action('').then(result =>{
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
    }),
  },
  watch:{
    video_time_check: function(data){//subtitle view methods
      for (let i = 0; i < this.subtitle.length; i++) {
        if(this.video.currentTime.toFixed(1) === this.subtitle[i][1][0].toFixed(1)){
          this.subtitle_open = this.subtitle[i][2]+"#"+i;
        }
        else if(this.video.currentTime.toFixed(1) === this.subtitle[i][1][1].toFixed(1)){
          this.subtitle_open = "";
        }
      }
    }
  },
}
</script>

<style lang="css" scoped>
</style>
