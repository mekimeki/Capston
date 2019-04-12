const mutations = {
  video_mutation: (state, payload) => {
    state.video = payload;
  },
  subtitle_mutation: (state, payload) => {
    state.subtitle = payload;
  },
  subtitle_buffer_mutation: (state, payload) => {
    state.subtitle_buffer = payload;
  },
  seek_bar_mutation: (state,payload) => {
    state.seek_bar = payload;
  },
  login_mutation: (state,payload) => {
    state.login = payload;
  },
  login_page_mutation: (state,payload) => {
    state.login_page = payload;
  },
  upload_mutation: (state,payload) => { //upload
    if(payload){
      state.upload.video = true;
    }else{
      state.upload.subtitle = true;
    }
  },
  video_cut_mutation: (state,payload) => {
    state.video_cut = payload;
  },
}

export default mutations;
