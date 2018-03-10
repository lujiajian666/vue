import axios from "axios";

const cookieHandle={
    setCookie: function (cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    },
    //获取cookie
    getCookie: function (cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1);
            if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
        }
        return "";
    },
    //清除cookie
    clearCookie: function () {
        this.setCookie("PHPSESSID","",-1);
        this.setCookie("username", "", -1);
    },
}
const vuexHandle={
    setVuex:function (self,name,value,type=true) {
        self.$store.state[name]=value;
        if(type){
            sessionStorage.setItem(name,value);
        }
    },
    getVuex:function (self,name,type=true) {
        if(type){
            var res=self.$store.state[name]==""?sessionStorage.getItem(name):self.$store.state[name];
            return res;
        }else{
            return self.$store.state[name];
        }
    }
}
const timeHandle={
    format(str,timestamp){
       var date=new Date(timestamp*1000);
       var year=date.getFullYear();
       var month=date.getMonth()+1;
       var day=date.getDay();
       var weekDay=date.getDate();
        str=str.replace(/Y/,year)
        str=str.replace(/m/,month)
        str=str.replace(/d/,day)
        return str;
    }
}
const axiosHandle={
    _self:'',
    setThis(_self){
        this._self=_self;
    },
    post(url,data){
        return axios.post("http://localhost/vue-project-one/think5/public/index.php?s=" + url,data)
               .then((res,reject)=>{
                   if(res.data=="no_permit") {
                       this._self.$alert('您的权限不足', '警告', {
                           confirmButtonText: '确定',
                       });
                       throw "no_permit";
                   }else if(res.data=="no_login"){
                       this._self.$alert('请先登录', '警告', {
                           confirmButtonText: '确定',
                           callback:() => {
                               this._self.$router.push({path: '/background'})
                           }
                       });
                       throw "no_login";
                   }else{
                       return res;
                   }
               })
    },

}
export { cookieHandle,vuexHandle,timeHandle,axiosHandle };
