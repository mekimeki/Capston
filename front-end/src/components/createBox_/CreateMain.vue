<template lang="html">
  <div class="">
    <input id="createBar" type="range" name="" value="0" v-on:click="create_timeCheck()">
    time:{{check_time}}
    first:{{first_time}}
    last:{{last_time}}
    <div class="" v-for="subtitle in subtitle_box">
      <span>firstTime:{{subtitle.firstTime}}</span>
      <span>LastTime:{{subtitle.lastTime}}</span>
      <br>
      <input type="text" name="" value="" v-model="subtitle.textArea">
    </div>
  </div>
</template>

<script>
import {mapState, mapGetters, mapActions} from 'vuex'

export default {
  data(){
    return{
      video:"",
      createBar:"",
      move_time:"",
      check_time:"",
      check_time_check:true,
      first_time:"",
      last_time:"",
      subtitle_box:[],
    }
  },
  methods:{
    // ...mapActions(['']);
    create_timeCheck(){
      this.video.pause();
      this.check_time = this.video.currentTime;
      console.log(video.currentTime);
      this.video.play();
    }
  },
  mounted:function(){
    console.log("CreateMainmouted");
    this.video = this.v_getter;
    this.createBar = document.getElementById('createBar');
    setInterval(()=>{
      this.move_time = (100/this.video.duration) * this.video.currentTime;
      this.createBar.value = this.move_time;
    },100);
  },
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
    }),
  },
  watch:{
    check_time:function(data){
      if(this.check_time_check){
        this.check_time_check = false;
        this.first_time = data;
      }else{
        this.check_time_check = true;
        this.last_time = data;
        this.subtitle_box.push({
          firstTime : this.first_time,
          lastTime : this.last_time,
          textArea: "없뜸",
        });
      }
    }
  }
}
</script>

<style lang="css" scoped>
  #createBar{
    -webkit-appearance:none;
    background: black;
    width:100%;
    height:10px;
  }
  #createBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    width:15px;
    height:15px;
    background:rgb(47,7,186);
    cursor:pointer;
  }
</style>
