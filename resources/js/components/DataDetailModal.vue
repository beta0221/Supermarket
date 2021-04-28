<template>
    <CModal
        title="詳細"
        color="info"
        size="xl"
        :show.sync="show"
        footer>


        <div v-for="column in columns" v-bind:key="column.key">
            
            <CInput v-if="(column.type == 'text')" 
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

            <SingleSelector
                v-if="column.type == 'single_selector'"
                :label="column.label"
                :relationUrl="column.relationUrl"
                :column="column.key"
                :trackBy="column.trackBy"
                v-on:updateDataColumn="updateDataColumn"
                :value="detailData[column.key]"/>
        
            <TextEditor
                v-if="column.type == 'text_editor'"
                :label="column.label"
                :slug="slug"
                :uploadUrl="column.uploadUrl"
                :text="detailData[column.key]"
                :column="column.key"
                v-on:updateDataColumn="updateDataColumn"/>

            <ImageInput 
                v-if="column.type == 'image_input'"
                :label="column.label"
                :slug="slug"
                :addImageUrl="column.addImageUrl"
                :url="column.url"/>


            <div v-if="column.type == 'plain_text'">
                <label>{{column.label}}</label>
                <textarea rows="10"  class="form-control" readonly="false" v-html="detailData[column.key]"></textarea>
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
            if(this.requestUrl == null){ return; }
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