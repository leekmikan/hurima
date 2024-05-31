var prices = document.getElementsByName("price");
var sum = 0;
for(var i = 0;i < prices.length;i++){
    sum += Number(prices[i].innerText);
    prices[i].innerText = Number(prices[i].innerText).toLocaleString();
}
document.getElementById("")