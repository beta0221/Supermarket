<template>
    <CModal
        title="詳細"
        color="info"
        size="xl"
        :show.sync="show"
        footer>


        <div>
            
            <CInput :label="'名稱'" :placeholer="'名稱'" :readonly="false" v-model="detailData['name']" />

            <SingleSelector
                :label="'類型'"
                :relationUrl="'/api/cartRuleType/all'"
                :column="'rule_type'"
                :trackBy="'name'"
                v-on:updateDataColumn="updateCartRuleType"
                :value="detailData['rule_type']"/>



            <div v-for="column in columns" v-bind:key="column.key">
                <div v-if="column.type == 'text'">
                    <CInput v-if="showColumn[column.key]" :label="column.label" :placeholer="column.label" :readonly="false" v-model="detailData[column.key]" />        
                </div>

                <div v-if="column.type == 'single_selector'">
                    <SingleSelector
                        v-if="showColumn[column.key]"
                        :label="column.label"
                        :relationUrl="column.relationUrl"
                        :column="column.key"
                        :trackBy="column.trackBy"
                        v-on:updateDataColumn="updateDataColumn"
                        :value="detailData[column.key]"/>
                </div>
            </div>
            

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
            columnsDict:{},
            showColumn:{},
        }
    },
    created(){
        this.getColumnsDict();
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
        setShowColumn(){
            this.showColumn = {};
            if(this.columnsDict[this.detailData.rule_type] !== undefined){
                let columnArray = this.columnsDict[this.detailData.rule_type];
                columnArray.forEach(column => {
                    this.showColumn[column] = true;
                });
            }
        },
        getColumnsDict(){
            axios.get('/api/cartRule/columnsDict')
            .then(res => {
                this.columnsDict = res.data;
            })
            .catch(error => {
                errorHelper.handle(error);
            })
        },
        getDetailData(){
            axios.get(this.requestUrl + this.dataSlug)
            .then(res => {
                this.show = true;
                this.detailData = res.data;
                this.setShowColumn();
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
        updateCartRuleType(obj){
            this.updateDataColumn(obj);
            this.setShowColumn();
        },
        updateDataColumn(obj){
            this.$set(this.detailData,obj.column,obj.value);
        }
    }
}
</script>

<style>

</style>