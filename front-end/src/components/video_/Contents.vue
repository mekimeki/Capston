<template lang="html">
  <div class="pa-3" id="scroll_div">
    <v-textarea
      outline
      name="input-7-4"
      label="Outline textarea"
    >
    </v-textarea>
  </div>
</template>

<script>
export default {
  data(){
    return{

    }
  }
}
</script>

<style lang="css" scoped>
#scroll_div{
  overflow: scroll;
  height:500px;
}
</style>
