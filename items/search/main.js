function max_change(){
    var price = document.getElementById("price_min").value;
    if(document.getElementById("price_max").value < price){
        document.getElementById("price_max").value = price;
    }
}
function min_change(){
    var price = document.getElementById("price_max").value;
    if(document.getElementById("price_min").value > price){
        document.getElementById("price_min").value = price;
    }
}