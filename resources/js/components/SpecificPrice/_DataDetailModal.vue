<template>
    <CModal
        title="詳細"
        color="info"
        size="xl"
        :show.sync="show"
        footer>

        <CContainer>

            <CRow class="mb-2">
                <CCol lg="1">#</CCol>
                <CCol lg="2">類別</CCol>
                <CCol lg="2">折價</CCol>
                <CCol lg="3">開始時間</CCol>
                <CCol lg="3">結束時間</CCol>
                <CCol lg="1">-</CCol>
            </CRow>

            <div v-for="(data,index)  in dataList" v-bind:key="data.id">
                <CRow class="mb-2">
                    <CCol lg="1">{{index + 1}}</CCol>
                    <CCol lg="2">{{data.discount_type}}</CCol>
                    <CCol lg="2">{{data.reduction}}</CCol>
                    <CCol lg="3">{{data.start_date}}</CCol>
                    <CCol lg="3">{{data.expiration_date}}</CCol>
                    <CCol lg="1">
                        <CButton @click="deleteData(data.id)" size="sm" color="danger">刪除</CButton>
                    </CCol>
                </CRow>
            </div>

            <hr>
            <CRow>
                <CCol lg="1"></CCol>
                <CCol lg="2">
                    <select class="form-control" v-model="postData.discount_type">
                        <option value="">類別</option>
                        <option value="amount">定額</option>
                        <option value="dicimal">折數</option>
                    </select>
                </CCol>
                <CCol lg="2">
                    <CInput :placeholder="'折價'" v-model="postData.reduction"/>
                </CCol>
                <CCol lg="3">
                    <input type="date" class="form-control" v-model="postData.start_date">
                </CCol>
                <CCol lg="3">
                    <input type="date" class="form-control" v-model="postData.expiration_date">
                </CCol>
                <CCol lg="1">
                    <CButton size="sm" color="success" @click="submitPostData">新增</CButton>
                </CCol>
            </CRow>


        </CContainer>
        
        
        <template slot="footer">
            <CButton @click="show = false">取消</CButton>
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
            dataList:[],
            postData:{},
        }
    },
    created(){
        
    },
    mounted(){
        EventBus.$on("showDetailModal", item => {
            let slug = item['sku'];
            this.dataSlug = slug;
            this.getDataList();
        });
    },
    destroyed(){
        EventBus.$off("showDetailModal");
    },
    methods:{
        getDataList(){
            axios.get(this.requestUrl + this.dataSlug)
            .then(res => {
                this.show = true;
                this.dataList = res.data;
            })
            .catch(error => {
                errorHelper.handle(error);
            })
        },
        submitPostData(){
            axios.post(`/api/product/${this.dataSlug}/addSpecificPrice`,this.postData)
            .then(res => {
                messageHelper.success('新增成功');
                this.postData = {};
                this.getDataList();
            })
            .catch(err => {
                errorHelper.handle(error);
            })
        },
        deleteData(id){
            axios.delete(`/api/product/${id}/deleteSpecificPrice`)
            .then(res => {
                console.log(res);
                this.getDataList();
            })
            .catch(err => {
                console.error(err); 
            })
        }
    }
}
</script>

<style>

</style>