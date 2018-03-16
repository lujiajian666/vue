<template>
  <div id="headTop">
    <div style="display: inline-block;text-align: right;line-height: 100px;width: 20%">
      <router-link to="/">
       中小企业政务管理平台
      </router-link>
    </div><!--
 --><search-div message="请输入你想要的内容"></search-div><!--
 --><div style="display: inline-block;width: 20%;
                vertical-align: middle;box-sizing: border-box;padding-left: 10px">
         <router-link to="/background" tag="i" class="fa fa-user" style="color: #188be9;font-size: 17.5px;vertical-align: sub"></router-link>
         <router-link to="/background" tag="span" style="font-size: 12px;line-height: 17px;display: inline-block">后台入口</router-link><br>
         <router-link to="/background" tag="span" style="font-size: 12px;line-height: 17px;display: inline-block">登录/注册</router-link>
    </div>
  </div>
</template>

<script>
$(".fa-user").click(function () {
    alert("Hello")
})
import searchDiv from "./searchDiv";
export default {
//  name:"HeadTop",
  data () {
    return {
      msg: "data"
    }
  },
  components:{
      "search-div":searchDiv
  },
  methods:{
     alert:function (a) {
         alert(a)
     }
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  a:visited,a:link,a:hover,a:active{
    text-decoration: none;
    color: black;
  }
  #headTop{
    text-align: left;
    height: 100px;
    background-color: white;
    position: relative;
  }
</style>
