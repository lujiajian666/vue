<template>
  <div id="index">
    <div class="content">
      <div id="myChart"  class="myChart" style="width: calc(50% - 25px);height: 400px;"></div>
      <div id="myChart2" class="myChart" style="width: calc(50% - 25px);height: 400px;"></div>
      <div id="myChart3" class="myChart" style="width: calc(50% - 25px);height: 400px;"></div>
    </div>
  </div>
</template>

<script>
  import head from '@/components/head';
  import floatRightDiv from '@/components/floatRightDiv';
  import footDiv from "./foot-div";

  export default {
    name: 'index',
    data() {
      return {
        msg: "data"
      }
    },
    components: {
      "head-div": head,
      "float-right-div": floatRightDiv,
      "foot-div": footDiv
    },
    mounted(){
      this.drawLine()
    },
    methods:{
      drawLine(){
      // 基于准备好的dom，初始化echarts实例
      let myChart  = this.$echarts.init(document.getElementById('myChart'));
      let myChart2 = this.$echarts.init(document.getElementById('myChart2'));
      let myChart3 = this.$echarts.init(document.getElementById('myChart3'));
      // 绘制图表
      myChart.setOption({
        title: {text: '第一季度营业额度（单位：千万）'},
        tooltip: {},
        xAxis: {
          data: ["软件部", "饮食部", "建筑部", "培训部", "服装部", "小卖部"]
        },
        yAxis: {},
        series: [{
          name: '净利润',
          type: 'bar',
          data: [5, 20, 36, 10, 10, 20]
        }]
      });
      myChart2.setOption({
          title: {text: '第二季度营业额度（单位：千万）'},
          tooltip: {},
          xAxis: {
            data: ["软件部", "饮食部", "建筑部", "培训部", "服装部", "小卖部"]
          },
          yAxis: {},
          series: [{
            name: '净利润',
            type: 'bar',
            data: [20, 36, 10, 10, 20,7]
          }]
        });
      myChart3.setOption({
          title: {text: '第三季度营业额度（单位：千万）'},
          tooltip: {},
          xAxis: {
            data: ["软件部", "饮食部", "建筑部", "培训部", "服装部", "小卖部"]
          },
          yAxis: {},
          series: [{
            name: '净利润',
            type: 'bar',
            data: [5,68, 36, 4, 10, 17]
          }]
        });
    }
    }
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
  .content{
    overflow: hidden;
    & >.myChart {


       margin: 30px auto;
       padding: 20px;
       box-sizing: border-box;
       float: left;
     }
  }
</style>
