<template>
    <div>
        <NavBar :title="'購物車規則管理'"/>

        <CCardBody>
            
            <CreateDetailModal 
                :requestUrl="'/api/cartRule'"
                :columns="create_columns"/>

            <DataTable 
                :fields="fields"
                :requestUrl="'/api/cartRule'"/>
            
            <DataDetailModal
                :requestUrl="'/api/cartRule/'"
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
            create_columns:[
                {key:'name',type:'text',label:'名稱'},
            ],
            columns:[
                {key:'name',type:'text',label:'名稱'},
                {key:'code',type:'text',label:'折扣碼'},
                {key:'priority',type:'text',label:'權重'},
                {key:'start_date',type:'text',label:'開始日期 ex:2020-12-19 00:00:00'},
                {key:'expiration_date',type:'text',label:'結束日期 ex:2020-12-19 00:00:00'},
                {key:'status',type:'single_selector',label:'狀態',relationUrl:'/api/cartRuleStatus/all',trackBy:'name'},
                {key:'highlight',type:'single_selector',label:'Hightlight',relationUrl:'/api/cartRuleHeightlight/all',trackBy:'name'},
                {key:'minimum_amount',type:'text',label:'數量門檻'},
                {key:'free_delivery',type:'single_selector',label:'免運',relationUrl:'/api/cartRuleFreeDelivery/all',trackBy:'name'},
                {key:'total_available',type:'text',label:'使用次數'},
                {key:'total_available_each_user',type:'text',label:'每人使用次數'},
                {key:'promo_label',type:'text',label:'小標籤'},
                {key:'promo_text',type:'text',label:'說明'},
                {key:'discount_type',type:'single_selector',label:'折扣方式',relationUrl:'/api/discountType/all',trackBy:'name'},
                {key:'reduction_amount',type:'text',label:'折扣'},
            ]
            
        }
    }
}
</script>

<style>

</style>