<template>
    <div>
        <NavBar :title="'金流管理'"/>

        <CCardBody>
            
            <CreateDetailModal 
                :requestUrl="'/api/payment'"
                :columns="columns"/>

            <DataTable 
                :fields="fields"
                :requestUrl="'/api/payment'"/>
            
            <DataDetailModal
                :requestUrl="'/api/payment/'"
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
                {key:'edit',label:'-'},
            ],
            columns:[
                {key:'name',type:'text',label:'名稱'},
            ]
        }
    }
}
</script>

<style>

</style>