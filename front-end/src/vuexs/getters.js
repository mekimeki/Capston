const getters = {
  video_getter: (state) => { //video element getter
    return state.video;
  },
  subtitle_getter: (state) =>{ //subtitle getter
    return state.subtitle;
  },
  subtitle_buffer_getter: (state) =>{ //create input subtitle buffer getter
    return state.subtitle_buffer;
  },
  seek_bar_getter: (state) =>{ //input[range] element getter
    return state.seek_bar;
  },
  login_getters: (state) =>{ //login values getter
    return state.login;
  },
  upload_getters: (state) =>{ //upload values getter
    return state.upload;
  },
}

export default getters;
