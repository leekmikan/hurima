var prices = document.getElementsByName("price");
for(var i = 0;i < prices.length;i++){
    prices[i].innerText = Number(prices[i].innerText).toLocaleString();
}