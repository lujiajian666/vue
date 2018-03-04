<template>
    <div id="AttendanceVerify">
        <el-table
                :data="tableData" v-loading="loading"
                style="width: 98%;margin: 10px auto;text-align: left">
            <el-table-column
                    prop="begin_time"
                    label="开始时间">
            </el-table-column>
            <el-table-column
                    prop="end_time"
                    label="结束时间">
            </el-table-column>
            <el-table-column
                    prop="username"
                    label="申请人">
            </el-table-column>
            <el-table-column
                    label="操作"
                    width="100">
                <template slot-scope="scope">
                    <el-button type="text" @click="showReason(scope.$index)" >
                        审批
                    </el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-dialog
                :modal-append-to-body=false
                title="申请原因"
                :visible.sync="dialogVisible"
                width="30%"
                :before-close="handleClose">
            <span>{{reason}}</span>
            <span slot="footer" class="dialog-footer">
            <el-button @click="handleApply('ban')">否 决</el-button>
            <el-button type="primary" @click="handleApply('pass')">通 过</el-button>
            </span>
        </el-dialog>

    </div>
</template>

<script>
    import {vuexHandle,axiosHandle } from "../../lib/utils.js"

    export default {
        data() {
            return {
                loading: false,
                tableData: [],
                dialogVisible: false,
                reason:"原因原因原因",
                id:0,
                index:0
            }
        },
        methods: {
            handleClose() {
                this.dialogVisible = false;
            },
            showReason(key){
                this.dialogVisible=true;
                this.id=this.tableData[key].id;
                this.index=key;
                this.reason=this.tableData[key].reason;
            },
            handleApply(type){
                var _self = this;
                var data=new FormData();
                data.append("type",type);
                data.append("id",this.id);
                axiosHandle.post('admin/Vacation/applyHandle',data)
                    .then(function (response) {
                        var data = response.data;
                        if(data.status==1){
                            _self.tableData.splice(_self.index,1);
                            _self.dialogVisible=false;
                            _self.$message({
                                type: 'success',
                                message: '审核成功'
                            });
                        }
                    })
                    .catch(function (error) {
                        _self.dialogVisible=false;
                        _self.$message({
                            type: 'error',
                            message: '审核失败'
                        });
                    });
            }
        },
        created: function () {
            var _self = this;
            axiosHandle.setThis(this);
            axiosHandle.post('admin/Vacation/applyVerify')
                .then(function (response) {
                    var data = response.data;
                    _self.tableData = data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">

</style>
