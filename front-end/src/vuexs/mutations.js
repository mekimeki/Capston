import router from '../router';

const mutations = {
  video_mutation: (state, payload) => {//video mutation
    state.video = payload;
  },
  subtitle_mutation: (state, payload) => {//subtitle mutation
    state.subtitle = payload;
  },
  subtitle_buffer_mutation: (state, payload) => {//subtitle buffer mutation
    state.subtitle_buffer = payload;
  },
  seek_bar_mutation: (state,payload) => {//seek bar mutation
    state.seek_bar = payload;
  },
  login_mutation: (state,payload) => {//login mutation
    if (localStorage.getItem('login')) {
      state.login.email = payload.email;
      state.login.nickname = payload.nickname;
    }else{
      alert("오류입니다.");
    }
  },
  // upload mutation
  upload_mutation: (state,payload) => { //upload
    if(payload.substring(payload.length,payload.length-3) != 'srt'){
      state.upload.video = payload;
    }else{
      state.upload.subtitle = payload;
    }
    if(state.upload.subtitle && state.upload.video){
      router.push({name:'c-video', query:{video:state.upload.video}});//move
    }
  },
  video_cut_mutation: (state,payload) => {
    state.upload.video_cut = payload;
    if(state.upload.video_cut){
      router.push({name:'subtitle', query:{subtitle:state.upload.subtitle}});//move
    }
  },
  upload_subtitle_mutations: (state,payload) =>{
    state.upload.subtitle_ = payload;
    if(state.upload.subtitle_){
      router.push({name:'content'});
    }
  },
  upload_content_mutations: (state,payload) =>{
    console.log("content");
  },
}

export default mutations;
