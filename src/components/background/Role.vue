<template>
  <div id="Role">
    <el-dialog title="创建角色" :visible.sync="dialogFormVisible" :append-to-body=true>
      <el-form :model="form">
        <el-form-item label="角色名称" :label-width="formLabelWidth">
          <el-input v-model="form.name" auto-complete="off" placeholder="请填写角色名称"></el-input>
        </el-form-item>
        <el-form-item label="角色描述" :label-width="formLabelWidth">
          <el-input v-model="form.desc" placeholder="请填写活动描述">
          </el-input>
        </el-form-item>
      </el-form>
      <div slot="footer" class="dialog-footer">
        <el-button @click="createCancel">取 消</el-button>
        <el-button type="primary" @click="createSure">确 定</el-button>
      </div>
    </el-dialog>
    <el-dialog style="text-align: center" title="配置角色权限" :visible.sync="dialogVisible" :append-to-body=true>
      <el-transfer v-model="value" filterable :titles="['所有权限', '启用权限']" :button-texts="['到左边', '到右边']" :format="{
                    noChecked: '${total}',
                    hasChecked: '${checked}/${total}'
                }" @change="handleChange" :data="data">
      </el-transfer>
      <el-button type="success" @click="submit">保存修改</el-button>
    </el-dialog>
    <el-dialog style="text-align: center" title="应用角色" :visible.sync="dialog" :append-to-body=true>
      <el-tabs v-model="activeName" @tab-click="handleClick">
        <el-tab-pane label="按部门应用权限" name="first">
          <el-form>
            <el-form-item label="部门" :label-width="formLabelWidth">
              <el-select v-model="selectDepartment" placeholder="请选择部门">
                <el-option v-for="(item,index) in department" :label="item.name" :value="item.id" :key="index">
                </el-option>
              </el-select>
            </el-form-item>
          </el-form>
        </el-tab-pane>
        <el-tab-pane label="按名字应用权限" name="second">
          <el-input placeholder="请输入账号" prefix-icon="el-icon-search" v-model="apply.name" @keydown.native="search"></el-input>
          <el-table ref="multipleTable" :data="apply.list" tooltip-effect="dark" max-height="250" @selection-change="handleSelectionChange"
            style="width: 100%;text-align: left">
            <el-table-column type="selection" width="55"></el-table-column>
            <el-table-column label="姓名" width="120">
              <template slot-scope="scope">{{ scope.row.name }}</template>
            </el-table-column>
            <el-table-column prop="time" label="入职时间" show-overflow-tooltip>
            </el-table-column>
          </el-table>
        </el-tab-pane>
      </el-tabs>
      <div slot="footer" class="dialog-footer">
        <el-button @click="dialog = false">取 消</el-button>
        <el-button type="primary" @click="dialogSubmit">确 定</el-button>
      </div>
    </el-dialog>

    <div style="padding: 10px;text-align: left">
      <el-button type="primary" icon="el-icon-plus" @click="dialogFormVisible = true"></el-button>
    </div>

    <el-table header-cell-class-name="table-header" :data="tableData" style="width: 100%;text-align: left">
      <el-table-column label="权限id" width="180">
        <template slot-scope="scope">
          <i class="el-icon-star-off"></i>
          <span style="margin-left: 10px">{{ scope.row.role_id }}</span>
        </template>
      </el-table-column>
      <el-table-column label="权限描述" width="180">
        <template slot-scope="scope">
          <el-popover trigger="hover" placement="top">
            <p>详细描述: {{ scope.row.detail }}</p>
            <div slot="reference" class="name-wrapper">
              <el-tag size="medium">{{ scope.row.name }}</el-tag>
            </div>
          </el-popover>
        </template>
      </el-table-column>
      <el-table-column label="操作">
        <template slot-scope="scope">
          <el-button size="mini" @click="editRole(scope.$index, scope.row)">编辑</el-button>
          <el-button size="mini" type="success" @click="applyRole(scope.$index, scope.row)">应用</el-button>
          <el-button size="mini" type="danger" @click="deleteRole(scope.$index, scope.row)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
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
        dialogVisible: false,
        dialog: false,
        role_id: 0,
        form: {
          name: '',
          desc: ''
        },
        formLabelWidth: '120px',
        tableData: [],
        allData: [],
        data: [],
        value: [],
        activeName: 'second',
        department: "",
        selectDepartment: "",
        apply: {
          name: '',
          select: "",
          list: [],
        },
        multipleSelection: "",
        tabName: ''
      }
    },
    methods: {
      handleSelectionChange(val) {
        var arr = [];
        for (var i of val) {
          arr.push(i.id);
        }
        this.multipleSelection = arr;
        console.log(this.multipleSelection)
      },
      handleChange(value, direction, movedKeys) {
        console.log(value, direction, movedKeys);
      },
      createCancel() {
        this.dialogFormVisible = false;
        this.form.name = "";
        this.form.desc = "";
      },
      createSure() {
        var _self = this;
        var data = new FormData();
        data.append("name", _self.form.name);
        data.append("desc", _self.form.desc);
        axiosHandle.post("admin/Authority/addRole", data)
          .then(function (res) {
            _self.dialogFormVisible = false;
            _self.form.name = "";
            _self.form.desc = "";
            if (res.data.status == 1) {
              _self.$message({
                type: 'success',
                message: '添加成功'
              })
              _self.getRole(_self);
            } else {
              _self.$message({
                type: 'error',
                message: '添加失败'
              });
            }
          })
      },
      getRole(_self) {
        axiosHandle.post("admin/Authority/getRole")
          .then(function (res) {
            _self.tableData = res.data
            //ljj 获取所有配置为可用的基本权限
            var data = new FormData();
            data.append("type", "role")
            axiosHandle.post("admin/Authority/getAuthority", data)
              .then(function (res) {
                _self.allData = res.data;
                _self.data = _self.generateData(res.data);
              })
          })
      },
      deleteRole(index, row) {
        var _self = this;
        var data = new FormData();
        data.append("role_id", row.role_id);
        this.$confirm('此操作将永久删除, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          axiosHandle.post("admin/Authority/deleteRole", data)
            .then(function (res) {
              if (res.data.status == 1) {
                _self.$message({
                  type: 'success',
                  message: '删除成功'
                })
                _self.tableData.splice(index, 1);
              } else {
                _self.$message({
                  type: 'error',
                  message: '删除失败'
                })
              }
            })
        });

      },
      editRole(index, row) {
        var _self = this;
        this.role_id = row.role_id;
        var data = new FormData();
        data.append("role_id", row.role_id);
        axiosHandle.post("admin/Authority/editRole", data)
          .then(function (res) {
            if (res.data.status == 1) {
              _self.dialogVisible = true;
              _self.value = _self.generateSelectData(res.data.value);
            } else {
              _self.$message({
                type: "error",
                message: "网络错误"
              })
            }
          })
      },
      applyRole(index, row) {
        this.role_id = row.role_id;
        this.selectDepartment = "";
        this.multipleSelection = "";
        this.dialog = true;
      },
      submit() {
        var _self = this;
        var arr = [];
        for (var i of this.value) {
          arr.push({
            authority_item_id: this.allData[i]["id"],
          })
        }
        var data = new FormData();
        data.append("data", JSON.stringify(arr));
        data.append("role_id", this.role_id)
        axiosHandle.post("admin/authority/saveRoleItem", data)
          .then(function (response) {
            var data = response.data;
            if (data.status == 1) {
              _self.$message({
                type: 'success',
                message: '保存成功'
              });
            } else {
              _self.$message({
                type: 'error',
                message: '保存失败'
              });
            }
            _self.dialogVisible = false;
          })
          .catch(function (error) {
            console.log(error);
          });
      },
      generateData(arr) {
        const newData = [];
        for (var i in arr) {
          newData.push({
            key: i,
            label: this.allData[i]["name"]
          })
        }
        return newData;
      },
      generateSelectData(arr) {
        var newData = [];
        for (var i of arr) {
          for (var j = 0; j < this.allData.length; j++) {
            if (this.allData[j]["id"] == i) {
              newData.push(j.toString())
              break;
            }
          }
        }
        return newData;
      },
      search() {
        var data = new FormData();
        data.append("name", this.apply.name);
        var _self = this;
        axiosHandle.post("admin/Authority/search", data)
          .then(function (res) {
            _self.apply.list = res.data.data
          })
      },
      dialogSubmit() {
        var _self = this;
        var data = new FormData();
        data.append("role_id", this.role_id);
        if (this.tabName == "first") {
          data.append("type", "department");
          data.append("value", this.selectDepartment);
        } else {
          data.append("type", "name");
          data.append("value", this.multipleSelection);
        }
        axiosHandle.post("admin/Authority/applyRole", data)
          .then(function (res) {
            _self.dialog = false;
            if (res.data.status == 1) {
              _self.$message({
                type: "success",
                message: "应用成功"
              })
            } else {
              _self.$message({
                type: "error",
                message: "网络错误"
              })
            }
          })

      },
      handleClick(tab, event) {
        this.tabName = tab.name;
      }
    },
    created() {
      var _self = this;
      //ljj 设置指针
      axiosHandle.setThis(this)
      //ljj 获取角色
      this.getRole(_self);
      //ljj 获取所有部门
      axiosHandle.post('admin/background/selectDepartment')
        .then(function (response) {
          var data = response.data;
          _self.department = data;
          console.log(_self.department)
        })
        .catch(function (error) {
          console.log(error);
        });
    }
  }

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="less">
  .table-header {
    background-color: #efefef !important;
  }

  .el-transfer {
    margin-top: 20px;
    text-align: center;
    &>div {
      text-align: left;
    }
  }

</style>
