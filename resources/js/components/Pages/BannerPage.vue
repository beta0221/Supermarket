<template>
    <div>

        <NavBar :title="'Banner管理'"/>

        <CCardBody>

            <CreateDetailModal 
                :requestUrl="'/api/banner'"
                :columns="columns"/>
            
            <DataTable 
                :fields="fields"
                :requestUrl="'/api/banner'"/>
            
            <DataDetailModal
                :requestUrl="'/api/banner/'"
                :slug="'slug'"
                :columns="columns"/>
            

        </CCardBody>
    </div>
</template>

<script>
export default {
    data(){
        return{
            fields:[
                {key:'index',label:'#'},
                {key:'key_word',label:'名稱'},
                // {key:'image_path',label:'圖片'},
                {key:'edit_delete',label:'-'},
            ],
            columns:[
                {key:'slug',type:'text',label:'代號',readonly:true},
                {key:'key_word',type:'text',label:'名稱'},
                {key:'order',type:'text',label:'排序'},
                {key:'image_path',type:'image_input',addImageUrl:'banner',label:'圖片',url:'/api/banner/images'},
            ]
        }
    }
}
</script>

<style>

</style>