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
                {key:'edit',label:'-'},
            ],
            columns:[
                {key:'name',type:'text',label:'商品名稱'},
                {key:'image',type:'image_input',label:'商品圖片'},
                {key:'group_id',type:'single_selector',label:'商品群組',relationUrl:'/api/productGroup/all',trackBy:'name'},
                {key:'attribute_set_id',type:'single_selector',label:'標籤群組',relationUrl:'/api/attributeSet/all',trackBy:'name'},
                {key:'active',type:'single_selector',label:'上下架',relationUrl:'/api/activeStatus/all',trackBy:'name'},
                {key:'description',type:'text_editor',label:'說明',uploadUrl:'/'}
            ]
        }
    }
}
</script>

<style>

</style>