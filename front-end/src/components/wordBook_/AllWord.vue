<template lang="html">
<v-container white fluid :grid-list-md="!$vuetify.breakpoint.xs">
    <v-layout white wrap row>

        <!--select of words-->
        <v-flex justify-start white xs12 sm12 md12>
            <v-toolbar-items>
                <v-bottom-nav :active.sync="bottomNav" :value="true" color="white">
                    <v-btn color="blue" flat v-for="(menu,m) in menus" :key="(menu,m)" v-bind:value="menu.value" v-on:click="allWord(m)">{{menu.word}}</v-btn>
                </v-bottom-nav>
            </v-toolbar-items>
        </v-flex>

        <!--words button-->
        <v-flex lg12 sm12 xs2 row wrap>
            <v-container fluid grid-list-md white>
                <v-layout v-model="box" justify-end>
                    <v-card-text>
                        <h3>
                            <li>전체단어</li>
                        </h3>
                    </v-card-text>

                    <!-- selected all checked -->
                    <v-checkbox v-bind:value="toggle" @change="toggleAll()" v-if="box==true" color="grey darken-3">
                    </v-checkbox>
                    <v-icon color="grey darken-3" medium v-on:click="click()">playlist_add</v-icon>
                    <v-icon color="grey darken-3" v-on:click="click()">delete</v-icon>
                </v-layout>
                <v-layout justify-center row wrap>
                    <v-flex v-for="(word, i) in words" :key="(word, i)" v-bind="{ [`xs${words.flex}`]: true }" md2>
                        <v-card color="light-blue lighten-3">
                            <v-card-text style="padding: 5px 10px">
                                <v-layout justify-end>

                                    <!-- selected checked -->
                                    <v-checkbox v-model="selected" v-bind:value="word.id" @change="checked()" height="1px" v-if="box==true" color="grey darken-3"></v-checkbox>

                                    <!--start of like icon-->
                                    <v-icon v-if="word.memorized=='T'" id="memorized" color="red accent-2" v-on:click.stop="changeHeart(i)">
                                        {{ }}turned_in
                                    </v-icon>
                                    <v-icon v-else id="memorized" color="red accent-2" v-on:click.stop="changeHeart(i)">
                                        turned_in_not
                                    </v-icon>
                                </v-layout>
                            </v-card-text>

                            <!--cards of words-->
                            <v-container fill-heights fluid pa-2 text-xs-center>
                                <v-layout fill-height>
                                    <v-flex xs12 align-end flexbox>
                                        <v-card color="whtie">
                                            {{ word.word }}
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
export default {
    data() {
        return {
            menus: [{
                    word: '전체 단어',
                    value: 'all'
                },
                {
                    word: '암기 단어',
                    value: 'memory'
                },
                {
                    word: '미암기 단어',
                    value: 'unmemory'
                }
            ],
            words: [{
                word: '',
            }],
            flex: 4,
            box: false,
            selected: [],
            toggle: false,
            bottomNav: "all"
        };
    },
    methods: {
        changeHeart(i) {
            console.log(this.words[i].memorized);
            if (this.words[i].memorized == "T") {
                this.wordQuest(this.words[i].id, "F")
                this.words[i].memorized = "F";
            } else {
                this.wordQuest(this.words[i].id, "T")
                this.words[i].memorized = "T";
            }
        },
        wordQuest(changeID, flag) {
            const baseURI = "http://172.26.4.41/api/update"
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
        allWord(m) {
            if (m == 0) {
                var baseURI = "http://172.26.4.41/api/book/0";
            } else if (m == 1) {
                var baseURI = "http://172.26.4.41/api/memo/T";
            } else {
                var baseURI = "http://172.26.4.41/api/memo/F";
            }
            axios
                .get(baseURI)
                .then(res => {
                    this.words = res.data;
                    console.log("ok", res);
                })
                .catch(error => {
                    console.log("failed", error);
                })
        },
        classifyQuest(classifyWord = '') {
            var form = new FormData();
            const baseURI = "http://172.26.4.41/api/book/0";
            form.append("classifyWord", classifyWord)
            axios
                .get(baseURI, form)
                .then(res => {
                    this.words = res.data;
                    console.log("ok", this.words);
                })
                .catch(error => {
                    console.log("failed", error);
                });
        },
        checked() {
            if (this.selected.length == this.words.length)
                this.toggle = true
            else {
                this.toggle = false
            }
        },
        deleteQuest() {
            var form = new FormData();
            form.append("selected", this.selected);
            axios.get("http://172.26.4.41/get-token").then(response => {
                if (response.data) {
                    form.append("_token", response.data);
                    console.log(this.selected)
                    axios
                        .post("http://172.26.4.41/api/deletedWord", form)
                        .then(response => {
                            console.log("response ==>>>> ", response.data);
                            this.words = response.data
                        })
                        .catch(error => {
                            console.log("failed", error);
                        });
                }
            });
        },
        click() {
            if (this.box == false) {
                this.box = true;
            } else {
                this.deleteQuest();
            }
        },
        toggleAll() {
            if (this.selected.length == this.words.length) {
                this.selected = []
            } else {
                this.selected = this.words.slice().map(x => {
                    return x.id
                })
            }
        },
    },
    mounted() {
        const baseURI = "http://172.26.4.41/api/book/0";
        axios
            .get(baseURI)
            .then(res => {
                this.words = res.data;
                console.log("ok", this.words);
            })
            .catch(error => {
                console.log("failed", error);
            });
    }
};
</script>

<style lang="css" scoped>
#memorized {
    cursor: pointer;
}
</style>
