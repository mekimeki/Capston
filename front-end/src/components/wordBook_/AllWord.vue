<template>
<v-container white fluid :grid-list-md="!$vuetify.breakpoint.xs">
    <v-layout white wrap row>
    <v-toolbar color="white" flat>
        <v-toolbar-items>
        <v-btn color="white">전체 단어</v-btn>
        <v-btn color="white">암기 단어</v-btn>
        <v-btn color="white">미암기 단어</v-btn>
        </v-toolbar-items>
    </v-toolbar>

    <!--words select-->
    <v-flex white xs12 sm12>
    </v-flex>
    
    <!--words button-->
    <v-flex lg9 sm12 xs2 row wrap >
        <v-container
        fluid
        grid-list-md
        white
    >
    <v-layout justify-end>
        <v-card-text><h3><li>전체단어</li></h3></v-card-text>
            <v-icon color="grey darken-3" >check_box_outline_blank</v-icon>
            <v-icon color="grey darken-3" medium>playlist_add</v-icon>
            <v-icon color="grey darken-3" >delete</v-icon>
    </v-layout>
        <v-layout justify-center row wrap>
        <v-flex
        v-for= "(word, i) in words"
        :key="(word, i)"
        v-bind="{ [`xs${words.flex}`]: true }"
        md2
        >
        <v-card color="blue-grey lighten-4">
        <v-card-text>
        <v-layout justify-end>
            <v-icon color="grey darken-3">check_box_outline_blank</v-icon>
            <v-spacer></v-spacer>

            <!--start of like icon-->
            <v-icon v-if="word.memorized=='T'" id="memorized" color="red" v-on:click="changeHeart(i)">
            favorite
            </v-icon>

            <v-icon v-else id="memorized" color="red" v-on:click="changeHeart(i)">
            favorite_border
            </v-icon>

        </v-layout>
        </v-card-text>
            <v-container
            fill-height
            fluid
            pa-2
            text-xs-center
            >
            <v-layout  fill-height>
                <v-flex xs12 align-end flexbox>
                    <v-card
                    color="whtie"
                    >
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
    

    <!--words album-->
    <v-flex lg3 sm12 xs12>
        <v-card height="600px" color="deep-orange lighten-3">
        </v-card>
        </v-flex>
    </v-layout>
    </v-container>
</template>


    <script>
    import axios from 'axios'
    import { constants } from 'crypto';

    export default {

    data() {
        return {
        words: [],
        flex: 4,
        memorized:'',
        }
    },
    methods: {
        changeHeart(i) {
            console.log(this.words[i].memorized);
            if(this.words[i].memorized=="T"){
                this.words[i].memorized="F"    
            }else{
                this.words[i].memorized="T"
            }
        }
    },
    mounted() { 
        const baseURI = "http://172.26.1.52/api/book/0";
        axios.get(baseURI)
        .then((res)=>{
            this.words = res.data;
            console.log('ok',res);
        }).catch(error => {
            console.log('failed',error);
        })
    }
    }
    </script>

    <style  lang="css" scoped>
    #memorized {
        cursor: pointer;
    }
    </style>