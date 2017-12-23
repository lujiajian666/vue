<template>
    <div id="B_First">
      <div class="title">
         <span>研发部</span>
      </div>
      <div class="content">
         <ul>
             <li v-for="p in people">
                 <div class="person">
                     <img :src="p.src" style="float: left">
                     <div>
                         <p>
                             姓名:{{p.name}}&nbsp;&nbsp;&nbsp;
                             职称:{{p.jobTitle}}&nbsp;&nbsp;&nbsp;
                             ID:{{p.id}}
                         </p>
                         <p>
                             入职时间:{{p.time}}&nbsp;&nbsp;&nbsp;
                             工资:{{p.salary}}
                         </p>
                     </div>
                     <div class="button1">
                         修改
                     </div>
                 </div>
             </li>
         </ul>
      </div>
    </div>
</template>

<script>
    import search_div from '@/components/searchDiv';
    export default {
        data() {
            return {
                people:[
                    {
                     "src":"/static/image/headPic.jpg","name":"路加减","time":"2017-1-1",
                     "jobTitle":"高级软件设计师","id":"20142005033","salary":10000
                    },
                    {
                        "src":"/static/image/headPic.jpg","name":"路加减","time":"2017-1-1",
                        "jobTitle":"高级软件设计师","id":"20142005033","salary":10000
                    },
                    {
                        "src":"/static/image/headPic.jpg","name":"路加减","time":"2017-1-1",
                        "jobTitle":"高级软件设计师","id":"20142005033","salary":10000
                    },
                    {
                        "src":"/static/image/headPic.jpg","name":"路加减","time":"2017-1-1",
                        "jobTitle":"高级软件设计师","id":"20142005033","salary":10000
                    },
                    {
                        "src":"/static/image/headPic.jpg","name":"路加减","time":"2017-1-1",
                        "jobTitle":"高级软件设计师","id":"20142005033","salary":10000
                    },
                    {
                        "src":"/static/image/headPic.jpg","name":"路加减","time":"2017-1-1",
                        "jobTitle":"高级软件设计师","id":"20142005033","salary":10000
                    },
                ],
            }
        },
        components:{

        },
        methods:{

        }

    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
    .button(@color:white;@bgColor:orange;@width:100px;@lineHeight:2;@fontSize:15px){
        border-radius: 5px;
        background-color: @bgColor;
        color: @color;
        width: @width;
        line-height: @lineHeight;
        font-size: @fontSize;
        text-align: center;
        font-weight: bold;
    }
    .title{
        position: fixed;
        top:50px;left: 200px;right: 0;
        line-height: 2;
        text-align: left;
        text-indent: 2em;
        color:#007fcf;
        border-bottom: 1px solid #007fcf;
        background-color: #f9f9f9;
    }
    .content{
        position: fixed;
        top:100px;left: 200px;right: 0;bottom: 0;
        overflow: auto;
    }
    .person{
        position: relative;
        width: 90%;
        margin: 0 auto 30px auto;
        height: 120px;
        box-sizing: border-box;
        padding: 5px;
        text-align: left;
        /*background-color: rgba(81,151,255,0.7);*/
        color: white;
        font-size: 15px;
        background:url(/static/image/background/black.jpg) fixed;
        background-size: contain;
        &>img{
            height: 100%;
            margin-right: 20px;
        }
        &>.button1{
            position: absolute;
            bottom: 5px;
            right: 10px;
            .button(white,orange,60px);
        }
    }
</style>
