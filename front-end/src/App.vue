<template>
  <div id="app">
    <h1>Main</h1>
    <router-link to="video">video</router-link>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: 'app',
  components: {
  },
  created:function(){
    console.log(this.$store.state.counter);//vuex check
  }
}
</script>

<style>
</style>
