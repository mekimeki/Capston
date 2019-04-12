<template>
  <v-layout row justify-center>
    <v-btn
      color="green"
      dark
      @click.stop="dialog = true"
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
        <v-card  justify-center>
          <v-card flat>
          <v-card-text v-if="n==1">{{ text1 }}</v-card-text>
          <v-card-text v-if="n==2">{{ (n-1) + text2 }}
            <v-card-text>{{ answer }}</v-card-text>
          </v-card-text>
          <v-card-text v-if="n==3">{{ (n-1) + text3 }}
            <v-card-text>{{ answer }}</v-card-text>
          </v-card-text>
          <v-card-text v-if="n==4">{{ (n-1) + text4 }}
            <v-card-text>{{ answer }}</v-card-text>
          </v-card-text>
          <v-card-text v-if="n==5">{{ (n-1) + text5 }}
            <v-card-text>{{ answer }}</v-card-text>
          </v-card-text>
          <v-card-text v-if="n==6">{{ (n-1) + text6 }}
            <v-card-text>{{ answer }}</v-card-text>
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
                    >{{ n + ". " + example }}</v-btn> 
                  </v-flex> 
                </v-layout>
              </v-flex>
            </v-layout>
          </v-card>
          <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
            color="red lighten-1"
            flat="flat"
            @click="next"
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
  export default {
  data () {
      return {
        active: null,
        dialog: false,
        text1: '본 게임은 자신의 단어장에 저장되어 있는 단어를 이용하여, 제시된 단어에 알맞은 뜻을 찾는 퀴즈입니다. 알맞은 답을 클릭해 주세요.',
        text2: '. 알맞은 단어를 고르시오.',
        text3: '. 알맞은 단어를 고르시오.',
        text4: '. 알맞은 단어를 고르시오.',
        text5: '. 알맞은 단어를 고르시오.', 
        text6: '. 알맞은 단어를 고르시오.',
        button: 'click',
        example: '단어',
        answer: '토끼',
      }
    },
    methods: {
      next () {
        const active = parseInt(this.active)
        this.active = (active < 6 ? active + 1 : 0)
      }
    }
  }
</script>