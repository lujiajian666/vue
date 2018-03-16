<template>
  <div id="AlertBox">
    <div id="shadow"></div>
    <div id="content">
      <header>
        <h2>{{title}}</h2>
        <i class="fa fa-close" @click="close"></i>
      </header>
      <main>
        <form id="form">
          <div class="inputGroup" style="display:flex;height: 250px">
            <div style="position: relative;padding-left: 100px;margin: auto;height:165px">
              <input placeholder="姓名" name="name" v-model="name">
              <span class="tips" v-show="isEmpty(this.name)">姓名不能为空！</span>

              <br>
              <select name="department" @change="changeDepartment($event)">
                <option value="0">所属部门</option>
                <option v-for="(value,index) in selectDepartment" :key="index" :value="value['id']" :selected="departmentId==value['id']">
                  {{value['name']}}
                </option>
              </select>

              <br>
              <select name="title" @change="changeJobTitle($event)">
                <option value="0">职称</option>
                <option v-for="(value,index) in selectJobTitle" :key="index" :value="value['id']" :selected="jobTitle==value['id']">
                  {{value['title']}}
                </option>
              </select>
              <span class="tips" v-show="isEmpty(this.jobTitle)">职称不能为空！</span>

              <span class="tips" v-show="isEmpty(this.departmentId)">部门不能为空！</span>
              <div class="pic_btn_div" id="pic_btn_div" :style="head_img_url">点击上传头像</div>
              <input class="pic_btn" type="file" name="head_img" @change="changePic($event,'pic_btn_div')">
              <p class="pic_btn_p" @click="submit">确定</p>
            </div>
          </div>
        </form>
      </main>
      <footer>

      </footer>
    </div>

  </div>
</template>

