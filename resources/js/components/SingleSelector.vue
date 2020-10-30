<template>
    <CSelect 
        :label="label"
        :options="options"
        v-on:update:value="updateValue"
        :value="value"/>
        
</template>

<script>
export default {
    props:[
        'column','label','relationUrl','trackBy','value'
    ],
    created(){
        this.getAllOptions();
    },
    data(){
        return{
            options:[],
        }
    },
    methods:{
        getAllOptions(){
            axios.get(this.relationUrl)
            .then(res => {
                this.loadOptions(res.data);
            })
            .catch(error => {
                errorHelper.handle(error);
            })
        },
        loadOptions(data){
            let options = [{value:null,label:'請選擇'}];
            data.forEach(item => {
                let option = {
                    value:item.id,
                    label:item[this.trackBy],
                };
                options.push(option);
            });
            this.options = options;
        },
        updateValue(value){
            this.$emit('updateDataColumn',{column:this.column,value:value});
        }
    }
}
</script>

<style>

</style>