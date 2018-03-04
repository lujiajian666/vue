<template>
    <div id="Background">
      <form id="form">
        <div class="inputBox">
          <div style="margin: auto;width:400px">
            <h2>用户登录</h2>
            <div class="inputGroup">
              <label>用户名/username</label><br>
              <input  name="username" id="username"><br>
            </div>
            <div class="inputGroup">
              <label>密码/password</label><br>
              <input name="password" id="password" type="password" @keydown.enter="login">
              <span>忘记密码</span><br>
            </div>
            <div class="inputGroup">
              <input type="checkbox" name="remember" id="remember" value="yes"/>
              <span>记住用户名和密码</span>
            </div>
            <div class="inputGroup">
              <p style="background-color: orange;color: white;width: 250px;text-align: center"
                 @click="login">登录</p>
            </div>

          </div>

        </div>
      </form>
    </div>
</template>

<script>
    import { cookieHandle,vuexHandle,axiosHandle } from '../../lib/utils.js';
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
                var _self=this;
                axiosHandle.post('admin/background/index.html',data)
                    .then(function (response) {
                        var data=response.data;
                        if(data.status==1){
                            var isRemember =document.getElementById("remember");
                            var username=document.getElementById("username").value
                            var password=document.getElementById("password").value
                            if(isRemember.checked){
                                cookieHandle.setCookie("username",username,7);
                                cookieHandle.setCookie("password",password,7);
                            }
                            _self.$alert("登录成功", '欢迎您，'+username, {
                                confirmButtonText: '确定',
                                callback: action => {
                                    vuexHandle.setVuex(_self,"username",data.username)
                                    _self.$router.push({path: '/backgroundIndex'})
                                }
                            });
                        }else{
                            _self.$alert("账号或密码错误", '！！！', {
                                confirmButtonText: '确定'
                            });
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            loginWithCookie:function (username,password) {
                var _self=this;
                var data=new FormData();
                data.append("username",username);
                data.append("password",password);
                axiosHandle.post('admin/background/index.html', data)
                    .then(function (response) {
                        var data=response.data;
                        if(data.status==1){
                            cookieHandle.setCookie("username",username,7);
                            cookieHandle.setCookie("password",password,7);
                            vuexHandle.setVuex(_self,"username",data.username);
                            _self.$router.push({path: '/backgroundIndex'})
                        }else{
                            cookieHandle.clearCookie("username");
                            cookieHandle.clearCookie("password");
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            }
        },
        created:function(){
            axiosHandle.setThis(this);
            const username=cookieHandle.getCookie("username");
            const password=cookieHandle.getCookie("password");
            const isRemember=username!="" && password!="";
            if(isRemember){
                this.loginWithCookie(username,password)
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
    background:url("/static/image/background/backgroundImage.jpg") no-repeat fixed center;
    background-size: cover;
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
    height: 500px;
    width: 700px;
    display: flex;
    .font(white,16px);
    #Background .input();
    &:after{
      content: "";
      background:url("/static/image/background/backgroundImage.jpg") no-repeat fixed center;
      background-size: cover;
      position: absolute;
      top:0;
      left:0;
      right:0;
      bottom: 0;
      opacity: 0.9;
      filter: blur(15px);
      z-index: -1;
    }
    .inputGroup{
      width: 350px;
      text-align: left;
      margin:auto 0 auto 70px;
    }
  }
  .font(@color:white,@size:14px,@lineHeight:2){
    font-size: @size;
    color: @color;
    line-height: @lineHeight;
  }

</style>
