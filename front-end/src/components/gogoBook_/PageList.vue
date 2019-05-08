<template>
<div class="pt-3">
    <v-flex class="pl-5 ml-2" white xs12 sm12 md12>
        <div>
            <ul id="gnb">
                <li v-for="category in categories" :key="category" v-bind:value="category.value"><a href="#">{{ category.menu }}</a>|</li>
            </ul>
        </div>
    </v-flex>

    <table>
        <tr>
            <th>앨범명</th>
            <th>
                <v-icon color="red">favorite</v-icon>
            </th>
            <th>
                <v-icon color="black">remove_red_eye</v-icon>
            </th>
            <th>게시일</th>
        </tr>
        <tr v-for="p in paginatedData" :key="p.no">
            <td width="20%">{{ p.tel }}</td>
            <td width="10%">{{ p.address }}</td>
            <td width="15%">{{ p.name }}</td>
            <td width="15%">{{ p.name }}</td>
        </tr>
    </table>

    <div class="btn-cover">
        <v-btn :disabled="pageNum === 0" @click="prevPage" class="page-btn">
            이전
        </v-btn>
        <span class="page-count">{{ pageNum + 1 }} / {{ pageCount }} 페이지</span>
        <v-btn :disabled="pageNum >= pageCount - 1" @click="nextPage" class="page-btn">
            다음
        </v-btn>
    </div>

</div>
</template>

<script>
export default {
    name: 'paginated-list',
    data() {
        return {
            categories: [{
                    menu: '전체',
                    value: 'all'
                },
                {
                    menu: '판타지',
                    value: '1'
                },
                {
                    menu: 'SF',
                    value: '2'
                },
                {
                    menu: '공포',
                    value: '3'
                },
                {
                    menu: '스릴러',
                    value: '4'
                },
                {
                    menu: '코미디',
                    value: '5'
                },
                {
                    menu: '멜로',
                    value: '6'
                },
                {
                    menu: '애니메이션',
                    value: '7'
                },
                {
                    menu: '그외',
                    value: '8'
                }
            ],
            pageNum: 0,
            bottomNav: "all",
        }
    },
    props: {
        listArray: {
            type: Array,
            required: true
        },
        pageSize: {
            type: Number,
            required: false,
            default: 10
        }
    },
    methods: {
        nextPage() {
            this.pageNum += 1;
        },
        prevPage() {
            this.pageNum -= 1;
        }
    },
    computed: {
        pageCount() {
            let listLeng = this.listArray.length,
                listSize = this.pageSize,
                page = Math.floor(listLeng / listSize);
            if (listLeng % listSize > 0) page += 1;

            /*
            아니면 page = Math.floor((listLeng - 1) / listSize) + 1;
            이런식으로 if 문 없이 고칠 수도 있다!
            */
            return page;
        },
        paginatedData() {
            const start = this.pageNum * this.pageSize,
                end = start + this.pageSize;
            return this.listArray.slice(start, end);
        }
    }
}
</script>

<style>
li {
    list-style-type: none;
}

/* gnb 아래 하위선택자 */
#gnb li {
    display: inline;
}

#gnb li a {
    display: inline-block;
    background: #fff;
    color: black;
    width: 120px;
    height: 23px;
    padding-top: 1%;
    padding-bottom: 2.4%;
    text-align: center;
    text-decoration: none;
}

#gnb li a:hover {
    background: #ECEFF1;
    color: #000000;
    font-size: 1rem;
    font-weight: 600;
    text-decoration: none;
}
/* start of table css*/
table {
    width: 90%;
    border-collapse: collapse;
    margin-left: auto;
    margin-right: auto;
}

table th {
    font-size: 1.2rem;
}

table tr {
    height: 2.5rem;
    text-align: center;
    border-bottom: 1px solid #505050;
}

table tr:first-of-type {
    border-top: 2px solid #030303;
    border-bottom: 2px solid #030303;
}

table tr td {
    padding: 1rem 0;
    font-size: 1.1rem;
}

.btn-cover {
    margin-top: 1.5rem;
    text-align: center;
}

.btn-cover .page-btn {
    width: 5rem;
    height: 2rem;
    letter-spacing: 0.5px;
}

.btn-cover .page-count {
    padding: 0 1rem;
}
</style>
