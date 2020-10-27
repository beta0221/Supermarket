<template>

<CCardBody>
    <data-table 
        :fields="fields"
        :requestUrl="'/api/category'">
    </data-table>
    
</CCardBody>
  
</template>

<script>
import dataTable from '../DataTable'
export default {
    components:{
        dataTable,
    },
    data(){
        return{
            fields:[
                {key:'id'},
                {key:'name'},
            ],
        }
    }
}
</script>

<style>

</style>