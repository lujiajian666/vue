<template>
    <div id="vacationApply">
        <el-collapse v-model="activeName" accordion>
            <el-collapse-item title="请假日期" name="1">
                <div class="block">
                    <el-date-picker
                            v-model="value7"
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
            <el-collapse-item title="请假原因" name="2">
                <div style="padding:10px 30px">
                    <el-input
                            type="textarea"
                            :rows="10"
                            placeholder="请输入内容"
                            v-model="textarea">
                    </el-input>
                </div>

            </el-collapse-item>
            <el-collapse-item title="统计" name="3">
                <div>你已经累计休假 10 天</div>
                <div>年假剩余 0 天</div>
                <el-switch
                        v-model="value3"
                        inactive-text="我已阅读">
                </el-switch>
            </el-collapse-item>
        </el-collapse>
        <br><br><br><br>
        <el-button type="primary" :disabled="disable">确认申请</el-button>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                disable:true,
                value3: false,
                textarea: '',
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
                value6: '',
                value7: ''
            }
        },
        components:{
        },
        methods:{
        },
        created:function () {
        },
        watch:{
            '$route' (to,from){
            }
        }


    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">

</style>
