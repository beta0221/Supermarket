<template>
    <div>
        <NavBar :title="'商品特價管理'"/>

        <CCardBody>

            <DataTable 
                :fields="fields"
                :requestUrl="'/api/product'"/>

            
            <SpecificPriceDataDetailModal />

        </CCardBody>
    </div>
</template>

<script>
import SpecificPriceDataDetailModal from '../SpecificPrice/_DataDetailModal'
export default {
    components:{
        SpecificPriceDataDetailModal,
    },
    data(){
        return{
            fields:[
                {key:'index',label:'#'},
                {key:'name',label:'商品名稱'},
                {key:'edit',label:'-'},
            ],
        }
    }
}
</script>

<style>

</style>