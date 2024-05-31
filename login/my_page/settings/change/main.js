var pattern = /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_.-]+.[A-Za-z0-9]+$/;
function check(){
    var str = document.getElementById("password").value;
    if(str.length < 8) {
        alert("パスワードは8文字以上にしてください。"); 
        return false;
    }
    var used = [false,false,false];
    for(var i = 0;i < str.length;i++){
        var ascii = str[i].codePointAt(0);
        if(ascii >= 0x41 && ascii <= 0x5A){
            used[0] = true;
        }else if(ascii >= 0x61 && ascii <= 0x7A){
            used[1] = true;
        }else if(ascii >= 0x30 && ascii <= 0x39){
            used[2] = true;
        }else{
            alert("パスワードに半角英数字以外の文字が含まれています!"); 
            return false;
        }
    }
    if(!used[0] || !used[1] || !used[2]){
        alert("パスワードに小文字,大文字,数字をすべていれてください"); 
        return false;
    }
    if(document.getElementById("password2").value != str) {
        alert("再確認パスワードが正しくありません"); 
        return false;
    }
    if(document.getElementById("user_name").value == "") {
        alert("ユーザー名を入力してください。"); 
        return false;
    }
    if(document.getElementById("user_sei").value == "") {
        alert("姓を入力してください。"); 
        return false;
    }
    if(document.getElementById("user_mei").value == "") {
        alert("名を入力してください。"); 
        return false;
    }
    if(!pattern.test(document.getElementById("email").value)) {
        alert("不正なメールアドレスです"); 
        return false;
    }
    if(document.getElementById("adress_number").value == "") {
        alert("郵便番号を入力してください。"); 
        return false;
    }
    if(document.getElementById("adress").value == "") {
        alert("住所を入力してください。"); 
        return false;
    }
    if(document.getElementById("birth").value == "") {
        alert("生年月日を入力してください。"); 
        return false;
    }
}