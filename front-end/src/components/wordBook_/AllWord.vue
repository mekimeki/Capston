<template lang="html">
<v-container white fluid :grid-list-md="!$vuetify.breakpoint.xs">
    <v-layout white wrap row>

        <!--words select-->
        <v-flex justify-start white xs12 sm12 md12>
            <v-toolbar-items>
                <v-bottom-nav :active.sync="bottomNav" :value="true" color="white">
                    <v-btn v-for="menu in menus" :key="menu" color="blue" flat>{{menu.name}}</v-btn>
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
                    <v-icon color="grey darken-3" medium>playlist_add</v-icon>
                    <v-icon color="grey darken-3" v-on:click="click()">delete</v-icon>
                </v-layout>
                <v-layout justify-center row wrap>
                    <v-flex v-for="(word, i) in words" :key="(word, i)" v-bind="{ [`xs${words.flex}`]: true }" md2>
                        <v-card color="blue-grey lighten-4">
                            <v-card-text style="padding: 5px 10px">
                                <v-layout justify-end>

                                    <!-- selected checked -->
                                    <v-checkbox v-model="selected" v-bind:value="word" @change="checked()" height="1px" v-if="box==true" color="grey darken-3"></v-checkbox>

                                    <!--start of like icon-->
                                    <v-icon v-if="word.memorized=='T'" id="memorized" color="red" v-on:click="changeHeart(i)">
                                        turned_in
                                    </v-icon>

                                    <v-icon v-else id="memorized" color="red" v-on:click="changeHeart(i)">
                                        turned_in_not
                                    </v-icon>
                                </v-layout>
                            </v-card-text>

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
import { constants } from "crypto";
export default {
  data() {
    return {
      menus: [
        {
          name: "전체단어"
        },
        {
          name: "암기단어"
        },
        {
          name: "미암기단어"
        }
      ],
      words: [
        {
          word: "one",
          memorized: false
        },
        {
          word: "two",
          memorized: true
        },
        {
          word: "three",
          memorized: false
        },
        {
          word: "four",
          memorized: true
        },
        {
          word: "five",
          memorized: false
        },
        {
          word: "six",
          memorized: true
        },
        {
          word: "seven",
          memorized: false
        },
        {
          word: "eight",
          memorized: false
        },
        {
          word: "nine",
          memorized: false
        }
      ],
      flex: 4,
      memorized: "",
      box: false,
      selected: [],
      toggle: false,
      bottomNav: "recent"
    };
  },

  methods: {
    changeHeart(i) {
      console.log(this.words[i].memorized);
      if (this.words[i].memorized == "T") {
        this.words[i].memorized = "F";
      } else {
        this.words[i].memorized = "T";
      }
    },
    checked(){
      if(this.selected.length == this.words.length)
        this.toggle = true
      else{
        this.toggle = false
      }
    },
    deleteQuest() {
      var form = new FormData();
      form.append("selected", this.selected);
      axios.get("http://172.26.4.41/get-token").then(response => {
        if (response.data) {
          form.append("_token", reponse.data);
          axios
            .post("http://172.26.4.41/api/deletedWord", form)
            .then(response => {
              console.log("respnse", ok);
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
      if(this.selected.length == this.words.length){
        this.selected = []
      }else{
        this.selected = this.words.slice()
      }
    }
  },
  mounted() {
    const baseURI = "http://172.26.4.41/api/book/0";
    axios
      .get(baseURI)
      .then(res => {
        this.words = res.data;
        console.log("ok", res);
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
