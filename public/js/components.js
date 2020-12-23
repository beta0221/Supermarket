function cartItem(item){
    return `<li class="clearfix">
        <img src="${item.product.imageUrl}" />
        <div class="item-info">
            <span class="item-name">${item.name}</span>
            <span class="item-price">${item.price}</span>
            <span class="item-quantity">Quantity: ${item.qty}</span>
        </div>            
    </li>`;
}