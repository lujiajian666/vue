<template>
  <div id="floatRigntDiv">
    <ul>
        <li @mouseenter="show(0)" @mouseleave="hide(0)" >
        <div>
          <i class="fa fa-send"></i>
          <p>写信</p>
        </div>
        <div class="hidden" v-show="hiddenDiv[0]">
          <ul>
            <li>
              <div class="hiddenSubDiv">
                <i class="fa fa-exclamation-triangle"></i>
                <br>
                投诉
              </div>
            </li>
            <li>
              <div class="hiddenSubDiv">
                <i class="fa fa-envelope-open-o"></i>
                <br>
                建议
              </div>
            </li>
          </ul>
        </div>
      </li>
        <li @mouseenter="show(1)" @mouseleave="hide(1)" >
        <div>
          <i class="fa fa-question"></i>
          <p>常见问题</p>
        </div>
        <div class="hidden" v-show="hiddenDiv[1]">
          <ul>
            <li>
              <div class="hiddenSubDiv">
                  <i class="fa fa-question-circle"></i>
                  <br>
                  <span class="textOverflow">为什么我没钱</span>
              </div>
            </li>
            <li>
              <div class="hiddenSubDiv">
                <i class="fa fa-question-circle"></i>
                <br>
                <span class="textOverflow">为什么我没女朋友</span>
              </div>
            </li>
            <li>
              <div class="hiddenSubDiv">
                <i class="fa fa-question-circle"></i>
                <br>
                <span class="textOverflow">为什么我没房子</span>
              </div>
            </li>
            <li>
              <div class="hiddenSubDiv">
                <i class="fa fa-question-circle"></i>
                <br>
                <span class="textOverflow">为什么我没车</span>
              </div>
            </li>
          </ul>
        </div>
      </li>
        <li @mouseenter="show(2)" @mouseleave="hide(2)" >
        <div>
          <i class="fa fa-android"></i>
          <p>AI客服</p>
        </div>
        <div class="hidden" v-show="hiddenDiv[2]">
          <ul>
            <li>
              <div class="hiddenSubDiv">
                 <i class="fa fa-meh-o"></i>
                 <br>
                 <span class="textOverflow">AI 小兰</span>
              </div>
            </li>
            <li>
              <div class="hiddenSubDiv">
                <i class="fa fa-meh-o"></i>
                <br>
                <span class="textOverflow">AI 小蓝</span>
              </div>
            </li>
          </ul>
        </div>
      </li>
        <li @click="top" >
        <div style="border-bottom: none">
          <i class="fa  fa-chevron-up"></i>
          <p>回到顶部</p>
        </div>
      </li>
        <li>
        <div style="background-color: #188be9;color: white;transition:1s" :class="pClass" @click="putAway">
          <p>{{pWord}}</p>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
  export default {
    name: 'floatRigntDiv',
    data() {
      return {
        msg: "data",
        hiddenDiv: {"0": false, "1": false, "2": false},
        pClass:"lay_out",
        pWord:"收起"
      }
    },
    methods: {
      "show": function (val) {
        this.hiddenDiv[val] = true;
        //console.log("hiddenDiv"+val+":"+this.hiddenDiv[val])
      },
      "hide": function (val) {
        this.hiddenDiv[val] = false;
        //console.log("hiddenDiv"+val+":"+this.hiddenDiv[val])
      },
      "top": function () {
        window.scrollTo(0, 0)
      },
      putAway:function () {
         if(this.pClass=="lay_out"){
            this.pWord="展开";
            this.pClass="put_away";

            //ljj 前四个li上滑
           console.log( $("#floatRigntDiv"))
           $("#floatRigntDiv>ul>li:not(:last-of-type)").animate({height:0},1000,function () {
               $(this).css("overflow","hidden")
           })
         }else{
           this.pWord="收起";
           this.pClass="lay_out";
           $("#floatRigntDiv>ul>li:not(:last-of-type)").animate({height:"80px"},1000,function () {
             $(this).css("overflow","visible")
           })
         }
      }
    }

  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">


  .lay_out{
    height: 30px;
    line-height: 30px;
  }
  .put_away{
    margin:0 auto;
    height:60px;
    line-height: 60px;
    width:60px;
    border-radius: 50% !important;
  }
  .textOverflow{
    display: block;
    text-overflow: ellipsis;
    width: 100%;
    white-space: nowrap;
    overflow: hidden;
  }
  .fa {
    line-height: 60px;
    font-size: 30px;
  }

  #floatRigntDiv {
    /*opacity: 0.8;*/
    position: fixed;
    right: 50px;
    top: 120px;
    z-index: 10;

  }

  ul {
    list-style: none;
    font-size: 12px;
    text-align: center;
  }

  ul > li {
    position: relative;
  }

  ul > li > .hidden {
    position: absolute;
    left: -101px;
    top: 0;
    width: 100px;
    background-color: transparent;
    border-bottom: none;
  }

  .hidden ul > li  .hiddenSubDiv{
    background-color: white;
    border: 1px solid #ccc;
    border-bottom: none;
    border-radius: 0 !important;
    width: 80px;
    height: 80px;
  }
  .hidden ul >li:last-of-type .hiddenSubDiv{
    border-bottom: 1px solid #ccc;
  }

  .hidden ul > li:first-of-type .hiddenSubDiv:after {
    content: '';
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    right: -1px;
    height: 0;
    width: 0;
    border: 10px solid transparent;
    border-left-color: white;
  }

  .hidden ul > li:first-of-type .hiddenSubDiv:before {
    content: '';
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    right: -3px;
    height: 0;
    width: 0;
    border: 11px solid transparent;
    border-left-color: #ccc;
  }

  ul > li > div {
    cursor: pointer;
    height: 80px;
    width: 70px;
    border-bottom: 1px solid #e5e5e5;
    background-color: #f7fbfd;
  }

  ul > li > div:not([class=hidden]):hover {
    background-color: #188be9;
    color: white;
  }

  ul > li:first-of-type > div {
    border-radius: 5px 5px 0 0;
  }

  ul > li:last-of-type > div {
    border-radius: 0 0 5px 5px;
    border-bottom: none;
  }
</style>
