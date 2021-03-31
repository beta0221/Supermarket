function cartItem(item){
    return `<li class="clearfix">
        <img src="${item.product.imageUrl}" />
        <div class="item-info">
            <span class="item-name">
                <a class="common-a" href="/product/${item.sku}">${item.name}</a>
            </span>
            <span class="item-price">單價: ${item.price}</span>
            <span class="item-quantity">數量: ${item.qty}</span>
            <a href="javascript:;" onclick="deleteFromCart('${item.rowId}')" class="common-a icon_trash_alt">刪除</a>
        </div>            
    </li>`;
}

function priceListTable(priceList){
    let table = `<table class="w-100 price-list-table text-center h4">
        <tr>
            <td>數量</td>
            <td>單價</td>
        </tr>
        {LIST}
    </table>`;
    let tr = '';
    Object.keys(priceList).forEach(qty =>{
        let price = priceList[qty];
        tr +=  `<tr>
            <td>${qty}</td>
            <td>${price}</td>
        </tr>`;
    });
    return table.replace("{LIST}",tr);
}