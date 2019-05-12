<template lang="html">
<v-container>
    <v-layout justify-center>
        <v-flex class="pt-5" xs12 sm12 md12 text-xs-center>
            <v-container class="pt-5" grid-list-xl text-xs-center>
                <div class="quizBox">
                    <span class="mainName pt-3"><div class="pt-3 pb-3">QUIZ TEST</div></span>
                    <v-layout fill-height>
                        <v-flex xs12 align-center flexbox>
                            <v-card flat justify-center>
                                <span class="subName">
                                  <div 
                                  v-for="name in names"
                                  :key="name" 
                                  class="pt-1">
                                  {{name.text}}</div>
                                </span>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </div>
            </v-container>

            <v-container fluid grid-list-md>
                <v-layout justify-center row wrap>
                    <v-flex v-for="card in cards" :key="card.title" v-bind="{ [`xs${card.flex}`]: true }">
                        <v-card>
                            <v-img :src="card.src" height="200px">
                                <v-container fill-height fluid pa-2>
                                    <v-layout fill-height>
                                        <v-flex xs12 align-end flexbox>
                                            <span class="example" v-text="card.title"></span>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-img>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <quizOne_></quizOne_>
                                <v-spacer></v-spacer>
                            </v-card-actions>

                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-flex>
    </v-layout>
</v-container>
</template>

<script>
import quizOne_ from "@/components/quizPage_/QuizOne";
export default {
    components: {
        quizOne_
    },
    data: () => ({
        cards: [{
                title: "1. 알맞은 단어 고르기",
                src: "https://cdn.vuetifyjs.com/images/cards/house.jpg",
                flex: 2
            },
            {
                title: "2. 알맞은 뜻 고르기",
                src: "https://cdn.vuetifyjs.com/images/cards/road.jpg",
                flex: 2
            },
            {
                title: "3. 대사 맞추기",
                src: "https://cdn.vuetifyjs.com/images/cards/plane.jpg",
                flex: 2
            },
            {
                title: "4. 카드 뒤집기 게임",
                src: "https://cdn.vuetifyjs.com/images/cards/house.jpg",
                flex: 2
            },
            {
                title: "5. 대사 빈칸 채우기",
                src: "https://cdn.vuetifyjs.com/images/cards/road.jpg",
                flex: 2
            }
        ],
        names: [{
                text: "영상을 보고 난 후, 자신이 외운 단어를 확인해 봅시다."
            },
            {
                text: "사용자에게 재미있고 다양한 퀴즈로 단어 암기의 효율을 높여줍니다."
            },
            {
                text: "자신이 원하는 퀴즈 선택 후 풀고 확인할 수 있으며, 성적 변화도 확인 가능합니다."
            }
        ]
    })
};
</script>

<style lang="css" scoped>
.mainName {
    color: black;
    font-size: 2.8rem;
    font-weight: 550;
}

.subName {
    color: black;
    font-size: 1.15rem;
    font-weight: 200;
}

.example {
    color: white;
    font-size: 1.65rem;
    font-weight: 550;
}
</style>
