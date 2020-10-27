<template>
    <CModal
        title="詳細"
        color="info"
        size="xl"
        :show.sync="show"
        footer>


        <div v-for="column in columns" v-bind:key="column.key">
            <CInput v-if="detailData[column.key]!='undefinded'" 
                :label="column.label" 
                :placeholder="column.label"
                :readonly="(column.readonly == true)?true:false"
                v-model="detailData[column.key]"/>
        </div>
        
        
        
        <template slot="footer">
            <CButton @click="show = false">取消</CButton>
            <CButton color="info" @click="updateDetailData">更新</CButton>
        </template>
        
        
    </CModal>
</template>

<script>
export default {
    props:['requestUrl','slug','columns'],
    data(){
        return{
            dataSlug:null,
            show:false,
            detailData:{},
        }
    },
    created(){
        EventBus.$on("showDetailModal", item => {
            let slug = item[this.slug];
            this.dataSlug = slug;
            this.getDetailData();
        });
    },
    methods:{
        getDetailData(){
            axios.get(this.requestUrl + this.dataSlug)
            .then(res => {
                this.show = true;
                this.detailData = res.data;
            })
            .catch(error => {
                console.log(error);
            })
        },
        updateDetailData(){
            let postData = this.detailData;
            postData['_method'] = 'PUT';
            axios.post(this.requestUrl + this.dataSlug, postData)
            .then(res =>{
                EventBus.$emit("reloadData");
                EventBus.$emit('popMessage',{
                    type:'success',
                    header:'訊息',
                    body:'更新成功',
                })
            })
            .catch(error =>{
                console.log(error);
            })
        }
    }
}
</script>

<style>

</style>