<script>
  import {
    axiosHandle
  } from '../../lib/utils';
  export default {
    data() {
      return {
        id: "",
        name: "",
        jobTitle: "",
        department: "",
        head_img: "",
        departmentId: "",
        selectJobTitle: null,
        selectDepartment: null,
      }
    },
    methods: {
      close: function () {
        //ljj 清空alterMessage,防止alter和alert的显示混淆（用的都是这个单页面组件）
        this.$store.state.alterMessage = null;
        //ljj 关闭
        this.$emit("close")
      },
      changePic: function fileReader(node, imgNode) {
        if (node.currentTarget == null || imgNode == null) {
          if (node == null) console.log("node 为空")
          console.log("请传入合理参数");
          return;
        }
        node = typeof node == "string" ? document.getElementById(node) : node.currentTarget;
        imgNode = typeof imgNode == "string" ? document.getElementById(imgNode) : imgNode;

        if (typeof FileReader == 'undefined') {
          console.log("浏览器版本较低，不支持FileReader");
          var src = node.value;
          imgNode.src = src;
        } else {
          // 获得文件
          var file = node.files[0];
          var reader = new FileReader();
          // 将文件读取为DataUrl
          reader.readAsDataURL(file);
          reader.onload = function (event) {
            imgNode.style.backgroundImage = "url(" + this.result + ")";
          }
          reader.onerror = function (event) {
            throw new Error("读取出错");
          }
          reader.onloadstart = function () {
            console.log("读取开始");
          }
        }
      },
      changeDepartment: function (node) {
        this.departmentId = node.currentTarget.value;
        //ljj 职称选项生成
        var data=new FormData();
        var _self=this;
        data.append("departmentid",this.departmentId);
        axiosHandle.post('admin/background/selectJobTitleByDepartment',data)
          .then(function (response) {
            var data = response.data;
            _self.selectJobTitle = data;
          })
          .catch(function (error) {
            console.log(error);
          });
      },
      changeJobTitle: function (node) {
        this.jobTitle = node.currentTarget.value;
      },
      submit: function () {
        //ljj 清空alterMessage,防止alter和alert的显示混淆（用的都是这个单页面组件）
        this.$store.state.alterMessage = null;
        var _self = this;
        //ljj 检查是否为空
        if (this.isEmpty(this.name) ||
          this.isEmpty(this.jobTitle) ||
          this.isEmpty(this.departmentId)) {
          return false;
        }
        //ljj url生成
        var url = "";
        var data = new FormData(document.getElementById("form"));

        if (this.id != "") { //ljj 修改
          url = 'admin/background/editEmployee';
          data.append("id", this.id);
        } else { //ljj 上传
          url = 'admin/background/addEmployee'
        }
        axiosHandle.post(url, data)
          .then(function (response) {
            var data = response.data;
            if (data.status == 1) {
              _self.$message({
                type: 'success',
                message: '添加成功'
              })
              _self.close();
              _self.$emit("change")
            } else if (data.status == 2) {
              _self.$message({
                type: 'success',
                message: '修改成功'
              })
              _self.close();
              _self.$emit("change")
            } else {
              _self.$message({
                type: 'success',
                message: '网络错误'
              })
            }
          })
          .catch(function (error) {
            console.log(error);
          });
      },
      isEmpty: function (a) {
        if (a != 0 && a != '') {
          return false;
        } else {
          return true;
        }
      }
    },
    computed: {
      head_img_url: function () {
        return {
          "background-image": "url(" + this.head_img + ")"
        };
      }
    },
    created: function () {
      var _self = this;
      axiosHandle.setThis(this);
      //ljj 部门选项生成
      axiosHandle.post('admin/background/selectDepartment')
        .then(function (response) {
          var data = response.data;
          _self.selectDepartment = data;
        })
        .catch(function (error) {
          console.log(error);
        });
      //ljj 默认选项填写
      var store = this.$store.state.alterMessage;
      if (store != null) {
        this.id = store.id;
        this.name = store.name;
        this.jobTitle = store.job_title_id;
        this.department = store.department;
        this.head_img = store.src;
        this.departmentId = store.department_id;
         //ljj 职称选项生成
        var data=new FormData();
        data.append("departmentid",this.departmentId);
        axiosHandle.post('admin/background/selectJobTitleByDepartment',data)
          .then(function (response) {
            var data = response.data;
            _self.selectJobTitle = data;
          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
    props: ["title"]

  }

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
  .tips {
    color: red;
    font-weight: bold;
    font-size: 12px;
  }

  .pic_btn {
    top: 0;
    left: -5px;
    height: 91px;
    width: 100px;
    position: absolute;
    border-radius: 5px;
    opacity: 0;
    cursor: pointer;
  }

  .pic_btn_div {
    .pic_btn;
    opacity: 1;
    border: 1px solid rgba(0, 0, 0, 0.2);
    line-height: 91px;
    font-size: 12px;
    background-position: center;
    background-repeat: no-repeat;
  }

  .pic_btn_p {
    .pic_btn;
    opacity: 1;
    font-size: 12px;
    top: auto;
    bottom: 20px;
    left: -5px;
    height: 30px;
    line-height: 30px;
    background-color: orange;
    color: white;
  }

  #content {
    position: absolute;
    height: 300px;
    width: 500px;
    border-radius: 3px;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin: auto;
    background-color: white;
    z-index: 20;
  }

  #shadow {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: black;
    opacity: 0.5;
    z-index: 10;
  }

  h2 {
    border-bottom: 1px solid #008ecc;
  }

  header {
    position: relative;
    line-height: 50px;
  }

  .fa-close {
    position: absolute;
    right: 10px;
    top: 16px;
  }

  input:not([type=file]) {
    outline: none;
    border: 1px solid #008ecc;
    padding: 10px 15px;
    display: block;
    margin: auto;
  }

  select {
    border: 1px solid #008ecc;
    padding: 5px 10px;
    height: 37px;
    background-color: white;
    display: block;
    width: 100%;
  }

</style>
