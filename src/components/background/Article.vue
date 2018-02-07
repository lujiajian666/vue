<template>
  <div id="article">
    <div class="title">
      <span>{{$route.query.name}}</span>&nbsp;&nbsp;&nbsp;
      <el-button type="primary" icon="el-icon-edit"
                 class="add" @click="to(3)"></el-button>
      <el-button type="primary" icon="el-icon-view"
                 class="add" @click="to(1)"></el-button>
    </div>
    <div class="content">
      <div id="show" v-show="select==1">
        <div v-if="!tableData.length">
          <img src="/static/image/no_data.jpeg" style="vertical-align: middle;">
          啥都没有
        </div>
        <div v-if="tableData.length" class="div">
          <table>
            <tbody>
            <tr>
              <th style="width: 30%;text-align: center">标题</th>
              <th style="width: 40%;text-align: center">内容</th>
              <th style="width: 30%;text-align: center;">操作</th>
            </tr>
            <tr v-for="val in tableData">
              <td style="text-align: center">{{val['title']}}</td>
              <td>{{val['content']}}</td>
              <td style="text-align: center">
                <i class="el-icon-edit" @click="editArticle(val['article_id'])"></i>
                &nbsp;&nbsp;&nbsp;
                <i class="el-icon-delete" @click="deleteArticle(val['article_id'])"></i>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
        <div v-if="tableData.length" style="position: absolute;bottom: 30px;left: 0">
          <el-pagination
            background layout="prev, pager, next"
            :total="tableData.length">
          </el-pagination>
        </div>
      </div>
      <div id="edit" v-show="select==2">
        <div class="form-contain">
          <el-form ref="form"
                   :model="form" label-width="80px"
                   :label-position="labelPosition"
                   v-loading="wait">
            <el-form-item label="对齐方式">
              <el-radio-group v-model="labelPosition" size="small">
                <el-radio-button label="left">左对齐</el-radio-button>
                <el-radio-button label="right">右对齐</el-radio-button>
                <el-radio-button label="top">顶部对齐</el-radio-button>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="文章">
              <el-input v-model="edit.title"></el-input>
            </el-form-item>
            <el-form-item label="排序">
              <el-input-number v-model="edit.sort" @change="handleChange" :min="1" :max="10" label="描述文字">
              </el-input-number>
            </el-form-item>
            <el-form-item label="文章内容">
              <el-input type="textarea" v-model="edit.content" :rows="10"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="onSubmit('edit')" >立即修改</el-button>
              <el-button>取消</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
      <div id="add" v-show="select==3">
        <div class="form-contain">
          <el-form ref="form"
                   :model="form" label-width="80px"
                   :label-position="labelPosition"
                   v-loading="wait">
            <el-form-item label="对齐方式">
              <el-radio-group v-model="labelPosition" size="small">
                <el-radio-button label="left">左对齐</el-radio-button>
                <el-radio-button label="right">右对齐</el-radio-button>
                <el-radio-button label="top">顶部对齐</el-radio-button>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="文章">
              <el-input v-model="form.title"></el-input>
            </el-form-item>
            <el-form-item label="排序">
              <el-input-number v-model="form.sort" @change="handleChange" :min="1" :max="10" label="描述文字">
              </el-input-number>
            </el-form-item>
            <el-form-item label="文章内容">
              <el-input type="textarea" v-model="form.desc" :rows="10"></el-input>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="onSubmit('add')">立即创建</el-button>
              <el-button>取消</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import { Loading } from 'element-ui';
  export default {
    data() {
      return {
        totalPage: 100,
        select: 1,
        labelPosition: "right",
        form: {
          title: '',
          sort: 1,
          desc: ''
        },
        edit:{

        },
        tableData: [],
        wait:false
      }

    },
    methods: {
      onSubmit(type) {
        var _self = this;
        var message = "";
        if(type=="add"){
          if (this.form.title == "") message = "标题不能为空";
          if (this.form.desc == "") message = "内容不能为空";
        }else{
          if (this.edit.title == "") message = "标题不能为空";
          if (this.edit.desc == "") message = "内容不能为空";
        }
        if (message != "") {
          this.$alert(message, '!!!', {
            confirmButtonText: '确定',
            callback: action => {
              this.$message({
                type: 'info',
                message: '提交已取消'
              });
            }
          });
          return;
        }
          _self.wait=true;
        var data = new FormData();
        if(type=="add"){
          data.append("title", this.form["title"]);
          data.append("sort", this.form["sort"]);
          data.append("content", this.form["desc"]);
          data.append("type", this.$route.query.id)
          var phpUrl=this.$store.state.phpUrl + 'admin/article/addArticle'
        }else{
          data.append("title", this.edit["title"]);
          data.append("sort", this.edit["sort"]);
          data.append("content", this.edit["content"]);
          data.append("article_id", this.edit["article_id"]);
          data.append("type", this.$route.query.id)
          var phpUrl=this.$store.state.phpUrl + 'admin/article/editArticle'
        }
        this.$axios.post(phpUrl,data)
          .then(function (response) {
            var data = response.data;
            if (data.status == 1) {
              _self.$message({
                type: 'success',
                message: '操作成功'
              });
              _self.select = 1;
              _self.getArticle()
            } else {
              _self.$message.error('操作失败')
            }
              _self.wait=false;
          })
          .catch(function (error) {
            console.log(error);
              _self.wait=false;
          });
      },
      handleChange(value) {
        console.log(value);
      },
      to(n) {
        this.select = n;
      },
      getArticle() {
        var _self = this;
        var type = this.$route.query.id;
        var data = new FormData();
        data.append("type", type);
        this.$axios.post(this.$store.state.phpUrl + 'admin/article/getArticle'
          , data)
          .then(function (response) {
            var data = response.data;
            _self.tableData = data;
          })
          .catch(function (error) {
            console.log(error);
              _self.wait=false;
          });
      },
      deleteArticle(id) {
        var _self = this;
          _self.wait=true;
        var data = new FormData();
        data.append("article_id", id);
        this.$axios.post(this.$store.state.phpUrl + 'admin/article/deleteArticle'
          , data)
          .then(function (response) {
            if (response.data.status == 1) {
              _self.$message({
                type: 'success',
                message: '删除成功'
              });
              _self.tableData.forEach(function (value, index, arr) {
                if (value["article_id"] == id) {
                  arr.splice(index, 1);
                }
              })
            } else {
              _self.$message({
                type: 'error',
                message: '删除失败'
              });
            }
              _self.wait=false;
          })
          .catch(function (error) {
            _self.$message({
              type: 'warning',
              message: '网络错误'
            });
              _self.wait=false;
          });
      },
      editArticle(id) {
        this.edit=null;
        for(var i of this.tableData){
          if(i["article_id"]==id){
            this.edit=i;
          }
        }
        if(this.edit==null){
          this.$message({
            type:"warning",
            message:"意外错误"
          })
        }else{
          this.select=2;
        }
      }
    },
    watch: {
      '$route'(to, from) {
        this.select=1;
        var index = this.$route.query.id;
        this.getArticle();
      }
    },
    created() {
      this.getArticle();
    }

  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
  .button(@color:white;@bgColor:orange;@width:100px;@lineHeight:2;@fontSize:15px) {
    border-radius: 5px;
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
    text-align: left;
  }

  .add {
    float: right;
    margin: 5px 10px;
  }

  table {
    border-collapse: collapse;
    width: 100%;
    line-height: 50px;
    & tr:not(:last-of-type) {
      border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    & td{
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
      max-width: 0px;
    }
  }

  .div {
    padding: 10px 5%;
    height: 450px;
    overflow: auto;
  }
</style>
