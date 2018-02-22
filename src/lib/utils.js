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
        this.setCookie("username", "", -1);
    }
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
export { cookieHandle,vuexHandle };
