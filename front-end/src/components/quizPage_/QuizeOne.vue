<template>
  <v-layout  row justify-center>
    <v-btn
      color="#00BFA5"
      dark
      v-on:click.stop="dialog = true"
    >
      QUIZ START
    </v-btn>
    <v-dialog
      v-model="dialog"
      max-width="500"
    >
    <v-tabs
      v-model="active"
      color="#00BFA5"
      dark
      slider-color="#EC407A"
    >
    <v-tab
        v-for="n in 6"
        :key="n"
      >
      {{ n-1 }}

      </v-tab>
    <v-tab-item
        v-for="n in 6"
        :key="n"
      >
        <v-card justify-center>
          <v-card flat>
          <v-card-text v-if="n==1">{{ head }}</v-card-text>

          <v-card-text mb-5 v-if="n>=2">{{ (n-1) + text }} <br />
            <p v-for="question in questions">{{ question }}</p>
          </v-card-text>
          
            <v-layout>
              <v-flex v-if="n==2" xs3 sm12>
                <v-layout justify-space-around row wrap >
                  <v-flex
                    v-for="n in 4"
                    :key="n"
                    md5
                  >
                    <v-btn
                      large
                      block
                      color="cyan lighten-2" 
                      
                    >{{ n + ". " + choice[n-1].word}}</v-btn> 
                  </v-flex> 
                </v-layout>
              </v-flex>
            </v-layout>
          </v-card>
          <v-card-actions>
          <v-spacer></v-spacer>

          
          <v-btn
            v-if="n!=6"
            color="red lighten-1"
            flat="flat"
            v-on:click="next(), getQuest(), select==n"
          >
            {{ button }}
          </v-btn>
        </v-card-actions>
        </v-card>
      </v-tab-item>
    </v-tabs>
    </v-dialog>
  </v-layout>
</template>


<script>
  import axios from 'axios'

  export default {
  data () {
      return {
        active: null,
        dialog: false,
        head: '본 게임은 자신의 단어장에 저장되어 있는 단어를 이용하여, 제시된 단어에 알맞은 뜻을 찾는 퀴즈입니다. 알맞은 답을 클릭해 주세요.',
        text: '. 알맞은 단어를 고르시오.',
        button: 'click',
        choice: [{"word":""},{"word":""},{"word":""},{"word":""}],
        questions: [],
        answer: 0,
        select: 0,
      }
    },
    methods: {
      next () {
        const active = parseInt(this.active)
        this.active = (active < 6 ? active + 1 : 0)
      },
      getQuest() {
        const baseURI ='http://172.26.1.175/api/quiz';
        axios.get(baseURI).then((res)=>{
          var back = res.data;
          this.choice = back.choice;
          this.questions = back.ques;
          this.answer = back.ans;
      }).catch( error => {
        console.log('failed',error);
      });
      }
    },
  }
</script>