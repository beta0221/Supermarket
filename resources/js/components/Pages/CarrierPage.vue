<template>
    <div>
        <NavBar :title="'國家管理'"/>

        <CCardBody>
            
            <CreateDetailModal 
                :requestUrl="'/api/carrier'"
                :columns="columns"/>

            <DataTable 
                :fields="fields"
                :requestUrl="'/api/carrier'"/>
            
            <DataDetailModal
                :requestUrl="'/api/carrier/'"
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
                {key:'name',label:'名稱'},
                {key:'price',label:'運費'},
                {key:'delivery_text',label:'說明'},
                {key:'edit',label:'-'},
            ],
            columns:[
                {key:'name',type:'text',label:'名稱'},
                {key:'price',type:'text',label:'運費'},
                {key:'delivery_text',type:'text',label:'說明'},
            ]
        }
    }
}
</script>

<style>

</style>