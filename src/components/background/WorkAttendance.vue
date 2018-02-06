<template>
    <div id="WorkAttendance">
        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="考勤记录" name="first">
                <work-attendance-form></work-attendance-form>
            </el-tab-pane>
            <el-tab-pane label="考勤统计" name="second">配置管理</el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    import workAttendanceForm from "../tool/canlender"
    export default {
        data() {
            return {
                activeName: 'second'
            }
        },
        components:{
            "work-attendance-form":workAttendanceForm
        },
        methods:{
            handleClick(tab, event) {
                console.log(tab, event);
            }
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
   #WorkAttendance{
       padding: 10px;
   }
</style>
