<template>
  <div id="article">
    <div class="title">
      <span>{{$route.query.name}}</span>&nbsp;&nbsp;&nbsp;
      <el-button type="primary" icon="el-icon-edit" class="add" @click="to(3)"></el-button>
      <el-button type="primary" icon="el-icon-view" class="add" @click="to(1)"></el-button>
    </div>
    <div class="content">
      <div id="show" v-show="select==1">
        <div v-if="!tableData.length">
          <img src="/static/image/no_data.jpeg" style="vertical-align: middle;"> 啥都没有
        </div>
        <div v-if="tableData.length" class="div">
          <el-table :data="tableData" border style=";text-align: left">
            <el-table-column prop="article_id" label="id">
            </el-table-column>
            <el-table-column prop="title" label="标题">
            </el-table-column>
            <el-table-column label="标题图片">
              <template slot-scope="scope">
                <img :src="scope.row.src!=''?$store.state.imgUrl+scope.row.src:'/static/image/no_data.jpeg'" 
                style="height:50px;width:50px">
              </template>
            </el-table-column>
            <el-table-column label="操作" width="100">
              <template slot-scope="scope">
                <el-button type="text" size="small" @click="deleteArticle(scope.row.article_id)">删除</el-button>
                <el-button type="text" size="small" @click="editArticle(scope.row.article_id)">编辑</el-button>
              </template>
            </el-table-column>
          </el-table>
        </div>
        <div v-if="tableData.length" style="position: absolute;bottom: 30px;left: 0">
          <el-pagination background layout="prev, pager, next" :total="allPage*10" @current-change="getArticle" :current-page.sync="nowPage"></el-pagination>
        </div>
      </div>
      <div id="edit" v-if="select==2">
        <div class="form-contain">
          <el-form ref="form" :model="form" label-width="80px" :label-position="labelPosition" v-loading="wait">
            <el-form-item label="对齐方式">
              <el-radio-group v-model="labelPosition" size="small">
                <el-radio-button label="left">左对齐</el-radio-button>
                <el-radio-button label="right">右对齐</el-radio-button>
                <el-radio-button label="top">顶部对齐</el-radio-button>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="图片上传">
              <el-upload class="upload-demo" drag :action="url" :file-list="fileList" :on-success="handleAvatarSuccess" :before-upload="beforeAvatarUpload"
                :before-remove="handleRemove" list-type="picture">
                <i class="el-icon-upload"></i>
                <div class="el-upload__text">将文件拖到此处，或
                  <em>点击上传</em>
                </div>
                <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过2MB</div>
              </el-upload>
            </el-form-item>
            <el-form-item label="文章">
              <el-input v-model="edit.title"></el-input>
            </el-form-item>
            <el-form-item label="排序">
              <el-input-number v-model="edit.sort" @change="handleChange" :min="1" :max="10" label="描述文字">
              </el-input-number>
            </el-form-item>
            <el-form-item label="文章内容" style="height:400px">
              <vue-editor v-model="edit.content"></vue-editor>
              <!--<el-input type="textarea" v-model="edit.content" :rows="10"></el-input>-->
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="onSubmit('edit')">立即修改</el-button>
              <el-button @click="select=1">取消</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
      <div id="add" v-if="select==3">
        <div class="form-contain">
          <el-form ref="form" :model="form" label-width="80px" :label-position="labelPosition" v-loading="wait">
            <el-form-item label="对齐方式">
              <el-radio-group v-model="labelPosition" size="small">
                <el-radio-button label="left">左对齐</el-radio-button>
                <el-radio-button label="right">右对齐</el-radio-button>
                <el-radio-button label="top">顶部对齐</el-radio-button>
              </el-radio-group>
            </el-form-item>
            <el-form-item label="图片上传">
              <el-upload class="upload-demo" drag :action="url" :file-list="fileList" :on-success="handleAvatarSuccess" :before-upload="beforeAvatarUpload"
                :before-remove="handleRemove" list-type="picture">
                <i class="el-icon-upload"></i>
                <div class="el-upload__text">将文件拖到此处，或
                  <em>点击上传</em>
                </div>
                <div class="el-upload__tip" slot="tip">只能上传jpg/png文件，且不超过2MB</div>
              </el-upload>
            </el-form-item>
            <el-form-item label="文章">
              <el-input v-model="form.title"></el-input>
            </el-form-item>
            <el-form-item label="排序">
              <el-input-number v-model="form.sort" @change="handleChange" :min="1" :max="10" label="描述文字">
              </el-input-number>
            </el-form-item>
            <el-form-item label="文章内容" style="height:400px">
             <vue-editor v-model="form.desc"></vue-editor>
            </el-form-item>
            <el-form-item>
              <el-button type="primary" @click="onSubmit('add')">立即创建</el-button>
              <el-button @click="select=1">取消</el-button>
            </el-form-item>
          </el-form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import {
    axiosHandle
  } from "../../lib/utils";
  import {
    Loading,
    Form
  } from 'element-ui';
  import { VueEditor } from 'vue2-editor';
  export default {
    data() {
      return {
        editorOption: {
          height: '1000px'
        },
        fileList: [],
        fileListUrl: '',
        url: this.$store.state.phpUrl + "admin/Upload/upload",
        select: 1,
        allPage: 1,
        nowPage: 1,
        labelPosition: "right",
        form: {
          title: '',
          sort: 1,
          desc: ''
        },
        edit: {

        },
        tableData: [],
        wait: false
      }

    },
    methods: {
      handleAvatarSuccess(res, file) {
        console.log(res);
        var name = res.pic.split("/").pop();
        this.fileList = [{
          name: name,
          url: this.$store.state.imgUrl + res.pic
        }];
        this.fileListUrl = res.pic;
      },
      handleRemove(file, fileList) {
        console.log("2")
        if (typeof this.fileList[0] != "undefined") {
          var _self = this;
          var data = new FormData();
          data.append("picUrl", this.fileList[0].url);
          return axiosHandle.post("admin/Upload/removePic", data).then(res => {
            if (res.data.status == 1) {
              _self.$message({
                type: "success",
                message: "删除成功"
              })
              _self.fileListUrl = "";
              _self.fileList = [];
              return Promise.resolve();
            } else {
              _self.$message({
                type: "error",
                message: "网络错误"
              })
              return Promise.reject();
            }
          })
        }
      },
      beforeAvatarUpload(file) {
        console.log(file.type)
        const isJPG = file.type === 'image/jpeg' || file.type === 'image/png';
        const isLt2M = file.size / 1024 / 1024 < 2;
        if (!isJPG) {
          this.$message.error('上传图片只能是 JPG 或者 PNG 格式!');
        }
        if (!isLt2M) {
          this.$message.error('上传图片大小不能超过 2MB!');
        }
        return isJPG && isLt2M;
      },
      onSubmit(type) {
        console.log(this.form);
        var _self = this;
        var message = "";
        if (type == "add") {
          if (this.form.title == "") message = "标题不能为空";
          if (this.form.desc == "") message = "内容不能为空";
        } else {
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
        _self.wait = true;
        var data = new FormData();
        if (type == "add") {
          data.append("title", this.form["title"]);
          data.append("sort", this.form["sort"]);
          data.append("content", this.form["desc"]);
          data.append("type", this.$route.query.id);
          data.append("src", this.fileListUrl);
          var phpUrl = 'admin/article/addArticle';
        } else {
          data.append("title", this.edit["title"]);
          data.append("sort", this.edit["sort"]);
          data.append("content", this.edit["content"]);
          data.append("article_id", this.edit["article_id"]);
          data.append("type", this.$route.query.id);
          data.append("src", this.fileListUrl);
          var phpUrl = 'admin/article/editArticle';
        }
        axiosHandle.post(phpUrl, data)
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
            _self.wait = false;
          })
      },
      handleChange(value) {
        console.log(value);
      },
      to(n) {
        this.form={
          title:"",
          desc:"",
          sort:1
        };
        console.log(this.form);
        this.fileList = [];
        this.fileListUrl = '';
        this.select = n;
      },
      getArticle() {
        console.log("getArticle")
        var _self = this;
        var type = this.$route.query.id;
        var data = new FormData();
        data.append("type", type);
        data.append("nowPage", this.nowPage)
        axiosHandle.post('admin/article/getArticle', data)
          .then(function (response) {
            var data = response.data;
            _self.tableData = data.article;
            _self.allPage = data.allPage;
          })
      },
      deleteArticle(id) {
        var _self = this;
        _self.wait = true;
        var data = new FormData();
        data.append("article_id", id);
        this.$confirm('此操作将永久删除, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          axiosHandle.post('admin/article/deleteArticle', data)
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
            })
        })

      },
      editArticle(id) {
        this.edit = null;
        this.fileListUrl = "";
        for (var i of this.tableData) {
          if (i["article_id"] == id) {
            this.edit = i;
            var arr = {};
            if (this.edit.src != "") {
              arr["url"] = this.$store.state.imgUrl + this.edit.src;
              arr["name"] = arr["url"].split("/").pop();
              this.fileList = [arr];
              this.fileListUrl = this.edit.src;
            }
          }
        }
        if (this.edit == null) {
          this.$message({
            type: "warning",
            message: "意外错误"
          })
        } else {
          this.select = 2;
        }
      }
    },
    watch: {
      '$route' (to, from) {
        this.select = 1;
        var index = this.$route.query.id;
        this.nowPage = 1;
        this.getArticle();
      }
    },
    components: {
      VueEditor
    },
    created() {
      this.getArticle();
      axiosHandle.setThis(this);
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
    & td {
      overflow: hidden;
      white-space: nowrap;
      text-overflow: ellipsis;
      max-width: 0px;
    }
  }

  .div {
    padding: 10px 1%;
    height: 450px;
    overflow: auto;
  }

</style>
