<template>
    <div id="AlertBox">
        <div id="shadow"></div>
        <div id="content">
            <header>
                <h2>{{title}}</h2>
                <i class="fa fa-close" @click="close"></i>
            </header>
            <main>
                <div class="inputGroup">
                    <input placeholder="姓名">
                    <input placeholder="职称">
                    <input type="file">
                </div>
                <slot></slot>
            </main>
            <foot>
                <slot name="footer"></slot>
            </foot>
        </div>
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
          close:function(){
              this.$emit("close")
          }
        },
        props:["title"]

    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
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
     border-bottom: 1px solid #008ecc;;
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
</style>
