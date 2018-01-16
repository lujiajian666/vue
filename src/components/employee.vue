<template>
  <div id="employee">
    <div id="content_div_left">
      <ul>
        <li :class="{'select':topList[0]}" @mouseover="select(0)">研发部</li>
        <li :class="{'select':topList[1]}" @mouseover="select(1)">后勤部</li>
        <li :class="{'select':topList[2]}" @mouseover="select(2)">行政部</li>
        <li :class="{'select':topList[3]}" @mouseover="select(3)">人事部</li>
      </ul>
    </div>
    <div id="content_div_right">
      <table>
        <tr>
          <th>id</th>
          <th>头像</th>
          <th>职务</th>
          <th>名称</th>
          <th>资历</th>
          <th>工资</th>
        </tr>
        <tr v-for="i in peopleInform[position]">
          <td>{{ i["id"] }}</td>
          <td>
            <img :src="i['image']" class="headPic">
          </td>
          <td>{{ i["position"] }}</td>
          <td>{{ i["name"] }}</td>
          <td>{{ i["experience"] }}</td>
          <td>{{ i["salary"] }}</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'employee',
    data() {
      return {
        position:0,
        topList: [true, false, false, false],
        peopleInform: [
          [
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键",
              "experience": "十年", "salary": "10000"
            },
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键",
              "experience": "十年", "salary": "10000"
            },
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键",
              "experience": "十年", "salary": "10000"
            },
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键",
              "experience": "十年", "salary": "10000"
            }
          ],
          [
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键2",
              "experience": "十年", "salary": "10000"
            },
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键2",
              "experience": "十年", "salary": "10000"
            },
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键2",
              "experience": "十年", "salary": "10000"
            },
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键2",
              "experience": "十年", "salary": "10000"
            }
          ],
          [
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键3",
              "experience": "十年", "salary": "10000"
            },
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键3",
              "experience": "十年", "salary": "10000"
            },
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键3",
              "experience": "十年", "salary": "10000"
            },
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键3",
              "experience": "十年", "salary": "10000"
            }
          ],
          [
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键4",
              "experience": "十年", "salary": "10000"
            },
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键4",
              "experience": "十年", "salary": "10000"
            },
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键4",
              "experience": "十年", "salary": "10000"
            },
            {
              "id": "123456", "image": "../../static/image/headPic.jpg", "position": "主任", "name": "陆家键4",
              "experience": "十年", "salary": "10000"
            }
          ],
        ]

      }
    },
    methods: {
      "select": function (index) {
        this.topList.splice(0, 4, false, false, false, false);
        this.topList.splice(index, 1, true);
        this.position=index
      }
    },
    updated() {

    },
    mounted() {

    },


  }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
  @keyframes scaleout {
    0% {
      transform: scale(1.0);
      -webkit-transform: scale(1.0);
    }
    100% {
      transform: scale(1.5);
      -webkit-transform: scale(1.5);
      opacity: 0;
    }
  }
  @keyframes scaleout2 {
    0% {
      transform: scale(1.0);
      -webkit-transform: scale(1.0);
    }
    100% {
      transform: scale(2);
      -webkit-transform: scale(2);
      opacity: 0;
    }
  }
  @yellow: #ffd333;
  @green: #7be92f;
  #employee {
    width: 95%;
    margin: auto;
    display: table;
  }
  .headPic {
    height: 60px;
    width: 60px;
  }
  #content_div_left {
    display: table-cell;
    vertical-align: middle;
    width: 20%;
    ul {
      margin: 100px auto;
      width: 80px;
      & > li {
        @height: 70px;
        height: @height;
        line-height: @height;
        color: white;
        width: @height;
        border-radius: 50%;
        background-color: @yellow;
        margin-bottom: 20px;
        position: relative;
        transition: .5s;
        &:after {
          content: "";
          top: 0;
          bottom: 0;
          left: 0;
          right: 0;
          position: absolute;
          border-radius: 50%;
          border: 2px solid @yellow;
          animation: scaleout 3s ease-in-out infinite;
        }
        &:before {
          @size: 0;
          content: "";
          top: @size;
          bottom: @size;
          left: @size;
          right: @size;
          position: absolute;
          border-radius: 50%;
          border: 2px solid @yellow;
          animation: scaleout2 3s ease-in-out infinite;
        }
      }
      & > li:nth-of-type(2):after {
        animation-delay: .5s;
      }
      & > li:nth-of-type(3):after {
        animation-delay: 1s;
      }
      & > li:nth-of-type(4):after {
        animation-delay: 1.5s;
      }
      & > li:nth-of-type(2):before {
        animation-delay: .5s;
      }
      & > li:nth-of-type(3):before {
        animation-delay: 1s;
      }
      & > li:nth-of-type(4):before {
        animation-delay: 1.5s;
      }
    }
    .select {
      background-color: @green;
      &:after {
        border-color: @green;
      }
      &:before {
        border-color: @green;
      }
    }
  }
  #content_div_right {
    display: table-cell;
    width: 70%;
    vertical-align: middle;
    table {
      width: 80%;
      border-collapse: collapse;
    }
    tr > td, tr > th {
      min-width: 50px;
      padding: 10px 20px;
      border: 1px solid #ccc;
    }

  }
</style>
