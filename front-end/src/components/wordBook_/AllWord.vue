<template>
<v-container fluid :grid-list-md="!$vuetify.breakpoint.xs">
    <v-layout wrap row>
    <v-toolbar color="white" >
        <v-toolbar-items>
        <v-btn flat>전체 단어</v-btn>
        <v-btn flat>암기 단어</v-btn>
        <v-btn flat>미암기 단어</v-btn>
        </v-toolbar-items>
    </v-toolbar>

    <!--words select-->
    <v-flex xs12 sm12 class="pb-2">
        <v-layout>
            <v-card-text><h2>전체단어</h2></v-card-text>
            <v-card-text>
            <v-layout justify-end>
            <v-icon color="gray darken-2">video_call</v-icon>
            <v-icon color="gray darken-2">notifications</v-icon>
            <v-icon color="gray darken-2">account_circle</v-icon>
            </v-layout>
            </v-card-text>
        </v-layout>
    </v-flex>
    
    <!--words button-->
    <v-flex lg9 sm12 xs2 row wrap >
        <v-container
        fluid
        grid-list-md
    >
        <v-layout justify-center row wrap>
        <v-flex
            v-for= "word in words"
            :key="word"
            v-bind="{ [`xs${words.flex}`]: true }"
            md2
        >
            <v-card color="red">
            <v-card-text>
            <v-layout justify-end>
            <v-icon color="gray darken-2">video_call</v-icon>
            <v-spacer></v-spacer>
            <v-icon color="gray darken-2">notifications</v-icon>
            <v-icon color="gray darken-2">account_circle</v-icon>
            </v-layout>
            </v-card-text>
                <v-container
                fill-height
                fluid
                pa-2
                text-xs-center
                >
                <v-layout fill-height>
                    <v-flex xs12 align-end flexbox>
                        <v-card 
                        class="headline black--text">
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
        a: 0,
        }
    },
    mounted() { 
        const baseURI = "http://172.26.2.146/api/show";
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
