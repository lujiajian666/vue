<template>
  <div id="indexContent">
    <div class="left">
      <div class="topDiv" :class="{select:isSelectOne}" @mouseenter="changeSelect1">
        今日关注
      </div>
      <div class="topDiv" :class="{select:isSelectTwo}" @mouseenter="changeSelect2">
        活动新闻
      </div>
      <div style="position: relative">
        <transition name="select">
          <ul class="selectOne" v-if="isSelectOne" style="width: 100%">
            <li>
              <ul class="imgShow" data-not-ul>
                <router-link tag="li" v-for="(item,index) in todayFocus" :key="index"
                  :to="{name:'news',query:{id:item.article_id}}" v-if="nowImagePoint==index">
                  <img :src="item.src==''?'./static/image/no_data.jpeg':$store.state.imgUrl+item.src" />
                  <div class="item">
                    <p class="title limitSingleRow">{{item.title}}</p>
                    <p class="word limit" data-max="20">{{item.content}}</p>
                    <p class="time">{{timeHandle.format('Y-m-d',item.time)}}</p>
                  </div>
                </router-link>
              </ul>
              <ul class="imgPoint" data-not-ul>
                <li v-for="(item,index) in todayFocus" :key="index">
                  <i class="fa fa-circle" :class="{selectPoint:nowImagePoint==index}" 
                  @click="changeImagePoint(index)" @mouseover="imagePointOver"
                    @mouseleave="imagePointLeave">
                  </i>
                </li>
              </ul>
            </li>
            <router-link :to="{name:'news',query:{id:item.article_id}}" tag="li"
            v-for="(item,index) in todayFocusAll" :key="index">
              <div class="item">
                <p class="word limit" data-max="20">{{item.title}}</p>
                <p class="time">{{timeHandle.format('Y-m-d',item.time)}}</p>
              </div>
            </router-link>
          </ul>
        </transition>
        <transition name="select">
          <ul class="selectTwo" v-if="isSelectTwo" style="width: 100%">
            <router-link :to="{name:'news',query:{id:item.article_id}}" tag="li" v-for="(item,index) in activityNews"
            :key="index">
              <div class="item">
                <div class="imgItem">
                  <img :src="item.src==''?'./static/image/no_data.jpeg':$store.state.imgUrl+item.src" style="width:90%;height:100%" />
                </div>
                <div class="wordItem">
                  <p class="limit">{{item.content}}</p>
                  <p class="time">{{timeHandle.format('Y-m-d',item.time)}}</p>
                </div>
              </div>
            </router-link>
          </ul>
        </transition>
      </div>
    </div>
    <div class="right">
      <div class="title">
        热点服务
      </div>
      <div style="height: 500px;text-align: left;position: relative;overflow: hidden">
        <i class="fa  fa-chevron-circle-left" @click="rightItemLeft"></i>
        <i class="fa  fa-chevron-circle-right" @click="rightItemRight"></i>
        <transition name="rightItem">
          <div v-show="rightShowNum==0" class="outerRightItem">
            <router-link tag="div" :to="{name:'news',query:{id:item.article_id}}" class="rightItem" 
            v-for="(item,index) in hotService" :key="index">
            <div style="display:flex;content-align:center;width:100%;height: 100px;">
                <img :src="item.src==''?'./static/image/no_data.jpeg':$store.state.imgUrl+item.src">
            </div>
              <p>高级职称评审与专技考试</p>
            </router-link>
          </div>
        </transition>
          <transition name="rightItem">
          <div v-show="rightShowNum==1" class="outerRightItem">
            <router-link tag="div" :to="{name:'news',query:{id:item.article_id}}" class="rightItem" 
            v-for="(item,index) in hotService" :key="index">
             <div style="display:flex;content-align:center;width:100%;height: 100px;">
              <img :src="item.src==''?'./static/image/no_data.jpeg':$store.state.imgUrl+item.src">
             </div>
              <p>高级职称评审与专技考试</p>
            </router-link>
          </div>
        </transition>
          <transition name="rightItem">
          <div v-show="rightShowNum==2" class="outerRightItem">
            <router-link tag="div" :to="{name:'news',query:{id:item.article_id}}" class="rightItem" 
            v-for="(item,index) in hotService" :key="index">
             <div style="display:flex;content-align:center;width:100%;height: 100px;">
              <img :src="item.src==''?'./static/image/no_data.jpeg':$store.state.imgUrl+item.src">
             </div>
              <p>高级职称评审与专技考试</p>
            </router-link>
          </div>
        </transition>

      </div>
    </div>
  </div>
