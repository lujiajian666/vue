<template>
  <div id="Contact">
    <section>
      <div class="left">
        <p style="color: orange;font-weight: bold;border-bottom: 1px solid;margin: 0 20px;">投诉建议</p>
        <ul>
          <li :class="{select:isSelect[0]}" @click="changeSelect(0)">投诉</li>
          <li :class="{select:isSelect[1]}" @click="changeSelect(1)">建议</li>
        </ul>
      </div>
      <div class="right">
        <div class="complain" v-if="isSelect[0]">
          <div class="inputGroup">
            <label for="title">投诉标题</label>
            <input placeholder="投诉标题" id="title" name="title" v-model="complaint.title" />
          </div>
          <div class="inputGroup">
            <label for="detail">具体内容</label>
            <textarea placeholder="请输入投诉内容" id="detail" name="detail" v-model="complaint.detail"></textarea>
          </div>
          <p class="submit" @click="submit('complaint')">提交</p>
        </div>
        <div class="advice" v-if="isSelect[1]">
          <div class="inputGroup">
            <label for="title">建议标题</label>
            <input placeholder="建议标题" id="title" name="title" v-model="advice.title" />
          </div>
          <div class="inputGroup">
            <label for="detail">具体内容</label>
            <textarea placeholder="请输入投诉内容" id="detail" name="detail" v-model="advice.detail"></textarea>
          </div>
          <p class="submit" @click="submit('advice')">提交</p>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
  import head from '@/components/head';
  import footDiv from "./foot-div";
  import {
    axiosHandle
  } from '../lib/utils';
  export default {
    data() {
      return {
        complaint: {
          title: "",
          detail: ""
        },
        advice: {
          title: "",
          detail: ""
        },
        isSelect: [true, false],
      }
    },
    components: {
      "head-div": head,
      "foot-div": footDiv
    },
    methods: {
      changeSelect(a) {
        if (a == 1) {
          this.isSelect.splice(0, 1, false);
          this.isSelect.splice(1, 1, true);
        } else {
          this.isSelect.splice(0, 1, true);
          this.isSelect.splice(1, 1, false);
        }
      },
      submit(str) {
        console.log("submit")
        var data = new FormData();
        var form;
        if (str == "complaint") {
          form = this.complaint;
        } else {
          form = this.advice;
        }

        data.append("title", form.title);
        data.append("detail", form.detail);
        data.append("type", str);
        axiosHandle.post("admin/Advice/addAdvice", data).then(res => {
          if (res.data.status == 1) {
            var reStr = str == "complaint" ? "您的投诉已发送成功，如若为您带来不便，万分抱歉" : "您的建议已发送成功，非常感谢您宝贵的建议";
            this.$alert(reStr, '操作反馈', {
              confirmButtonText: '确定',
              callback: action => {
                this.$router.push({
                  path: "/"
                });
              }
            });
          }
        })
      }
    },
    watch: {
      '$route' (to, from) {
        var index = this.$route.query.anchor;
        var arr = [false, false];
        if (typeof index != 'undefined' && index != '' && !(typeof index != 'undefined' && index != 0 && !index)) {
          arr.splice(index, 1, true)
        } else {
          arr.splice(0, 1, true)
        }
        this.isSelect = arr;
      }
    },
    created() {
      axiosHandle.setThis(this);
      var index = this.$route.query.anchor;
      var arr = [false, false];
      if (typeof index != 'undefined' && index != '' && !(typeof index != 'undefined' && index != 0 && !index)) {
        arr.splice(index, 1, true)
      } else {
        arr.splice(0, 1, true)
      }
      this.isSelect = arr;
    }

  }

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
  section {
    margin: 50px 0;
  }

  .left {
    float: left;
    width: 200px;
    text-align: center;
    line-height: 30px;
    color: #444444;
    /*font-size: 20px;*/
    /*background-color:#eeeeee;*/
    box-sizing: border-box;
    /*border: 1px solid orange;*/
    & ul {
      height: 300px;
      text-indent: -2em
    }
  }

  .right {
    margin-left: 200px;
    padding: 50px 0;
    background-color: #eeee;
    border-radius: 10px;
  }

  .select {
    color: #69c5ff;
  }

  .inputGroup {
    display: table;
    margin-bottom: 20px;
    &>label {
      display: table-cell;
      vertical-align: top;
      width: 200px;
    }
    &>input {
      width: 300px;
    }
    &>textarea {
      resize: horizontal;
      width: 400px;
      height: 400px;
    }
  }

  input,
  textarea {
    vertical-align: middle;
    display: table-cell;
    border: 1px solid orange;
    outline: none;
    line-height: 15px;
    padding: 5px 10px;
  }

  .submit {
    background-color: orange;
    color: white;
    border-radius: 5px;
    line-height: 30px;
    text-align: center;
    width: 100px;
    margin: 0 auto;
  }

</style>
