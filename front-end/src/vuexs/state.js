const state = {
  video:"",//video element
  subtitle:[],//subtitle
  subtitle_buffer:[],//create input subtitle buffer
  seek_bar:"",//input[range] element
  login:{//login value
    email:"",
    nickname:"",
  },
  upload:{//upload value
    video:false, //video name
    subtitle:false, //subtitle name
    video_cut:false, //video cut name
    create_subtitle:false, //subtitle create name
    content:false, // content create name
  },
}

export default state;
