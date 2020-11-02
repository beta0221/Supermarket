<template>
    <CModal
        title="詳細"
        color="info"
        size="xl"
        :show.sync="show"
        footer>


        
        
        
        
        <template slot="footer">
            <CButton @click="show = false">取消</CButton>
            <CButton color="info" @click="updateDetailData">更新</CButton>
        </template>
        
        
    </CModal>
</template>

<script>
export default {
    
    data(){
        return{
            requestUrl:'/api/product/specificPrices/',
            dataSlug:null,
            show:false,
            detailData:{},
        }
    },
    created(){
        
    },
    mounted(){
        EventBus.$on("showDetailModal", item => {
            let slug = item['sku'];
            this.dataSlug = slug;
            this.getDetailData();
        });
    },
    destroyed(){
        EventBus.$off("showDetailModal");
    },
    methods:{
        getDetailData(){
            axios.get(this.requestUrl + this.dataSlug)
            .then(res => {
                this.show = true;
                this.detailData = res.data;
            })
            .catch(error => {
                errorHelper.handle(error);
            })
        },
        updateDetailData(){
            let postData = this.detailData;
            postData['_method'] = 'PUT';
            axios.post(this.requestUrl + this.dataSlug, postData)
            .then(res =>{
                EventBus.$emit("reloadData");
                messageHelper.success('更新成功');
            })
            .catch(error =>{
                errorHelper.handle(error);
            })
        },
        updateDataColumn(obj){
            // this.detailData[obj.column] = obj.value;
            this.$set(this.detailData,obj.column,obj.value);
        }
    }
}
</script>

<style>

</style>