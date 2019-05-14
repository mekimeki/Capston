<template lang="html">
<v-container white fluid :grid-list-md="!$vuetify.breakpoint.xs">
    <v-layout white wrap row>

        <!-- modal of add files -->
        <div class="text-xs-center">
            <v-dialog v-model="dialog" width="500">
                <v-card>
                    <span><div class="subheading font-weight-black pt-5 pb-2 pl-4 ml-3" primary-title>
                        저장할 단어장을 선택해 주세요.
                    </div></span>
                    <v-card-text>
                        <v-flex pl-3 ml-2>
                            <ul>
                                <div v-for="book in books" :key="book">
                                    <li class="subheading font-weight-black">
                                        <v-btn class="subheading" flat>{{ book.title }}</v-btn>
                                    </li>
                                </div>
                            </ul>
                        </v-flex>
                    </v-card-text>

                    <!-- select category -->
                    <v-layout wrap>
                        <v-flex pl-5 pr-3 pt-3 xs6 md6>
                            <v-select height="50px" sm4 v-model="lang" :items="items" label="언어 선택" outline></v-select>
                        </v-flex>
                        <v-flex pl-3 pr-5 pt-3 xs6 md6>
                            <v-select height="50px" sm4 v-model="category" :items="categories" label="카테고리" outline></v-select>
                        </v-flex>
                        <v-flex pl-5 pb-2 xs6 md8>
                            <v-text-field v-model="albumNames" sm8 label="단어장 명" single-line outline></v-text-field>
                        </v-flex>
                        <!-- make album button -->
                        <v-flex xs6 pl-3 mt-2 pb-2 md4>
                            <v-icon large color="grey darken-3" @click="createAlbumQuest()">add</v-icon>
                        </v-flex>
                    </v-layout>

                    <v-divider></v-divider>
                    <!-- confirm button -->
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" flat @click="dialog = false, box = false">
                            확인
                        </v-btn>
                    </v-card-actions>

                </v-card>
            </v-dialog>
        </div>

        <!-- modal of words crawling -->
        <div class="text-xs-center">
            <v-dialog v-model="crawl" width="450px">
                <v-card fill-height color="teal lighten-2">
                    <v-container fill-height fluid pa-2 text-xs-left>
                        <v-layout fill-height>
                            <v-flex xs12 align-end flexbox>
                                <v-card flat color="white">
                                    <v-img :src="lines[selectNumber].pic_add" contain></v-img>
                                </v-card>
                                <v-card flat color="white">
                                    <div style="text-align:center; height:40px;" class="title pt-3">{{ lines[selectNumber].line }}</div>
                                </v-card>
                                <v-card flat color="white">
                                    <div style="text-align:center; height:50px;" class="title pt-3">{{ lines[selectNumber].explain }}</div>
                                </v-card>

                                <v-card v-for="(crawlWord, i) in crawlWords" :key="(crawlWord, i)" flat color="white">
                                    <span v-if="i%2==0"><div class="py-2"></div></span>
                                    {{ crawlWord }}
                                    <span v-if="i==9"><div class="py-2"></div></span>
                                </v-card>

                            </v-flex>
                        </v-layout>
                    </v-container>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="white" flat @click="crawl = false">
                            확인
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </div>

        <!--select of words-->
        <v-flex justify-start white xs12 sm12 md12>
            <v-toolbar-items>
                <v-bottom-nav :active.sync="bottomNav" :value="true" color="white">
                    <v-btn color="teal" flat v-for="(menu,m) in menus" :key="(menu,m)" v-bind:value="menu.value" @click="allWord()">{{menu.word}}</v-btn>
                    <v-btn color="teal" flat v-for="(book,i) in books" :key="(book,i)" v-bind:value="book.id" @click="selectedWordsQuest(i)">{{book.title}}</v-btn>
                    <!-- <v-btn></v-btn> -->
                </v-bottom-nav>
            </v-toolbar-items>
        </v-flex>

        <!--words button-->
        <v-flex lg12 sm12 xs2 row wrap>
            <v-container fluid grid-list-md white>
                <v-layout v-model="box" justify-end>
                    <v-card-text>
                        <h3>
                            <div>・ 나의 대사장</div>
                        </h3>
                    </v-card-text>

                    <!-- selected all checked -->
                    <v-checkbox v-bind:value="toggle" @change="toggleAll()" v-if="box==true" color="grey darken-3">
                    </v-checkbox>
                    <v-icon color="grey darken-3" v-on:click="click('c')" medium>playlist_add</v-icon>
                    <v-icon color="grey darken-3" v-on:click="click('d')">delete</v-icon>
                </v-layout>
                <v-layout justify-center row wrap>
                    <v-flex v-for="(line, i) in lines" :key="(line, i)" v-bind="{ [`xs${flex}`]: true }" md2>
                        <v-card color="teal lighten-2">
                            <v-card-text style="padding: 5px 10px">
                                <v-layout justify-end>

                                    <!-- selected checked -->
                                    <v-checkbox v-model="selected" v-bind:value="line.id" @change="checked(i)" height="1px" v-if="box==true" color="grey darken-3"></v-checkbox>

                                </v-layout>
                            </v-card-text>

                            <!--cards of words-->
                            <v-container fill-height fluid px-3 pt-2 pb-3 text-xs-center>
                                <v-layout fill-height>
                                    <v-flex xs12 align-end flexbox>
                                        <v-card>
                                            <v-img @click="crawl = true, changeNumber(i)" :src="line.pic_add"></v-img>
                                            <v-card @click="crawl = true, changeNumber(i)">
                                                <div style="text-align:center; height:59px;" class="title mt-1 pt-3">{{ line.line }}</div>
                                            </v-card>
                                        </v-card>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-flex>
    </v-layout>
