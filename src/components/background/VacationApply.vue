<template>
    <div id="vacationApply">
        <el-collapse v-model="activeName" accordion v-loading="wait">
            <el-collapse-item title="请假记录" name="1">
                <el-table
                        :data="tableData"
                        border
                        style="width: 98%;margin: 10px auto;text-align: left">
                    <el-table-column
                            prop="time"
                            label="申请日期">
                    </el-table-column>
                    <el-table-column
                            prop="begin_time"
                            label="开始时间">
                    </el-table-column>
                    <el-table-column
                            prop="end_time"
                            label="结束时间">
                    </el-table-column>
                    <el-table-column
                            prop="status"
                            label="结果">
                    </el-table-column>
                </el-table>
            </el-collapse-item>
            <el-collapse-item title="请假日期" name="2">
                <div class="block">
                    <el-date-picker
                            v-model="time"
                            type="daterange"
                            align="right"
                            unlink-panels
                            range-separator="至"
                            start-placeholder="开始日期"
                            end-placeholder="结束日期"
                            :picker-options="pickerOptions2">
                    </el-date-picker>
                </div>
            </el-collapse-item>
            <el-collapse-item title="请假原因" name="3">
                <div style="padding:10px 30px">
                    <el-input
                            type="textarea"
                            :rows="10"
                            placeholder="请输入内容"
                            v-model="reason">
                    </el-input>
                </div>

            </el-collapse-item>
            <el-collapse-item title="统计" name="4">
                <div>你已经累计休假 {{allVacationTime}} 天</div>
                <div>年假剩余 {{10-allVacationTime}} 天</div>
                <el-switch
                        v-model="hasRead"
                        inactive-text="我已阅读">
                </el-switch>
            </el-collapse-item>
        </el-collapse>
        <br><br><br><br>
        <el-button type="primary" :disabled="disable" @click="submit">确认申请</el-button>
    </div>
</template>

<script>
    import { vuexHandle,axiosHandle } from "../../lib/utils.js"
    export default {
        data() {
            return {
                tableData:[],
                allVacationTime:0,
                wait:false,
                hasRead: false,
                reason: '',
                activeName: '1',
                pickerOptions2: {
                    shortcuts: [{
                        text: '最近一周',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近一个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
                            picker.$emit('pick', [start, end]);
                        }
                    }, {
                        text: '最近三个月',
                        onClick(picker) {
                            const end = new Date();
                            const start = new Date();
                            start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
                            picker.$emit('pick', [start, end]);
                        }
                    }]
                },
                time: ''
            }
        },
        components:{
        },
        computed:{
          disable(){
              if(this.hasRead && this.reason!="" && this.time!=""){
                  return false;
              }else{
                  return true;
              }
          }
        },
        watch:{
          time(current,old){
            console.log(current[0])
          }
        },
        methods:{
          submit(){
            var _self=this;
            var data=new FormData();
            var begin_time=new Date(this.time[0]).getTime()/1000;
            var end_time=new Date(this.time[1]).getTime()/1000;
            data.append("reason",this.reason);
            data.append("begin_time",begin_time);
            data.append("end_time",end_time);
            data.append("username",vuexHandle.getVuex(this,"username"));
            axiosHandle.post('admin/vacation/addVacation', data)
              .then(function (response) {
                if (response.data.status == 1) {
                  _self.$message({
                    type: 'success',
                    message: '申请成功'
                  });
                } else {
                  _self.$message({
                    type: 'error',
                    message: '申请失败'
                  });
                }
              })
          }
        },
        created:function () {
            var _self=this;
            axiosHandle.setThis(this);
            _self.wait=true;
            var data=new FormData();
            data.append("username",vuexHandle.getVuex(_self,"username"));
            axiosHandle.post('admin/vacation/getVacation',
            data)
                .then(function (response) {
                    var data=response.data.data;
                    _self.tableData=data
                    _self.allVacationTime=response.data.allTime/86400;
                })
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">

</style>
