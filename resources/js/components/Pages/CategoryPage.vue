<template>
    <div>

        <NavBar :title="'產品類別管理'"/>

        <CCardBody>

            <CreateDetailModal 
                :requestUrl="'/api/category'"
                :columns="columns"/>
            
            <DataTable 
                :fields="fields"
                :requestUrl="'/api/category'"/>
            
            <DataDetailModal
                :requestUrl="'/api/category/'"
                :slug="'slug'"
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
                {key:'slug',label:'代號'},
                {key:'name',label:'分類'},
                {key:'edit',label:'-'},
            ],
            columns:[
                {key:'slug',type:'text',label:'代號',readonly:true},
                {key:'name',type:'text',label:'分類'},
            ]
        }
    }
}
</script>

<style>

</style>