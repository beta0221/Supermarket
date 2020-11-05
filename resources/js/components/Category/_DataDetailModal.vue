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

        </div>


        <div>
            <label>子類別 (即時更新)</label><br>
            <CButton v-for="category in subCategoryList"
                @click="removeFromParentCategory(category)"
                v-bind:key="category.id"
                variant="outline"
                color="success"
                shape="pill"
                class="ml-2 mb-2">
                {{category.name}}
            </CButton>
        </div>

        <div>
            <label>所有類別</label><br>
            <CButton v-for="category in parentCategoryList" 
                @click="addSubCategory(category)"
                v-bind:key="category.id"
                variant="outline"
                color="info"
                shape="pill"
                class="ml-2 mb-2">
                {{category.name}}
            </CButton>
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
            categoryList:[],
            subCategoryList:[],
            parentCategoryList:[],
        }
    },
    created(){
        
    },
    watch:{
        show(value){
            if(value == false){
                EventBus.$emit('reloadData');
            }
        }
    },
    mounted(){
        EventBus.$on("showDetailModal", item => {
            let slug = item[this.slug];
            this.dataSlug = slug;
            this.getDetailData();
            this.initial();
        });
    },
    destroyed(){
        EventBus.$off("showDetailModal");
    },
    methods:{
        async initial(){
            await this.getParentCategory();
            this.getSubCategory();
        },
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
        async getParentCategory(){
            await axios.get('/api/category/allParents')
            .then(res => {
                this.categoryList = res.data;
            })
            .catch(error => {
                errorHelper.handle(error);
            })
        },
        getSubCategory(){
            axios.get(`/api/category/${this.dataSlug}/subCategory`)
            .then(res => {
                this.subCategoryList = res.data;
                let idArray = [];
                res.data.forEach(item => { idArray.push(item.id); });
                this.parentCategoryList = [];
                this.categoryList.forEach(item => {
                    if(idArray.includes(item.id)){ return; }
                    if(item.id == this.detailData.id){ return; }
                    this.parentCategoryList.push(item);
                });
            })
        },
        addSubCategory(category){
            axios.post(`/api/category/${this.dataSlug}/subCategory`,{
                id:category.id
            })
            .then(res => {
                this.getSubCategory();
            })
            .catch(error => {
                errorHelper.handle(error);
            })
        },
        removeFromParentCategory(category){
            axios.post(`/api/category/removeFromParentCategory/${category.slug}`,{
                '_method':'DELETE'
            })
            .then(res => {
                this.initial();
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
    }
}
</script>

<style>

</style>