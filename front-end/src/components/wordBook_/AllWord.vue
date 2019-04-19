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
    <v-layout v-model="box" justify-end>
        <v-card-text><h3><li>전체단어</li></h3></v-card-text>
            <v-checkbox v-if="box==true" color="grey darken-3"></v-checkbox>
            <v-icon color="grey darken-3" medium>playlist_add</v-icon>
            <v-icon color="grey darken-3" v-on:click="click()">delete</v-icon>
    </v-layout>
        <v-layout justify-center row wrap>
        <v-flex
        v-for= "(word, i) in words"
        :key="(word, i)"
        v-bind="{ [`xs${words.flex}`]: true }"
        md2
        >
        <v-card color="blue-grey lighten-4">
        <v-card-text style="padding: 5px 10px">
        <v-layout justify-end>
            <v-checkbox height="1px" v-if="box==true" color="grey darken-3"></v-checkbox>

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
            fill-heights
            fluid
            pa-2
            text-xs-center
            >
            <v-layout fill-height>
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
    <v-flex lg3 sm12 xs12 pa-4>
        <v-card height="500px" color="white">
            <v-layout pa-4>
            <v-text-field
            label="제목"
            solo
            outline
            ></v-text-field>
            <v-spacer></v-spacer>
        <div><v-icon x-large color="grey darken-3">create_new_folder</v-icon></div>
        </v-layout>
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
        box: false,
        deletedWord: [],
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
        },
        deleteQuest() {
            var form = new FormData();
            form.append("deleteWord", this.deletedWord);
            axios.get('http://172.26.1.97/get-token').then( response =>{
                if(response.data){
                    form.append("_token",reponse.data);
                    axios.post('http://172.26.2.104/api/deletedWord', form)
                .then( response =>{
                    console.log('respnse', ok)
                }).catch(error => {
                    console.log('failed',error)
                })
                }
            })
        },
        click() {
            if(this.box == false){
                this.box = true;
            }else{
                
            }


        }
    },

    mounted() { 
        const baseURI = "http://172.26.2.104/api/book/0";
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