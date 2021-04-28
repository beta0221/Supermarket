<template>
    <div>

        <NavBar :title="'訊息管理'"/>

        <CCardBody>
            

            <CRow class="mt-3">
                <CCol md="2">
                    <SingleSelector
                        :label="'狀態'"
                        :relationUrl="'/api/messageStatus/all'"
                        :column="'status'"
                        :trackBy="'name'"
                        v-on:updateDataColumn="updateFilter"
                        :value="filter.status"/>
                </CCol>
            </CRow>

            <DataTable 
                :fields="fields"
                :requestUrl="'/api/message'"/>
            
            <DataDetailModal
                :requestUrl="'/api/message/'"
                :slug="'id'"
                :columns="columns"/>
            

        </CCardBody>
    </div>
</template>

<script>
export default {
    data(){
        return{
            filter:{
                status:null,
            },
            fields:[
                {key:'index',label:'#'},
                {key:'status',label:'狀態'},
                {key:'title',label:'主旨'},
                {key:'name',label:'姓名'},
                {key:'created_at',label:'時間'},
                {key:'edit',label:'-'},
            ],
            columns:[
                {key:'status',type:'single_selector',label:'狀態',relationUrl:'/api/messageStatus/all',trackBy:'name'},
                {key:'name',type:'text',label:'姓名',readonly:true},
                {key:'email',type:'text',label:'Email',readonly:true},
                {key:'title',type:'text',label:'主旨',readonly:true},
                {key:'message',type:'plain_text',label:'訊息內容'},
            ]
        }
    },
    methods:{
        updateFilter(obj){
            this.$set(this.filter,obj.column,obj.value);
            EventBus.$emit("reloadDataWithFilter", this.filter);
        }
    }
}
</script>

<style>

</style>