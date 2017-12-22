<template>
    <div id="BackgroundIndex">
        <div class="head">
           <div >中小企业政务管理系统后台</div>
           <div style="float: right">&nbsp;lujiajian</div>
           <div style="float: right">
               2017年5月5日 星期天
               &nbsp;&nbsp;&nbsp;&nbsp;
               <span style="opacity: 0.7">欢迎您</span>
           </div>
        </div>
        <div class="left">
           <ul>
               <li>
                   <ul>
                       <li @click="show(0)">人事管理</li>
                       <li class="hideUl" v-show="hideUl[0]">
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
                       <li @click="show(1)">权限管理</li>
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
                       <li @click="show(2)">公告管理</li>
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
               select:[true,false,false]
            }
        },
        components:{

        },
        methods:{
           show:function(num){
               this.hideUl.forEach(function(value,index,array){
                   if(index==num){
                       if(value==false){
                           array.splice(num,1,true);
                       }else{
                           array.splice(num,1,false);
                       }
                   }else{
                       array.splice(index,1,false);
                   }
               })
           }
        }

    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
    @headColor: #008ecc;
    @leftColor: #2d323b;
    @headHeight:70px;
    ul{
        list-style: none;
    }
   .head{
       height: @headHeight;
       background-color: @headColor;
       &>div{
           color: white;
           line-height: @headHeight;
           &:first-of-type{
               float: left;
               margin-left: 50px;
               font-size: 20px;
           }
       }
   }

    .left{
        float: left;
        width: 200px;
        line-height: 2;
        background-color: @leftColor;
        color: white;
        height: calc(~"-70px + 100vh");
        &>ul{
           text-align: left;
           list-style: none;
           &>li:first-of-type{
               margin-top: 20px;
           }
           &>li{
               position: relative;
               text-indent: 2em;
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
        margin-left: 200px;
    }
</style>