</template>

<script>
  import { axiosHandle,timeHandle } from "../lib/utils";
  export default {
    name: 'content-div',
    data() {
      return {
        timeHandle:timeHandle,  
        isSelectOne: true,
        isSelectTwo: false,
        nowImagePoint: 0,
        todayFocus:[],
        todayFocusAll:[],
        hotService:[],
        activityNews:[],
        rightShowNum: 0
      }
    },
    methods: {
      "changeSelect1": function () {
        this.isSelectOne = true;
        this.isSelectTwo = false;
      },
      "changeSelect2": function () {
        this.isSelectTwo = true;
        this.isSelectOne = false;
      },
      "left": function () {  
        if ((this.nowImagePoint + 1) >= this.todayFocus.length) {
          this.nowImagePoint = 0;
        } else {
          this.nowImagePoint++;
        }
      },
      "changeImagePoint": function (val) {
        this.nowImagePoint = val
      },
      "imagePointOver": function () {
        clearInterval(window.times)
      },
      "imagePointLeave": function () {
        window.times = setInterval(this.left, 2000)
      },
      "rightItemLeft": function () {
        if (this.rightShowNum - 1 < 0) {
          return;
        } else {
          this.rightShowNum--;
        }
      },
      "rightItemRight": function () {
        if (this.rightShowNum + 1 > 2) {
          return;
        } else {
          this.rightShowNum++;
        }
      }
    },
    watch: {
      //      nowImagePoint:function (val) {
      //
      //      }
    },
    updated() {
      //ljj 限制limit类的字数
      $(".limit").each(function () {
        var _self = $(this)
        var maxLength = _self.data("max")
        if (maxLength == "" || maxLength == "undefined" || maxLength == undefined) {
          maxLength = 30
        }
        var text = _self.text()

        if (text.length > maxLength) {
          _self.text(text.slice(0, maxLength) + "...")
        }
      })
    },
    mounted() {
      //ljj 限制limit类的字数
      $(".limit").each(function () {
        var _self = $(this)
        var maxLength = _self.data("max")
        if (maxLength == "" || maxLength == "undefined" || maxLength == undefined) {
          maxLength = 30
        }
        var text = _self.text()

        if (text.length > maxLength) {
          _self.text(text.slice(0, maxLength) + "...")
        }
      })
      //ljj 轮播
      window.times = setInterval(this.left, 2000)
    },
    created(){
        var _self=this;
        axiosHandle.setThis(this);
        axiosHandle.post("index/Article/getArticle")
        .then(res=>{
             _self.todayFocus=res.data.todayFocus.slice(0,3);
             _self.todayFocusAll=res.data.todayFocus;
             _self.activityNews=res.data.activityNews;
             _self.hotService=res.data.hotService;
        })
    }
  }

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .outerRightItem {
    position: absolute;
    left: 0;
    right: 0;
    top: 0;
    cursor: pointer;
  }

  .fa-chevron-circle-left {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 50px;
    opacity: 0.1;
    transition: all .6s;
  }

  .fa-chevron-circle-right {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 50px;
    opacity: 0.1;
    transition: all .6s;
  }

  .fa-chevron-circle-left:hover,
  .fa-chevron-circle-right:hover {
    opacity: 1;
  }

  .rightItem {
    display: inline-block;
    box-sizing: border-box;
    text-align: center;
    width: 20%;
    padding: 5px;
  }

  .rightItem img {
    width: 100%;  
    display: block;
    margin: auto;
  }

  .rightItem>p {
    font-size: 14px;
  }

  #indexContent>.left {
    float: left;
    width: 30%;
    border: 1px solid #eaeaeb;
    box-sizing: border-box;
    vertical-align: top
  }

  #indexContent>.right {
    float: left;
    width: 65%;
    margin-left: 5%;
    background-color: white;
    vertical-align: top
  }

  #indexContent>.right>.title {
    line-height: 50px;
    text-align: left;
    padding-left: 20px;
    position: relative;
    color: #188be9;
    border-bottom: 1px solid #e2e2e2;
  }

  #indexContent>.right>.title:after {
    content: '';
    position: absolute;
    bottom: -1px;
    left: 0;
    width: 100px;
    border-bottom: 2px solid #188be9;
  }

  .selectPoint {
    color: black;
  }

  .imgPoint {
    position: absolute;
    right: 20px;
    top: 100px;
    font-size: 20px;
    width: 100px;
    cursor: pointer;
  }

  .imgPoint>li {
    float: left;
    width: 30px;
    color: white;
  }

  .item>.title {
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

  .imgShow {
    width: 100%;
    height: 116px;
    overflow: hidden;
  }

  /*ljj rightItem动画*/

  .rightItem-enter {
    opacity: 0;
    transform: translateX(668px);
  }

  .rightItem-enter-active {
    transition: all 1s;
  }
  .rightItem-leave-active {
    transition: all 1s;
    transform: translateX(-668px);
    opacity: 0;

  }

  /*ljj rightItem动画end*/

  /*ljj 右侧动画*/

  .select-enter {
    opacity: 0;
  }

  .select-enter-active {
    transition: all 0.3s;
  }

  .select-leave {
    opacity: 1;
  }

  .select-leave-active {
    transition: all 0.3s;
    opacity: 0;
  }

  /*ljj 右侧动画end*/

  .select {
    background-color: white;
  }

  .topDiv {
    float: left;
    width: 50%;
    text-align: center;
    line-height: 50px;
  }

  ul {
    list-style: none;
  }

  ul[data-not-ul]>li {
    height: 100%;
  }

  ul[data-not-ul]>li>img {
    height: 100%;
    width: 100%;
  }

  ul:not([data-not-ul]) {
    list-style: none;
    background-color: white;
    position: absolute;
    top: 50px;
    left: 0;
    right: 0;
  }

  .selectOne>li {
    height: 50px;
    padding: 10px 20px 10px 20px;
    position: relative;
    border-bottom: 1px solid #f2f2f2;
  }

  .selectOne>li:first-of-type {
    height: 200px;
  }

  .selectOne>li:first-of-type .word {
    color: #188be9;
    top: 151px;
    font-size: 14px;
  }

  .selectTwo>li:first-of-type {
    padding-top: 20px;
  }

  .selectTwo>li {
    height: 100px;
    padding: 10px 20px 10px 20px;
    position: relative;
  }

  .word {
    position: absolute;
    bottom: 20px;
    top: 10px;
    left: 20px;
    right: 20px;
    text-align: left;
    word-break: break-all;
    font-size: 14px;
    overflow: hidden;
  }

  .time {
    position: absolute;
    bottom: 10px;
    right: 10px;
    height: 10px;
    color: #a9a9a9;
    font-size: 12px;
    text-align: right;
  }

  #indexContent {
    background-color: #f2f2f2;
    padding: 30px 10% 50px 10%;
    height: 550px;
  }

  .imgItem {
    float:left;
    width: 40%;
    height: 100px;
    vertical-align: top;
  }

  .wordItem {
    float:left;
    width: 60%;
    height: 100px;
    overflow: hidden;
    font-size: 12px;
    word-break: break-all;
    text-align: left;
  }

  .limit {
    height: 80px;
    overflow: hidden;
  }

</style>
