<template lang="html">
  <div>
    <button id="captureButton" type="button" name="button" v-on:click="capture()">Capture</button>
    <canvas id="canvasd" width="1000" height="500"></canvas>
    <img id="image" v-bind:src="image_view" alt="" width="250" hegith="250">
  </div>
</template>

<script>
import {mapState,mapActions, mapGetters} from 'vuex'

export default {
  name:"capture_",
  data(){
    return{
      ctx:"",
      canvas:"",
      video_img: "",
      image:"",
      image_view:"",
      capture_check:true,
    }
  },
  methods:{
    ...mapActions(['capture_action','capture_data_action']),
    capture(){
      if(this.capture_check){
        this.capture_check = false;//flot
        this.image.style.display = "block";//css
        this.ctx = this.canvas.getContext("2d");//cnavas data start
        this.video_img = this.v_getter;//video store.js getter image data
        this.ctx.drawImage(this.video_img, 10, 10);
        this.image_view = this.canvas.toDataURL("image/png");
        this.capture_data_action(this.canvas.toDataURL("image/png"));
        setTimeout(()=>{
          this.capture_check = true;
          this.image.style.display = "none";
        }, 3000);
      }
    },
  },
  beforeCreate:function(){},
  created:function(){},
  beforeMout:function(){},
  mounted:function(){
    this.canvas = document.getElementById("canvasd");//canvas element
    this.image = document.getElementById("image");//image element
    this.capture_action(document.getElementById('captureButton'));//vuex capture element save
  },
  computed:{
    ...mapGetters({
      v_getter:'video_getter',
      c_getter:'capture_getter'
    }),
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
  #captureButton{
    display:none;
  }
</style>
