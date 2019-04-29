<template lang="html">
  <div class="">
    <button type="button" name="button"
    v-on:click="select(subtitle_open)"
    >자막:{{subtitle_open}}</button>
    <div class="" v-for="line in subtitle_line">
      <button type="button" name="button"
      >{{line['text']['content']}}</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { mapActions, mapGetters} from 'vuex'
export default {
  data(){
    return{
      video:"",
      subtitle:[],
      video_time_check:"",
      subtitle_open:"",
      subtitle_line:[],
    }
  },
  methods:{
    ...mapActions(['subtitle_action']),
    select(subtitle){
      let form = new FormData();
      form.append("data",subtitle);
      let url = "http://localhost/Capstone_practice/project_videoPlayer/api/test2.php";
      axios.post(url,form).then((res) => {
        this.subtitle_line = res.data;
        console.log("성공",this.subtitle_line[0]['text']['content']);
      }).catch( error => {
        console.log('failed', error);
      });
    },
  },
  beforeCreate:function(){},
  created:function(){},
  beforeMout:function(){

  },
  mounted:function(){
    this.video = this.v_getter;
    let url = "http://localhost/Capstone_practice/project_videoPlayer/videoBack/videoText_parser.php"
    axios.get(url).then((res)=>{
      this.subtitle_action(res.data);//store.js action
      this.subtitle = this.s_getter;
      setInterval(()=>{
        // console.log("setInterval");
        this.video_time_check = this.video.currentTime;
      },150);
    },(error)=>{alert("연결을 확인해 주세요")});
  },
  beforeUpdate:function(){
    //console.log("subtitle beforeUpdate");
  },
  updated:function(){
    // console.log("subtitle update");
  },
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
      s_getter:'subtitle_getter',
    }),
  },
  watch:{
    video_time_check: function(data){
      for (let i = 0; i < this.subtitle.length; i++) {
        if(this.video.currentTime.toFixed(1) === this.subtitle[i][1][0].toFixed(1)){
          this.subtitle_open = this.subtitle[i][2];
          // for (let s = 2; s < this.subtitle[i].length; s++) { // 이부분만 고치면 됨
          //   this.subtitle_open= this.subtitle_open + "|" + this.subtitle[i][s];
          // }
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
