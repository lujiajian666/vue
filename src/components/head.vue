<template>
  <div id="head">
    <head-Top></head-Top>
    <div id="item">
      <div id="itemBar">
        <div>
          <router-link tag="div" class="slide" :class="isSelect('one')"
                       @mouseenter.native="slideDown"
                       @mouseleave.native="slideOut"
                       to="/Hello">
            <i class="fa fa-bank red"></i>
            <p>人事查看</p>
            <i class="fa fa-bank"></i>
            <p>人事查看 </p>
          </router-link>
        </div>
        <div>
          <router-link tag="div" class="slide" :class="isSelect('two')"
                       @mouseenter.native="slideDown"
                       @mouseleave.native="slideOut"
                       to="/">
            <i class="fa fa-building red"></i>
            <p>公告通知</p>
            <i class="fa fa-building"></i>
            <p>公告通知 </p>
          </router-link>

        </div>
        <div>
          <router-link tag="div" class="slide" :class="isSelect('three')"
                       @mouseenter.native="slideDown"
                       @mouseleave.native="slideOut"
                       to="/charts">
            <i class="fa fa-codepen red"></i>
            <p>营运报表</p>
            <i class="fa fa-codepen"></i>
            <p>营运报表 </p>
          </router-link>
        </div>
        <div>
          <router-link tag="div" class="slide" v-bind:class="isSelect('four')"
                       v-on:mouseenter.native="slideDown"
                       v-on:mouseleave.native="slideOut"
                       to="/contact">
            <i class="fa fa-jsfiddle red"></i>
            <p>合作建议</p>
            <i class="fa fa-jsfiddle"></i>
            <p>合作建议 </p>
          </router-link>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
  import HeadTop from '@/components/HeadTop'

  export default {
    name: 'head',
    data() {
      return {
        msg: "data"
      }
    },
    components: {
      "head-Top": HeadTop
    },
    methods: {
      slideDown: function (event) {
        $(event.target).stop(true, true).animate({marginTop: "0px"}, 300)
      },
      slideOut: function (event) {
        $(event.target).stop(true, true).animate({marginTop: "-120px"}, 300)
      },
      isSelect: function (num) {
        if (this.select == num)
          return "red"
      }
    },
    computed: {

    },
    props: ["select"],
  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
  .slide {
    margin-top: -120px;
    position: relative;
    height: 240px;
    cursor: pointer;
  }

  .red {
    color: orange !important;
  }

  #head {

  }

  .fa {
    display: inline-block;
    line-height: 90px;
    font-size: 70px;
  }

  #item {
    position: relative;
    height: 457px;
    background: url("../assets/banner.jpg") center center no-repeat;
  }

  #itemBar {
    position: absolute;
    top: 200px;
    left: 150px;
    & > div {
      overflow: hidden;
      float: left;
      height: 120px;
      width: 120px;
      line-height: 120px;
      text-align: center;
      background-color: #dff0f9;
      position: relative;
      opacity: 0.8;
      & p:first-of-type {
        position: absolute;
        bottom: 130px;
        left: 0;
        right: 0;
        text-align: center;
        line-height: 20px;
        font-size: 15px;
        color: orange;
      }
    ;
      & p:nth-of-type(2) {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        text-align: center;
        line-height: 20px;
        font-size: 15px;
        color: #00afe3;
      }
    }
  }
</style>
