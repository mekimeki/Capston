const getters = {
  video_getter: (state) => { //video element getter
    return state.video;
  },
  subtitle_getter: (state) =>{ //subtitle getter
    return state.subtitle;
  },
  content_getter: (state) =>{
    return state.content;
  },
  subtitle_buffer_getter: (state) =>{ //create input subtitle buffer getter
    return state.subtitle_buffer;
  },
  subtitle_preview_getter: (state) =>{
    return state.subtitle_preview;
  },
  content_preview_getter: (state) =>{
    return state.content_preview;
  },
  bookmark_getter: (state) =>{
    return state.bookmark;
  },
  bookmark_image_getter: (state) =>{
    return state.bookmark_image;
  },
  seek_bar_getter: (state) =>{ //input[range] element getter
    return state.seek_bar;
  },
  capture_getter: (state) =>{
    return state.capture;
  },
  capture_data_getter: (state) =>{
    return state.capture_data;
  },
  percent_getter: (state) =>{
    return state.percent;
  },
  login_getters: (state) =>{ //login values getter
    return state.login;
  },
  upload_getters: (state) =>{ //upload values getter
    return state.upload;
  },
}

export default getters;
