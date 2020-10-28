<template>
    <div>

        <NavBar :title="'產品類別管理'"/>

        <CCardBody>
            

            <data-table 
                :fields="fields"
                :requestUrl="'/api/category'">
            </data-table>
            
            <data-detail-modal
                :requestUrl="'/api/category/'"
                :slug="'slug'"
                :columns="columns">
            </data-detail-modal>

        </CCardBody>
    </div>
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