<template>
  <div id="searchDiv">
     <div style="background:white">
       <input name="search" :placeholder="message"/>
     </div><!--
  --><div>
       <i class="fa fa-search"></i>
     </div>
  </div>
</template>

<script>
export default {
  data () {
    return {
      msg: "data"
    }
  },
  props:["message"],

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
   #searchDiv{
     display: inline-block;
     position: relative;
     text-align: right;
     width: 60%;
   }
   #searchDiv>div:first-of-type{
     box-sizing: border-box;
     height: 35px;
     width: 300px;
     border: solid 1px gainsboro;
     border-radius: 5px 0 0 5px;
     display: inline-block;
   }
   #searchDiv>div:nth-of-type(2){
     vertical-align: middle;
     width: 50px;
     text-align: center;
     line-height: 35px;
     height: 35px;
     border-radius: 0 5px 5px 0;
     display: inline-block;
     background-color: #188be9;
     color: white;
   }
   input{
     height: 100%;
     width: 90%;
     margin-left:5%;
     vertical-align: middle;
     outline: none;
     border: none;
   }
</style>
