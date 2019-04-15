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
            <v-card-text><h3>전체단어</h3></v-card-text>
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
            v-for="card in cards"
            :key="card.word"
            v-bind="{ [`xs${card.flex}`]: true }"
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
                        
                        <v-card class="headline black--text" v-text="card.word"></v-card>
                        <v-card class="headline black--text" v-text="card.mean"></v-card>
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
export default {
    
data() {
    return {
    cards: [
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    { word: 'Banana', mean: '바나나', flex: 4 },
    ]
}
}
    

}

</script>
