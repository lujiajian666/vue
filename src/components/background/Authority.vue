<template>
    <div id="Authority">
        <el-transfer
                v-loading="wait"
                lujiajian
                v-model="value"
                filterable
                :titles="['所有权限', '启用权限']"
                :button-texts="['到左边', '到右边']"
                :format="{
                    noChecked: '${total}',
                    hasChecked: '${checked}/${total}'
                }"
                @change="handleChange"
                :data="data">
        </el-transfer>
        <el-button type="success" @click="submit">保存修改</el-button>
    </div>
</template>

<script>
    import {vuexHandle,axiosHandle} from "../../lib/utils.js"

    export default {
        data() {
            return {
                wait:false,
                arr:[],
                data: [],
                value: [],
            };
        },
        methods: {
            generateData(arr){
                const newData=[];
                for(var i in arr){
                    newData.push({key:i,label:arr[i]["name"]})
                }
                return newData;
            },
            generateSelectData(arr){
                var newData=[];
                for(var i of arr){
                    for(var j=0;j<this.arr.length;j++){
                        if(this.arr[j]["id"]==i){
                            newData.push(j.toString())
                            break;
                        }
                    }
                }
                return newData;
            },
            handleChange(value, direction, movedKeys) {
                console.log(value, direction, movedKeys);
            },
            submit(){
                var _self=this;
                var arr=[];
                for(var i of this.value){
                    arr.push({
                            id:this.arr[i]["id"],
                            controller:this.arr[i]["controller"],
                            action:this.arr[i]["action"],
                            name:this.arr[i]["name"]
                        })}
                var data=new FormData();
                data.append("data",JSON.stringify(arr));
                axiosHandle.post("admin/authority/saveAuthority",data)
                .then(function (response) {
                    var data=response.data;
                    if(data.status==1){
                        _self.$message({
                            type: 'success',
                            message: '保存成功'
                        });
                    }else{
                        _self.$message({
                            type: 'error',
                            message: '保存失败'
                        });
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        watched:{
            value(old,current){
                console.log(current)
            }
        },
        created(){
            var _self=this;
            axiosHandle.setThis(this);
            //ljj 获取所有基本权限项
            axiosHandle.post("admin/authority/getAuthority")
                .then(function (response) {
                    var data=response.data;
                    _self.arr=data.allData;
                    _self.data=_self.generateData(data.allData);
                    _self.value=_self.generateSelectData(data.selectData);
                })
                .catch(function (error) {
                    console.log(error);
                });

        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style lang="less">
    .el-transfer[lujiajian]>.el-transfer-panel{
        width: 300px;
        height: 400px;
        &>.el-transfer-panel__body{
            height: 346px;
            &>.el-transfer-panel__list.is-filterable{
                height:300px
            }
        }
    }
    .el-transfer{
        margin-top: 20px;
        text-align: center;
    }
    .el-transfer>div{
        text-align: left;
    }
    .transfer-footer {
        margin-left: 20px;
        padding: 6px 5px;
    }
</style>
