<template>
  <div id="Department">
    <el-dialog title="新增职务" :visible.sync="dialogFormVisible" :append-to-body=true>
      <el-form :model="form" :rules="rules" ref="ruleFormAdd">
        <el-form-item label="职务名称" :label-width="formLabelWidth" prop="title">
          <el-input v-model="form.title" placeholder="请填写职务名称"></el-input>
        </el-form-item>
        <el-form-item label="职务月薪" :label-width="formLabelWidth">
          <el-input v-model="form.salary" placeholder="请填写职务月薪" type="number">
          </el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible=false">取 消</el-button>
        <el-button type="primary" @click="addJobTitle">确 定</el-button>
      </div>
    </el-dialog>
    <el-dialog title="编辑职务" :visible.sync="dialogFormVisible2" :append-to-body=true>
      <el-form :model="form" :rules="rules" ref="ruleFormEdit">
        <el-form-item label="职务名称" :label-width="formLabelWidth" prop="title">
          <el-input v-model="form.title" auto-complete="off" placeholder="请填写职务名称"></el-input>
        </el-form-item>
        <el-form-item label="职务月薪" :label-width="formLabelWidth">
          <el-input v-model="form.salary" placeholder="请填写职务月薪" type="number">
          </el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialogFormVisible2=false">取 消</el-button>
        <el-button type="primary" @click="editJobTitle">确 定</el-button>
      </div>
    </el-dialog>
    <el-tabs v-model="activeName">
      <el-tab-pane v-for="(item,index) in department" :label="item.name" :name="index|toString" :key="index">
        <el-button type="primary" style="float: left" @click="addDepartment">添加部门</el-button>
        <el-button type="primary" style="float: left" @click="editDepartment">修改部门</el-button>
        <el-button type="primary" style="float: left" @click="deleteDepartment">删除部门</el-button>
        <el-button type="primary" style="float: left" @click="dialogFormVisible=true;">添加职务</el-button>

        <el-table :data="jobTitle[item.id]" style="width: 100%;text-align: left" max-height="250">
          <el-table-column fixed prop="department_id" label="id" width="150"></el-table-column>
          <el-table-column prop="title" label="职位名称" show-overflow-tooltip></el-table-column>
          <el-table-column fixed="right" label="操作" width="120">
            <template slot-scope="scope">
              <el-button @click.native.prevent="deleteRow(scope.$index,item.id)" type="text" size="small">
                移除
              </el-button>
              <el-button @click.native.prevent="editRow(scope.$index,item.id)" type="text" size="small">
                修改
              </el-button>
            </template>
          </el-table-column>
        </el-table>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
  import {
    vuexHandle,
    axiosHandle
  } from "../../lib/utils.js"

  export default {
    data() {
      return {
        dialogFormVisible: false,
        dialogFormVisible2: false,
        rules: {
          title: [{
              required: true,
              message: '请输入职务名',
              trigger: 'blur'
            },
            {
              pattern: /^[\u4e00-\u9fa5]*$/,
              message: '请输入纯中文字符',
              required: true,
            },
            {
              min: 5,
              max: 10,
              message: '长度在 5 到 10 个字符',
              trigger: 'blur'
            }
          ]
        },
        formLabelWidth: '120px',
        form: {
          salary: "",
          title: ""
        },
        department: [],
        jobTitle: [],
        activeName: 0,
        jobTitleId: ""
      }
    },
    methods: {
      addDepartment() {
        var _self = this;
        this.$prompt('请输入部门名称', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          inputPattern: /^[\u4e00-\u9fa5]*$/,
          inputErrorMessage: '部门名必须为中文'
        }).then(({
          value
        }) => {
          var data = new FormData();
          data.append("name", value);
          axiosHandle.post("admin/Department/addDepartment", data)
            .then((res) => {
              if (res.data.status == 1) {
                _self.init("添加成功");
              } else {
                this.$message({
                  type: 'error',
                  message: '网络错误'
                });
              }
            })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '取消输入'
          });
        });
      },
      editDepartment() {
        var _self = this;
        var id = this.department[this.activeName]["id"]
        this.$prompt('请输入部门名称', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          inputPattern: /^[\u4e00-\u9fa5]*$/,
          inputErrorMessage: '部门名必须为中文'
        }).then(({
          value
        }) => {
          var data = new FormData();
          data.append("name", value);
          data.append("id", id);
          axiosHandle.post("admin/Department/editDepartment", data)
            .then((res) => {
              if (res.data.status == 1) {
                _self.department[_self.activeName]["name"] = value;
                this.$message({
                  type: 'success',
                  message: '修改成功'
                });
              } else {
                this.$message({
                  type: 'error',
                  message: '网络错误'
                });
              }
            })
        }).catch(() => {
          this.$message({
            type: 'info',
            message: '取消输入'
          });
        });
      },
      deleteDepartment() {
        var _self = this;
        var departmentId = this.department[this.activeName]["id"];
        var data = new FormData();
        data.append("id", departmentId);
        this.$confirm('此操作将永久删除, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          axiosHandle.post("admin/Department/deleteDepartment", data)
            .then(function (res) {
              if (res.data.status == 1) {
                _self.department.splice(_self.activeName, 1);
                _self.$message({
                  type: 'success',
                  message: '删除成功'
                })
              } else {
                _self.$message({
                  type: 'error',
                  message: '删除失败'
                })
              }
            })
        })

      },

      addJobTitle() {
        var _self = this;
        this.$refs['ruleFormAdd'].validate((valid) => {
          if (valid) {
            var _self = this;
            var data = new FormData();
            data.append("title", this.form.title);
            data.append("salary", this.form.salary);
            data.append("department_id", this.department[this.activeName]["id"]);
            axiosHandle.post('admin/Department/addJobTitle', data)
              .then((res) => {
                _self.dialogFormVisible = false;
                if (res.data.status == 1) {
                  _self.init("添加成功")
                } else {
                  _self.$message({
                    type: 'error',
                    message: '添加失败'
                  })
                }
              })
          } else {
            this.$message({
              type: 'error',
              message: '请按格式填写！'
            })
          }
        });
      },
      deleteRow(index, itemId) {
        var _self = this;
        var id = this.jobTitle[itemId][index]["id"];
        var data = new FormData();
        data.append("id", id);
        this.$confirm('此操作将永久删除, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          axiosHandle.post("admin/Department/deleteJobTitle", data)
            .then(function (res) {
              if (res.data.status == 1) {
                _self.jobTitle[itemId].splice(index, 1);
                _self.$message({
                  type: 'success',
                  message: '删除成功'
                })
              } else {
                _self.$message({
                  type: 'error',
                  message: '删除失败'
                })
              }
            })
        });

      },
      editRow(index, itemId) {
        this.dialogFormVisible2 = true;
        this.form.title = this.jobTitle[itemId][index]["title"];
        this.form.salary = this.jobTitle[itemId][index]["salary"];
        this.jobTitleId = this.jobTitle[itemId][index]["id"];
      },
      editJobTitle() {
        this.$refs['ruleFormEdit'].validate((valid) => {
          if (valid) {
            var _self = this;
            var data = new FormData();
            data.append("title", this.form.title);
            data.append("salary", this.form.salary);
            data.append("id", this.jobTitleId);
            axiosHandle.post('admin/Department/editJobTitle', data)
              .then((res) => {
                _self.dialogFormVisible2 = false;
                if (res.data.status == 1) {
                  _self.init("修改成功")
                } else {
                  _self.$message({
                    type: 'error',
                    message: '网络错误'
                  })
                }
              })
          } else {
            this.$message({
              type: 'error',
              message: '请按格式填写！'
            })
          }
        });

      },
      init(text) {
        var _self = this;
        axiosHandle.post('admin/background/selectDepartment')
          .then(function (response) {
            var data = response.data;
            _self.department = data;
            return axiosHandle.post('admin/background/selectJobTitle')
          })
          .then(function (response) {
            var data = response.data;
            var obj = {};
            for (var i of data) {
              if (typeof obj[i["department_id"]] == "undefined") {
                obj[i["department_id"]] = [];
              }
              obj[i["department_id"]].push(i);
            }
            _self.jobTitle = obj;
            _self.$message({
              type: 'success',
              message: text
            })

          })
          .catch(function (error) {
            console.log(error);
          });
      }
    },
    filters: {
      toString(value) {
        return value.toString();
      }
    },
    created() {
      axiosHandle.setThis(this);
      var _self = this;
      axiosHandle.post('admin/background/selectDepartment')
        .then(function (response) {
          var data = response.data;
          _self.department = data;
          return axiosHandle.post('admin/background/selectJobTitle')
        })
        .then(function (response) {
          var data = response.data;
          var obj = {};
          for (var i of data) {
            if (typeof obj[i["department_id"]] == "undefined") {
              obj[i["department_id"]] = [];
            }
            obj[i["department_id"]].push(i);
          }
          _self.jobTitle = obj;
        })
        .catch(function (error) {
          console.log(error);
        });
    }
  }

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
  #Department {
    padding: 20px 20px 0 20px;
  }

</style>
