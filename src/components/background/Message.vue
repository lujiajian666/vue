<template>
    <div id="Message">
        <el-table :data="message" style="width: 100%;text-align: left" max-height="250">
            <el-table-column prop="message_id" label="id" width="150"></el-table-column>
            <el-table-column prop="title" label="标题" width="150"></el-table-column>
            <el-table-column prop="detail" label="内容" width="350"></el-table-column>
            <el-table-column prop="deadline" label="有效期至"  show-overflow-tooltip></el-table-column>
            <el-table-column fixed="right" label="操作" width="120">
                <template slot-scope="scope">
                    <el-button
                            @click.native.prevent="deleteRow(scope.$index,item.id)"
                            type="text"
                            size="small">
                        移除
                    </el-button>
                    <el-button
                            @click.native.prevent="editRow(scope.$index,item.id)"
                            type="text"
                            size="small">
                        修改
                    </el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script>
    import {vuexHandle, axiosHandle} from "../../lib/utils.js"

    export default {
        data() {
            return {
               message:[]
            }
        },
        methods: {

        },
        created(){
            axiosHandle.post('admin/Message/getMessage')
        }
    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="less">
    #Message {
        padding: 20px 20px 0 20px;
    }
</style>
