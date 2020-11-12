<template>
    <div>

        <NavBar :title="'商品管理'"/>

        <CCardBody>
            
            <CreateDetailModal 
                :requestUrl="'/api/order'"
                :columns="columns"/>

            <DataTable 
                :fields="fields"
                :requestUrl="'/api/order'"/>
            
            <DataDetailModal
                :requestUrl="'/api/order/'"
                :slug="'order_numero'"
                :columns="columns"/>

        </CCardBody>


    </div>
  
</template>

<script>
export default {    
    components:{
        
    },
    data(){
        return{
            fields:[
                {key:'index',label:'#'},
                {key:'name',label:'訂單編號'},
                {key:'status',label:'狀態'},
                {key:'status',label:'商品'},
                {key:'date',label:'日期'},
            ],
            columns:[
                {key:'name',type:'text',label:'商品名稱'},
                {key:'sku',type:'text',label:'商品代號',readonly:true},
                {key:'stock',type:'text',label:'庫存'},
                {key:'price',type:'text',label:'價格'},
                {key:'image',type:'image_input',label:'商品圖片',url:'/api/product/images'},
                {key:'group_id',type:'single_selector',label:'商品群組',relationUrl:'/api/productGroup/all',trackBy:'name'},
                {key:'attribute_set_id',type:'single_selector',label:'標籤群組',relationUrl:'/api/attributeSet/all',trackBy:'name'},
                {key:'active',type:'single_selector',label:'上下架',relationUrl:'/api/activeStatus/all',trackBy:'name'},
                {key:'_',type:'multiple_selector',label:'標籤',url:'/api/product',relation:'attributes',relationUrl:'/api/attribute/all',trackBy:'name'},
                {key:'__',type:'multiple_selector',label:'分類',url:'/api/product',relation:'categories',relationUrl:'/api/category/all',trackBy:'name'},
                {key:'description',type:'text_editor',label:'說明',uploadUrl:'/'}
            ]
        }
    }
}
</script>

<style>

</style>