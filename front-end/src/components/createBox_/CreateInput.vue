<template lang="html">
    <v-card color="blue" class="white--text ma-1">
      <v-layout row wrap>
        <v-flex xl12 sm12 md12>
          <v-card-title>
            <label class="pr-2">START:</label>
            <input type="text" name="" value="" v-model="firstTime">
            <label>EDN:</label>
            <input type="text" name="" value="" v-model="lastTime">
          </v-card-title>
        </v-flex>
        <v-flex xl12 sm12 md12 class="ma-2">
          <v-text-field
            label="Create Subtitle"
            v-on:click="time_check(true)"
            v-model="subtitle_write"
          >
          </v-text-field>
          <v-layout justify-end>
            <v-icon color="white" medium v-on:click="time_check(false)">add_circle_outline</v-icon>
          </v-layout>
        </v-flex>
      </v-layout>
    </v-card>
</template>

<script>
import {mapState,mapGetters,mapActions} from 'vuex'
import axios from 'axios';
export default {
  data(){
    return{
      video:"",
      check_time:{
        'first':"",
        'last':"",
        'now':"",
      },
      create_number:"",
      subtitle_buffer:[],
      subtitle_write:"",
    }
  },
  methods:{
    ...mapActions(['subtitle_buffer_action']),
    time_change(seconds){
      let hour = parseInt(seconds/3600);
      let min = parseInt((seconds%3600)/60);
      let sec = seconds%60;
      return hour+":"+min+":" + sec;
    },
    time_check(check){
      if(check){
        this.check_time.first = this.video.currentTime;
      }else{
        if(!(this.check_time.first === "")){
          if(this.check_time.last === ""){
            this.check_time.last = this.video.currentTime + 2;
            this.create_number = this.check_time.first;
          }else{
            this.check_time.last = this.video.currentTime;
            this.create_number = this.check_time.first;
          }
        }else{
          if(this.create_number === this.check_time.first){
            alert("같음");
          }else{
            this.check_time.last = this.video.currentTime;
            this.create_number = this.check_time.first;
          }
        }
      }
    },
    subtitle_scroll_save(){
    }
  },
  mounted:function(){
    this.video = this.v_getter;
  },
  computed:{
    ...mapGetters({
      v_getter:"video_getter",
      s_getter:"subtitle_getter",
    }),
    firstTime:function(){
      return this.time_change(Math.ceil(this.check_time.first));
    },
    lastTime:function(){
      return this.time_change(Math.ceil(this.check_time.last));
    }
  },
  watch:{
    create_number(data){
      this.subtitle_buffer.push({
        "firstTime":this.check_time.first,
        "lastTime":this.check_time.last,
        "textArea":this.subtitle_write,
      });
      this.subtitle_buffer_action(this.subtitle_buffer);
      this.check_time.first = "";
      this.check_time.last = "";
      this.subtitle_write = "";
    }
  }
}
</script>

<style lang="css" scoped>
</style>
