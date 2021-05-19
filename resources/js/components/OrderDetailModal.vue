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
        </tr>
        <tr>
          <td>{{user.name}}</td>
          <td>{{user.email}}</td>
        </tr>
      </table>
      <table class="table table-bordered mt-2">
        <tr>
          <th colspan="2" style="background-color:#1E90FF"><span style="color:white">出貨資訊</span></th>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">收件人</td>
          <td>{{address.name}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">地址</td>
          <td>{{address.address1}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">電話</td>
          <td>{{address.phone}}</td>
        </tr>
      </table>


      <table class="table table-bordered mt-2">
        <tr>
          <th colspan="2" style="background-color:#1E90FF"><span style="color:white">訂單資訊</span></th>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">付款方式</td>
          <td>{{order.payment}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">運送方式</td>
          <td>{{order.carrier}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">發票</td>
          <td></td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">備註</td>
          <td>{{order.comment}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">小記</td>
          <td>{{order.subtotal}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">運費</td>
          <td>{{order.total_shipping}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">折扣</td>
          <td>-{{order.total_discount}}（使用紅利:{{order.bonus_cost}}）</td>
        </tr>
         <tr>
          <td style="background-color:#D3D3D3">總金額</td>
          <td style="color:red">{{order.total}}</td>
        </tr>
      </table>


      <table class="table table-bordered mt-2" v-if="atmInfo != null">
        <tr>
          <th colspan="2" style="background-color:#1E90FF"><span style="color:white">atm繳款資訊</span></th>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">繳費銀行代碼</td>
          <td>{{atmInfo.BankCode}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">虛擬帳號</td>
          <td>{{atmInfo.vAccount}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">繳費期限</td>
          <td>{{atmInfo.ExpireDate}}</td>
        </tr>
      </table>


      <table class="table table-bordered mt-2" v-if="cardInfo != null">
        <tr>
          <th colspan="2" style="background-color:#1E90FF"><span style="color:white">信用卡繳款資訊</span></th>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">卡片末四碼</td>
          <td>{{cardInfo.Card4No}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">銀行授權碼</td>
          <td>{{cardInfo.AuthCode}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">金額</td>
          <td>{{cardInfo.Amount}}</td>
        </tr>
        <tr>
          <td style="background-color:#D3D3D3">交易時間</td>
          <td>{{cardInfo.ProcessDate}}</td>
        </tr>

        
      </table>



      <div class="alert alert-success" role="alert">
          <h4 class="alert-heading">使用折扣 :</h4>
          <hr class="mt-2 mb-2">
          <p style="color:#155724" class="mb-0" v-for="(rule,index) in cartRules" :key="index">＊{{rule}}</p>
      </div>

          <CDataTable
          :items="productList"
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
            user:{},
            order:{},
            address:{},
            productList:[],
            cartRules:[],
            atmInfo:{},
            cardInfo:{},
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
          this.order = res.data;
          this.user = res.data.user;
          this.address = res.data.address;
          this.productList = res.data.productList;
          this.cartRules = res.data.cartRules;
          this.atmInfo = res.data.atmInfo;
          this.cardInfo = res.data.cardInfo;
        })
        .catch((err) => {
          errorHelper.handle(error);
        });
    },
    }
}
</script>