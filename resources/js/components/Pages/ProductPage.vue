<template>
    <div>

        <NavBar :title="'商品管理'"/>

        <CCardBody>
            
            <CreateDetailModal 
                :requestUrl="'/api/product'"
                :columns="columns"/>

            <DataTable 
                :fields="fields"
                :requestUrl="'/api/product'"/>
            
            <DataDetailModal
                :requestUrl="'/api/product/'"
                :slug="'sku'"
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
                {key:'name',label:'商品名稱'},
                {key:'active',label:'上下架'},
                {key:'edit',label:'-'},
            ],
            columns:[
                {key:'name',type:'text',label:'商品名稱'},
                {key:'sku',type:'text',label:'商品代號',readonly:true},
                {key:'stock',type:'text',label:'庫存'},
                {key:'price',type:'text',label:'價格'},
                {key:'bonus_rate',type:'text',label:'紅利回饋'},
                {key:'image',type:'image_input',addImageUrl:'product',label:'商品圖片',url:'/api/product/images'},
                {key:'group_id',type:'single_selector',label:'商品群組',relationUrl:'/api/productGroup/all',trackBy:'name'},
                {key:'attribute_set_id',type:'single_selector',label:'標籤群組',relationUrl:'/api/attributeSet/all',trackBy:'name'},
                {key:'active',type:'single_selector',label:'上下架',relationUrl:'/api/activeStatus/all',trackBy:'name'},
                {key:'_',type:'multiple_selector',label:'標籤',url:'/api/product',relation:'attributes',relationUrl:'/api/attribute/all',trackBy:'name'},
                {key:'__',type:'multiple_selector',label:'分類',url:'/api/product',relation:'categories',relationUrl:'/api/category/all',trackBy:'name'},
                {key:'___',type:'multiple_selector',label:'配合活動',url:'/api/product',relation:'cartRules',relationUrl:'/api/cartRule/all',trackBy:'name'},
                {key:'description',type:'text_editor',label:'說明',uploadUrl:'/api/product/addImageInDescription/'},
            ]
        }
    }
}
</script>

<style>

</style>