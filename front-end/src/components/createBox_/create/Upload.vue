<template lang="html">
<!-- <v-flex xs12 sm4>
    <v-overflow-btn
      :items="select"
      label="Select"
    ></v-overflow-btn>
    </v-flex> -->
<v-container>
    <v-layout row wrap>
        <v-flex xs12 sm6 md6 class="pa-1">
            <v-container>
                <v-card class="video">
                    <v-card-text class="dropzone" id="video" v-on:dragover.prevent v-on:drop="on_drop($event)">
                        <v-icon color="teal lighten-1">subscriptions</v-icon><span class="textSize pl-2">영상 업로드</span>
                        <br>
                        <v-icon large v-show="!image_video" style="width:100%; height:100%;" color="black">add</v-icon>
                        <v-card-text class="" v-show="image_video">
                            <video id="video_preview" :src="image_video" autoplay width="100%" height="100%" muted="muted"></video>
                            <!-- <img v-bind:src="image_video" alt="" class="img" width="180" height="120"/> -->
                            <!-- <v-spacer></v-spacer> -->
                            <v-layout row wrap pt-3>
                                <v-flex xl5 sm5 md5>
                                    <v-layout row wrap>
                                        <v-flex xl12 sm12 md12>
                                            <v-btn flat class="videobtn" v-on:click="remove_file($event)">
                                                <v-icon color="red" large>delete</v-icon>
                                                <span class="pl-2 mt-1">REMOVE</span>
                                            </v-btn>
                                        </v-flex>
                                        <v-flex xl12 sm12 md12>
                                            <v-btn flat type="button" name="button" v-on:click="file_upload_video($event)">
                                                <v-icon color="teal lighten-2" large>get_app</v-icon>
                                                <span class="pl-2 mt-1">UPLOAD</span>
                                            </v-btn>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                                <v-flex xl7 sm7 md7>
                                    <v-progress-circular justify center :rotate="360" :size="100" :width="20" :value="percent" color="teal lighten-2" v-model="percent_video">
                                        {{percent_video}}
                                    </v-progress-circular>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                    </v-card-text>
                    <label>
                      <input class="hidden" id="videoInput" type="file" name="video" v-on:change="on_change($event)" multiple>
                    </label>

                    <v-layout align-end justify-start row fill-height>
                        <v-btn color="teal lighten-2" v-on:click="file_select_video($event)">
                            <v-icon>add</v-icon>
                            video select
                        </v-btn>
                        <v-layout align-end justify-start row fill-height pr-2>{{video_file_name}}</v-layout>
                    </v-layout>
                </v-card>
            </v-container>
        </v-flex>

        <v-flex xs12 sm6 md6 class="pa-1">
            <v-container>
                <v-card class="subtitle">
                    <v-card-text class="dropzone" id="subtitle" v-on:dragover.prevent v-on:drop="on_drop($event)">
                        <v-icon color="teal lighten-1">subtitles</v-icon><span class="textSize pl-2">자막 업로드</span>
                        <br>
                        <v-icon large v-show="!image_subtitle" style="width:100%; height:100%;" color="black">add</v-icon>
                        <v-card-text class="" v-show="image_subtitle">
                            <div class="">
                                <v-img v-bind:src="image_subtitle" :alt="subtitle_file_name" class="img" width="50px" height="50px" />
                                <div class="">
                                    {{subtitle_file_name}}
                                </div>
                            </div>
                            <hr>
                            <v-spacer></v-spacer>
                            <v-layout row wrap pt-3>
                                <v-flex xl5 sm5 md5>
                                    <v-layout row wrap>
                                        <v-flex xl12 sm12 md12>
                                            <v-btn flat class="subtitlebtn" type="button" name="button" v-on:click="remove_file($event)">
                                                <v-icon large color="red">delete</v-icon>
                                                <span class="pl-2 mt-1">REMOVE</span>
                                            </v-btn>
                                        </v-flex>
                                        <v-flex xl12 sm12 md12>
                                            <v-btn flat type="button" name="button" v-on:click="file_upload_subtitle($event)">
                                                <v-icon large color="teal lighten-2">get_app</v-icon>
                                                <span class="pl-2 mt-1">UPLOAD</span>
                                            </v-btn>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                                <v-flex xl7 sm7 md7>
                                    <v-progress-circular :rotate="360" :size="100" :width="20" :value="percent_subtitle" color="teal lighten-2">
                                        {{percent_subtitle}}
                                    </v-progress-circular>
                                </v-flex>
                            </v-layout>
                        </v-card-text>
                    </v-card-text>
                    <label>
            <input class="hidden" id="subtitleInput" type="file" name="subtitle" v-on:change="on_change($event)">
          </label>
                    <v-layout align-end justify-start row fill-height>
                        <v-btn color="teal lighten-2" v-on:click="file_select_subtitle($event)">
                            <v-icon largle>add</v-icon>
                            subtitle select
                        </v-btn>
                        <span>{{subtitle_file_name}}</span>
                    </v-layout>
                </v-card>
            </v-container>
        </v-flex>
        <v-layout align-end justify-end row fill-height class="" v-if="up_getters.video">
            <v-btn large color="teal lighten-1" class="white--text" v-on:click="move()">다음으로</v-btn>
        </v-layout>
    </v-layout>
