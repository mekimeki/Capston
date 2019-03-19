<template lang="html">
  <div>
    <button type="button" name="button" v-on:click="capture()">Capture</button>
    <canvas id="canvasd" width="1300" height="1000"></canvas>
    <img id="image" v-bind:src="image_view" alt="" width="250" hegith="250">
    <p v-if="imageText">SAVE</p>
    <p v-else>NOT SAVE</p>
  </div>
</template>

<script>
import {mapState, mapGetters} from 'vuex'

export default {
  name:"capture_",
  data(){
    return{
      ctx:"",
      canvas:"",
      video_img: "",
      image:"",
      image_view:"",
      imageText:"",
      capture_check:true,
    }
  },
  methods:{
    capture(){
      console.log(this.capture_check);
      if(this.capture_check){
        this.capture_check = false;
        this.image.style.display = "block";
        this.ctx = this.canvas.getContext("2d");
        this.video_img = this.v_getter;//video store.js getter
        this.ctx.drawImage(this.video_img, 10, 10);
        this.image_view = this.canvas.toDataURL("image/png");
        this.imageText = true;

        setTimeout(()=>{
          console.log("setTimeout");
          this.capture_check = true;
          this.imageText = false;
          this.image.style.display = "none";
        }, 3000);
      }else{

      }
    },
    save(){

    },
  },
  beforeCreate:function(){},
  created:function(){},
  beforeMout:function(){},
  mounted:function(){
    this.canvas = document.getElementById("canvasd");
    this.image = document.getElementById("image");
  },
  beforeUpdate:function(){

  },
  updated:function(){

  },
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
    }),
    ...mapState(['video']),
  },
  watch:{
    imageText: function(data){
      if(data){
        // alert("저장됨");
      }else{
        // alert("저장안됨");
      }
    }
  }
}
</script>

<style lang="css" scoped>
  img{
    float:right;
    top: 0;
  }
  #canvasd{
    display:none;

  }
</style>
