<template>
  <div id="Employee">
    <div class="title">
      <span style="float:left">{{$route.query.departmentName}}</span>&nbsp;&nbsp;&nbsp;
      <el-button type="primary" icon="el-icon-edit" class="add" @click="add"></el-button>
      <div style="float:left;margin-right:20px">
        <el-input placeholder="请输入姓名" v-model="searchName" @keydown.enter.native="search">
          <el-button slot="append" icon="el-icon-search" style="margin: 0px 0px 0 -30px;padding:0" @click="search"></el-button>
        </el-input>
      </div>
    </div>
    <div class="content">
      <ul v-if="people" style="height:500px;overflow:auto">
        <li v-for="(p,index) in people" :key="index">
          <div class="person">
            <img :src="p.src" style="float: left">
            <div>
              <p>
                <span style="display: inline-block;width: 120px">ID：{{p.id}}</span>
                <span style="display: inline-block;">账号：{{p.username}}</span>
              </p>
              <p>
                <span style="display: inline-block;width: 120px">姓名：{{p.name}}</span>
                <span style="display: inline-block;">职称：{{p.jobTitle}}</span>
              </p>
              <p>
                <span style="display: inline-block;width: 120px">工资：{{p.salary}}</span>
                <span style="display: inline-block;">入职：{{timeHandle.format("Y年m月d日",p.time)}}</span>
              </p>
              <p>
                权限id:{{p.role}}
              </p>
            </div>
            <div class="button3" @click="resetPass($event)" :data-id="p.id">
              重置密码
            </div>
            <div class="button1" @click="changeAlter($event)" :data-id="p.id">
              修改
            </div>
            <div class="button2" @click="deleteEmployeeById($event)" :data-id="p.id">
              删除
            </div>
          </div>
        </li>
      </ul>
      <el-pagination v-if="people" layout="prev, pager, next" :total="total*10" @current-change="changePage" :current-page.sync="page">
      </el-pagination>
      <img v-if="!people" src="/static/image/no_data.jpeg">
    </div>

    <alert-box title="添加" v-if="alert" @close="close" @change="getAllEmployee($route.query.department)">

    </alert-box>
    <alter-box title="修改" v-if="alter" @close="closeAlter" @change="getAllEmployee($route.query.department)">
    </alter-box>
  </div>
</template>