</v-container>
</template>

<script>
import {
    mapState,
    mapGetters,
    mapActions
} from 'vuex';
export default {
    data() {
        return {
            image_view_video: require('@/assets/video-select.png'), //image view video
            image_view_subtitle: require('@/assets/subtitle-select.png'), //image view subtitle
            image_video: "", //image video
            image_subtitle: "", //image subtitle
            files: "", //file
            file_data: {
                video: '',
                subtitle: '',
            },
            subtitle_file_name: "", //subtitle file name
            video_file_name: "", //video file name
            input_video: "", //input video element
            input_subtitle: "", //input subtitle element
            select: [{ //select
                    text: "공개용"
                },
                {
                    text: "개인용"
                }
            ],
            page_move: "",
            percent_video: 0,
            percent_subtitle: 0,
        }
    },
    methods: {
        ...mapActions(['upload_actions', 'percent_action']),
        move() {
            this.percent_action(0);
            let video_pk = this.up_getters.video;
            this.$router.push({
                name: 'c-video',
                query: {
                    video: video_pk
                }
            });
        },
        on_drop(evt) { //on drop methods
            evt.stopPropagation();
            evt.preventDefault();
            if (evt.target.id === "video") { //element id check
                this.files = evt.dataTransfer.files;
                this.create_video_file(this.files[0]);
            } else if (evt.target.id === "subtitle") { //element id check
                this.files = evt.dataTransfer.files;
                this.create_subtitle_file(this.files[0]);
            }
        },

        on_change(evt) { //change methods
            if (evt.target.id === "videoInput") { //element id check
                this.up_getters.video = false;
                this.files = evt.target.files;
                this.create_video_file(this.files[0]);
            } else if (evt.target.id === "subtitleInput") { //element id check
                this.up_getters.subtitle = false;
                this.files = evt.target.files;
                this.create_subtitle_file(this.files[0]);;
            }
        },
        file_select_video(evt) {
            this.input_video.click();
        },
        file_select_subtitle(evt) {
            this.input_subtitle.click();
        },
        create_video_file(file) { //create file video methods
            if (this.percent === 100) {
                this.percent_action(0);
            }
            if (!file.type.match('video.*')) { //video filter
                alert('video를 선택해라');
                return;
            } else {
                let reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('video_preview').src = e.target.result;
                }
                reader.readAsDataURL(file);

                this.file_data.video = file;
                this.image_video = this.image_view_video;
                this.video_file_name = file.name;
            }
        },
        create_subtitle_file(file) { //create file subtitle methods
            if (this.percent === 100) {
                this.percent_action(0);
            }
            if (file.name.substring(file.name.length, file.name.length - 3) != 'srt') { //srt filter
                alert('subtitle를 선택해라'); //subtitle
                return;
            } else {
                this.file_data.subtitle = file;
                this.image_subtitle = this.image_view_subtitle;
                this.subtitle_file_name = file.name;
            }
        },
        remove_file(evt) { //remove file video and subtitle
            if (evt.target.id === "videobtn") { //element id check
                this.image_video = '';
                this.video_file_name = "";
                this.input_video.value = "";
                this.up_getters.video = false;
            } else if (evt.target.id === "subtitlebtn") { //element id check
                this.image_subtitle = '';
                this.subtitle_file_name = "";
                this.input_subtitle.value = "";
                this.up_getters.subtitle = false;
            }
        },
        file_upload_video() { //
            if (this.video_file_name) {
                if (this.files.length) {
                    let payload = {
                        file: this.file_data.video, //
                        check: true,
                    }
                    this.upload_actions(payload); //upload
                    let inter = setInterval(() => {
                        this.percent_video = this.percent;
                        if (this.percent_video == 100) {
                            if (this.up_getters.video) {
                                alert('ready subtitle upload');
                                clearInterval(inter);
                            }
                        }
                    }, 100);
                }
            }
        },
        file_upload_subtitle() {
            if (this.up_getters.video) {
                if (this.subtitle_file_name) {
                    if (this.files.length) {
                        let payload = {
                            file: this.file_data.subtitle,
                            video_pk: this.up_getters.video,
                            check: false
                        }
                        this.upload_actions(payload); //upload
                        let inter = setInterval(() => {
                            this.percent_subtitle = this.percent;
                            if (this.percent_subtitle === 100) {
                                console.log("clear");
                                clearInterval(inter);
                            }
                        }, 100);
                        // this.page_move = true;
                    }
                }
            } else {
                alert("video를 업로드 후 업로드 해주세요.");
            }
        }
    },
    mounted: function () {
        this.input_video = document.getElementById('videoInput');
        this.input_subtitle = document.getElementById('subtitleInput');
    },
    updated: function () {},
    computed: {
        ...mapGetters({
            up_getters: 'upload_getters',
            percent: 'percent_getter',
        })
    },
    watch: {}
}
</script>

<style lang="css" scoped>
.hidden {
    display: none;
}

.dropzone {
    width: 100%;
    height: 100%;

}

.textSize {
    font-size: 1.2rem;
    font-weight: 400;
}
</style>
