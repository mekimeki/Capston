<template lang="html">
  <div>
    <button type="button" name="button" v-on:click="capture()">Capture</button>
    <canvas id="canvasd" width="1300" height="1000"></canvas>
      <img id="image" v-bind:src="image_view" alt="" width="250" hegith="250">
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
    }
  },
  ...mapGetters({
    v_getter:'video_getter',
  }),
  ...mapState(['video']),
  methods:{
    capture(){
      console.log("capture");
      this.image.style.display = "block";
      this.ctx = this.canvas.getContext("2d");
      this.video_img = this.$store.getters.video_getter;
      this.ctx.drawImage(this.video_img, 10, 10);
      this.image_view = this.canvas.toDataURL("image/png");
      this.imageText = "저장됨";
      setTimeout(function(){
        console.log("setTimeout");
        this.imageText = "";
        this.image.style.display = "none";
      }, 3000);
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
