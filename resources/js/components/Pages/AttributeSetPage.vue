<template>
    <div>

        <NavBar :title="'標籤群組管理'"/>

        <CCardBody>
            
            <CreateDetailModal 
                :requestUrl="'/api/attributeSet'"
                :columns="columns"/>

            <DataTable 
                :fields="fields"
                :requestUrl="'/api/attributeSet'"/>
            
            <DataDetailModal
                :requestUrl="'/api/attributeSet/'"
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
                {key:'_',type:'multiple_selector',label:'標籤',url:'/api/attributeSet',relation:'attributes',relationUrl:'/api/attribute/all',trackBy:'name'},
                // {key:'group_id',type:'single_selector',label:'哈哈',relationUrl:'/api/productGroup/all',trackBy:'name'},
            ]
        }
    }
}
</script>

<style>

</style>