<template lang="html">
<div>
    <header_></header_>
    <allWord_></allWord_>
</div>
</template>

<script>
import header_ from '@/components/mainPage_/Header';
import allWord_ from '@/components/wordBook_/AllWord';

export default {
components:{
    header_,
    allWord_,
},
data(){
    return{
    }
},
}
</script>

<style lang="css" scoped>
.container{
    max-width: 82%
}
</style>
