const state = {
  video:"",//video element
  subtitle:[],//subtitle
  content:[],//cotent
  subtitle_buffer:[],//create input subtitle buffer
  seek_bar:"",//input[range] element
  cature:"",
  capture_data:"",
  percent:0,
  login:{//login value
    email:"",
    nickname:"",
  },
  upload:{//upload value
    video:false, //video name
    subtitle:false, //subtitle name
    firstTime:false, //video cut firstTime
    lastTime:false, //video cut lastTime
    subtitle_:false, //subtitle create name
    content:false, // content create name
  },
}

export default state;
