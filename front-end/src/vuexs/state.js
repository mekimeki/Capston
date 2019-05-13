const state = {

  video:"",//video element
  subtitle:[],//subtitle
  content:[],//cotent
  subtitle_buffer:[],//create input subtitle buffer
  subtitle_preview:[],//
  content_preview:[
    {name:'문법', content:[]},
    {name:'어휘',content:[]},
  ],//create content preview value
  bookmark:[//book mark
    {tab:'문법' ,name:'content',color:'info',mark:'bookmark_border', option:'share' ,content:[]},
    {tab:'단어' ,name:'word',color:'blue-grey',mark:'bookmark', option:'share',content:[]},
    {tab:'단어북마크' ,name:'wordBook',color:'blue-grey',mark:'bookmark', option:'bookmark',content:[]},
    {tab:'대사북마크' ,name:'subtitleBook',color:'info',mark:'bookmark_border', option:'bookmark',content:[]},
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
  upload:{//upload value
    video:false, //video name
    subtitle:false, //subtitle name
    firstTime:false, //video cut firstTime
    lastTime:false, //video cut lastTime
    subtitle_:false, //subtitle create name
    content:false, // content create name
  },
  video_cut:false,
  graph_origin:[],
  graph_record:[],
  graph_score:'',
  subtitle_record:'',
  audio:'',
}

export default state;
