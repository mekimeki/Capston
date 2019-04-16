<template lang="html">
  
    <v-layout justify-center row wrap>
      <v-flex xs12 sm3>
        <v-card>
          <v-container >
            <span>추천 영상</span>
            <v-layout row wrap>
              <v-flex
                v-for="n in 9"
                :key="n"
                xs4
              >
                <v-card flat tile>
                  <v-img
                    :src="`https://unsplash.it/150/300?image=${Math.floor(Math.random() * 100) + 1}`"
                    height="100px"
                  ></v-img>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card>  
      </v-flex>
      <v-flex xs12 sm3>
        <v-card>
          <v-container >
            <span>추천 영상</span>
            <v-layout row wrap>
              <v-flex
                v-for="n in 9"
                :key="n"
                xs4
              >
                <v-card flat tile>
                  <v-img
                    :src="`https://unsplash.it/150/300?image=${Math.floor(Math.random() * 100) + 1}`"
                    height="100px"
                  ></v-img>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card>  
      </v-flex>
      <v-flex xs12 sm3>
        <v-card>
          <v-container >
            <span>추천 영상</span>
            <v-layout row wrap>
              <v-flex
                v-for="n in 9"
                :key="n"
                xs4
              >
                <v-card flat tile>
                  <v-img
                    :src="`https://unsplash.it/150/300?image=${Math.floor(Math.random() * 100) + 1}`"
                    height="100px"
                  ></v-img>
                </v-card>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card>  
      </v-flex>
      
    </v-layout>

</template>

<script>
export default {}
</script>

<style lang="css" scoped>
</style>
