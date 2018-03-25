<template>
  <div id="news">
    <head-div :backgroundColor="{background:'white'}"></head-div>
    <div id="content">
      <div class="title">
        <h1>{{title}}</h1>
      </div>
      <div class="ql-editor" style="width:1040px;margin:auto">
        <div class="article" v-html="content"></div>
      </div>
      <time>{{timeHandle.format('Y-m-d',time)}}</time>
    </div>
    <foot-div></foot-div>
  </div>
</template>

<script>
  import head from "./HeadTop"
  import footDiv from "./foot-div";
  import {
    axiosHandle,
    timeHandle
  } from "../lib/utils";
  export default {
    name: 'news',
    data() {
      return {
        timeHandle: timeHandle,
        title: "",
        content: "",
        time: "",
        src: ""
      }
    },
    components: {
      "head-div": head,
      "foot-div": footDiv
    },
    watch: {
      '$route' (to, from) {
        this.getNews();
      },
    },

    methods: {
      getNews() {
        var data = new FormData();
        data.append("article_id", this.$route.query.id);
        axiosHandle.post("index/News/getNews", data).then(res => {
          this.title = res.data.title;
          this.content = res.data.content;
          this.time = res.data.time;
          this.src = res.data.src == "" ? "url(./static/image/no_data.jpeg)" : "url(" + this.$store.state.imgUrl +
            res.data.src + ")";
        })
      }
    },
    created: function () {
      //ljj 在此根据id查询具体新闻,公告($route.query.id)
      axiosHandle.setThis(this);
      this.getNews();
    }

  }

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
  @import "/static/css/quill/quill.snow.css";
  #content {
    background: no-repeat center center;
    background-size: 200px;
    min-height: 400px;
    position: relative;
    &>.title {
      text-align: center;
      margin: 30px auto 50px auto;
    }
    &>.article {
      width: 70%;
      margin: auto;
      text-align: left;
      text-indent: 2em;
    }
    &:after {
      content: "";
      position: absolute;
      left: 0;
      right: 0;
      top: -20px;
      border-bottom: solid #eeeeee 1px;
    }
  }

  time {
    text-align: right;
    display: block;
    width: 60%;
    margin: 50px auto;
  }

</style>
