<template lang="html">
  <div class="">
    자막:{{subtitle_open}}
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
    }
  },
  methods:{
    ...mapActions(['subtitle_action']),
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
    });
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
          for (let s = 2; s < this.subtitle[i].length; s++) {
            this.subtitle_open= this.subtitle_open + "|" + this.subtitle[i][s];
          }
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
