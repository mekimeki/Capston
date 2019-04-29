<template>
<v-app style="background: #FFFFFF;">
<v-layout justify-center align-center >
  <v-flex xs12 sm12 md9 text-xs-center>
    <v-container color="#00BFA5"  grid-list-xl text-xs-center>
      <v-toolbar-title>QUIZ TEST</v-toolbar-title>
    </v-container>
    
      <v-container
        fluid
        grid-list-md
        
      >
        <v-layout justify-center row wrap>
          <v-flex
            v-for="card in cards"
            :key="card.title"
            v-bind="{ [`xs${card.flex}`]: true }"
            
          >
            <v-card>
              <v-img
                :src="card.src"
                height="200px"
              > 
                <v-container
                  fill-height
                  fluid
                  pa-2
                >
                  <v-layout fill-height>
                    <v-flex xs12 align-end flexbox>
                      <span class="headline white--text" v-text="card.title"></span>
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
</v-app>
</template>

<script>
import quizOne_ from '@/components/quizPage_/QuizOne';
export default {
  components: {
    quizOne_,
  },
  data: () => ({
    cards: [
      { title: '1. 대사 순서 맞추기', src: 'https://cdn.vuetifyjs.com/images/cards/house.jpg', flex: 2 },
      { title: '2. 사진으로 연상하기', src: 'https://cdn.vuetifyjs.com/images/cards/road.jpg', flex: 2 },
      { title: '3. 단어 읽는 방법', src: 'https://cdn.vuetifyjs.com/images/cards/plane.jpg', flex: 2 },
      { title: '4. 단어 퍼즐', src: 'https://cdn.vuetifyjs.com/images/cards/house.jpg', flex: 2 },
      { title: '5. 빈칸 채우기', src: 'https://cdn.vuetifyjs.com/images/cards/road.jpg', flex: 2 },
    ]
  })
}
</script>