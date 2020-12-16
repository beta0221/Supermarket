<template>
    <div>

        <NavBar :title="'會員管理'"/>

        <CCardBody>
            
            <CreateDetailModal 
                :requestUrl="'/api/member'"
                :columns="columns"/>

            <DataTable 
                :fields="fields"
                :requestUrl="'/api/member'"/>
            
            <DataDetailModal
                :requestUrl="'/api/member/'"
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
                {key:'level',label:'會員等級'},
                {key:'name',label:'會員名稱'},
                {key:'edit',label:'-'},
            ],
            columns:[
                {key:'type',type:'text',label:'類別'},
                {key:'name',type:'text',label:'標籤名稱'},
                {key:'_',type:'multiple_selector',label:'標籤群組',url:'/api/member',relation:'attributeSets',relationUrl:'/api/attributeSet/all',trackBy:'name'},
            ]
        }
    }
}
</script>

<style>

</style>