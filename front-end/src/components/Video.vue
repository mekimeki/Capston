<template lang="html">
  <div class="">
    <div id="videoplayer">
      <video id="video" width="500" src="http://media.w3.org/2010/05/bunny/movie.ogv">
        <!-- src="http://media.w3.org/2010/05/bunny/movie.ogv" -->
        <!-- <source v-bind:src="videoLink" type="video/mp4"> -->
      </video>

      <div id="videoController">
        <input id="seekBar" type="range" name="" value="">
        <button class="btn" id="playBtn" type="button" name="button">Play</button>
        <span id="videoAudio">
          <input id="audioBar" type="range" name="" value="">
          <button class="btn" id="audioBtn" type="button" name="button">on</button>
        </span id="videoSpeend">
        <span id="videoSpeed">
          <input id="speedBar" type="range" name="" value="">
          <button class="btn" id="speedBtn" type="button" name="button">on</button>
        </span>
      </div>
    </div>
    <hr>
    <div id="videoCapture">
      <button type="button" name="button">Capture</button>
      <canvas id="canvas" width="300" height="300"></canvas>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      videoLink: '',
    }
  },
  methods: {

  },
  created: function() {
    this.videoLink = "my-video.mp4";

  }
}
</script>

<style lang="css" scoped>
  #videoplayer{
    float:left;
    padding:1em 1em .5em;
    background-color: white;
    border: 5px solid rgb(47,7,186);
    border-radius: 15px;
  }
  #videoController{
    border: 5px solid rgb(47, 7, 186);
    width:490px;
    border-radius: 15px;
    visibility: hidden;
    position:absolute;
    top:380px;
  }
  #videoplayer:hover #videoController{
    visibility: inherit;
    position:absolute;
    top:380px;
  }
  /* buttons css */
  .btn{
    text-indent:-10000px;
    width:15px;
    height:15px;
    border:none;
    cursor:pointer;
  }
  #playBtn{
    /* background-image:url('play.png'); */
  }
  #audioBtn{
    background:red;
  }
  #speedBtn{
    background:blue;
  }
  /* seekbar css */
  #seekBar{
    -webkit-appearance:none;
    background: white;
    width:80%;
    height:10px;
  }
  #seekBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    width:15px;
    height:15px;
    background:rgb(47,7,186);
    cursor:pointer;
  }
  /* audioBar css */
  #audioBar{
    transform: rotate(-90deg);
    -webkit-appearance:none;
    background:white;
    width:30%;
    height:10px;
    position:absolute;
    top:-77px;
    left:343px;
    visibility: hidden;
  }
  #audioBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    width:15px;
    height:15px;
    background: rgb(47,7,186);
    cursor:pointer;
  }
  #videoAudio:hover #audioBar{
    visibility: inherit;
  }
  /* speedBar css */
  #speedBar{
    transform: rotate(-90deg);
    -webkit-appearance:none;
    background:white;
    width:30%;
    height:10px;
    position:absolute;
    top:-77px;
    left:358px;
    visibility: hidden;
  }

  #speedBar::-webkit-slider-thumb{
    -webkit-appearance:none;
    width:15px;
    height: 15px;
    background: rgb(47,7,186);
  }

  #videoSpeed:hover #speedBar{
    visibility: inherit;
  }

</style>
