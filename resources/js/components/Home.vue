<template>
<div>
    <SideBar></SideBar>

    <CWrapper>
        <router-view></router-view>
    </CWrapper>

    <CToaster :autohide="1500" >
        <template v-for="(message,index) in messages">
            <CToast
                style="flex-basis: auto;color:#fff"
                :style="'background-color:'+ message.color"
                :key="'toast' + index"
                :show="true"
                :header="message.header">
                <p>{{message.body}}</p>
            </CToast>
      </template>
    </CToaster>

</div>
  

</template>

<script>
export default {
    created(){
        EventBus.$on("popMessage", message => {
            this.popMessage(message);
        })
    },
    data(){
        return{
            messages:[],
        }
    },
    methods:{
        popMessage(message){
            this.messages.push(message);
        }
    }
}
</script>

<style>

</style>