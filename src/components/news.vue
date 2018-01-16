<template>
  <div id="news">
     <foot-div></foot-div>
  </div>
</template>

<script>
import footDiv from "./foot-div";
export default {
  name: 'news',
  data () {
    return {
      msg: "data"
    }
  },
  components:{
      "head-div":head,
      "float-right-div":floatRightDiv,
      "content-div":contentDiv,
      "foot-div":footDiv
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
