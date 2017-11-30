<template>
  <div id="floatRigntDiv">
    <ul>
      <li @mouseenter="show(0)" @mouseleave="hide(0)">
        <div>
          <i class="fa fa-send"></i>
          <p>写信</p>
        </div>
        <div class="hidden" v-show="hiddenDiv[0]">
          <div class="hiddenSubDiv">

          </div>
        </div>
      </li>
      <li @mouseenter="show(1)" @mouseleave="hide(1)">
        <div>
          <i class="fa fa-question"></i>
          <p>常见问题</p>
        </div>
        <div class="hidden" v-show="hiddenDiv[1]">
          <div class="hiddenSubDiv">

          </div>
        </div>
      </li>
      <li @mouseenter="show(2)" @mouseleave="hide(2)">
        <div>
          <i class="fa fa-android"></i>
          <p>AI客服</p>
        </div>
        <div class="hidden" v-show="hiddenDiv[2]">
          <div class="hiddenSubDiv">

          </div>
        </div>
      </li>
      <li @click="top">
        <div style="border-bottom: none">
          <i class="fa  fa-chevron-up"></i>
          <p>回到顶部</p>
        </div>
      </li>
      <li @mouseenter="show" @mouseleave="hide">
        <div style="background-color: #188be9;height: 30px;color: white;line-height: 30px">
          <p>收起</p>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import head from '@/components/head'
export default {
  name: 'floatRigntDiv',
  data () {
    return {
      msg: "data",
      hiddenDiv:{"0":false,"1":false,"2":false},
    }
  },
  methods:{
      "show":function (val) {
          this.hiddenDiv[val]=true;
          //console.log("hiddenDiv"+val+":"+this.hiddenDiv[val])
      },
      "hide":function (val) {
          this.hiddenDiv[val]=false;
          //console.log("hiddenDiv"+val+":"+this.hiddenDiv[val])
      },
      "top":function () {
          window.scrollTo(0,0)
      }
  }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .fa{
    line-height: 60px;
    font-size: 30px;
  }
   #floatRigntDiv{
     /*opacity: 0.8;*/
     position: fixed;
     right: 50px;
     top: 120px;
     z-index: 10;
   }
   ul{
     list-style: none;
     font-size: 12px;
     text-align: center;
   }
   ul>li{
     position: relative;
   }
   ul>li>.hidden{
     position: absolute;
     left:-101px;
     top:0;
     width: 100px;
     background-color: transparent;
     border-bottom: none;
   }
   ul>li>.hidden>.hiddenSubDiv{
     position: absolute;
     left: 0;
     top: 0;
     bottom: 0;
     background-color: white;
     border: 1px solid #ccc;
     border-radius: 0 !important;
     width: 80px;
   }
   ul>li>.hidden>.hiddenSubDiv:after{
     content: '';
     position: absolute;
     top: 50%;
     transform: translateY(-50%);
     right: -20px;
     height: 0;
     width: 0;
     border: 10px solid transparent;
     border-left-color: white;
   }
   ul>li>.hidden>.hiddenSubDiv:before{
     content: '';
     position: absolute;
     top: 50%;
     transform: translateY(-50%);
     right: -23px;
     height: 0;
     width: 0;
     border: 11px solid transparent;
     border-left-color: #ccc;
   }
   ul>li>div{
     cursor: pointer;
     height: 80px;
     width: 70px;
     border-bottom: 1px solid #e5e5e5;
     background-color: #f7fbfd;
   }
   ul>li>div:not([class=hidden]):hover{
     background-color: #188be9;
     color:white;
   }
   ul>li:first-of-type>div{
     border-radius:5px 5px 0 0;
   }
   ul>li:last-of-type>div{
     border-radius:0 0 5px 5px;
     border-bottom:none;
   }
</style>
