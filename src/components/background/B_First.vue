<template>
    <div id="B_First">
      <div class="title">
         <span>{{$route.query.departmentName}}</span>&nbsp;&nbsp;&nbsp;
         <el-button type="primary" icon="el-icon-edit"
                    class="add" @click="add"></el-button>
      </div>
      <div class="content">
         <ul v-if="people">
             <li v-for="p in people">
                 <div class="person">
                     <img :src="p.src" style="float: left">
                     <div>
                         <p>
                             姓名:{{p.name}}&nbsp;&nbsp;&nbsp;
                             职称:{{p.jobTitle}}&nbsp;&nbsp;&nbsp;
                             ID:{{p.id}}
                         </p>
                         <p>
                             入职时间:{{p.time}}&nbsp;&nbsp;&nbsp;
                             工资:{{p.salary}}
                         </p>
                     </div>
                     <div class="button1" @click="changeAlter($event)" :data-id="p.id">
                         修改
                     </div>
                     <div class="button2" @click="deleteEmployeeById($event)" :data-id="p.id">删除</div>
                 </div>
             </li>
         </ul>
         <img v-if="!people" src="/static/image/no_data.jpeg">
      </div>

      <alert-box title="添加" v-if="alert" @close="close"
                 @change="getAllEmployee($route.query.department)">

      </alert-box>
      <alter-box title="修改" v-if="alter" @close="closeAlter"
                 @change="getAllEmployee($route.query.department)">

      </alter-box>
    </div>
</template>

<script>
    import search_div from '@/components/searchDiv';
    import alertBox from '@/components/tool/alertBox';
    import alterBox from '@/components/tool/alertBox';
    export default {
        data() {
            return {
                people:[],
                alert:false,
                alter:false,
            }
        },
        components:{
            "alert-box":alertBox,
            "alter-box":alterBox
        },
        methods:{
            add:function(){//ljj 显示添加框
               this.alert=true;
            },
            close:function(){//ljj 关闭添加框
                this.alert=false;
            },
            closeAlter:function(){//ljj 关闭修改框
                this.alter=false;
            },
            changeAlter:function (node) {//ljj 显示修改框
                //ljj 获得员工id
                var id=node.currentTarget.getAttribute("data-id")
                //ljj 根据id获取员工信息
                this.getEmployee(id)
            },
            getEmployee:function (id) {
                var data=new FormData();
                var _self=this;
                var returnData;
                data.append("id",id);

                this.$axios.post(this.$store.state.phpUrl +'admin/background/getEmployeeById',
                    data)
                    .then(function (response) {
                        var data=response.data;
                        if(data.status==1){
                            if(data["man"]["src"]=="" || data["man"]["src"] == null){
                                data["man"]["src"]="/static/image/no_data.jpeg";
                            }else{
                                data["man"]["src"]=_self.$store.state.imgUrl+data.man["src"];
                            }
                            //ljj 记录信息
                            _self.$store.state.alterMessage=data["man"];
                            //ljj 显示
                            _self.alter=true;
                        }else{
                            console.log("加载失败")
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getAllEmployee:function (department) {
                var _self=this;
                var data=new FormData();
                data.append("department",department);


                this.$axios.post(this.$store.state.phpUrl +'admin/background/getEmployee',
                    data)
                    .then(function (response) {
                        var data=response.data;
                        if(data.status==1){
                            _self.people=data.people;
                            _self.people.forEach(function (value,index,array) {
                                if(value["src"]=="" || value["src"] == null){
                                    value["src"]="/static/image/no_data.jpeg";
                                }else{
                                    value["src"]=_self.$store.state.imgUrl+value["src"];
                                }
                            })
                        }else{
                            _self.people=null;
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            deleteEmployeeById:function (node) {
                var _self=this;
                var id=node.currentTarget.getAttribute("data-id");
                var data=new FormData();
                data.append("id",id);
                //ljj 根据id删除员工
                this.$axios.post(this.$store.state.phpUrl +'admin/background/deleteEmployeeById',
                    data)
                    .then(function (response) {
                        var data=response.data;
                        if(data.status==1){
                             _self.people.forEach(function (value,index,array) {
                                 if(value['id']==id){
                                     console.log(array)
                                     array.splice(index,1);
                                     console.log(array)
                                 }
                                 return;
                             })
                        }else{
                            alert("删除失败")
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        created:function () {
            if(this.$route.query.department!=undefined){
                this.getAllEmployee(this.$route.query.department);
            }
        },
        watch:{
            '$route' (to,from){
                var department=this.$route.query.department;
                if(typeof department!='undefined' && department!='' &&
                    !(typeof department!='undefined' && department!=0 && !department)){
                    this.getAllEmployee(department)
                }
            }
        }


    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
    .button(@color:white;@bgColor:orange;@width:100px;@lineHeight:2;@fontSize:15px){
        border-radius: 5px;
        background-color: @bgColor;
        color: @color;
        width: @width;
        line-height: @lineHeight;
        font-size: @fontSize;
        text-align: center;
        font-weight: bold;
    }
    .title{
        position: fixed;
        top:50px;left: 200px;right: 0;
        line-height: 50px;
        text-align: left;
        text-indent: 2em;
        color:#007fcf;
        border-bottom: 1px solid #007fcf;
        background-color: #f9f9f9;
    }
    .content{
        position: fixed;
        top:110px;left: 200px;right: 0;bottom: 0;
        overflow: auto;
    }
    .person{
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
        background:url(/static/image/background/black.jpg) fixed;
        background-size: contain;
        &>img{
            height: 100%;
            width: 150px;
            margin-right: 20px;
        }
        &>.button1{
            position: absolute;
            bottom: 5px;
            right: 10px;
            .button(white,orange,60px);
        }
        &>.button2{
            position: absolute;
            bottom: 5px;
            right: 80px;
            .button(white,#188aef,60px)
        }
    }
    .add{
        float: right;
        margin: 5px 10px;
    }
</style>
