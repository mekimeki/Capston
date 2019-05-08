const state = {

  video:"",//video element
  subtitle:[],//subtitle
  content:[],//cotent
  subtitle_buffer:[],//create input subtitle buffer
  subtitle_preview:[],//
  content_preview:[
    {name:'content', content:[]},
    {name:'word',content:[]},
  ],//create content preview value
  bookmark:[//book mark
    {name:'content',color:'info',mark:'bookmark_border', option:'share' ,content:[]},
    {name:'word',color:'blue-grey',mark:'bookmark', option:'share',content:[]},
    {name:'wordBook',color:'blue-grey',mark:'bookmark', option:'bookmark',content:[]},
    {name:'subtitleBook',color:'info',mark:'bookmark_border', option:'bookmark',content:[]},
  ],
  bookmark_image:[],
  seek_bar:"",//input[range] element
  cature:"",
  capture_data:"",
  percent:0,
  login:{//login value
    email:"",
    PassWord:"",
  },
  upload:{//upload
    video:false,
    subtitle:false,
  },
  video_cut:false,
}

export default state;
