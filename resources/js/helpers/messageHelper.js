export default class messageHelper{
    
    default(body,header='訊息'){
        EventBus.$emit('popMessage',{
            color:'#fff',
            header:header,
            body:body,
        })
    }

    success(body,header='訊息'){
        EventBus.$emit('popMessage',{
            color:'#2eb85c',
            header:header,
            body:body,
        })
    }

    error(body,header='錯誤訊息'){
        EventBus.$emit('popMessage',{
            color:'#e55353',
            header:header,
            body:body,
        })
    }

}