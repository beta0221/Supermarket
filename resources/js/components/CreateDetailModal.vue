<template>
    <div>

        <CButton color="success" @click="showCreateDetailModal">新增</CButton>
        
        <CModal
            title="新增"
            color="success"
            size="xl"
            :show.sync="show"
            footer>


            <div v-for="column in columns" v-bind:key="column.key">
                <CInput 
                    :label="column.label" 
                    :placeholder="column.label"
                    v-model="detailData[column.key]"/>
            </div>
            
            
            
            <template slot="footer">
                <CButton @click="show = false">取消</CButton>
                <CButton color="success" @click="createDetailData">新增</CButton>
            </template>
            
            
        </CModal>
    </div>
</template>

<script>
export default {
    props:['requestUrl','columns'],
    data(){
        return{
            show:false,
            detailData:{},
        }
    },
    created(){
        
    },
    mounted(){
        
    },
    destroyed(){
        
    },
    methods:{
        showCreateDetailModal(){
            this.show = true;
            this.detailData = {};
        },
        createDetailData(){
            let postData = this.detailData;
            axios.post(this.requestUrl, postData)
            .then(res =>{
                this.detailData = {};
                this.show = false;
                EventBus.$emit("reloadData");
                messageHelper.success('新增成功');
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