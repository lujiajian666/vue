<template>
  <div id="index">
     <head-div></head-div>
     <float-right-div></float-right-div>
     <router-view>
     </router-view>
     <foot-div></foot-div>
  </div>
</template>

<script>
import head from '@/components/head';
import floatRightDiv from '@/components/floatRightDiv';
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
      "foot-div":footDiv
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
