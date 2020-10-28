<template>
    <div>

        <NavBar :title="'標籤管理'"/>

        <CCardBody>
            
            <CreateDetailModal 
                :requestUrl="'/api/attribute'"
                :columns="columns"/>

            <DataTable 
                :fields="fields"
                :requestUrl="'/api/attribute'"/>
            
            <DataDetailModal
                :requestUrl="'/api/attribute/'"
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
                {key:'type',label:'類別'},
                {key:'name',label:'標籤名稱'},
                {key:'edit',label:'-'},
            ],
            columns:[
                {key:'type',type:'text',label:'類別'},
                {key:'name',type:'text',label:'標籤名稱'},
            ]
        }
    }
}
</script>

<style>

</style>