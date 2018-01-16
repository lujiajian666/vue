<template>
  <div id="indexContent">
      <div class="left">
        <div class="topDiv" :class="{select:isSelectOne}" @mouseenter="changeSelect1">
          今日关注
        </div><!--
     --><div class="topDiv" :class="{select:isSelectTwo}" @mouseenter="changeSelect2">
          活动新闻
        </div>
        <div style="position: relative">
            <transition name="select">
                <ul class="selectOne" v-if="isSelectOne" style="width: 100%">
                    <li>
                        <ul class="imgShow" data-not-ul>
                            <router-link tag="li" :to="{name:'news'}" v-if="nowImagePoint==0">
                                <img src="/static/image/2.jpg"/>
                                <div class="item" >
                                  <p class="title limitSingleRow">看病正他妈贵看病正他妈贵看病正他妈贵</p>
                                  <p class="word limit" data-max="20">这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？</p>
                                  <p class="time">2017-5-6</p>
                                </div>
                            </router-link>
                            <router-link tag="li" :to="{name:'news'}" v-if="nowImagePoint==1">
                                <img src="/static/image/3.jpg"/>
                                <div class="item">
                                    <p class="title limitSingleRow">看病正他妈贵看病正他妈贵看病正他妈贵</p>
                                    <p class="word limit" data-max="20">这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？</p>
                                    <p class="time">2017-5-6</p>
                                </div>
                            </router-link>
                            <router-link tag="li" :to="{name:'news'}" v-if="nowImagePoint==2">
                                <img src="/static/image/4.jpg"/>
                                <div class="item">
                                    <p class="title limitSingleRow">看病正他妈贵看病正他妈贵看病正他妈贵</p>
                                    <p class="word limit" data-max="20">这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？这里看病有多贵？</p>
                                    <p class="time">2017-5-6</p>
                                </div>
                            </router-link>
                        </ul>
                        <ul class="imgPoint" data-not-ul>
                            <li><i class="fa fa-circle"
                                   :class="{selectPoint:nowImagePoint==0}"
                                   @click="changeImagePoint(0)"
                                   @mouseover="imagePointOver"
                                   @mouseleave="imagePointLeave">
                            </i></li><!--
                         --><li><i class="fa fa-circle"
                                   :class="{selectPoint:nowImagePoint==1}"
                                   @click="changeImagePoint(1)"
                                   @mouseover="imagePointOver"
                                   @mouseleave="imagePointLeave">
                            </i></li><!--
                         --><li><i class="fa fa-circle"
                                   :class="{selectPoint:nowImagePoint==2}"
                                   @click="changeImagePoint(2)"
                                   @mouseover="imagePointOver"
                                   @mouseleave="imagePointLeave">
                            </i></li>
                        </ul>
                    </li>
                    <router-link :to="{name:'news',query:{id:1}}" tag="li">
                        <div class="item">
                            <p class="word limit" data-max="20">这里看病有多贵？？？</p>
                            <p class="time">2017-5-6</p>
                        </div>
                    </router-link>
                    <router-link :to="{name:'news',query:{id:2}}" tag="li">
                        <div class="item">
                            <p class="word limit" data-max="20">这里看病有多贵？？？</p>
                            <p class="time">2017-5-6</p>
                        </div>
                    </router-link>
                    <router-link :to="{name:'news',query:{id:3}}" tag="li">
                        <div class="item">
                            <p class="word limit" data-max="20">这里看病有多贵？？？</p>
                            <p class="time">2017-5-6</p>
                        </div>
                    </router-link>
                    <router-link :to="{name:'news',query:{id:4}}" tag="li">
                        <div class="item">
                            <p class="word limit" data-max="20">这里看病有多贵？？？</p>
                            <p class="time">2017-5-6</p>
                        </div>
                    </router-link>
                </ul>
            </transition>
            <transition name="select">
                <ul class="selectTwo" v-if="isSelectTwo" style="width: 100%">
                    <router-link :to="{name:'news'}" tag="li">
                        <div class="item">
                            <div class="imgItem">
                                <img src="/static/image/1.jpg" style="height: 100px"/>
                            </div><!--
                  --><div class="wordItem">
                            <p class="limit">《浙江省人民政府办公厅关于调整完善户口迁移政策的通知</p>
                            <p class="time">2017-2-6</p>
                        </div>
                        </div>
                    </router-link>
                    <router-link :to="{name:'news'}" tag="li">
                        <div class="item">
                            <div class="imgItem">
                                <img src="/static/image/1.jpg" style="height: 100px" />
                            </div><!--
                  --><div class="wordItem">
                            <p class="limit">《浙江省人民政府办公厅关于调整完善户口迁移政策的通知《浙江省人民政府办公厅关于调整完善户口迁移政策的通知《浙江省人民政府办公厅关于调整完善户口迁移政策的通知</p>
                            <p class="time">2017-2-6</p>
                        </div>
                        </div>
                    </router-link>
                </ul>
            </transition>
        </div>
      </div><!--
   --><div class="right">
          <div class="title">热点服务</div>
          <div style="height: 500px;text-align: left;position: relative;overflow: hidden">
              <i class="fa  fa-chevron-circle-left"
                 @click="rightItemLeft"></i>
              <i class="fa  fa-chevron-circle-right"
                 @click="rightItemRight"></i>
              <transition name="rightItem">
                  <div v-show="rightShowNum==0" class="outerRightItem">
                      <router-link tag="div" :to="{name:'news'}" class="rightItem"  v-for="a in rightItem[0]" >
                          <img src="http://www.zjzwfw.gov.cn/picture/0/s1709211818156878798.png">
                          <p>高级职称评审与专技考试</p>
                      </router-link>
                  </div>
              </transition>
              <transition name="rightItem">
                  <div v-show="rightShowNum==1" class="outerRightItem">
                      <router-link tag="div" :to="{name:'news'}" class="rightItem"  v-for="a in rightItem[1]">
                         <img src="http://www.zjzwfw.gov.cn/picture/0/s1705181041271102553.png">
                         <p>工商全程电子化登记平台</p>
                      </router-link>
                  </div>
              </transition>
              <transition name="rightItem">
                  <div v-show="rightShowNum==2" class="outerRightItem">
                      <router-link tag="div" :to="{name:'news'}" class="rightItem"  v-for="a in rightItem[2]">
                          <img src="http://www.zjzwfw.gov.cn/picture/94/4a08ac6b8ca5498193288d2d9923a146.png">
                          <p>结婚登记预约</p>
                      </router-link>
                  </div>
              </transition>

          </div>
      </div>
  </div>
