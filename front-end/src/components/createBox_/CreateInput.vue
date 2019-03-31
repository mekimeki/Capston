<template lang="html">
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
    <v-btn
    color="success"
    v-on:click="time_check(false)"
    >추가</v-btn>
  </div>
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
