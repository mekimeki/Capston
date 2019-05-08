<template>
  <div id="app">
    <div class="container">
      <div class="Chart__list">
        <div class="Chart">
          <h2>Linechart</h2>
          <line-example :chartdata="datacollection" :options="options"></line-example>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import LineExample from '@/components/myPage_/LineChart.js'
export default {
  name: 'app',
  components: {
    LineExample
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
.container {
  margin:  0 ;
}
</style>
