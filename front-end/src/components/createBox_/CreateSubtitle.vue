<template lang="html">
<div class="pt-3">
    <span v-show="sb_getter.length === 1">+</span>
    <div id="scroll_div" v-on:scroll="scroll()">
        <v-layout row wrap>
            <div class="subtitlePlus pl-2">업로드한 자막</div>
            <v-flex xs12 sm12 md12 class="textarea" v-for="(tent, i) in content" v-if="i >= scroll_num.first && i<= scroll_num.last">
                <v-card color="teal lighten-2" class="white--text ma-1">
                    <v-card-title>
                        <span class="textSize pr-2" style="color:black;" >START  </span> 
                        <input style="width:60px; font-size:18px; color:black;" v-bind:value="time_change(Math.ceil(tent.firstTime))" v-on:keyup="keyup_time_change($evnet,i,true,tent.firstTime)">
                        <span class="textSize pr-2" style="color:black;">END  </span>
                        <input style="width:60px; font-size:18px; color:black;" v-bind:value="time_change(Math.ceil(tent.lastTime))" v-on:keyup="keyup_time_change($event,i,false,tent.lastTime)">
                        <v-icon color="teal darken-3" medium v-on:click="create_btn(i)">add_circle_outline</v-icon>
                        <v-icon color="teal darken-4" medium v-on:click="delete_btn(i)">delete</v-icon>
                        <v-text-field v-model="tent.textArea">
                        </v-text-field>
                    </v-card-title>
                </v-card>
                <!-- <span class="" v-if="!up_getters.subtitle_">
            <v-btn><v-icon v-on:click="record(i,$event)">mic_off</v-icon></v-btn>
        </span> -->
            </v-flex>
        </v-layout>
    </div>
    <div class="">
        <v-layout align-start justify-space-between row fill-height class="">
            <v-btn large color="red lighten-1" class="white--text" v-on:click="save_btn()">
                <span>자막 업로드</span>
            </v-btn>
            <v-btn large color="teal lighten-1" class="white--text"  v-if="up_getters.subtitle_" v-on:click="move()">다음으로</v-btn>
        </v-layout>
        <v-dialog v-model="open" hide-overlay persistent width="300">
            <v-card>
                <v-card-text>
                    업로드 중
                    <v-progress-linear v-model="percent_data"></v-progress-linear>
                </v-card-text>
            </v-card>
        </v-dialog>
    </div>

</div>
</template>

