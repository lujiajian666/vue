<template>
  <div id="headTop">
    <div style="display: inline-block;text-align: right;line-height: 100px;width: 20%">
      中小企业政务管理平台
    </div><!--
 --><search-div message="请输入你想要的内容"></search-div><!--
 --><div style="display: inline-block;width: 20%;
                vertical-align: middle;box-sizing: border-box;padding-left: 10px">
         <i class="fa fa-user" style="color: #188be9;font-size: 17.5px;vertical-align: sub"></i>
         <span style="font-size: 12px;line-height: 17px;display: inline-block">用户中心</span><br>
         <span style="font-size: 12px;line-height: 17px;display: inline-block">登录/注册</span>
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
  #headTop{
    text-align: left;
    height: 100px;
    background-color: white;
    position: relative;
  }
</style>
