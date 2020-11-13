<template>
    <div>

        <NavBar :title="'國家管理'"/>

        <CCardBody>
            
            <CreateDetailModal 
                :requestUrl="'/api/country'"
                :columns="columns"/>

            <DataTable 
                :fields="fields"
                :requestUrl="'/api/country'"/>
            
            <DataDetailModal
                :requestUrl="'/api/country/'"
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
                {key:'code',label:'國碼'},
                {key:'name',label:'國家'},
                {key:'edit',label:'-'},
            ],
            columns:[
                {key:'code',type:'text',label:'國碼'},
                {key:'name',type:'text',label:'國家'},
            ]
        }
    }
}
</script>

<style>

</style>