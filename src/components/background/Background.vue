<template>
    <div id="Background">
      <form id="form">
        <div class="inputBox">
          <div style="margin: auto;width:400px">
            <h2>用户登录</h2>
            <div class="inputGroup">
              <label>用户名/username</label><br>
              <input type="password" name="username"><br>
            </div>
            <div class="inputGroup">
              <label>密码/password</label><br>
              <input name="password">
              <span>忘记密码</span><br>
            </div>
            <div class="inputGroup">
              <input type="checkbox"/>
              <span>记住用户名和密码</span>
            </div>
            <div class="inputGroup">
              <p style="background-color: orange;color: white;width: 250px;text-align: center"
                 @click="login">确认登录</p>
            </div>

          </div>

        </div>
      </form>
    </div>
</template>

<script>
    export default {
        data() {
            return {

            }
        },
        components:{

        },
        methods:{
            login:function () {
                var data=new FormData(document.getElementById("form"))
                this.$axios.post('http://localhost/vue-project-one/thinkphp5/public/index.php?index/index/index.html',data)
                    .then(function (response) {
                        console.log(response.data);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        }

    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
  #Background{
    position: fixed;
    top: 0;
    left:0;
    bottom:0;
    right: 0;
    background:url("/static/image/background/backgroudImage.jpg") no-repeat fixed center;
    background-size: contain;
    .input(){
      input:not([type=checkbox]){
        border: none;
        outline: none;
        padding: 5px;
        width: 250px;
        height: 25px;
        box-sizing: border-box;
      }
    };

  }
  .inputBox{

    position: fixed;
    top:0;
    left:0;
    right:0;
    bottom: 0;
    margin: auto;
    height: 300px;
    width: 700px;
    display: flex;
    .font(white,16px);
    #Background .input();
    &:after{
      content: "";
      background:url("/static/image/background/backgroudImage.jpg") no-repeat fixed center;
      background-size: contain;
      position: absolute;
      top:0;
      left:0;
      right:0;
      bottom: 0;
      opacity: 1;
      filter: blur(7px);
      z-index: -1;
    }
    .inputGroup{
      width: 350px;
      text-align: left;
      margin: auto;
    }
  }
  .font(@color:white,@size:14px,@lineHeight:2){
    font-size: @size;
    color: @color;
    line-height: @lineHeight;
  }

</style>