<script>
import {
    mapState,
    mapGetters,
    mapActions
} from 'vuex';
import axios from 'axios';
export default {
    data() {
        return {
            video: "",
            scroll_div: "",
            scroll_bottom: "",
            content: [],
            record_box: [],
            scroll_num: {
                first: 0,
                last: 100,
            },
            terval: "",
            video_time_check: "",
            percent_data: 0,
            open: false,
        }
    },
    methods: {
        ...mapActions(['subtitle_action', 'upload_subtitle_actions', 'upload_content_actions', 'percent_action', 'subtitle_answer_action', 'subtitle_preview_action']),
        move() {
            this.percent_action(0);
            this.$router.push({
                name: 'content',
                query: {
                    video: this.up_getters.subtitle_.video_pk
                }
            });
        },
        keyup_time_change(evt, num, check, time) {
            if (check) {
                // this.content[num].firstTime = this.time_second(evt.target.value);//초로 바꿔야함
                this.content[num].firstTime = time;
            } else {
                // this.content[num].lastTime = this.time_second(evt.target.value);//초로 바꿔야함
                this.content[num].lastTime = time;
            }
        },
        time_change(seconds) {
            let hour = parseInt(seconds / 3600);
            let min = parseInt((seconds % 3600) / 60);
            let sec = seconds % 60;
            return hour + ":" + min + ":" + sec;
        },
        time_second(time) {
            let time_s = time.split(":");
            let hour = parseInt((time_s[0] * 60) * 60);
            let min = parseInt(time_s[1] * 60);
            let sec = parseInt(time_s[2]);
            return hour + min + sec;
        },
        create_btn(check) {
            this.content.splice(check + 1, 0, {
                "firstTime": this.content[check].lastTime + 1,
                "lastTime": this.content[check].lastTime + 3,
                "textArea": "Content Box",
            })
        },
        delete_btn(check) {
            if (check === 0) {
                this.content.shift();
            } else {
                this.content.splice(check, 1);
            }
        },
        save_btn() {
            this.open = true;
            let data = {
                video: this.$route.query.video,
                content: this.content,
            }
            this.upload_subtitle_actions(data);
            let inter = setInterval(() => {
                this.percent_data = this.percent;
                if (this.percent_data === 100) {
                    this.open = false;
                    clearInterval(inter);
                }
            }, 100);
        },
        scroll() {
            this.scroll_bottom = this.scroll_div.scrollTop;
        },
        record(num, evt) {
            evt.target.innerHTML = "mic";
            this.record_box.push({
                firstTime: this.content[num].firstTime,
                lastTime: this.content[num].lastTime,
                mic: true,
            });

        }
    },
    mounted: function () {
        this.video = this.v_getter;
        this.scroll_div = document.getElementById('scroll_div');
        let data = {
            'video': this.$route.query.video,
            'firstTime': this.$route.query.firstTime,
            'lastTime': this.$route.query.lastTime,
        }
        this.subtitle_answer_action(data)
            .then(result => {
                console.log("an", result);
                this.subtitle_action(result.subtitle);
                for (let i = 0; i < this.s_getter.length; i++) {
                    this.content.push({
                        "firstTime": this.s_getter[i][1][0],
                        "lastTime": this.s_getter[i][1][1],
                        "textArea": this.s_getter[i][2],
                    });
                }
            });

        let inter = setInterval(() => {
            this.video_time_check = this.video.currentTime;
        }, 100);
    },
    beforeUpdate: function () {},
    updated: function () {
        while (this.sb_getter.length != 0) {
            let i = 0;
            for (i; i < this.content.length; i++) {
                if (this.content[i].firstTime > this.sb_getter[0].firstTime) {
                    break;
                } else {
                    if (this.content.length === i) {
                        i = 0;
                        break;
                    }
                }
            }
            this.content.splice(i, 0, {
                "firstTime": this.sb_getter[0].firstTime,
                "lastTime": this.sb_getter[0].lastTime,
                "textArea": this.sb_getter[0].textArea,
            });
            this.sb_getter.splice(0, 1);
        }
        this.subtitle_preview_action(this.content);
    },
    computed: {
        ...mapGetters({
            v_getter: 'video_getter',
            s_getter: 'subtitle_getter',
            sb_getter: 'subtitle_buffer_getter',
            up_getters: 'upload_getters',
            percent: 'percent_getter',
        }),
    },
    watch: {
        scroll_bottom: function (data) {
            if (Math.ceil(data) >= Math.floor(this.scroll_div.scrollHeight - this.scroll_div.clientHeight)) {
                this.scroll_num.last = this.scroll_num.last + 100;
            }
        },
        video_time_check: function (data) {
            //코드 수정 필요
            for (let i = 0; i < this.content.length; i++) {
                //
                if (this.content[i].firstTime.toFixed(1) === data.toFixed(1)) {
                    if (this.scroll_num.first <= i && i <= this.scroll_num.last) {} else {
                        this.scroll_num.last = this.scroll_num.last + i;
                    }
                    setTimeout(() => {
                        clearInterval(this.terval);
                        let input = document.getElementsByClassName("textarea");
                        input[i].style.border = "4px solid #EF5350";
                        input[i].scrollIntoView({
                            behavior: 'smooth'
                        }); //instant
                        setTimeout(() => {
                            this.terval = setInterval(() => {
                                this.video_time_check = this.video.currentTime;
                            }, 100);
                        }, this.content[i].lastTime - this.content[i].firstTime);
                    }, 100);
                    //
                } else {
                    if (this.content[i].lastTime.toFixed(1) === data.toFixed(1)) {
                        let input = document.getElementsByClassName("textarea");
                        input[i].style.border = "none";
                    }
                }
            } //for end
        },
    }
}
</script>

<style lang="css" scoped>
#scroll_div {
    height: 800px;
    overflow-y: scroll;
    overflow-x: scroll;
    white-space: nowrap;
}
.textSize{
    font-size: 1.2rem;
    font-weight: 500;
}
.subtitlePlus{
  font-size: 1.3rem;
  font-weight: 600;
}
/* .btn{
  position: absolute;
  visibility: hidden;
}
.textarea:hover .btn{
  position: relative;
  visibility: inherit;
} */
</style>