<script>
  import search_div from '@/components/searchDiv';
  import alertBox from '@/components/tool/alertBox';
  import alterBox from '@/components/tool/alertBox';
  import {
    timeHandle,
    axiosHandle
  } from "../../lib/utils.js"
  export default {
    data() {
      return {
        searchName: "",
        timeHandle: timeHandle,
        people: [],
        alert: false,
        alter: false,
        total: 1,
        page: 1,
      }
    },
    components: {
      "alert-box": alertBox,
      "alter-box": alterBox
    },
    methods: {
      add: function () { //ljj 显示添加框
        this.alert = true;
      },
      close: function () { //ljj 关闭添加框
        this.alert = false;
      },
      closeAlter: function () { //ljj 关闭修改框
        this.alter = false;
      },
      changeAlter: function (node) { //ljj 显示修改框
        //ljj 获得员工id
        var id = node.currentTarget.getAttribute("data-id")
        //ljj 根据id获取员工信息
        this.getEmployee(id)
      },
      getEmployee: function (id) {
        var data = new FormData();
        var _self = this;
        data.append("id", id);
        axiosHandle.post('admin/background/getEmployeeById', data)
          .then(function (response) {
            var data = response.data;
            if (data.status == 1) {
              if (data["man"]["src"] == "" || data["man"]["src"] == null) {
                data["man"]["src"] = "./static/image/no_data.jpeg";
              } else {
                data["man"]["src"] = _self.$store.state.imgUrl + data.man["src"];
              }
              //ljj 记录信息
              _self.$store.state.alterMessage = data["man"];
              //ljj 显示
              _self.alter = true;
            } else {
              console.log("加载失败")
            }
          })
          .catch(function (error) {
            console.log(error);
          });
      },
      search(){
        this.page = 1;    
        this.getEmployeeByName();
      },
      getEmployeeByName() {
        var _self=this;
        if (this.searchName != "") {
          var data = new FormData();
          data.append("name", this.searchName);
          data.append("page",this.page);
          axiosHandle.post('admin/background/getEmployeeByName', data).then(res => {
            var data = res.data;
            if (data.status == 1) {
              _self.people = data.people;
              _self.total = data.total;
              _self.people.forEach(function (value, index, array) {
                if (value["src"] == "" || value["src"] == null) {
                  value["src"] = "./static/image/no_data.jpeg";
                } else {
                  value["src"] = _self.$store.state.imgUrl + value["src"];
                }
              })
            } else {
              _self.people = null;
            }
          });
        } else {
          this.getAllEmployee(this.$route.query.department);
        }

      },
      getAllEmployee: function (department) {
        var _self = this;
        var data = new FormData();
        data.append("department", department);
        data.append("page", this.page);

        axiosHandle.post('admin/background/getEmployee', data)
          .then(function (response) {
            var data = response.data;
            if (data.status == 1) {
              _self.people = data.people;
              _self.total = data.total;
              _self.people.forEach(function (value, index, array) {
                if (value["src"] == "" || value["src"] == null) {
                  value["src"] = "./static/image/no_data.jpeg";
                } else {
                  value["src"] = _self.$store.state.imgUrl + value["src"];
                }
              })
            } else {
              _self.people = null;
            }
          })
      },
      deleteEmployeeById: function (node) {
        var _self = this;
        var id = node.currentTarget.getAttribute("data-id");
        var data = new FormData();
        data.append("id", id);
        this.$confirm('此操作将永久删除, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          //ljj 根据id删除员工
          axiosHandle.post('admin/background/deleteEmployeeById', data)
            .then(function (response) {
              var data = response.data;
              if (data.status == 1) {
                _self.people.forEach(function (value, index, array) {
                  if (value['id'] == id) {
                    array.splice(index, 1);
                  }
                  return;
                })
                _self.$message({
                  type: "success",
                  message: "删除成功"
                })
              } else {
                _self.$message({
                  type: "error",
                  message: "删除失败！" + data.txt
                })
              }
            })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '已取消删除'
          });
        });
      },
      changePage() {
        if (this.searchName == '') {
          this.getAllEmployee(this.$route.query.department)
        } else {
          this.getEmployeeByName();
        }

      },
      resetPass(node) {
        var id = node.currentTarget.getAttribute("data-id");
        var _self = this;
        var data = new FormData();
        data.append("id", id);
        axiosHandle.post("admin/background/resetPass", data)
          .then((res) => {
            if (res.data.status == 1) {
              _self.$message({
                type: "success",
                message: "重置成功"
              })
            } else {
              _self.$message({
                type: "error",
                message: "重置失败"
              })
            }
          })
      }
    },
    created: function () {
      axiosHandle.setThis(this);
      if (this.$route.query.department != undefined) {
        var _self = this;
        var data = new FormData();
        data.append("department", department);
        data.append("page", this.page);

        axiosHandle.post('admin/background/getEmployee', data)
          .then(function (response) {
            var data = response.data;
            if (data.status == 1) {
              _self.people = data.people;
              _self.total = data.total;
              _self.people.forEach(function (value, index, array) {
                if (value["src"] == "" || value["src"] == null) {
                  value["src"] = "./static/image/no_data.jpeg";
                } else {
                  value["src"] = _self.$store.state.imgUrl + value["src"];
                }
              })
            } else {
              _self.people = null;
            }
          })
      }
    },
    watch: {
      '$route' (to, from) {
        var department = this.$route.query.department;
        if (typeof department != 'undefined' && department != '' &&
          !(typeof department != 'undefined' && department != 0 && !department)) {
          this.getAllEmployee(department)
        }
      }
    }


  }

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
  .button(@color: white;
  @bgColor: orange;
  @width: 100px;
  @lineHeight: 2;
  @fontSize: 15px) {
    border-radius: 2px;
    background-color: @bgColor;
    color: @color;
    width: @width;
    line-height: @lineHeight;
    font-size: @fontSize;
    text-align: center;
    font-weight: bold;
  }

  .title {
    position: fixed;
    top: 50px;
    left: 200px;
    right: 0;
    line-height: 50px;
    text-align: left;
    text-indent: 2em;
    color: #007fcf;
    border-bottom: 1px solid #007fcf;
    background-color: #f9f9f9;
  }

  .content {
    position: fixed;
    top: 110px;
    left: 200px;
    right: 0;
    bottom: 0;
    overflow: auto;
  }

  .person {
    position: relative;
    width: 90%;
    margin: 0 auto 30px auto;
    height: 120px;
    box-sizing: border-box;
    padding: 5px;
    text-align: left;
    /*background-color: rgba(81,151,255,0.7);*/
    color: white;
    font-size: 15px;
    background: url(/static/image/background/black.jpg) fixed;
    background-size: contain;
    &>img {
      height: 100%;
      width: 150px;
      margin-right: 20px;
    }
    &>.button1 {
      position: absolute;
      bottom: 5px;
      right: 10px;
      .button(white, orange, 60px);
    }
    &>.button2 {
      position: absolute;
      bottom: 5px;
      right: 80px;
      .button(white, #188aef, 60px)
    }
    &>.button3 {
      position: absolute;
      bottom: 5px;
      right: 150px;
      .button(white, rgb(54, 179, 172))
    }
  }

  .add {
    float: right;
    margin: 5px 10px;
  }

</style>
