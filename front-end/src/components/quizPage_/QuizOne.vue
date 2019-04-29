<template>
  <v-layout row justify-center>
    <v-btn flat v-on:click.stop="dialog = true" small class="subheading font-weight-bold">QUIZ START</v-btn>
    <v-dialog v-model="dialog" max-width="500">
      <v-tabs v-model="active" color="red" dark slider-color="yellow">
        <v-tab v-for="n in 7" :key="n">{{ n-1 }}</v-tab>
        <v-tab-item v-for="n in 7" :key="n">
          <v-card justify-center>
            <v-card v-if="n<7" flat>
              <v-card-text v-if="n==1">{{ head }}</v-card-text>

              <v-card-text mb-5 v-if="n>=2">
                {{ (n-1) + text }}
                <p v-for="question in questions" :key="question">{{ question }}</p>
              </v-card-text>

              <v-layout>
                <v-flex v-if="n>=2" xs3 sm12>
                  <v-layout justify-space-around row wrap>
                    <v-flex v-for="n in 4" :key="n" md5>
                      <v-btn
                        large
                        block
                        color="orange"
                        v-on:click="select=(n-1)"
                        value="check"
                      >{{ n + ". " + example[n-1].word}}</v-btn>
                    </v-flex>
                  </v-layout>
                </v-flex>
              </v-layout>
            </v-card>

            <v-card v-if="n==7" flat>
              <v-card-text>{{ end }}</v-card-text>
              <v-card-text v-for="a in result" :key="a">
                내가선택한답 {{ a[0] }}
                <v-spacer></v-spacer>
                정답 {{ a[1] }}
                <v-spacer></v-spacer>
                결과 {{ a[2] }}
                <v-spacer></v-spacer>
              </v-card-text>
            </v-card>

            <v-card-actions>
              <v-spacer></v-spacer>

              <v-btn
                v-if="1<n&&n<6"
                color="red lighten-1"
                flat="flat"
                v-on:click="next(), getQuest(), checkAns()"
              >{{ button }}</v-btn>

              <v-btn
                v-if="n==1"
                color="red lighten-1"
                flat="flat"
                v-on:click="next(), getQuest()"
              >{{ button }}</v-btn>

              <v-btn
                v-if="n==6"
                color="red lighten-1"
                flat="flat"
                v-on:click="next(),checkAns()"
              >{{ button }}</v-btn>

              <v-btn
                v-if="n==7"
                color="red lighten-1"
                flat="flat"
                v-on:click.stop="dialog = false, postQuest()"
              >{{ close }}</v-btn>
            </v-card-actions>
          </v-card>
        </v-tab-item>
      </v-tabs>
    </v-dialog>
  </v-layout>
</template>

<script>
import axios from "axios";
import { constants } from "crypto";

export default {
  data() {
    return {
      active: null,
      dialog: false,
      head:
        "본 게임은 자신의 단어장에 저장되어 있는 단어를 이용하여, 제시된 단어에 알맞은 뜻을 찾는 퀴즈입니다. 알맞은 답을 클릭해 주세요.",
      text: ". 알맞은 단어를 고르시오.",
      button: "click",
      close: "닫기",
      end: "결과입니다",
      example: [
        {
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
      score: 0
    };
  },
  methods: {
    next() {
      const active = parseInt(this.active);
      this.active = active < 6 ? active + 1 : 0;
    },
    getQuest() {
      const baseURI = "http://172.26.4.41/api/quiz";
      axios
        .get(baseURI)
        .then(res => {
          var back = res.data;
          this.example = back.choice;
          this.questions = back.ques;
          this.answer = back.ans;
        })
        .catch(error => {
          console.log("failed", error);
        });
    },
    //FormData()方式
    postQuest() {
      var form = new FormData();
      form.append("results", this.score);
      axios.get("http://172.26.4.41/get-token").then(response => {
        if (response.data) {
          form.append("_token", response.data);
          axios
            .post("http://172.26.4.41/api/quiz", form)
            .then(response => {
              console.log("response", ok);
            })
            .catch(error => {
              console.log("failed", error);
            });
        }
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
