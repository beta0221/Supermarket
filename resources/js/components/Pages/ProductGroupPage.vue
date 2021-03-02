<template>
    <div>

        <NavBar :title="'產品群組管理'"/>

        <CCardBody>
            
            <CreateDetailModal 
                :requestUrl="'/api/productGroup'"
                :columns="columns"/>

            <DataTable 
                :fields="fields"
                :requestUrl="'/api/productGroup'"/>
            
            <DataDetailModal
                :requestUrl="'/api/productGroup/'"
                :slug="'id'"
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
                {key:'name',label:'群組名稱'},
                {key:'edit',label:'-'},
            ],
            columns:[
                {key:'name',type:'text',label:'群組名稱'},
                {key:'_',type:'multiple_selector',label:'配合活動',url:'/api/productGroup',relation:'cartRules',relationUrl:'/api/cartRule/all',trackBy:'name'},
            ]
        }
    }
}
</script>

<style>

</style>