<template>
  <div id="footDiv">
      <div style="margin: auto;font-size: 13px">
          <a>把本站设为首页</a>&nbsp;&nbsp;&nbsp;
          |
          &nbsp;&nbsp;&nbsp;<a>关于浙江政务服务网</a>&nbsp;&nbsp;&nbsp;
          |
          &nbsp;&nbsp;&nbsp;<a>本站声明</a>&nbsp;&nbsp;&nbsp;
          |
          &nbsp;&nbsp;&nbsp;<a>新手指南</a>&nbsp;&nbsp;&nbsp;
          |
          &nbsp;&nbsp;&nbsp;<a>联系我们</a><br><br><br>
          <a>华南师范大学软件学院14级陆家键毕业设计</a>
      </div>
  </div>
</template>

<script>
export default {
  name: 'footDiv',
  data () {
    return {
      msg: "data"
    }
  },

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
    @color:#e5e5e5;
    #footDiv{
        background-color:@color;
        height: 200px;
        display: flex;
    }
</style>
