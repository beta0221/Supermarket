<template>
    <div>
        <label>{{label}}</label>
        <ckeditor id="editor" :editor="editor" v-model="text" :config="editorConfig"></ckeditor>
    </div>
</template>

<script>
import MyUploadAdapter from '../MyUploadAdapter'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
export default {
    props:['label','uploadUrl'],
    created(){
        
    },
    mounted(){

    },
    data(){
        return{
            text:null,
            editor:ClassicEditor,
            editorConfig:{
                placeholder: 'Type some text...',
                extraPlugins:[(editor)=>{
                    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                        return new MyUploadAdapter( loader , this.uploadUrl);
                    };
                }]
            },
        }
    }
}
</script>

<style>

</style>