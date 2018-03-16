<template>
  <div id="footDiv">
      <div style="margin: auto;font-size: 13px">
          <a>把本站设为首页</a>&nbsp;&nbsp;&nbsp;
          |
          &nbsp;&nbsp;&nbsp;<a href="http://www.zjzwfw.gov.cn">关于浙江政务服务网</a>&nbsp;&nbsp;&nbsp;
          |
          &nbsp;&nbsp;&nbsp; <router-link tag="a" :to="{name:'news',query:{id:webStatement.article_id}}" class="rightItem" 
          >本站声明</router-link>&nbsp;&nbsp;&nbsp;
          |
          &nbsp;&nbsp;&nbsp;<router-link tag="a" :to="{name:'news',query:{id:newPlayerDirection.article_id}}" class="rightItem" 
          >新手指南</router-link>&nbsp;&nbsp;&nbsp;
          |
          &nbsp;&nbsp;&nbsp;<router-link tag="a" :to="{name:'news',query:{id:aboutUs.article_id}}" class="rightItem" 
          >关于我们</router-link><br><br><br>
          <a>华南师范大学软件学院14级陆家键毕业设计</a>
      </div>
  </div>
</template>

<script>
import { axiosHandle } from "../lib/utils";
export default {
  name: 'footDiv',
  data () {
    return {
        webStatement:"",
        normalProblem:"",
        newPlayerDirection:"",
        aboutUs:""
    }
  },
  created(){
      var _self=this;
        axiosHandle.setThis(this);
        axiosHandle.post("index/Article/getArticleForFoot")
        .then(res=>{
           _self.webStatement=res.data.webStatement[0];
           _self.newPlayerDirection=res.data.newPlayerDirection[0];
           _self.aboutUs=res.data.aboutUs[0];
        })
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
    @color:#e5e5e5;
     a:link,a:visited,a:hover,a:active{
       color: black;
       text-decoration: none;
     }
    #footDiv{
        background-color:@color;
        height: 200px;
        display: flex;
    }
</style>
