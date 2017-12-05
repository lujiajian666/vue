<template>
  <div id="index">
     <head-div select="two"></head-div>
     <float-right-div></float-right-div>
     <content-div></content-div>
     <foot-div></foot-div>
  </div>
</template>

<script>
import head from '@/components/head';
import floatRightDiv from '@/components/floatRightDiv';
import contentDiv from "./content-div"
import footDiv from "./foot-div";
export default {
  name: 'index',
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
