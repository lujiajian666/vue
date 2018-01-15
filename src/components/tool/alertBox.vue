<template>
    <div id="AlertBox">
        <form id="form">
        <div id="shadow"></div>
        <div id="content">
            <header>
                <h2>{{title}}</h2>
                <i class="fa fa-close" @click="close"></i>
            </header>
            <main>
                <div class="inputGroup" style="display:flex;height: 250px">
                    <div style="position: relative;padding-left: 100px;margin: auto;">
                        <input placeholder="姓名" name="name" :value="name"><br>
                        <select name="title">
                            <option value="0" :selected="jobTitle==0">职称</option>
                            <option value="1" :selected="jobTitle==1">经理</option>
                            <option value="2" :selected="jobTitle==3">扫地阿姨</option>
                        </select>

                        <br>
                        <select name="department">
                            <option value="0">所属部门</option>
                            <option value="1">研发部</option>
                            <option value="2">后勤部</option>
                            <option value="3">行政部</option>
                            <option value="4">人事部</option>
                        </select>
                        <div class="pic_btn_div" id="pic_btn_div">点击上传头像</div>
                        <input class="pic_btn" type="file" name="head_img"
                                @change="changePic($event,'pic_btn_div')">
                        <p class="pic_btn_p"
                           @click="submit">确定</p>
                    </div>
                </div>
            </main>
            <footer>

            </footer>
        </div>
        </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {
               name:"",
               jobTitle:"",
               department:"",
               head_img:"",
            }
        },
        components:{

        },
        methods:{
          close:function(){
              this.$emit("close")
          },
          changePic:function fileReader(node, imgNode){
              if(node.currentTarget == null || imgNode == null) {
                  if(node==null) console.log("node 为空")
                  console.log("请传入合理参数");
                  return;
              }
              node = typeof node == "string" ? document.getElementById(node) : node.currentTarget;
              imgNode = typeof imgNode == "string" ? document.getElementById(imgNode) : imgNode;

              if(typeof FileReader == 'undefined'){
                  console.log("浏览器版本较低，不支持FileReader");
                  var src = node.value;
                  imgNode.src = src;
              }else {
                  // 获得文件
                  var file = node.files[0];

                  var reader = new FileReader();

                  // 将文件读取为DataUrl
                  reader.readAsDataURL(file);

                  reader.onload = function(event) {
                      console.log(imgNode);
                      imgNode.style.backgroundImage = "url("+this.result+")";
                  }

                  reader.onerror = function(event){
                      throw new Error("读取出错");
                  }

                  reader.onloadstart = function() {
                      console.log("读取开始");
                  }
              }
          },
          submit:function () {
              var data=new FormData(document.getElementById("form"));
              var _self=this;
              this.$axios.post('http://localhost/vue-project-one/think5/public/' +
                  'index.php?s=admin/background/addEmployee',
                  data)
                  .then(function (response) {
                      var data=response.data;
                      if(data.status==1){
                          alert("添加成功")
                          _self.close();
                      }else{
                          alert("添加失败")
                      }
                  })
                  .catch(function (error) {
                      console.log(error);
                  });
          }  
        },
        created:function () {
           var store=this.$store.state.alterMessage;
           console.log(store)
           if(store !=null){
               this.name=store.name;
               this.jobTitle=store.job_title_id;
               this.department=store.department;
               this.head_img=store.src
               if(store.src!=null){
                   $("#pic_btn_div").css("backgroundImage","url("+this.head_img+")");
               }
           }
        },
        props:["title"]

    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
    .pic_btn{
        top: 0;
        left: -5px;
        height: 91px;
        width: 100px;
        position: absolute;
        border-radius: 5px;
        opacity: 0;
        cursor: pointer;
    }
    .pic_btn_div{
        .pic_btn;
        opacity: 1;
        border: 1px solid rgba(0,0,0,0.2);
        line-height: 91px;
        font-size: 12px;
        background-position: center;
        background-repeat: no-repeat;
    }
    .pic_btn_p{
        .pic_btn;
        opacity: 1;
        font-size: 12px;
        top: auto;
        bottom: 0;
        left: -5px;
        height: 30px;
        line-height: 30px;
        background-color: orange;color: white;
    }
   #content{
       position: absolute;
       height: 300px;
       width: 500px;
       border-radius: 10px;
       top: 0;left: 0;right: 0;bottom: 0;
       margin: auto;
       background-color: white;
       z-index: 20;
   }
   #shadow{
       content:"";
       position: absolute;
       top: 0;left: 0;right: 0;bottom: 0;
       background-color: black;
       opacity: 0.5;
       z-index: 10;
   }
   h2{
     border-bottom: 1px solid #008ecc;
   }
    header{
        position: relative;
        line-height: 50px;
    }
    .fa-close{
        position: absolute;
        right: 10px;
        top: 16px;
    }
    input:not([type=file]){
        outline: none;
        border: 1px solid #008ecc;
        border-radius: 5px;
        padding: 10px 15px;
        display: block;
        margin: auto;
    }
    select{
        border: 1px solid #008ecc;
        border-radius: 5px;
        padding: 5px 10px;
        height: 37px;
        background-color: white;
        width: 100%;
    }

</style>
