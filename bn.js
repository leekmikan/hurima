const BN_LEN = 2;
var change_time = [0,5000];
change_time[0] = change_time[1];
let bnn = 0;
//画像更新.
function b_upd(){
    document.getElementById("bn_img").src = "img/b" + (bnn + 1) + ".jpg";
}
//画像切りかえ.
function b_change(x){
    bnn = (bnn + x + BN_LEN) % BN_LEN;
    b_upd();
}

//定期的に画像切り替え.
setInterval(function(){
    change_time[0] -= 100;
    if(change_time[0] <= 0){
        change_time[0] = change_time[1];
        b_change(1);
    }
}, 100);

//初回実行
b_upd();
