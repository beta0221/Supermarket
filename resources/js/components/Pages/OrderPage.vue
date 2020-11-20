<template>
    <div>

        <NavBar :title="'商品管理'"/>
        <CCardBody>
            <CDataTable
            :items="items"
            :fields="fields"
            items-per-page-select
            :items-per-page="10"
            v-on:pagination-change="setRows"
            >
            <template #checkbox={item}>
                <td>
                    <CInputCheckbox
                    :checked=false
                    @click="checkedOrNot(item)">

                    </CInputCheckbox>
                </td>
            </template>
            </CDataTable>

            <CPagination
            :activePage.sync="pagination.page"
            :pages.sync="pagination.totalPage"
            align="start"
            v-on:update:activePage="reloadData"/>

        </CCardBody>


    </div>
  
</template>

<script>
export default {    
    components:{
        
    },
    data(){
        return{
            checked:false,
            items:[],
            pagination:{
                page:1,
                rows:10,
                totalPage:10,
                //orderBy:'id',
                //order:'desc',
            },

            fields:[
                {key:'checkbox',label:'#'},
                {key:'order_numero',label:'訂單編號'},
                {key:'status',label:'狀態'},
                {key:'buyer',label:'訂購人'},
                {key:'date',label:'日期'},
            ],
            columns:[
                // {key:'name',type:'text',label:'商品名稱'},
                // {key:'sku',type:'text',label:'商品代號',readonly:true},
                // {key:'stock',type:'text',label:'庫存'},
                // {key:'price',type:'text',label:'價格'},
                // {key:'image',type:'image_input',label:'商品圖片',url:'/api/product/images'},
                // {key:'group_id',type:'single_selector',label:'商品群組',relationUrl:'/api/productGroup/all',trackBy:'name'},
                // {key:'attribute_set_id',type:'single_selector',label:'標籤群組',relationUrl:'/api/attributeSet/all',trackBy:'name'},
                // {key:'active',type:'single_selector',label:'上下架',relationUrl:'/api/activeStatus/all',trackBy:'name'},
                // {key:'_',type:'multiple_selector',label:'標籤',url:'/api/product',relation:'attributes',relationUrl:'/api/attribute/all',trackBy:'name'},
                // {key:'__',type:'multiple_selector',label:'分類',url:'/api/product',relation:'categories',relationUrl:'/api/category/all',trackBy:'name'},
                // {key:'description',type:'text_editor',label:'說明',uploadUrl:'/'}
            ]
        }
    },
    created(){
        this.reloadData();
    },
    mounted(){
        EventBus.$on("reloadData",_ => {
            this.reloadData();
        });
    },
    destroyed(){
        EventBus.$off("reloadData");
    },
    methods:{
        setRows(value){
            this.pagination.rows = value;
            this.reloadData();
        },
        reloadData(){
            axios.get('/api/order/all', {
                params: this.pagination
            })
            .then(res => {
                this.items = res.data.data;
                this.pagination = res.data.pagination;
            })
            .catch(error =>{
                errorHelper.handle(error);
            })
        },
        showDetail(item){
            EventBus.$emit("showDetailModal",item);
        },
        checkedOrNot(item){
             this.$set(item, 'checked', !item.checked)
        }
    }
}
</script>

<style>

</style>