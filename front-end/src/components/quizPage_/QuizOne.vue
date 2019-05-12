<template>
<v-layout row justify-center>
    <v-btn flat v-on:click.stop="dialog = true" small class="subheading font-weight-bold">QUIZ START</v-btn>
    <v-dialog v-model="dialog" max-width="700">
        <v-tabs v-model="active" color="teal lighten-1" dark slider-color="yellow">
            <v-tab v-for="n in 7" :key="n">{{ n-1 }}</v-tab>
            <v-tab-item v-for="n in 7" :key="n">
                <v-card justify-center height="640">
                    <v-card v-if="n<7" flat>
                        <v-card-text v-if="n==1">
                            <div class="headName py-3 pl-5">퀴즈 푸는 방법</div>
                            <div class="mx-5 pb-3">
                                <v-img :src="require(`@/assets/Quiz/quiz1.png`)" contain></v-img>
                            </div>
                            <div class="headName pt-3 px-5">{{ head }}</div>
                        </v-card-text>

                        <v-card-text v-if="n>=2">
                            <div class="problem pt-3 pl-3">{{ (n-1) + text }}</div>
                            <div class="pb-3 pt-4"></div>
                            <div class="exampleUp mx-3 py-5 mb-4">
                                <div class="pt-4 mt-5"></div>
                                <span class="example px-4 pb-2 pt-5 mt-3" v-for="question in questions" :key="question">{{ question }}</span>
                            </div>
                        </v-card-text>

                        <v-layout pb-3>
                            <v-flex v-if="n>=2" xs3 sm12>
                                <v-layout justify-space-around row wrap>
                                    <v-flex v-for="n in 4" :key="n" md5>
                                        <v-btn large block color="teal lighten-3 title font-weight-bold" v-on:click="select=(n-1)" value="check">{{ n + ". " + example[n-1].word}}</v-btn>
                                    </v-flex>
                                </v-layout>
                            </v-flex>
                        </v-layout>
                    </v-card>

                    <v-card v-if="n==7" flat>
                        <div class="result py-5">{{ end }}</div>
                        <div v-for="(a,b) in result" :key="(a,b)">
                            <div class="pt-5 pl-4 resultPage">
                                <div class="resultPro pl-5 ml-5 pb-2">문제. {{b+1}}</div>
                                <div class="resultSee pl-5 ml-5">선택 : {{ a[0] }}</div>
                                <div class="resultSee pl-5 ml-5">정답 : {{ a[1] }}</div>
                                <div class="resultScore pl-5 pb-4 ml-5">결과 : {{ a[2] }}</div>
                            </div>
                        </div>

                    </v-card>

                    <v-card-actions>
                        <v-spacer></v-spacer>

                        <v-btn v-if="1<n&&n<6" color="red lighten-1" flat="flat" v-on:click="next(), getQuest(), checkAns()">
                            <div class="buttonClick">NEXT</div>
                        </v-btn>
                        <v-btn v-if="n==1" color="red lighten-1" flat="flat" v-on:click="next(), getQuest()">
                            <div class="pb-3 buttonClick">NEXT</div>
                        </v-btn>
                        <v-btn v-if="n==6" color="red lighten-1" flat="flat" v-on:click="next(),checkAns()">
                            <div class="buttonClick">NEXT</div>
                        </v-btn>
                        <div class="buttonClick pt-5 mt-5" v-if="n==7" color="red" flat="flat" v-on:click.stop="dialog = false, postQuest()">

                            <v-layout class="pt-5 mt-5">
                                <div class="pt-5 mt-5">
                                    <div class="pt-5 mt-5 pr-3">
                                        <div class="pt-3 mt-5 pr-3">{{ close }}</div>
                                    </div>
                                </div>
                            </v-layout>

                        </div>
                    </v-card-actions>
                </v-card>
            </v-tab-item>
        </v-tabs>
    </v-dialog>
</v-layout>
</template>

<script>
import axios from "axios";
import {
    constants
} from "crypto";
import {
    mapActions
} from 'vuex';
// import { lookup } from 'dns';
export default {
    data() {
        return {
            active: null,
            dialog: false,
            head: "본 게임은 자신의 단어장에 저장되어 있는 단어를 이용하여, 제시된 단어에 알맞은 뜻을 찾는 퀴즈입니다. 알맞은 답을 클릭해 주세요.",
            text: ". 알맞은 단어를 고르시오.",
            close: "닫기",
            end: "결과입니다",
            example: [{
                    word: ""
                },
                {
                    word: ""
                },
                {
                    word: ""
                },
                {
                    word: ""
                }
            ],
            questions: [],
            answer: 0,
            select: 99,
            result: [],
            score: 0,
            ran_box: []
        };
    },
    methods: {
        ...mapActions(['quest_actions', 'quest_post_actions']),
        next() {
            const active = parseInt(this.active);
            this.active = active < 6 ? active + 1 : 0;
        },
        getQuest() {
            console.log("check box ", this.ran_box);
            this.quest_actions(this.ran_box).then(result => {
                const back = result;
                this.example = back.choice;
                this.questions = back.ques;
                this.answer = back.ans;
                this.ran_box = back.ran_box;
                console.log('quiz quest sucesdddddddddddddddddds', result);
                console.log('quiz quest error', this.ran_box);
            }).catch(error => {
                console.log('quiz quest error', error);
            });
        },
        postQuest() {
            this.quest_post_actions([this.score, "123@gmail.com"]).then(result => {
                console.log("response", result);
            }).catch(error => {
                console.log('failed', error);
            });
        },
        checkAns() {
            if (this.select == this.answer) {
                this.result.push([this.select + 1, this.answer + 1, "O"]);
                this.score = this.score + 20;
            } else this.result.push([this.select + 1, this.answer + 1, "X"]);

            console.log(this.select);
            console.log(this.result);
            console.log(this.answer);
        }
    }
};
</script>

<style>
.buttonClick{
    cursor: pointer;
}
.resultPage {
    display: inline;
    float: left;
    width: 200px;
}

.resultPro {
    font-size: 1.3rem;
    font-weight: 600;
}

.resultSee {
    font-size: 1.3rem;
    font-weight: 600;
}

.resultScore {
    font-size: 1.3rem;
    font-weight: 600;
    color: rgba(238, 58, 58, 0.89);
}

.buttonClick {
    color: red;
    font-size: 1.3rem;
    font-weight: 600;
}

.headName {
    color: black;
    font-size: 1.3rem;
    font-weight: 600;
}

.problem {
    color: black;
    font-size: 1.3rem;
    font-weight: 600;
}

.example {
    color: black;
    font-size: 1.8rem;
    font-weight: 600;
}

.exampleUp {
    background-color: white;
    border-radius: 10px 10px 10px 10px;
    border: 3px solid #00695C;
    height: 300px;
    text-align: center;
}

.result {
    color: black;
    font-size: 1.5rem;
    font-weight: 600;
    text-align: center;
}
</style>
