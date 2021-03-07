<template>
    <div>
        <CModal
      title="訂單詳情"
      color="info"
      :show.sync="show"
      size="lg"
      id ="orderDetail"
      >
      <h2>訂單編號: {{order_numero}}</h2>
      <table class="table table-bordered mt-2">
        <tr>
          <th style="background-color:#D3D3D3">姓名</th>
          <th style="background-color:#D3D3D3">信箱</th>
          <th style="background-color:#D3D3D3">累積紅利</th>
        </tr>
        <tr>
          <td>{{userInfo.name}}</td>
          <td>{{userInfo.email}}</td>
          <td>{{userInfo.bonus}}</td>
        </tr>
      </table>
      <table class="table table-bordered mt-2">
        <tr>
          <th colspan="2" style="background-color:#1E90FF"><span style="color:white">訂購資訊</span></th>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">收件人</td>
          <td>{{addressInfo.name}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">地址</td>
          <td>{{addressInfo.address1}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">電話</td>
          <td>{{addressInfo.phone}}</td>
        </tr>
         <tr>
          <td style="background-color:#D3D3D3">總金額</td>
          <td>{{order.total}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">發票</td>
          <td></td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">備註</td>
          <td>{{addressInfo.comment}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">配合活動</td>
          <li v-for="(cart,index) in cartRuleList" :key="index">{{ cart.name }}</li>
        </tr>
      </table>
          <CDataTable
          :items="orderProduct"
          :fields="orderProductFields"
          >
          <template #imageUrl="{item}">
            <td>
              <img
                :src="item.imageUrl"
                width="90px"
                height="90px"
                class="mt-1"
                style="align-middle"
              />
            </td>
              
            </template>
          </CDataTable>
      </CModal>
    </div>
</template>
<script>
export default {
    data(){
        return{
            show:false,
            order_numero:'',
            orderProduct:[],
            addressInfo:[],
            order:[],
            cartRuleList:[],
            orderProductFields : [
        { key: "name", label: "商品" },
        { key: "imageUrl", label: "圖片" },
        { key: "price", label: "價錢" },
        { key: "quantity", label: "數量" },
      ],
        }
    },
    mounted(){
        EventBus.$on("showDetailModal", order_numero => {
            this.orderDetail(order_numero);
            this.order_numero = order_numero;
        });
    },
    destroyed(){
        EventBus.$off("showDetailModal");
    },
    methods:{
        orderDetail(order_numero) {
      axios
        .get("/api/order/getOrderDetail/"+order_numero )
        .then((res) => {
          this.show = true;
          this.orderProduct = res.data.orderProduct;
          this.userInfo = res.data.userInfo;
          this.order = res.data.order;
          this.addressInfo = res.data.addressInfo;
          this.cartRuleList = res.data.cartRuleList;

        })
        .catch((err) => {
          console.error(err);
        });
    },
    }
}
</script>