<template>
  <div id="employee">
    <div id="content_div_left">
      <ul>
        <li v-for="(item,index) in peopleInform" :key="index" :class="{'select':topList[index]}" @mouseover="select(index)">
          {{item.name}}
        </li>
      </ul>
    </div>
    <div id="content_div_right">
      <table v-if="peopleInform[position]['total']!=0">
        <tr>
          <th style="width:15%">id</th>
          <th style="width:15%">头像</th>
          <th style="width:15%">职务</th>
          <th style="width:15%">名称</th>
          <th style="width:15%">资历</th>
          <th style="width:15%">工资</th>
        </tr>
        <tr v-for="(i,index) in peopleInform[position]['data']" :key="index">
          <td>{{ i["id"] }}</td>
          <td>
            <img :src="i['head_img']==''?'./static/image/no_data.jpeg':$store.state.imgUrl+i['head_img']" class="headPic">
          </td>
          <td>{{ i["title"] }}</td>
          <td>{{ i["name"] }}</td>
          <td>{{ i["time"] | curriculum}}</td>
          <td>{{ i["salary"] }}</td>
        </tr>
      </table>
      <div v-if="peopleInform[position]['total']==0" style="margin-top:100px;height:300px;background:url(/static/image/no_data.jpeg) no-repeat center">
        <h1>┭┮﹏┭┮没数据啦</h1>
      </div>
      
    </div>
  </div>
</template>

<script>
  import { axiosHandle } from "../lib/utils";
  export default {
    name: 'employee',
    data() {
      return {
        position:0,
        topList: [],
        peopleInform: []
      }
    },
    filters:{
       curriculum(value){
          var time=new Date().getTime()/1000;
          time=Math.ceil(time);
          var day=parseFloat((time-value)/86400)
          if(year<30)
            return Math.floor(day)+"天";
          else{
             var month=parseFloat(day/30);
             if(month<12){
                return Math.floor(month)+"天";
             }else{
                var leftMonth=month%12;
                var year=Math.floor(month/12);
                return year+"年零"+leftMonth+"个月"
             }
          }  
       }
    },
    methods: {
     select(index){
        for(var i in this.topList){
          this.topList[i]=false;
        };
        this.topList.splice(index,1,true);
        this.position=index;
     }
    },
    created() {
      axiosHandle.setThis(this);
       //ljj获取部门信息和各部门工资最高，资料最深的前5个员工
      axiosHandle.post("index/Employee/index").then(res=>{
          this.peopleInform=res.data;
          console.log(this.peopleInform);
          var start=0;
          for(var i in this.peopleInform){
            if(start==0){
              this.topList[i]=true;
              this.position=i;
            }else{
              this.topList[i]=false;
            }
            start++;
          }
      })  
    },


  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
  @keyframes scaleout {
    0% {
      transform: scale(1.0);
      -webkit-transform: scale(1.0);
    }
    100% {
      transform: scale(1.5);
      -webkit-transform: scale(1.5);
      opacity: 0;
    }
  }
  @keyframes scaleout2 {
    0% {
      transform: scale(1.0);
      -webkit-transform: scale(1.0);
    }
    100% {
      transform: scale(2);
      -webkit-transform: scale(2);
      opacity: 0;
    }
  }
  @yellow: #ffd333;
  @green: #7be92f;
  #employee {
    width: 95%;
    overflow: hidden;
    margin-bottom: 20px
  }
  .headPic {
    height: 60px;
    width: 60px;
  }
  #content_div_left {
    float: left;
    margin-top: 70px;
    width: 20%;
    ul {
      margin: 10px auto;
      width: 80px;
      & > li {
        @height: 70px;
        height: @height;
        line-height: @height;
        color: white;
        width: @height;
        border-radius: 50%;
        background-color: @yellow;
        margin-bottom: 20px;
        position: relative;
        transition: .5s;
        &:after {
          content: "";
          top: 0;
          bottom: 0;
          left: 0;
          right: 0;
          position: absolute;
          border-radius: 50%;
          border: 2px solid @yellow;
          animation: scaleout 3s ease-in-out infinite;
        }
        &:before {
          @size: 0;
          content: "";
          top: @size;
          bottom: @size;
          left: @size;
          right: @size;
          position: absolute;
          border-radius: 50%;
          border: 2px solid @yellow;
          animation: scaleout2 3s ease-in-out infinite;
        }
      }
      & > li:nth-of-type(2):after {
        animation-delay: .5s;
      }
      & > li:nth-of-type(3):after {
        animation-delay: 1s;
      }
      & > li:nth-of-type(4):after {
        animation-delay: 1.5s;
      }
      & > li:nth-of-type(2):before {
        animation-delay: .5s;
      }
      & > li:nth-of-type(3):before {
        animation-delay: 1s;
      }
      & > li:nth-of-type(4):before {
        animation-delay: 1.5s;
      }
    }
    .select {
      background-color: @green;
      &:after {
        border-color: @green;
      }
      &:before {
        border-color: @green;
      }
    }
  }
  #content_div_right {
    float: left;
    width: 80%;
    margin-top: 20px;
    vertical-align: middle;
    table {
      width: 90%;
      border-collapse: collapse;
    }
    tr > td, tr > th {
      min-width: 50px;
      padding: 10px 20px;
      /*border: 1px solid #ccc;*/
    }
    tr:nth-child(2n){
      background: #f0f0f0;
    }

  }
</style>
