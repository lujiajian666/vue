<template>
    <div id="head">
        <head-div select="one"></head-div>
        <float-right-div></float-right-div>
        <content-div></content-div>
        <foot-div></foot-div>
    </div>
</template>

<script>
    import head from '@/components/head';
    import floatRightDiv from '@/components/floatRightDiv';
    import contentDiv from "./content-man-div"
    import footDiv from "./foot-div";
    import ContentDiv from "./content-man-div.vue";

    export default {
        name: 'hello',
        data() {
            return {
                msg: "data"
            }
        },
        components:{
            ContentDiv,
            "head-div":head,
            "float-right-div":floatRightDiv,
            "content-div":contentDiv,
            "foot-div":footDiv
        }

    }
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
