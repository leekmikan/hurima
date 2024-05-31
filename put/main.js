var picnum = 0;
window.onload = function() {
    (function() {
      if (checkFileApi()) {
        var file_image = document.getElementById('images');
        file_image.addEventListener('change', selectReadfile, false);
      }
      function checkFileApi() {
        if (window.File && window.FileReader && window.FileList && window.Blob) {
          return true;
        }
        alert('このブラウザはFile APIに対応していないため利用できません');
        return false;
      }
      function selectReadfile(e) {
        picnum = 0;
        var file = e.target.files;
        var len = Math.min(5,file.length);
        var reader = new Array(len);
        for(var i = 0;i < len;i++){
            reader[i] = new FileReader();
            reader[i].readAsDataURL(file[i]);
            reader[i].onload = function() {
            readImage(this);
            }
        }
        for(var i = len;i < 5;i++){
            document.getElementById(i + "x").value = "../img/noimage.jpg";
            document.getElementById(i).src = "../img/noimage.jpg";
        }
      }
      function readImage(reader) {
        var result_DataURL = reader.result;
        var img = document.getElementById(picnum);
        var src = document.createAttribute('src');
        src.value = result_DataURL;
        img.setAttributeNode(src);
        document.getElementById(picnum + "x").value = src.value;
        picnum++;
      }
    })();
  }
function reset_img(){
    document.getElementById("images").value = "";
    for(i = 0;i < 5;i++){
        document.getElementById(i).src = "../img/noimage.jpg";
        document.getElementById(i + "x").value = "../img/noimage.jpg";
    }
}
var counter = 0;
setInterval(function(){
	counter++;
	if(counter == 60){
    save_data();
    document.getElementById("saved").style.display = "block";
	}
  if(counter >= 65){
    counter == 0;
    document.getElementById("saved").style.display = "none";
  }
}, 1000);

function save_data(){
  var item = {
    id: 0,
    name: document.getElementById("name").value,
    price: Math.max(Math.min(Number(document.getElementById("price").value),1000000),1),
    src: ["","","","",""],
    text: document.getElementById("exp").value,
    genre: document.getElementById("genre").value,
    stat: document.getElementById("stat").value,
    send: document.getElementById("send").value,
  }
  for(var i = 0;i < 5;i++){
    item.src[i] = document.getElementById("" + i).src;
  }
  set_data(item,"item_draft");
}
item = get_data("item_draft");
if(item != null){
  document.getElementById("name").value = item.name;
  document.getElementById("price").value = item.price;
  document.getElementById("exp").value = item.text;
  document.getElementById("stat").value = item.stat;
  document.getElementById("send").value = item.send;
  for(var i = 0;i < 5;i++){
    document.getElementById("" + i).src = item.src[i];
    document.getElementById(i + "x").value = item.src[i];
  }
}
function check(){
  if(document.getElementById("name").value == ""){
    alert("商品名を入力してください");
    return false;
  }
  if(document.getElementById("price").value === null){
    alert("価格を入力してください");
    return false;
  }
  if(document.getElementById("0").src == "../img/noimage.jpg" || document.getElementById("0").src == ""){
    alert("画像を1枚以上いれてください");
    return false;
  }
  if(document.getElementById("exp").value == ""){
    alert("説明を入力してください");
    return false;
  }
  save_data();
  return true;
}