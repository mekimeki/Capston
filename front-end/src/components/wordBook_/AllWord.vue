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
    <v-flex lg9 sm12 xs2 >
        <v-card xs12 sm6 md3 height="600px" color="cyan lighten-3">
            <v-layout v-for="i in 10" :key="i" justify-space-around>
                <v-btn
                xs1 sm1 md1
                large v-for="i in 5" 
                :key="i" 
                >
                <h3>
                BANANA
                </h3>
                </v-btn>
            </v-layout>
        </v-card>
    </v-flex>

    <!--words album-->
    <v-flex lg3 sm12 xs12>
        <v-card height="600px" color="deep-orange lighten-3">
        각종 현황
        </v-card>
    </v-flex>
    </v-layout>

    <div id="app">
    <h4>User</h4>
        <div>
            <table>
                <tr>
                    <th>Name</th>
                    <th>Select All<input type="checkbox" v-on:click="selectAll()" v-model="allSelected"></th>
                </tr>
                <tr v-for="user in users" :key="user">
                    <td>{{ user.name }}</td>
                    <td><input type="checkbox" v-model="userIds" v-on:click="select()" :value="user.id"></td>
                </tr>
            </table>
        </div>

        <span>Selected Ids: {{ userIds }}</span>
</div>
    </v-container>
</template>


<script>
export default {
    
    data() {
        return{
        el: '#app',
        users: [ 
            { "id": "Shad", "name": "Shad" }, 
            { "id": "Duane", "name": "Duane" }, 
            { "id": "Myah", "name": "Myah" }, 
            { "id": "Kamron", "name": "Kamron" }, 
            { "id": "Brendon", "name": "Brendon" }
        ],
        selected: [],
        allSelected: false,
        userIds: []
        }
    },
    methods: {
        selectAll() {
            this.userIds = [];

            if (this.allSelected) {
                for (user in this.users) {
                    this.userIds.push(user[name].toString());
                }
            }
        },
        select() {
            this.allSelected = false;
        }
    }

}

</script>
