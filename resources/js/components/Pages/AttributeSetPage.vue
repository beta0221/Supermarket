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
            ]
        }
    }
}
</script>

<style>

</style>