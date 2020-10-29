<template>
  
  <ckeditor id="editor" :editor="editor" v-model="text" :config="editorConfig"></ckeditor>

</template>

<script>
import MyUploadAdapter from '../MyUploadAdapter'
import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
export default {
    props:['text','requestUrl'],
    data(){
        return{
            editor:ClassicEditor,
            editorConfig:{
                placeholder: 'Type some text...',
                extraPlugins:[(editor)=>{
                    editor.plugins.get( 'FileRepository' ).createUploadAdapter = ( loader ) => {
                        return new MyUploadAdapter( loader , this.requestUrl);
                    };
                }]
            },
        }
    }
}
</script>

<style>

</style>