</v-container>
</template>

<script>
import axios from "axios";
import {
    constants
} from "crypto";

//  wordQuest => 단어 미암기 변환
//  allWord => 전체단어, 미암기단어, 암기단어 호출
//  changeHeart => 암기, 미암기 단어 구분
//  classifyQuest => 전체단어, 미암기단어, 암기단어 분류 요청

//  callAlbumQuest => 단어장 목록 부르기
//  plus => 모달창의 단어장 목록 추가
//  createAlbumQuest => 단어장 추가 요청
//  addWordsQuest => 단어장 선택 후 단어 추가

//  checked => 체크박스 전체선택시 윗부분 체크박스 선택
//  click => 체크박스 보이는 여부
//  toggleAll => 체크박스 선택후 비우는 부분(?)
//  deleteQuest => 단어 삭제 요청

//  crawlingPage => 자세히보기 페이지

export default {
    data() {
        return {
            menus: [{
                word: '전체 대사',
                value: 'all'
            }],
            books: [],
            lines: [],
            flex: 6,
            box: false,
            selected: [],
            selectWords: [],
            selectExplains: [],
            imgAdd: [],
            startData: [],
            videoId: [],
            toggle: false,
            bottomNav: "all",
            //albumNums: [],
            albumNames: '',
            dialog: false,
            items: ['일본어', '영어', '한국어', '중국어'],
            categories: ['판타지', 'SF', '공포', '스릴러', '코미디', '멜로'],
            lang: '',
            category: '',
            crawl: false,
            crawlWords: [],
            crawlMeans: [],
            mainWord: '',
            selectNumber: 0
        };
    },
    methods: {
        //  start of 단어 출력 및 분류 
        wordQuest(changeID, flag) {
            const baseURI = "http://172.26.3.30/api/update"
            const form = new FormData();
            form.append("id", changeID)
            form.append("flag", flag)
            axios
                .post(baseURI, form)
                .then(res => {
                    console.log("ok", res);
                    return true;
                })
                .catch(error => {
                    console.log("failed", error);
                    return false;
                })
        },
        allWord() {

            var baseURI = "http://172.26.3.30/api/line/0";

            axios
                .get(baseURI)
                .then(res => {
                    this.lines = res.data;
                    console.log("ok", res);
                    this.selected = []
                })
                .catch(error => {
                    console.log("failed", error);
                })
        },
        // changeHeart(i) {
        //     console.log(this.lines[i].memorized);
        //     if (this.lines[i].memorized == "T") {
        //         this.wordQuest(this.lines[i].id, "F")
        //         this.lines[i].memorized = "F";
        //     } else {
        //         this.wordQuest(this.lines[i].id, "T")
        //         this.lines[i].memorized = "T";
        //     }
        // },
        classifyQuest(classifyWord = '') {
            var form = new FormData();
            const baseURI = "http://172.26.3.30/api/book/0";
            form.append("classifyWord", classifyWord)
            axios
                .get(baseURI, form)
                .then(res => {
                    this.lines = res.data;
                    console.log("ok", this.lines);
                    this.selected = []
                })
                .catch(error => {
                    console.log("failed", error);
                });
        },

        //  start of 단어장 목록 보기 및 단어장에 단어추가 
        plus(table) {
            this.books.push({
                "title": this.albumNames,
                "id": table
            });
            this.albumNames = '';
            console.log(this.books);
        },
        createAlbumQuest() {
            const baseURI = "http://172.26.3.30/api/createLine"
            const form = new FormData();
            form.append("title", this.albumNames);
            form.append("lang", this.lang);
            form.append("lines[]", this.selectWords);
            form.append("explains[]", this.selectExplains);
            form.append("pic_adds[]", this.imgAdd);
            form.append("start_dts[]", this.startData);
            form.append("v_ids[]", this.videoId);
            console.log("success of make albums", this.selectWords)
            axios
                .post(baseURI, form)
                .then(res => {
                    console.log("ok", res);
                    this.plus(res.data);
                    return true;
                })
                .catch(error => {
                    console.log("failed", error);
                    return false;
                })
            this.selected = [];
            this.selectWords = [];
            this.selectExplains = [];
            this.imgAdd = [];
            this.startData = [];
            this.videoId = [];
            this.lang = '';
            this.category = '';
        },
        selectedWordsQuest(i) {
            const baseURI = "http://172.26.3.30/api/line/" + this.books[i].id;
            axios
                .get(baseURI)
                .then(res => {
                    console.log("select ok", res);
                    this.lines = res.data;
                })
                .catch(error => {
                    console.log("failed", error);
                    return false;
                })
            this.selected = [];
            this.selectWords = [];
        },

        //  start of 체크박스 선택 및 삭제 요청
        checked(po) {
            if (this.selected.length == this.lines.length) {
                this.toggle = true
            } else {
                this.toggle = false
            }
            let idx = this.selectWords.indexOf(this.lines[po].line);
            let idy = this.selectExplains.indexOf(this.lines[po].explain);
            let idz = this.imgAdd.indexOf(this.lines[po].pic_add);
            let ida = this.startData.indexOf(this.lines[po].start_dt);
            let idb = this.videoId.indexOf(this.lines[po].v_id);

            if (idx < 0) {
                this.selectWords.push(this.lines[po].line);
                this.selectExplains.push(this.lines[po].explain);
                this.imgAdd.push(this.lines[po].pic_add);
                this.startData.push(this.lines[po].start_dt);
                this.videoId.push(this.lines[po].v_id);

                console.log("선택ㄱㄱㄱㄱㄱㄱㄱㄱㄱㄱㄱㄱㄱㄱ", this.selectWords)
            } else {
                this.selectWords.splice(idx, 1);
                this.selectExplains.splice(idy, 1);
                this.imgAdd.splice(idz, 1);
                this.startData.splice(ida, 1);
                this.videoId.splice(idb, 1);
            }

            console.log(this.selected)
        },
        click(flag) {
            if (this.box == false) {
                this.box = true;
            } else {
                if (flag == 'c') {
                    this.dialog = true;
                } else {
                    this.deleteQuest();
                    alert("삭제되었습니다");
                    this.box = false;
                    this.selected = [];
                }
            }
        },
        toggleAll() {
            if (this.selected.length == this.lines.length) {
                this.selected = []
                this.selectWords = []
            } else {
                this.selected = this.lines.slice().map(x => {
                    return x.id
                })
                this.selectWords = this.lines.slice().map(x => {
                    return x.word
                })
            }
        },
        deleteQuest() {
            var form = new FormData();
            form.append("selected", this.selected);
            axios.get("http://172.26.3.30/get-token").then(response => {
                if (response.data) {
                    form.append("_token", response.data);
                    console.log(this.selected)
                    axios
                        .post("http://172.26.3.30/api/deletedLine", form)
                        .then(response => {
                            console.log("response ==>>>> ", response.data);
                            this.lines = response.data
                            this.selected = []
                        })
                        .catch(error => {
                            console.log("failed", error);
                        });
                }
            });
        },

        crawlingQuest(cword) {
            var form = new FormData();
            form.append("clickWord", cword)
            console.log(cword);
            var baseURI = "http://172.26.3.30/api/example";
            axios
                .post(baseURI, form)
                .then(res => {
                    console.log("crawling ok", res);
                    this.crawlWords = res.data.example;
                    this.crawlMeans = res.data.means;
                    this.mainWord = cword;
                    console.log("crawling word ok", this.crawlMeans[0]);
                })
                .catch(error => {
                    console.log("failed", error);
                });
        },
        changeNumber(i) {
            this.selectNumber = i;
        }
    },

    beforeCreate() {
        var baseURI = "http://172.26.3.30/api/line/0";
        axios
            .get(baseURI)
            .then(res => {
                this.lines = res.data;
                console.log("beforeCreate OK", this.lines);
            })
            .catch(error => {
                console.log("failed", error);
            });
        baseURI = "http://172.26.3.30/api/lineBook";
        axios
            .get(baseURI)
            .then(res => {
                this.books = res.data;
                console.log("okkkkkkkkkkkkk", this.books);
            })
            .catch(error => {
                console.log("failed", error);
            });
    },

};
</script>

<style lang="css" scoped>
#memorized {
    cursor: pointer;
}
</style>
