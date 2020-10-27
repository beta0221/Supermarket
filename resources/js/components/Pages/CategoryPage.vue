<template>

<CCardBody>
    <data-table 
        :fields="fields"
        :requestUrl="'/api/category'">
    </data-table>
    
    <data-detail-modal></data-detail-modal>
</CCardBody>
  
</template>

<script>
import dataTable from '../DataTable'
import dataDetailModal from '../DataDetailModal'
export default {
    components:{
        dataTable,
        dataDetailModal,
    },
    data(){
        return{
            fields:[
                {key:'index',label:'#'},
                {key:'slug',label:'代號'},
                {key:'name',label:'分類'},
                {key:'edit',label:'-'},
            ],
        }
    }
}
</script>

<style>

</style>