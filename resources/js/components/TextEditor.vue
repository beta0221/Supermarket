<template>
    <div>
        <label>{{label}}</label>
        <ckeditor id="editor" :editor="editor" v-model="editText" :config="editorConfig"></ckeditor>
    </div>
</template>

<script>
import MyUploadAdapter from '../MyUploadAdapter'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
export default {
    props:['column','label','uploadUrl','text','slug'],
    created(){
        
    },
    mounted(){
        EventBus.$on("showDetailModal", item => {
            this.id = item[this.slug];
        });
    },
    destroyed(){
        EventBus.$off("showDetailModal");
    },
    watch:{
        text(value){
            this.editText = value;
        },
        editText(value){
            this.$emit('updateDataColumn',{column:this.column,value:value});
        }
    },
    data(){
        return{
            id:null,
            editText:null,
            editor:ClassicEditor,
            editorConfig:{
                placeholder: 'Type some text...',
                extraPlugins:[(editor)=>{
                    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                        return new MyUploadAdapter( loader , this.uploadUrl + this.id);
                    };
                }]
            },
        }
    }
}
</script>

<style>

</style>