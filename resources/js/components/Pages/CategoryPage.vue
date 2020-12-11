<template>
    <div>

        <NavBar :title="'產品分類管理'"/>

        <CCardBody>

            <CreateDetailModal 
                :requestUrl="'/api/category'"
                :columns="columns"/>
            
            <DataTable 
                :fields="fields"
                :requestUrl="'/api/category'"/>
            
            <CategoryDataDetailModal
                :requestUrl="'/api/category/'"
                :slug="'slug'"
                :columns="columns"/>
            

        </CCardBody>
    </div>
</template>

<script>
import CategoryDataDetailModal from '../Category/_DataDetailModal'
export default {
    components:{
        CategoryDataDetailModal
    },
    data(){
        return{
            fields:[
                {key:'index',label:'#'},
                {key:'slug',label:'代號'},
                {key:'name',label:'分類'},
                {key:'edit',label:'-'},
            ],
            columns:[
                {key:'slug',type:'text',label:'代號',readonly:true},
                {key:'name',type:'text',label:'分類'},
                {key:'_',type:'multiple_selector',label:'配合活動',url:'/api/category',relation:'cartRules',relationUrl:'/api/cartRule/all',trackBy:'name'},
            ]
        }
    }
}
</script>

<style>

</style>