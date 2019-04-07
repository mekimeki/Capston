const getters = {
  video_getter: (state) => {
    return state.video;
  },
  subtitle_getter: (state) =>{
    return state.subtitle;
  },
  subtitle_buffer_getter: (state) =>{
    return state.subtitle_buffer;
  },
  seek_bar_getter: (state) =>{
    return state.seek_bar;
  },
  login_getters: (state) =>{
    return state.login;
  },
  login_page_getters: (state) =>{//login page check getters
    return state.login_page;
  },
  upload_getters: (state) =>{
    return state.upload;
  },
  video_cut_getters: (state) =>{
    return state.video_cut;
  }
}

export default getters;
