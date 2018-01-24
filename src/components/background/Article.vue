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
                <div class="div">
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
                                <i class="el-icon-edit"></i>
                                &nbsp;&nbsp;&nbsp;
                                <i class="el-icon-delete"></i>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div style="position: absolute;bottom: 30px;left: 0">
                    <el-pagination background layout="prev, pager, next" :total="totalPage"></el-pagination>
                </div>

            </div>
            <div id="edit" v-show="select==2"></div>
            <div id="add" v-show="select==3">
                <div class="form-contain">
                    <el-form ref="form" :model="form" label-width="80px" :label-position="labelPosition">
                        <el-form-item label="对齐方式">
                            <el-radio-group v-model="labelPosition" size="small">
                                <el-radio-button label="left">左对齐</el-radio-button>
                                <el-radio-button label="right">右对齐</el-radio-button>
                                <el-radio-button label="top">顶部对齐</el-radio-button>
                            </el-radio-group>
                        </el-form-item>
                        <el-form-item label="文章名称">
                            <el-input v-model="form.name"></el-input>
                        </el-form-item>
                        <el-form-item label="排序">
                            <el-input-number v-model="num1" @change="handleChange" :min="1" :max="10" label="描述文字">
                            </el-input-number>
                        </el-form-item>
                        <el-form-item label="文章内容">
                            <el-input type="textarea" v-model="form.desc" rows=10></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="onSubmit">立即创建</el-button>
                            <el-button>取消</el-button>
                        </el-form-item>
                    </el-form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                totalPage:100,
                select: 1,
                labelPosition: "right",
                num1: 1,
                form: {
                    name: '',
                    date1: '',
                    date2: '',
                    desc: ''
                },
                tableData: [
                    {
                        title: "文章一",
                        content: "adfasdfasfasdffdf"
                    },
                    {
                        title: "文章一",
                        content: "adfasdfasfasdffdf"
                    },
                    {
                        title: "文章一",
                        content: "adfasdfasfasdffdf"
                    },
                    {
                        title: "文章一",
                        content: "adfasdfasfasdffdf"
                    },
                    {
                        title: "文章一",
                        content: "adfasdfasfasdffdf"
                    },
                    {
                        title: "文章一",
                        content: "adfasdfasfasdffdf"
                    },
                    {
                        title: "文章一",
                        content: "adfasdfasfasdffdf"
                    },
                    {
                        title: "文章一",
                        content: "adfasdfasfasdffdf"
                    },
                    {
                        title: "文章一",
                        content: "adfasdfasfasdffdf"
                    },
                    {
                        title: "文章一",
                        content: "adfasdfasfasdffdf"
                    },
                    {
                        title: "文章一",
                        content: "adfasdfasfasdffdf"
                    },
                    {
                        title: "文章一",
                        content: "adfasdfasfasdffdf"
                    },
                ]
            }

        }
        ,
        methods: {
            onSubmit() {
                console.log('submit!');
            }
            ,
            handleChange(value) {
                console.log(value);
            },
            to(n) {
                this.select = n;
            },
            handleEdit(index, row) {
                console.log(index, row);
            },
            handleDelete(index, row) {
                console.log(index, row);
            }
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
    table{
        border-collapse: collapse;
        width: 100%;
        line-height: 50px;
        & tr:not(:last-of-type){
            border-bottom: 1px solid rgba(0,0,0,0.1);
        }
    }
    .div{
        padding: 10px 5%;
        height: 450px;
        overflow: auto;
    }
</style>
