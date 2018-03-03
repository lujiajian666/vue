<template>
    <div id="WorkAttendance">
        <el-tabs v-model="activeName" @tab-click="handleClick" v-loading="loading">
            <el-tab-pane label="考勤记录" name="first">
                <full-calendar :events="fcEvents" @changeMonth="changeMonth"></full-calendar>
            </el-tab-pane>
            <el-tab-pane label="签到" name="second">
                <div id="clock">
                    <p class="date">{{ date.date }}</p>
                    <p class="time">{{ date.time }}</p>
                    <p class="text">
                        <el-button type="warning" @click="checkIn">签到/签退</el-button>
                    </p>
                </div>

            </el-tab-pane>
        </el-tabs>
    </div>
</template>

<script>
    import fullCalendar from 'vue-fullcalendar'
    import { vuexHandle } from "../../lib/utils.js"
    export default {
        data() {
            return {
                loading:false,
                week:['星期日', '星期一', '星期二', '星期三', '星期四', '星期五', '星期六'],
                date: {
                    time: '',
                    date: ''
                },
                activeName: 'first',
                fcEvents:[]
            }
        },
        components: {
            "full-calendar": fullCalendar
        },
        methods: {
            handleClick(tab, event) {
                console.log(tab, event);
            },
            updateTime() {
                var cd = new Date();
                this.date.time = this.zeroPadding(cd.getHours(), 2) + ':' +
                                 this.zeroPadding(cd.getMinutes(), 2) + ':' +
                                 this.zeroPadding(cd.getSeconds(), 2);
                this.date.date = this.zeroPadding(cd.getFullYear(), 4) + '-' +
                                 this.zeroPadding(cd.getMonth() + 1, 2) + '-' +
                                 this.zeroPadding(cd.getDate(), 2) + ' ' +
                                 this.week[cd.getDay()];
            },
            zeroPadding(num, digit) {
                var zero = '';
                for (var i = 0; i < digit; i++) {
                    zero += '0';
                }
                return (zero + num).slice(-digit);
            },
            checkIn(){
                var _self=this;
                _self.loading=true;
                var data=new FormData();
                data.append("username",vuexHandle.getVuex(this,"username"))
                this.$axios.post(this.$store.state.phpUrl + 'admin/vacation/addAttendance',
                data).then(function (response) {
                    var data=response.data;
                    if(data.status==1){
                        _self.$message({
                            type: 'success',
                            message: data.txt
                        });
                    }else{
                        _self.$message({
                            type: 'error',
                            message: data.txt
                        });
                    }
                    _self.loading=false;
                })
            },
            changeMonth(start, end, current){
                var _self=this;
                var data=new FormData();
                data.append("username",vuexHandle.getVuex(this,"username"));
                data.append("currentTime",Math.floor(new Date(current).getTime()/1000));
                _self.loading=true;
                this.$axios.post(this.$store.state.phpUrl + 'admin/vacation/getAttendance',
                    data).then(function (response) {
                    var data=response.data;
                    if(data.status==1){
                        _self.fcEvents=data.data;
                    }
                    _self.loading=false;
                })
            }
        },
        created: function () {
            setInterval(this.updateTime, 1000);
            this.updateTime();
            var _self=this;
            var data=new FormData();
            data.append("username",vuexHandle.getVuex(this,"username"));
            data.append("currentTime",Math.floor(new Date().getTime()/1000));
            _self.loading=true;
            this.$axios.post(this.$store.state.phpUrl + 'admin/vacation/getAttendance',
                data).then(function (response) {
                var data=response.data;
                if(data.status==1){
                    _self.fcEvents=data.data;
                }
                _self.loading=false;
            })
        },
        watch: {
            '$route'(to, from) {
            }
        }


    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style  lang="less">
    #WorkAttendance {
        padding: 10px;
    }
    p {
        margin: 0;
        padding: 0;
    }

    #clock {
        overflow: hidden;
        font-family: 'Microsoft YaHei','Lantinghei SC','Open Sans',Arial,'Hiragino Sans GB','STHeiti','WenQuanYi Micro Hei','SimSun',sans-serif;
        text-align: center;
        color: rgba(0,0,0,0.4);
        text-shadow: 0 0 20px rgba(0,0,0,0.8), 0 0 20px black;
    }
    #clock .time {
        letter-spacing: 0.05em;
        font-size: 80px;
        padding: 5px 0;
    }
    #clock .date {
        margin-top: 200px;
        letter-spacing: 0.1em;
        font-size: 24px;
    }
    #clock .text {
        letter-spacing: 0.1em;
        font-size: 12px;
        padding: 20px 0 0;
    }
    .late{
        background-color: orange !important;
        color: white !important;
    }
    .normal{
        background-color: green !important;
        color: white !important;
    }
    .leaveEarly{
        background-color: rgba(54, 99, 255, 0.53) !important;
        color: white !important;
    }
    .absent{
        background-color: red !important;
        color: white !important;
    }
</style>
