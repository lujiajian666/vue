<template>
  <div id="advice">
    <el-tabs v-model="activeName">
      <el-tab-pane label="建议" name="first">
        <el-table :data="advice.tableData" height="500" border style="width: 801px">
          <el-table-column prop="title" label="标题" width="300">
          </el-table-column>
          <el-table-column prop="time" label="时间" width="300">
          </el-table-column>
          <el-table-column label="操作" width="200">
            <template slot-scope="scope">
              <el-button @click="view(scope.row)" type="text" size="small">查看</el-button>
              <el-button @click="deleteAdvice(scope.index,scope.row)" type="text" size="small">删除</el-button>
            </template>
          </el-table-column>
        </el-table>
        <el-pagination style="float:left;margin-top:10px" layout="prev, pager, next" :total="advice.total*10" :current-page.sync="advice.nowPage"
          @current-change="advicePageChange">
        </el-pagination>
      </el-tab-pane>
      <el-tab-pane label="投诉" name="second">
        <el-table :data="complaint.tableData" height="500" border style="width: 801px">
          <el-table-column prop="title" label="标题" width="300">
          </el-table-column>
          <el-table-column prop="time" label="时间" width="300">
          </el-table-column>
          <el-table-column label="操作" width="200">
            <template slot-scope="scope">
              <el-button @click="view(scope.row)" type="text" size="small">查看</el-button>
              <el-button @click="deleteComplaint(scope.index,scope.row)" type="text" size="small">删除</el-button>
            </template>
          </el-table-column>
        </el-table>
        <el-pagination style="float:left;margin-top:10px" layout="prev, pager, next" :total="complaint.total*10" :current-page.sync="complaint.nowPage"
          @current-change="complaintPageChange">
        </el-pagination>
      </el-tab-pane>
    </el-tabs>
  </div>
</template>

<script>
  import {
    axiosHandle
  } from "../../lib/utils";
  export default {
    data() {
      return {
        activeName: "first",
        advice: {
          tableData: [],
          total: 1,
          nowPage: 1
        },
        complaint: {
          tableData: [],
          total: 1,
          nowPage: 1
        },
      }
    },
    methods: {
      advicePageChange() {
        var data = new FormData();
        data.append("page", this.advice.nowPage);
        axiosHandle.post('admin/Advice/getAdvice', data).then(res => {
          this.advice.tableData = res.data.advice;
          this.advice.total = res.data.total;
        })
      },
      complaintPageChange() {
        var data = new FormData();
        data.append("page", this.advice.nowPage);
        axiosHandle.post('admin/Advice/getComplaint', data).then(res => {
          this.complaint.tableData = res.data.complaint;
          this.complaint.total = res.data.total;
        })
      },
      view(row) {
        this.alert(row.detail)
      },
      deleteAdvice(index, row) {
        var data = new FormData();
        data.append("id", row.id);
        this.$confirm('此操作将永久删除, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          axiosHandle.post('admin/Advice/delete', data).then(res => {
            if (res.data.status == 1) {
              this.$message({
                type: "success",
                message: "删除成功"
              });
              this.advice.tableData.splice(index, 1);
            } else {
              this.$message({
                type: "error",
                message: "网络错误"
              });
            }
          })
        })


      },
      deleteComplaint(index, row) {
        var data = new FormData();
        data.append("id", row.id);
        this.$confirm('此操作将永久删除, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          axiosHandle.post('admin/Advice/delete', data).then(res => {
            if (res.data.status == 1) {
              this.$message({
                type: "success",
                message: "删除成功"
              });
              this.complaint.tableData.splice(index, 1);
            } else {
              this.$message({
                type: "error",
                message: "网络错误"
              });
            }
          })
        })


      },
      alert(str, title = "具体内容") {
        this.$alert(str, title, {
          confirmButtonText: '确定',
        });
      },
    },
    created() {
      axiosHandle.setThis(this);
      var data = new FormData();
      var _self = this;
      data.append("page", this.advice.nowPage);
      axiosHandle.post('admin/Advice/getAdvice', data).then(res => {
        this.advice.tableData = res.data.advice;
        this.advice.total = res.data.total;
        var data2 = new FormData();
        data2.append("page", this.complaint.nowPage);
        axiosHandle.post('admin/Advice/getComplaint', data2).then(res => {
          this.complaint.tableData = res.data.complaint;
          this.complaint.total = res.data.total;
        })
      })
    }
  }

</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="less">
  #advice {
    padding: 10px;
  }

  table {
    text-align: left;
  }

</style>
