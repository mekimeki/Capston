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
  content_mutation: (state, payload) =>{
    state.content = payload;
  },
  seek_bar_mutation: (state,payload) => {//seek bar mutation
    state.seek_bar = payload;
  },
  capture_mutation: (state,payload) => {
    state.capture = payload;
  },
  capture_data_mutation: (state,payload) =>{
    state.capture_data = payload;
  },
  upload_percent_mutation:(state,payload) => {
    state.percent = payload;
  },
  login_mutation: (state,payload) => {//login mutation
    state.login.email = payload.email;
    state.login.nickname = payload.nickname;
  },
  logout_mutation: (state) => {
    state.login.email = "";
    state.login.nickname = "";
    localStorage.setItem('login',"");
  },
  upload_mutation: (state,payload) => { //upload
    if(payload.video_pk){
      state.upload.video = payload.video_pk;
    }else if(payload.subtitle_pk){
      state.upload.subtitle = payload.subtitle_pk;
    }
  },
  video_cut_mutation: (state,payload) => {
    state.upload.firstTime = payload.firstTime;
    state.upload.lastTime = payload.lastTime
  },
  upload_subtitle_mutations: (state,payload) =>{
    state.upload.subtitle_ = payload;
  },
  upload_content_mutations: (state,payload) =>{
    state.upload_content = payload;
  },
}

export default mutations;
