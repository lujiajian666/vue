<template>
  <div id="app">
    <router-view></router-view>
  </div>
</template>
<script>
import $ from "jquery"
export default {
  name: 'app'
}
</script>
<style>
*{
  margin: 0;
  padding: 0;
}
body{
  min-width: 1000px;
}
@import '/static/css/font-awesome-4.7.0/css/font-awesome.css';
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  min-width: 1000px;
}
a,li{
  cursor: pointer;
}
.limitSingleRow{
  text-overflow: ellipsis;
  overflow: hidden;
  white-space: nowrap;
}
</style>
