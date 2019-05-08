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
  subtitle_preview_mutation: (state, payload) => {
    state.subtitle_preview = payload;
  },
  content_preview_content_mutation: (state, payload) =>{
    if(typeof(payload.number) === 'boolean'){
      state.content_preview[0].content.push(payload.content);
    }else if(typeof(payload.number) === 'number'){
      state.content_preview[0].content.splice(payload.number,1);
    }
  },
  content_preview_word_mutation: (state, payload) =>{
    if(typeof(payload.number) === 'boolean'){
      state.content_preview[1].content.push(payload.content);
    }else if(typeof(payload.number) === 'number'){
      state.content_preview[1].content.splice(payload.number,1);
    }
  },
  bookamrk_mutation: (state,payload) =>{
    if (payload.indexOf('#') != -1) {
      payload = payload.split('#');
      state.bookmark[2].content.push({
        'title':payload[0],
        'textArea':payload[1],
      });
    }
    else{
      state.bookmark[3].content.push({
        'title':state.video.currentTime,
        'textArea':payload,
      });
    }
  },
  bookmark_image_mutation: (state,payload) =>{
    state.bookmark_image.push(payload);
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
    state.upload.lastTime = payload.lastTime;
  },
  upload_subtitle_mutations: (state,payload) =>{
    state.upload.subtitle_ = payload;
  },
  upload_content_mutations: (state,payload) =>{
    state.upload.content = payload;
  },
}

export default mutations;
