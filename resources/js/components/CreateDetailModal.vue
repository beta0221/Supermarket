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
                    v-if="(column.type == 'text')" 
                    :label="column.label" 
                    :placeholder="column.label"
                    v-model="detailData[column.key]"/>


                <SingleSelector
                    v-if="column.type == 'single_selector'"
                    :label="column.label"
                    :relationUrl="column.relationUrl"
                    :column="column.key"
                    :trackBy="column.trackBy"
                    v-on:updateDataColumn="updateDataColumn"
                    :value="null"/>

                <TextEditor
                    v-if="column.type == 'text_editor'"
                    :label="column.label"
                    :uploadUrl="column.uploadUrl"
                    :text="null"
                    :column="column.key"
                    v-on:updateDataColumn="updateDataColumn"/>

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
            Object.keys(this.detailData).forEach(key => {
                this.detailData[key] = null;
            });
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