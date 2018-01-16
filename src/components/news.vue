<template>
  <div id="news">
    <head-div></head-div>
    <div id="content">
      <div class="title">
        <h1>这是公告一</h1>
      </div>
      <div class="article">
        这是公告一的内容这是公告一的内容这是公告一的内容这是公告一的内容这是公告一的内容
        这是公告一的内容这是公告一的内容这是公告一的内容这是公告一的内容这是公告一的内容
        这是公告一的内容这是公告一的内容这是公告一的内容这是公告一的内容这是公告一的内容
        这是公告一的内容这是公告一的内容这是公告一的内容这是公告一的内容这是公告一的内容
        这是公告一的内容这是公告一的内容这是公告一的内容这是公告一的内容这是公告一的内容
        这是公告一的内容这是公告一的内容这是公告一的内容这是公告一的内容这是公告一的内容
      </div>
      <time>2017年1月1日</time>
    </div>
    <foot-div></foot-div>
  </div>
</template>

<script>
  import head from "./HeadTop"
  import footDiv from "./foot-div";

  export default {
    name: 'news',
    data() {
      return {
        msg: "data"
      }
    },
    components: {
      "head-div": head,
      "foot-div": footDiv
    },
    created:function () {
       //ljj 在此根据id查询具体新闻,公告($route.query.id)
    }

  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
   #content{
     backgrou
     min-height: 500px;
     &>.title{
       text-align: center;
       margin:30px auto 50px auto;
     }
     &>.article{
       width: 90%;
       margin: auto;
       text-align: left;
       text-indent: 2em;
     }
   }
   time{
      text-align: right;
      display: block;
      width: 90%;
      margin:50px auto;
   }
</style>