</template>

<script>
export default {
  name: 'content-div',
  data () {
    return {
      isSelectOne:true,
      isSelectTwo:false,
      nowImagePoint:0,
      rightItem:[[1,2,3,4,5,6,7,8,9],[1,2,3,4,5,6,7],[1,2,4,5,6,7,8,910,1,1]],
      rightShowNum:0
    }
  },
  methods:{
      "changeSelect1":function () {
          this.isSelectOne=true;
          this.isSelectTwo=false;
      },
      "changeSelect2":function () {
          this.isSelectTwo=true;
          this.isSelectOne=false;
      },
      "left":function () {
          if((this.nowImagePoint+1)>=3){
              this.nowImagePoint=0;
          }else{
              this.nowImagePoint++;
          }
      },
      "changeImagePoint":function (val) {
          this.nowImagePoint=val
      },
      "imagePointOver":function () {
          clearInterval(window.times)
      },
      "imagePointLeave":function () {
          window.times=setInterval(this.left,2000)
      },
      "rightItemLeft":function () {
          if(this.rightShowNum-1<0){
              return;
          }else{
              this.rightShowNum--;
          }
      },
      "rightItemRight":function () {
          if(this.rightShowNum+1>2){
              return;
          }else{
              this.rightShowNum++;
          }
      }
  },
  watch:{
//      nowImagePoint:function (val) {
//
//      }
  },
  updated (){
      //ljj 限制limit类的字数
      $(".limit").each(function () {
          var _self=$(this)
          var maxLength=_self.data("max")
          if(maxLength=="" || maxLength=="undefined" ||maxLength==undefined){
              maxLength=30
          }
          var text=_self.text()

          if(text.length>maxLength){
              _self.text(text.slice(0,maxLength)+"...")
          }


      })
  },
  mounted (){
      //ljj 限制limit类的字数
      $(".limit").each(function () {
          var _self=$(this)
          var maxLength=_self.data("max")
          if(maxLength=="" || maxLength=="undefined" ||maxLength==undefined){
              maxLength=30
          }
          var text=_self.text()

          if(text.length>maxLength){
              _self.text(text.slice(0,maxLength)+"...")
          }
      })
      //ljj 轮播
      window.times=setInterval(this.left,2000)
  },


}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
   .outerRightItem{
       position: absolute;
       left: 0;
       right: 0;
       top: 0;
       cursor: pointer;
   }
   .fa-chevron-circle-left{
       position: absolute;
       left: 10px;
       top: 50%;
       transform: translateY(-50%);
       font-size: 50px;
       opacity: 0.1;
       transition: all .6s;
   }
   .fa-chevron-circle-right{
       position: absolute;
       right: 10px;
       top: 50%;
       transform: translateY(-50%);
       font-size: 50px;
       opacity: 0.1;
       transition: all .6s;
   }
   .fa-chevron-circle-left:hover,.fa-chevron-circle-right:hover{
       opacity: 1;
   }
   .rightItem{
       display: inline-block;
       box-sizing: border-box;
       text-align: center;
       width: 20%;
       padding: 5px;
   }
   .rightItem>img{
       display: block;
       margin: auto;
   }
   .rightItem>p{
     font-size: 14px;
   }
   #indexContent>.left{
       display: inline-block;
       width:30%;border: 1px solid #eaeaeb;
       box-sizing: border-box;vertical-align: top
   }
   #indexContent>.right{
       display: inline-block;
       width:65%;margin-left:5%;
       background-color: white;vertical-align: top
   }
   #indexContent>.right>.title{
       line-height: 50px;
       text-align: left;padding-left: 20px;
       position: relative;
       color: #188be9;
       border-bottom: 1px solid #e2e2e2;
   }
   #indexContent>.right>.title:after{
       content: '';
       position: absolute;
       bottom: -1px;
       left: 0;
       width: 100px;
       border-bottom:2px solid #188be9;
   }
  .selectPoint{
      color: black;
  }
  .imgPoint{
      position: absolute;
      right: 20px;
      top:100px;
      font-size: 20px;
      width: 100px;
      cursor: pointer;
  }
  .imgPoint>li{
      float: left;
      width: 30px;
      color: white;
  }
  .item>.title{
      color: #1e72e3;
      width: 80%;
      margin: auto;
      line-height: 25px;
      font-size: 15px;
      font-weight: bold;
      position: absolute;
      top: 126px;
      left: 0;
      right: 0;
  }
  .imgShow{
      width: 100%;
      height: 116px;
      overflow: hidden;
  }
   /*ljj rightItem动画*/
   .rightItem-enter{
       opacity: 0;
       transform: translateX(668px);
   }
   .rightItem-enter-active{
       transition: all 1s;
   }
   .rightItem-leave{

   }
   .rightItem-leave-active{
       transition: all 1s;
       transform: translateX(-668px);
       opacity: 0;

   }
   /*ljj rightItem动画end*/
   /*ljj 右侧动画*/
  .select-enter{
      opacity: 0;
  }
  .select-enter-active{
      transition: all 0.3s;
  }
  .select-leave{
      opacity: 1;
  }
  .select-leave-active{
      transition: all 0.3s;
      opacity: 0;
  }
   /*ljj 右侧动画end*/
  .select{
      background-color: white;
  }
  .topDiv{
      display:inline-block;width: 50%;text-align: center;line-height:50px;
  }
  ul{
      list-style: none;
  }
  ul[data-not-ul]>li{
      height: 100%;
  }
  ul[data-not-ul]>li>img{
      height: 100%;
      width: 100%;
  }
  ul:not([data-not-ul]){
      list-style: none;
      background-color: white;
      position: absolute;
      top:0;
      left: 0;
      right: 0;
  }
  .selectOne>li{
      height: 50px;
      padding:10px 20px 10px 20px;
      position: relative;
      border-bottom: 1px solid #f2f2f2;
  }
  .selectOne>li:first-of-type{
      height: 200px;
  }
  .selectOne>li:first-of-type .word{
      color: #188be9;
      top: 151px;
      font-size: 14px;
  }
  .selectTwo>li:first-of-type {
      padding-top: 20px;
  }
  .selectTwo>li{
      height: 100px;
      padding:10px 20px 10px 20px;
      position: relative;
  }
  .word{
      position: absolute;
      bottom: 20px;
      top:10px;
      left: 20px;
      right: 20px;
      text-align: left;
      word-break: break-all;
      font-size: 14px;
      overflow: hidden;
  }
  .time{
      position: absolute;
      bottom: 10px;
      right: 10px;
      height: 10px;
      color: #a9a9a9;
      font-size: 12px;
      text-align: right;
  }
  #indexContent{
      background-color: #f2f2f2;
      padding: 30px 10% 50px 10%;
      height: 550px;
  }
  .imgItem{
      display: inline-block;
      width: 50%;
      height: 100px;
      vertical-align: top;
  }
  .wordItem{
      display: inline-block;
      width: 50%;
      height: 100px;
      overflow: hidden;
      font-size: 12px;
      word-break: break-all;
      text-align: left;
  }
  .limit{
      height: 80px;overflow: hidden;
  }
</style>
