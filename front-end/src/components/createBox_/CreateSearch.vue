<template lang="html">
<div>
    <v-tabs color="white" slider-color="red">
        <v-tab v-for="content in contents" ripple>
            {{ content.name }}
        </v-tab>
        <v-tab-item v-for="tent in contents">
            <v-data-table :items="tent.content" :headers="tent.content.name" class="elevation-1" hide-actions hide-headers select-all>
                <template v-slot:items="props">
                    <td v-on:click="tent.kind? click_mark_content(props.item) : click_mark_word(props.item)">
                        <v-btn small>
                            추가
                            <v-icon v-show="props.item.select">check</v-icon>
                        </v-btn>
                    </td>
                    <td>{{ props.item.name }}</td>
                    <td class="text-xs-left">{{ time_change(Math.ceil(props.item.firstTime))}}</td>
                    <td class="text-xs-left">{{ props.item.voca }}</td>
                    <td class="text-xs-left">
                        <input width="200" type="text" name="" value="" v-model="props.item.explain">
                    </td>
                </template>
            </v-data-table>
            <!--  -->
            <hr>
            <v-layout row wrap>
                <v-flex xl8 sm8 md8>
                    <v-text-field label="검색" single-line solo v-model="search" v-on:click="time.firstTime = video.currentTime"></v-text-field>
                </v-flex>
                <v-flex xl4 sm4 md4>
                    <v-btn color="teal lighten-1" large class="white--text" v-on:click="tent.kind? click_search_content(search) : click_search_word(search)">
                        검색
                    </v-btn>
                </v-flex>
            </v-layout>
            <!--  -->
        </v-tab-item>
    </v-tabs>
</div>
</template>

<script>
import {
    mapActions,
    mapGetters
} from 'vuex';
export default {
    data() {
        return {
            video: '',
            contents: [ //book mark
                {
                    name: '문법',
                    content: [],
                    kind: true
                },
                {
                    name: '어휘',
                    content: [],
                    kind: false
                },
            ],
            search: '',
            pagination: {
                page: 5,
            },
            time: {
                firstTime: 0,
                lastTime: 0,
            }
        }
    },
    methods: {
        ...mapActions(['search_content_action', 'search_word_action', 'upload_content_action', 'content_preview_content_action', 'content_preview_word_action']),
        click_search_content(search) {
            this.search_content_action(search).then(result => {
                if (result.indata) {
                    for (let i = 0; i < result.data.length; i++) {
                        this.contents[0].content.push({
                            vo_pk: result.data[i].vo_pk,
                            voca: result.data[i].voca,
                            explain: result.data[i].explain,
                            firstTime: this.time.firstTime,
                            select: false,
                        });
                    }
                } else {
                    this.contents[0].content.push({
                        vo_pk: false,
                        voca: search,
                        explain: '내용을 적어주세요.',
                        firstTime: this.time.firstTime,
                        select: false
                    });
                }
            });
        },
        click_search_word(search) {
            this.search_word_action(search).then(result => {
                if (result) {
                    this.contents[1].content.push({
                        vo_pk: false,
                        voca: search,
                        explain: result.mean ? result.mean : '내용을 적어주세요',
                        firstTime: this.time.firstTime,
                        select: false
                    });
                } else {
                    this.contents[1].content.push({
                        vo_pk: false,
                        voca: search,
                        explain: '내용을 적어주세요.',
                        firstTime: this.time.firstTime,
                        select: false
                    });
                }
            });
        },
        click_mark_content(content) {
            if (content.select) {
                content.select = false;
                for (let i = 0; i <= this.cp_getter.length; i++) {
                    if (this.cp_getter[0].content[i].voca === content.voca) {
                        let data = {
                            content: content,
                            number: i,
                        }
                        console.log("??");
                        this.content_preview_content_action(data);
                        break;
                    }
                }
            } else {
                content.select = true;
                let data = {
                    content: content,
                    number: false,
                }
                this.content_preview_content_action(data);
            }
        },
        click_mark_word(content) {
            if (content.select) {
                content.select = false;
                for (let i = 0; i <= this.cp_getter.length; i++) {
                    if (this.cp_getter[1].cotnent[i].voca === content.voca) {
                        let data = {
                            content: content,
                            number: i,
                        }
                        this.content_preview_word_action(data);
                        break;
                    }
                }
            } else {
                content.select = true;
                let data = {
                    content: content,
                    number: false,
                }
                this.content_preview_word_action(data);
            }
        },
        time_change(seconds) {
            let hour = parseInt(seconds / 3600);
            let min = parseInt((seconds % 3600) / 60);
            let sec = seconds % 60;
            return hour + ":" + min + ":" + sec;
        },
    },
    mounted: function () {
        this.video = this.v_getter;
    },
    computed: {
        ...mapGetters({
            v_getter: "video_getter",
            cp_getter: "content_preview_getter",
        }),
    },
}
</script>

<style lang="css" scoped>
</style>
