function check(){
    var str = document.getElementById("password").value;
    if(str.length < 8 || Number(str) === NaN) {
        alert("パスワードは8文字以上の数字にしてください。"); 
        return false;
    }
}