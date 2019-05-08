<template>
<v-container>
    <v-layout py-4 wrap row>
        <v-flex pl-4 ml-5 pb-4 mt-4 xs12 sm12 md12>
            <span><div class="title">・ GOGO 추천집</div></span>
        </v-flex>
        <!-- <v-flex pt-4 mt-3 pr-5 xs6 sm6 md2>
            <v-select style="width:85%" :items="items" box label="정렬"></v-select>
        </v-flex> -->
        <v-flex xs12 sm12>
            <paginated-list :list-array="pageArray" />
        </v-flex>
    </v-layout>
</v-container>
</template>

<script>
import axios from 'axios'
import PaginatedList from './PageList'
export default {
    name: 'simple-pagination',
    components: {
        PaginatedList
    },
    data() {
        return {
            pageArray: [],
            items: ['좋아요수','조회수']
        }
    },
    created() {
        axios.get('http://sample.bmaster.kro.kr/contacts')
            .then(response => {
                console.log(response);
                this.pageArray = response.data.contacts;
            })
            .catch(err => {
                console.log(err);
            });
    }
}
</script>

<style>
.title {
    color: #454545;
    text-align: left;
    font-size: 1.6rem;
    font-weight: 600;
}
</style>
