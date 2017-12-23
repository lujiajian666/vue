<template>
    <div id="BackgroundIndex">
        <div class="head">
           <div style="background-color:#006591;">中小企业政务管理系统后台</div>
           <div style="float: right;margin-right: 50px">&nbsp;{{$store.state.username}}</div>
           <div style="float: right">
               <span v-html="today"></span>
               &nbsp;&nbsp;&nbsp;&nbsp;
               <span style="opacity: 0.7">欢迎您</span>
           </div>
        </div>
        <div class="left">
           <ul>
               <li>
                   <ul>
                       <li @click="show(0)" :class="{isselsct:select[0]}">
                           <i class="fa fa-address-card-o"></i>
                           人事管理
                       </li>
                       <li class="hideUl" v-show="hideUl[0]">
                           <ul>
                               <router-link tag="li" :to="{name:'B_First'}">研发部</router-link>
                               <router-link tag="li" :to="{name:'B_Second'}">后勤部</router-link>
                               <router-link tag="li" to>行政部</router-link>
                               <router-link tag="li" to>人事部</router-link>
                           </ul>
                       </li>
                   </ul>
               </li>
               <li>
                   <ul>
                       <li @click="show(1)" :class="{isselsct:select[1]}">
                           <i class="fa fa-superpowers"></i>
                           权限管理
                       </li>
                       <li class="hideUl" v-show="hideUl[1]">
                           <ul>
                               <li>部门1</li>
                               <li>部门2</li>
                               <li>部门3</li>
                               <li>部门4</li>
                           </ul>
                       </li>
                   </ul>
               </li>
               <li>
                   <ul>
                       <li @click="show(2)" :class="{isselsct:select[2]}">
                           <i class="fa fa-bullhorn"></i>
                           公告管理
                       </li>
                       <li class="hideUl" v-show="hideUl[2]">
                           <ul>
                               <li>部门1</li>
                               <li>部门2</li>
                               <li>部门3</li>
                               <li>部门4</li>
                           </ul>
                       </li>
                   </ul>
               </li>
           </ul>
        </div>
        <div class="right">
            <router-view></router-view>
        </div>

    </div>
</template>

<script>
    export default {
        data() {
            return {
               hideUl:[false,false,false,false],
               select:[true,false,false],
            }
        },
        components:{

        },
        methods:{
           show:function(num){
               var _self=this;
               this.hideUl.forEach(function(value,index,array){
                   if(index==num){
                       if(value==false){
                           array.splice(num,1,true);
                           _self.select.splice(num,1,true);
                       }else{
                           array.splice(num,1,false);
                       }
                   }else{
                       array.splice(index,1,false);
                       _self.select.splice(index,1,false);
                   }
               })
           }
        },
        computed:{
            today:function () {
                var time=new Date();
                var year=time.getFullYear();
                var month=time.getMonth()+1;
                var day=time.getDate();
                var weekday=time.getDay();
                var arr=["星期天","星期一","星期二","星期三","星期四","星期五","星期六"];
                return year+"年"+month+"月"+day+"日&nbsp;&nbsp;"+arr[weekday];
            }
        }

    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
    @headColor: #008ecc;
    @leftColor: #2d323b;
    @headHeight:50px;
    ul{
        list-style: none;
    }
   .head{
       position: fixed;
       top:0;
       left: 0;
       right: 0;
       height: @headHeight;
       background-color: @headColor;
       &>div{
           color: white;
           line-height: @headHeight;
           &:first-of-type{
               float: left;
               padding:0 50px;
               font-size: 12px;
           }
       }
   }

    .left{
        position: fixed;
        top:@headHeight;
        left: 0;
        bottom: 0;
        width: 200px;
        line-height: 2;
        background-color: @leftColor;
        color: white;
        font-size: 15px;
        &>ul{
           text-align: left;
           list-style: none;
           &>li:first-of-type{
               margin-top: 20px;
           }
           &>li{
               position: relative;
               text-indent: 1em;
               &:hover{
                   background-color: @headColor;
               }
           }
        }
    }
    .hideUl{
        background-color: @leftColor;
        text-indent: 3em;
        & li:hover{
            background-color: rgba(0,142,204,0.5);
        }
    }
    .right{
        position: fixed;
        top:@headHeight;
        left: 200px;
        bottom: 0;
        right: 0;
    }
    .isselsct{
        background-color: @headColor;
    }
</style>
