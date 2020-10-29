<template>
    <CModal
        title="詳細"
        color="info"
        size="xl"
        :show.sync="show"
        footer>


        <div v-for="column in columns" v-bind:key="column.key">
            
            <CInput v-if="(column.key in detailData)" 
                :label="column.label" 
                :placeholder="column.label"
                :readonly="(column.readonly == true)?true:false"
                v-model="detailData[column.key]"/>

            <MultipleSelector 
                v-if="column.type == 'multiple_selector'"
                :label="column.label"
                :url="column.url" 
                :relation="column.relation"
                :relationUrl="column.relationUrl"
                :trackBy="column.trackBy"/>

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
        
    },
    mounted(){
        EventBus.$on("showDetailModal", item => {
            let slug = item[this.slug];
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
        }
    }
}
</script>

<style>

</style>