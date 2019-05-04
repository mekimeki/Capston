<template>
<v-container>
    <v-layout wrap row>
        <v-flex pl-3 pt-5 pb-4 xs12 sm12>
            <span><li class="title">GOGO 추천집</li></span>
        </v-flex>
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
            pageArray: []
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
