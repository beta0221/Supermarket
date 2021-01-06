<template>
    <div>
        <label>{{label}}</label>
        <div>
            <div v-for="(image,index) in images" 
                v-bind:Key="index" 
                class="image-cell mr-2 mb-2">
                
                <button class="delete-button" @click="deleteImage(image.id)">X</button>

                <div class="image-outter">
                    <img :src="image.url">
                </div>                

            </div>

            <div class="image-cell">
                <input style="display:none;" type="file" id="file" ref="file" v-on:change="onChangeFileUpload()"/>
                <button class="add-button" @click="$refs.file.click()">+</button>
            </div>


        </div>
    </div>
</template>

<script>
export default {
    props:[
        'label','slug','url','addImageUrl'
    ],
    data(){
        return{
            id:null,
            images:[],
        }
    },
    mounted(){
        EventBus.$on("showDetailModal", item => {
            this.id = item[this.slug];
            this.getImages();
        });
    },
    destroyed(){
        EventBus.$off("showDetailModal");
    },
    methods:{
        getImages(){
            axios.get(`${this.url}/${this.id}`)
            .then(res => {
                this.images = res.data;
            })
            .catch(error =>{
                errorHelper.handle(error);
            })
        },
        onChangeFileUpload(){
            let file = this.$refs.file.files[0];
            let formData = new FormData();
            formData.append('file', file);
            axios.post(`/api/${this.addImageUrl}/${this.id}/addImage`,formData,{
                headers:{
                    'content-type': 'multipart/form-data',
                }
            })
            .then(res => {
                messageHelper.success('上傳成功');
                this.getImages();
            })
            .catch(error => {
                errorHelper.handle(error);
            })
        },
        deleteImage(id){
            axios.post(`/api/${this.addImageUrl}/${this.id}/deleteImage`,{
                '_method':'DELETE',
                'id':id,
            })
            .then(res => {
                messageHelper.success('刪除成功');
                this.getImages();
            })
            .catch(error => {
                errorHelper.handle(error);
            })
        }
    }
}
</script>

<style>
.image-cell{
    position: relative;
    border:1px solid lightgray;
    display:inline-block;
    width: 120px;
    height: 120px;
    vertical-align: middle;
    border-radius: .25rem;
}
.imgage-outter{
    overflow:hidden;
    border-radius: .25rem;
    height: 100%;
    width: 100%;
}
.image-cell img{
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    height: auto;
    width: auto;
    max-height: 100%;
    max-width:100%;   
}
.delete-button{
    position:absolute;
    top: 0;
    right:0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: rgba(0,0,0,0.3);
    color: #fff;
    border: none;
    line-height: 20px;
    font-size: 6px;
    z-index: 10;
}
.add-button{
    width: 100%;
    height: 100%;
    border: none;
    font-size: 40px;
    color: gray;
}
</style>